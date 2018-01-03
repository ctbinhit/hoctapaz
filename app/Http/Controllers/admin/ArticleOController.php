<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use Input,
    File,
    View;
use Carbon\Carbon;
use App\Models\ArticleOModel,
    LanguageModel,
    App\Models\PhotoModel;
use ImageService,
    App\Bcore\StorageService;
use Illuminate\Support\Facades\Lang;

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
                    $ArticleOModel->id_user = $this->current_admin->id;
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
        $formdata = $request->input('formdata');

        foreach ($formdata as $k => $v) {
            if (isset($v['id'])) {
                $ArticleOModel = ArticleOModel::where('id', '=', $v['id'])->first();
                $r = $ArticleOModel->update([
                    'title' => $v['title'],
                    'content' => $v['content'],
                    'seo_title' => $v['seo_title'],
                    'seo_keywords' => $v['seo_keywords'],
                    'seo_description' => $v['seo_description']
                ]);
            }
        }
        $request->session()->flash('message', __('message.capnhatthanhcong'));
        return redirect()->route('admin_articleo_index', $request->input('type'));
    }

}
