<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Input,
    File,
    View;
use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use App\Models\ArticleModel,
    App\Models\ArticleLangModel,
    LanguageModel,
    PhotoModel;
use ImageService,
    Illuminate\Support\Facades\DB;

class ArticleController extends AdminController {

    use \App\Bcore\Permissions\ArticlePermission;

    public $storage_folder = 'articles';
    public $ControllerName = 'Article';
    public $Sync = [
        'google-drive' => [
            'state' => null,
            'data' => null
        ],
        'dropbox' => [
            'state' => null,
            'data' => null
        ],
    ];

    public static function info() {
        return (object) [
                    'controller_name' => 'Article',
                    'storage_path' => 'articles',
                    'sync' => (object) [
                        'google-drive' => [
                            'state' => null,
                            'data' => null
                        ],
                        'dropbox' => [
                            'state' => null,
                            'data' => null
                        ],
                    ]
        ];
    }

    use \App\Functions\AdminFunction;

    public function __construct() {
        parent::__construct();
        // Default datatable config ------------------------------------------------------------------------------------
        $this->ViewDataController = (object) Config::get('ViewController.' . $this->ControllerName);
        // -------------------------------------------------------------------------------------------------------------
        $this->StorageGoogle = config::get('Bcore.storage_service.google_drive.GOOGLE_DRIVE_FOLDER_ARTICLE');
        // ----- GET DATA SYNC -----------------------------------------------------------------------------------------
        $this->Sync = $this->get_sync_state($this->Sync);

        $this->sendDataToView(array(
            'route_ajax' => 'admin_article_ajax'
        ));
        // -------------------------------------------------------------------------------------------------------------
        View::share('_ControllerName', $this->ControllerName);
    }

    private function controller_required($pType, $pId = 'notset') {
        if ($pType == null) {
            return redirect()->route('admin_index');
        } else {
            if ($pId == 'notset') {
                return;
            } else {
                if (is_numeric($pId) && $pId != null) {
                    return;
                } else {
                    return redirect()->route('admin_article_index', $pType);
                }
            }
        }
    }

    public function get_index($pType = null, Request $request) {
        // ================================== CHECK PERMISSION =========================================================
        $this->DVController = $this->registerDVC($this->ControllerName, $pType);
        $ArticleModels = new ArticleModel();
        $Models = $ArticleModels
                ->set_type($pType)
                ->set_lang(\App\Bcore\Services\UserServiceV2::get_currentLangId(\App\Bcore\System\UserType::admin()))
                ->set_orderBy(['articles.ordinal_number', 'ASC'])
                ->set_deleted(1)
                ->set_keyword($request->input('keyword'))
                ->set_perPage(10)
                ->with_photo(['photos', 'photo'])
                ->execute();
        return view($this->_RV . 'article/index', [
            'items' => $Models->data(),
            'type' => $pType,
        ]);
    }

    public function get_add($pType = null, Request $request) {
        $this->DVController = $this->registerDVC($this->ControllerName, $pType);
        if ($pType === null)
            return redirect()->route('admin_index');
        return view($this->_RV . 'article/add', [
            'type' => $pType
        ]);
    }

    public function get_edit($pType = null, $pId, Request $request) {
        $this->DVController = $this->registerDVC($this->ControllerName, $pType);
        $ArticleModel = ArticleModel::find($pId);
        if ($ArticleModel === null) {
            $request->session()->flash('message_type', 'warning');
            $request->session()->flash('message', Lang::get('message.dulieukhongcothuc'));
            return redirect()->route('admin_article_index', [$pType]);
        }
        $ArticleModel = PhotoModel::findByModel(['photo'], $ArticleModel);

        $ArticleLangModel = ArticleLangModel::where([
                    'id_article' => $ArticleModel->id
                ])->orderBy('id', 'DESC')->get();
        $ArticleLangGroupByIdLang = $this->groupFieldByModels('id_lang', $ArticleLangModel);
        return view($this->_RV . 'article/add', [
            'type' => $pType,
            'item' => $ArticleModel,
            'item_lang' => $ArticleLangGroupByIdLang,
                //'item_photo' => @$Data_ArticlePhoto
        ]);
    }

    public function get_recycle($pType, Request $request) {
        // ----- Controller required -----------------------------------------------------------------------------------
        $this->controller_required($pType);
        // -------------------------------------------------------------------------------------------------------------
        $this->DVController = $this->registerDVC($this->ControllerName, $pType);
        $ArticleModel = new ArticleModel();
        $items = $ArticleModel
                ->set_lang(session('user')['language'])
                ->set_orderBy(['deleted', 'DESC'])
                ->set_keyword($request->input('keyword'))
                ->set_deleted(-1)
                ->set_type($pType)
                ->set_perPage(10)
                ->db_get_items();


        return view($this->_RV . 'article/recycle', [
            'items' => $items,
            'type' => $pType,
            'template_recycle' => true,
        ]);
    }

    public function get_sync($pType = null, Request $request) {
        if ($pType === null)
            return redirect()->route('admin_index');
        // -------------------------------------------------------------------------------------------------------------


        return view($this->_RV . 'article/sync', [
            'title' => $request->instance()->query('title')
        ]);
    }

