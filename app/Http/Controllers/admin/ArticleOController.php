<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use Input,
    File,
    View;
use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use App\Models\ArticleOModel,
    LanguageModel,
    App\Models\PhotoModel;
use ImageService,
    App\Bcore\StorageService;

class ArticleOController extends AdminController {

    public $storage_folder = 'article';
    public $ControllerName = 'ArticleO';
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

    use \App\Functions\AdminFunction;

    public function __construct() {
        parent::__construct();
        // Default datatable config ------------------------------------------------------------------------------------
        //  $this->ViewDataController = (object) Config::get('ViewController.' . $this->ControllerName);
        // -------------------------------------------------------------------------------------------------------------
        //    $this->StorageGoogle = config::get('Bcore.storage_service.google_drive.GOOGLE_DRIVE_FOLDER_ARTICLE');
        // ----- GET DATA SYNC -----------------------------------------------------------------------------------------
        //     $this->Sync = $this->get_sync_state($this->Sync);

        $this->sendDataToView(array(
            'route_ajax' => 'admin_article_ajax'
        ));
        // -------------------------------------------------------------------------------------------------------------
        View::share('_ControllerName', $this->ControllerName);
    }

    public function get_index($pType, Request $request) {
        // ================================== CHECK PERMISSION =========================================================
        if (class_exists(\App\Modules\UserPermission\Services\UPService::class)) {
            $CP = \App\Modules\UserPermission\Services\UPService::check_permission('per_view', __CLASS__, $request);
            if (!$CP->status) {
                return $CP->view;
            }
        }
        // ================================== CHECK PERMISSION =========================================================

        $this->DVController = $this->registerDVC($this->ControllerName, $pType);

        $LIST_LANGS = $this->get_arrayIdLangs();

        $ArticleOModel = ArticleOModel::where([
                    ['type', '=', $pType]
                ])->whereIn('id_lang', $LIST_LANGS)->get();
        if ($ArticleOModel == null) {
            return redirect()->route('admin_articleo_creating', $pType);
        } else {
            if (count($LIST_LANGS) != count($ArticleOModel)) {
                return redirect()->route('admin_articleo_creating', $pType);
            }
        }

        $ArticleOModel = $this->groupFieldByModels('id_lang', $ArticleOModel);

        return view('admin/articleo/index', [
            'item_lang' => $ArticleOModel,
            'type' => $pType
        ]);
    }

    public function get_creating($pType) {
        $this->DVController = $this->registerDVC($this->ControllerName, $pType);

        $LIST_LANGS = $this->get_arrayIdLangs();

        $ArticleOModel = ArticleOModel::where([
                    ['type', '=', $pType]
                ])->whereIn('id_lang', $LIST_LANGS)->get();

        if (count($ArticleOModel) != count($LIST_LANGS)) {

            $ArticleOModel = $this->groupFieldByModels('id_lang', $ArticleOModel);

            foreach ($LIST_LANGS as $k => $v) {
                if (!isset($ArticleOModel[$v])) {
                    $ArticleOModel = new ArticleOModel();
                    $ArticleOModel->id_user = session('user')['id'];
                    $ArticleOModel->id_lang = $v;
                    $ArticleOModel->type = $pType;
                    $ArticleOModel->title = 'Tiêu đề mẫu';
                    $ArticleOModel->description = 'Mô tả mẫu';
                    $ArticleOModel->content = 'Nội dung mẫu';
                    if (!$ArticleOModel->save()) {
                        return "Khởi tạo dữ liệu tất bại!";
                    }
                }
            }
        }

        return view('admin/articleo/create', [
            'type' => $pType
        ]);
    }

    public function post_index(Request $request) {
        // ================================== CHECK PERMISSION =========================================================
        if (class_exists(\App\Modules\UserPermission\Services\UPService::class)) {
            $CP = \App\Modules\UserPermission\Services\UPService::check_permission('per_edit', __CLASS__, $request);
            if (!$CP->status) {
                return $CP->view;
            }
        }
        // ================================== CHECK PERMISSION =========================================================

        $form_fields = $this->form_field_generator($request->all(), [], true);
        $r = false;
        foreach ($form_fields as $k => $v) {
            if (isset($v->id)) {
                $tmp_id = $v->id;
                unset($v->id);
                $ArticleOModel = ArticleOModel::where('id', '=', $tmp_id)->first();
                unset($v->id_lang);
                $r = $ArticleOModel->update((array) $v);
            }
        }

        if ($r === true) {
            $request->session()->flash('message', __('message.capnhatthanhcong'));
        } else {
            $request->session()->flash('message_type', 'error');
            $request->session()->flash('message', __('message.capnhatkhongthanhcong'));
        }
        return redirect()->route('admin_articleo_index', $request->input('type'));
    }

    public static function register_strict() {
        return (object) [
                    'type' => [
                        'gioi-thieu' => (object) [
                            'name' => 'Giới thiệu',
                            'default' => true,
                        ],
                        'lien-he' => (object) [
                            'name' => 'Liên hệ',
                            'default' => false,
                        ],
                        'dieu-khoan-chinh-sach' => (object) [
                            'name' => 'Điều khoản & chính sách',
                            'default' => false,
                        ],
                        'huong-dan-mua-hang' => (object) [
                            'name' => 'Hướng dẫn mua hàng',
                            'default' => false,
                        ],
                        'huong-dan-thanh-toan' => (object) [
                            'name' => 'Hướng dẫn thanh toán',
                            'default' => false,
                        ],
                        'dieu-khoan-dang-ky' => (object) [
                            'name' => 'Điều khoản đăng ký',
                            'default' => false,
                        ],
                        'dieu-khoan-doi-tac' => (object) [
                            'name' => 'Điều khoản đối tác',
                            'default' => false,
                        ],
                        'faq' => (object) [
                            'name' => 'Câu hỏi thường gặp (FAQ)',
                            'default' => false,
                        ],
                        'huong-dan-nap-tien' => (object) [
                            'name' => 'Hướng dẫn nạp tiền',
                            'default' => false,
                        ],
                    ]
        ];
    }

    public static function register_permissions() {
        return (object) [
                    'admin' => (object) [
                        'per_require' => (object) [
                            'per_view' => (object) [
                                'name' => 'Xem bài viết',
                                'default' => true
                            ],
                            'per_edit' => (object) [
                                'name' => 'Sửa bài viết',
                                'default' => false
                            ],
                        ],
                        'signin_require' => true,
                        'classes_require' => (object) [
                            'App\Bcore\StorageService',
                            'App\Models\ArticleOModel',
                            'Illuminate\Support\Facades\Lang'
                        ]
                    ],
                    'client' => (object) [
                        'signin_require' => false,
                    ]
        ];
    }

}
