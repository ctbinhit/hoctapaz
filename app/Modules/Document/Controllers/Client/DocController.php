<?php

namespace App\Modules\Document\Controllers\Client;

use App\Bcore\PackageService;
use Illuminate\Http\Request;
use App\Bcore\Services\NotificationService;
use App\Events\AfterSendRequestFileDoc;
use App\Models\FileModel;
use App\Bcore\System\AjaxResponse;
use Carbon\Carbon;
use App\Bcore\Services\UserDataService;
use App\Models\UserDataModel;
use App\Bcore\Services\SeoService;
use App\Bcore\Services\UserService;
use App\Modules\Document\Components\DocumentState;
use Illuminate\Support\Facades\Log;
use App\Bcore\Services\LogService;
use View,
    DB;
use Illuminate\Support\Facades\Route;
use App\Bcore\Services\CategoryService;

class DocController extends PackageService {

    protected $current_route;

    public static function info() {
        return (object) [
                    'storage' => 'documents',
                    'version' => 2.0
        ];
    }

    public function __construct() {
        parent::__construct();
        $this->current_route = Route::currentRouteName();
        View::share('current_route', $this->current_route);
    }

    private function file_filter($FileModels, $mime_type) {
        switch ($mime_type) {
            case null:
                SeoService::seo_title('Tài liệu online | PDF | WORD');
                break;
            case 'pdf':
                SeoService::seo_title('Tài liệu PDF');
                $FileModels->where([
                    ['mimetype', 'application/pdf'],
                    ['price', 0]
                ]);
                break;
            case 'word':
                SeoService::seo_title('Tài liệu WORD');
                $FileModels->where([
                    ['mimetype', 'application/word'],
                    ['price', 0]
                ]);
                break;
            case 'pdf-tinh-phi':
                SeoService::seo_title('Tài liệu PDF tính phí');
                $FileModels->where([
                    ['mimetype', 'application/pdf'],
                    ['price', '<>', 0]
                ]);
                break;
            case 'word-tinh-phi':
                SeoService::seo_title('Tài liệu WORD tính phí');
                $FileModels->where([
                    ['mimetype', 'application/word'],
                    ['price', '<>', 0]
                ]);
                break;
        }
        return $FileModels;
    }

    private function file_orderBy($FileModels) {
        return $FileModels->orderBy('approved_date', 'DESC');
    }

    private function load_fileByType($type) {
        $FileModels = DB::table('files')
                        ->join('users', 'users.id', '=', 'files.id_user')
                        ->leftJoin('categories_lang', 'categories_lang.id_category', '=', 'files.id_category')
                        ->where([
                            ['files.obj_type', $type],
                            ['state', DocumentState::approve()],
                            ['files.display', true],
                            ['files.deleted_at', null],
                            ['categories_lang.id_lang', 1]
                        ])->select([
            'files.*', 'users.fullname',
            'categories_lang.name as name_category'
        ]);
        return $FileModels;
    }

    private function load_baseCategory() {
        return \App\Bcore\Services\CategoryService::get_baseCategories('hoctap', 'exam');
    }

    public function get_index($type = null, $mime_type = null, Request $request) {
        View::share('type', $type);
        View::share('mime_type', $mime_type);


        $doc_type = $request->doc_type;

        $DataUser = UserDataService::get_arrayIdData('files', $doc_type);

        $FileModel = $this->load_fileByType($type);
        $FileModel = $this->file_orderBy($FileModel);
        $FileModel = $this->file_filter($FileModel, $mime_type);

        if ($request->has('keywords')) {
            $FileModel->where('files.name', 'LIKE', '%' . $request->input('keywords') . '%');
        }

        $FileModel = $FileModel->paginate(8);

        $Categories = $this->load_baseCategory();

        if ($request->ajax()) {
            if ($request->input('type') == 'ajax_view') {
                return response()->json(view('client/tailieuhoc/parts/items', array('items' => $FileModel))->render());
            }
            goto responseArea;
        }

        responseArea:
        return view('client/tailieuhoc/index', [
            'doc_type' => $doc_type,
            'items' => $FileModel,
            'categories_hoctap' => $Categories
        ]);
    }

    public function get_category($type, $name_meta, $mime_type = null) {
        View::share('type', $type);
        View::share('cate_meta', $name_meta);
        View::share('mime_type', $mime_type);
        $this_category = CategoryService::find_byNameMeta($name_meta);

        SeoService::seo_title('Danh mục ' . $this_category->name);

        $FileModels = $this->load_fileByType($type);
        $FileModels = $this->file_orderBy($FileModels);
        $FileModels = $this->file_filter($FileModels, $mime_type);

        $FileModels->where('files.id_category', $this_category->id);

        $FileModels = $FileModels->paginate(8);

        $Categories = $this->load_baseCategory();


        return view('client/tailieuhoc/index', [
            'this_cate' => $this_category,
            'items' => $FileModels,
            'categories_hoctap' => $Categories
        ]);
    }

    public function post_save(Request $request) {
        
    }

    public function ajax(Request $request) {
        $act = $request->input('act');
        switch ($act) {
            case '88139f72e980bea9f07063f743ca523c':
                return $this->check_payment($request);
            case 'f83c2a85d972a89238f31296c63f0dbc': // Thanh toán
                return $this->payment($request);
            default:
                return response()->json(AjaxResponse::actionUndefined());
        }
    }

    private function payment($request) {
        $FILE_ID = $request->input('id');

        $FileModel = FileModel::find($FILE_ID);
        if ($FileModel == null) {
            $JsonResponse = AjaxResponse::dataNotFound();
            goto responseArea;
        }

        $UserCoinOld = UserService::coin();

        if (!UserService::pay($FileModel->price)) {
            // Thanh toán không thành công.
            $JsonResponse = AjaxResponse::fail(['msg' => 'Có lỗi xảy ra, thanh toán thất bại!']);
            goto responseArea;
        }

        $r = UserDataService::save_dataByModel($FileModel);
        if ($r) {
            $JsonResponse = AjaxResponse::success();
        } else {
            // Nếu có [Exception] => trả tiền lại cho KH
            $UserCoin = UserService::coin();
            if ($UserCoinOld < $UserCoin && $UserCoin - $UserCoinOld = $FileModel->price) {
                UserService::returnMoneyBack($FileModel->price);
            }
            $JsonResponse = AjaxResponse::fail();
        }
        responseArea:
        return response()->json($JsonResponse);
    }

    private function check_payment($request) {
        $File_ID = $request->input('id');
        $FileModel = FileModel::find($File_ID);
        if ($FileModel == null) {
            $JsonResponse = AjaxResponse::dataNotFound();
            goto responseArea;
        }

        if (UserService::isLoggedIn() != true) {
            $JsonResponse = AjaxResponse::not_logged_in([
                        'msg' => 'Chưa đăng nhập, vui lòng đăng nhập trước khi thực hiện thao tác này.'
            ]);
            goto responseArea;
        }

        $UserModel = UserService::db_info();

        if ($UserModel->coin - $FileModel->price < 0) {
            $JsonResponse = AjaxResponse::fail(['msg' => 'Số dư không đủ để thực hiện giao dịch, vui lòng nạp thêm']);
            goto responseArea;
        }

        $view = view('client/tailieuhoc/components/thanhtoan', [
            'file' => $FileModel,
            'user' => $UserModel,
                ])->render();

        $JsonResponse = AjaxResponse::success(['view' => $view, 'file_id' => $File_ID]);

        responseArea:
        return response()->json($JsonResponse);
    }

}