    public function post_save(Request $request) {
        dd(123);
        $r_action = '';

        if ($request->input('type') == null)
            return redirect()->route('admin_index');
        // ---------- GENERAL AREA -------------------------------------------------------------------------------------
        // [1] Check nếu id không tồn tại => Thao tác thêm mới
        // Ngược lại => thao tác cập nhật
        if ($request->input('id') == null) {
            $ArticleModel = new ArticleModel();
            $ArticleModel->id_user = \App\Bcore\Services\UserServiceV2::current_userId(\App\Bcore\System\UserType::admin());
            $ArticleModel->type = $request->input('type');
            $r_action = 'Thêm';
        } else {
            $ArticleModel = ArticleModel::find(trim(Input::get('id')));
            $r_action = 'Cập nhật';
        }
        // [2] Set data cho model
        // ARTICLE
        $ArticleModel->highlight = check_formInputResult('checkbox', Input::get('highlight'));
        $ArticleModel->display = check_formInputResult('checkbox', Input::get('display'));
        $ArticleModel->views = is_numeric(Input::get('views')) ? Input::get('views') : 0;
        $ArticleModel->ordinal_number = is_numeric(Input::get('ordinal_number')) ? Input::get('ordinal_number') : 0;
        $ArticleSaved = $ArticleModel->save();

        if ($ArticleSaved) {
            $request->session()->flash('message', "$r_action thành công");
        } else {
            $request->session()->flash('message_type', 'error');
            $request->session()->flash('message', "$r_action không thành công");
        }

        // [3] Lấy id của article vừa save (* Bước quan trọng)
        $IdModel = $ArticleModel->id;
        $PathLocal = null;
        // PHOTO -------------------------------------------------------------------------------------------------------
        if ($request->hasFile('photo')) {

            $photo = $request->file('photo');
            $PARENT_FOLDER = $this->info()->storage_path . '/' . $request->input('type') . '/photo';
            $PathLocal = Storage::disk('localhost')->putFile($PARENT_FOLDER, $photo, 'public');
            // ----- Database ------------------------------------------------------------------------------------------
            $PhotoModel = new PhotoModel();
            $PhotoModel->obj_id = $IdModel;
            $PhotoModel->obj_table = 'articles';
            $PhotoModel->obj_type = 'photo';
            $PhotoModel->dir_name = $this->storage_folder;
            $PhotoModel->mimetype = $request->file('photo')->getMimetype();
            $PhotoModel->size = $request->file('photo')->getSize();
            $PhotoModel->url = $PathLocal;
            $PhotoModel->url_encode = md5($PathLocal);
            $PhotoModel->name = $photo->getClientOriginalName();
            $PhotoModel->id_user = \App\Bcore\Services\UserServiceV2::current_userId(\App\Bcore\System\UserType::admin());

            // Nếu tồn tại $GOOGLE_JSON 
            $PhotoModel->sync_google = null;

            $PhotoUploaded = $PhotoModel->save();
            if ($PhotoUploaded) {
                // ----- Xóa hình cũ -----------------------------------------------------------------------------------
            } else {
                // Không thể lưu vào database
                // Write log, xóa hình đã up...
                if ($PathLocal != null)
                    Storage::disk('localhost')->delete($PathLocal);
            }
        }

        $datalang = $request->input('data_lang');
        foreach ($datalang as $lang_id => $model) {
            if ($model['id'] == null) {
                $tmp = [
                    'name' => @$model['name'],
                    'name_meta' => $model['name_meta'],
                    'id_article' => $IdModel,
                    'id_lang' => $lang_id,
                    'description' => @$model['description'],
                    'description2' => @$model['description2'],
                    'content' => @$model['content'],
                    'seo_title' => @$model['seo_title'],
                    'seo_description' => @$model['seo_description'],
                    'seo_keywords' => @$model['seo_keywords'],
                ];
                DB::table('articles_lang')->insert($tmp);
            } else {
                $TMP_AM = ArticleLangModel::find($model['id']);
                if ($TMP_AM != null) {
                    $TMP_AM->name = @$model['name'];
                    $TMP_AM->name_meta = @$model['name_meta'];
                    $TMP_AM->description = @$model['description'];
                    $TMP_AM->description2 = @$model['description2'];
                    $TMP_AM->content = @$model['content'];
                    $TMP_AM->seo_title = @$model['seo_title'];
                    $TMP_AM->seo_description = @$model['seo_description'];
                    $TMP_AM->seo_keywords = @$model['seo_keywords'];
                    $TMP_AM->save();
                }
            }
        }

        return redirect()->route('admin_article_index', $request->input('type'));
    }

    // ===== PRIVATE FUNCTION ==========================================================================================

    private function check_namemeta($request) {
        $type = 'warning';
        $state = false;
        try {
            $ArticleLangModel = ArticleLangModel::where([
                        ['id', '<>', $request->input('id')],
                        ['id_lang', '=', 1],
                        ['name_meta', '=', $request->input('val')]
                    ])
                    ->first();
            if ($ArticleLangModel != null) {
                $message = 'Địa chỉ URL đã tồn tại trên hệ thống, vui lòng chọn tên khác';
            } else {
                $type = 'success';
                $state = true;
            }
        } catch (\Exception $ex) {
            $message = 'Có lỗi xảy ra, vui lòng thử lại';
        }
        return response()->json([
                    'state' => $state,
                    'message' => @$message,
                    'title' => _('label.thongbao'),
                    'type' => @$type
        ]);
    }

    private function update_boolean($request) {
        $field = $request->input('field');
    }

    private function delete($request) {
        
    }

    private function remove($request) {
        
    }

    // ===== AJAX REQUEST ==============================================================================================

    public function ajax_(Request $request) {
        $requestAction = $request->input('act');
        switch ($requestAction) {
            case 'cnm':
                return $this->check_namemeta($request);
            case 'update_checkbox':
                return $this->update_boolean($request);
            case 'delete': // Xóa vào bộ nhớ tạm
                return $this->delete();
            case 'remove': // Xóa vĩnh viễn
                return $this->remove($request);
            default:
                return response()->json(['state' => false, 'message' => 'Act undefined!']);
        }
    }

    public static function register_package() {
        return (object) [
                    'package_name' => 'Bài viết',
                    'version' => 1.3,
                    'build_at' => '2017-09-10'
        ];
    }

}
