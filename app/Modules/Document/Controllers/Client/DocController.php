<?php

namespace App\Modules\Document\Controllers\Client;

use View;
use Carbon\Carbon;
use App\Models\FileModel;
use Illuminate\Http\Request;
use App\Bcore\PackageService;
use App\Bcore\Services\SeoService;
use Illuminate\Support\Facades\DB;
use App\Bcore\System\AjaxResponse;
use Illuminate\Support\Facades\Route;
use App\Bcore\Services\UserServiceV3;
use App\Bcore\Services\CategoryService;
use App\Bcore\Services\UserDataService;
use App\Bcore\SystemComponents\User\UserType;
use App\Modules\Document\Components\DocumentState;

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

    private function load_baseCategory() {
        return \App\Bcore\Services\CategoryService::get_baseCategories('hoctap', 'exam');
    }

    public function get_index($type = null, $mime_type = null, Request $request) {
        View::share('type', $type);
        View::share('mime_type', $mime_type);
        SeoService::seo_title('Tài liệu WORD tính phí');
        $doc_type = $request->doc_type;
        $DataUser = UserDataService::get_arrayIdData('files', $doc_type);

        $FileModels = (new \App\Bcore\Services\FileServiceV3())
                ->set_where('files.type', $type)
                ->set_where('files.state', DocumentState::approve())
                ->set_where('files.display', true)
                ->set_where('files.deleted_at', null)
                ->set_where('files.obj_type', 'base')
                ->set_orderBy('approved_date', 'DESC')
                ->set_pagination(5);
        $this->filter_mimeTypeByModels($FileModels, $mime_type);
        
        if ($request->has('keywords')) {
            $FileModels->search($request->input('keywords'));
        }

        $Categories = $this->load_baseCategory();
        $Models = $FileModels->get_models();

        $Models = \App\Bcore\Services\FileServiceV3::findFileByModels($Models);
     

        responseArea:
        return view('client/tailieuhoc/index', [
            'doc_type' => $doc_type,
            'items' => $Models,
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
            case 'view_demo':
                return $this->get_linkDemo($request);
            default:
                return response()->json(AjaxResponse::actionUndefined());
        }
    }

    private function get_linkDemo($request) {
        $ID_PDF = $request->input('id');
        $ParentFile = FileModel::find($ID_PDF);
        if ($ParentFile == null) {
            return null;
        }
        $FileDemo = FileModel::where([['obj_type', $ParentFile->type], ['obj_table', $ParentFile->tbl], ['obj_id', $ParentFile->id]])
                        ->orderBy('id', 'DESC')->first();
        if ($FileDemo != null) {
            return null;
        } else {
            return $FileDemo->url;
        }
    }

    private function payment($request) {
        $FILE_ID = $request->input('id');

        $FileModel = FileModel::find($FILE_ID);
        if ($FileModel == null) {
            $JsonResponse = AjaxResponse::dataNotFound();
            goto responseArea;
        }

        $UserCoinOld = \App\Models\UserModel::find($this->current_user->id);

        $UserCoinOld->coin = $UserCoinOld->coin - $FileModel->price;

        if (!$UserCoinOld->save()) {
            // Thanh toán không thành công.
            $JsonResponse = AjaxResponse::fail(['msg' => 'Có lỗi xảy ra, thanh toán thất bại!']);
            goto responseArea;
        }

        $r = UserDataService::save_dataByModel($FileModel);
        if ($r) {
            $JsonResponse = AjaxResponse::success();
        } else {
            $UM = \App\Models\UserModel::find($this->current_user->id);
            // Nếu có [Exception] => trả tiền lại cho KH
            $UserCoin = $UM->coin;
            if ($UserCoinOld < $UserCoin && $UserCoin - $UserCoinOld = $FileModel->price) {
                $UM->coin = $UM->coin + $FileModel->price;
                $UM->save();
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
        if (\App\Bcore\Services\UserServiceV2::isLoggedIn(UserType::user()) != true) {
            $JsonResponse = AjaxResponse::not_logged_in([
                        'msg' => 'Chưa đăng nhập, vui lòng đăng nhập trước khi thực hiện thao tác này.'
            ]);
            goto responseArea;
        }
        $UserModel = (new UserServiceV3())->user()->current()->loadFromDatabase()->get_userModel();

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

    private function filter_mimeTypeByModels($FileModels, $mime_type) {

        switch ($mime_type) {
            case null:
                SeoService::seo_title('Tài liệu online | PDF | WORD');
                break;
            case 'pdf':
                SeoService::seo_title('Tài liệu PDF');
                $FileModels->set_where('mimetype', 'application/pdf');
                $FileModels->set_where('price', 0);
                break;
            case 'word':
                SeoService::seo_title('Tài liệu WORD');
                $FileModels->set_where('mimetype', 'application/word');
                $FileModels->set_where('price', 0);
                break;
            case 'pdf-tinh-phi':
                SeoService::seo_title('Tài liệu PDF tính phí');
                $FileModels->set_where('mimetype', 'application/pdf');
                $FileModels->set_where('price', 0, '<>');
                break;
            case 'word-tinh-phi':
                SeoService::seo_title('Tài liệu WORD tính phí');
                $FileModels->set_where('mimetype', 'application/word');
                $FileModels->set_where('price', 0, '<>');
                break;
        }
    }

}
