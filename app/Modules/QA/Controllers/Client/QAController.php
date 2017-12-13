<?php

namespace App\Modules\QA\Controllers\Client;

use App\Bcore\PackageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
// MODELS
use App\Modules\QA\Models\QAModel;
use App\Modules\QA\Models\QACommentModel;
// SYSTEM SERVICE
use App\Bcore\Services\SeoService;
use App\Bcore\Services\CategoryService;
use App\Bcore\Services\UserService;
use App\Bcore\Services\PeopleService;
use App\Bcore\Services\NotificationService;
use App\Bcore\System\AjaxResponse;
use App\Bcore\System\DataType;
use View;
use App\Bcore\Services\UserServiceV2;
use App\Bcore\System\UserType;

class QAController extends PackageService {

    private $view_prefix = 'QA::Client/';

    public function __construct() {
        parent::__construct();

        View::share( 'base_categories', CategoryService::get_baseCategories('hoctap', 'exam'));
    }

    public function get_index($category = null, Request $request) {
        SeoService::seo_title('Hỏi đáp trực tuyến');
        SeoService::seo_description('Hỏi đáp trực tuyến, hàng nghìn học viên sẽ cùng giải đáp giúp bạn.');

        $QAModels = DB::table('qa')
                ->join('categories_lang', 'categories_lang.id_category', '=', 'qa.id_category')
                ->join('users', 'users.id', '=', 'qa.id_user')
                ->leftJoin('qa_cmt', 'qa_cmt.id_qa', '=', 'qa.id')
                ->where([
                    ['qa.obj_type', 'hoi-dap'],
                    ['qa.deleted_at', null],
                    ['categories_lang.id_lang', 1]
                ])
                ->select([
                    'qa.id', 'qa.title', 'qa.id_user', 'qa.created_at', 'qa.content', 'qa.tbl',
                    'categories_lang.name as category_name', 'users.fullname as user_name',
                    DB::raw('COUNT(tbl_qa_cmt.id) as answer_count')
                ])
                ->groupBy('qa.id')
                ->orderBy('qa.created_at', 'desc');


        // Sort by category
        if ($category != null) {
            $CategoriesModel = CategoryService::find_byNameMeta($category);
            if ($CategoriesModel == null) {
                NotificationService::alertRight('Danh mục bạn tìm không tồn tại hoặc đã bị chuyển sang một địa chỉ khác.');
                return redirect()->route('mdle_client_qa_index');
            }
            $ArrayIdCategory = [];
            $ArrayIdCategory[] = $CategoriesModel->id;
            $CHILD = CategoryService::get_arrayIdFromIdParent($CategoriesModel->id);
            $ArrayIdCategory_ = array_merge($CHILD, $ArrayIdCategory);
            $QAModels = $QAModels->whereIn('qa.id_category', $ArrayIdCategory_);
            SeoService::seo_title('Danh mục ' . @$CategoriesModel->seo_title);
            SeoService::seo_description('Hỏi đáp trực tuyến - danh mục ' . @$CategoriesModel->seo_description);
        }

        if ($request->has('k')) {
            $QAModels = $QAModels->where([
                ['qa.title', 'LIKE', '%' . $request->input('k') . '%']
            ]);
        }

        $db_danhsachcauhoi = $QAModels->paginate(5);

        foreach ($db_danhsachcauhoi as $k => $v) {
            $v->user_photo = PeopleService::get_userPhotoURLById($v->id_user);
        }

        return view($this->view_prefix . 'qaonline/index', [
            'items' => $db_danhsachcauhoi,
            'categories' => CategoryService::html_selectCategories('hoctap', 'exam'),
            'base_categories' => CategoryService::get_baseCategories('hoctap', 'exam')
        ]);
    }

    public function get_add() {
        SeoService::seo_title('Tạo câu hỏi nhanh');
        SeoService::seo_description('Học tập AZ - Đưa câu hỏi của bạn lên để mọi người cùng giải đáp.');
        SeoService::seo_keywords('Tạo câu hỏi nhanh, tạo câu hỏi, học tập az', 'az');

        return view($this->view_prefix . 'qaonline/add_post', [
            'categories' => CategoryService::html_selectCategories('hoctap', 'exam')
        ]);
    }

    public function post_save(Request $request) {
        if ($request->input('g-recaptcha-response') == null) {
            NotificationService::alertRight('Có lỗi xảy ra trong quá trình xác thực captcha, vui lòng thử lại sau.', 'error');
            goto responseArea;
        }
        if ($request->input('id_category') == -1) {
            NotificationService::alertRight('Đăng tin không thành công, không tìm thấy danh mục!.', 'warning');
            goto responseArea;
        }
        $QAModel = new QAModel();
        $QAModel->title = $request->input('title');
        $QAModel->id_category = $request->input('id_category');
        $QAModel->content = $request->input('content');
        $QAModel->id_user = UserService::id();
        $QAModel->obj_type = 'hoi-dap';
        if ($QAModel->save()) {
            NotificationService::alertRight('Đăng tin thành công!');
        } else {
            NotificationService::alertRight('Đăng tin thất bại, vui lòng thử lại sau ít phút.');
        }
        responseArea:
        return redirect()->route('mdle_client_qa_index');
    }

    public function get_qa_detail($id, Request $request) {

        $QAModel = $QAModels = DB::table('qa')
                        ->join('categories_lang', 'categories_lang.id_category', '=', 'qa.id_category')
                        ->join('users', 'users.id', '=', 'qa.id_user')
                        ->where([
                            ['qa.id', $id],
                            ['qa.obj_type', 'hoi-dap'],
                            ['qa.deleted_at', null],
                            ['categories_lang.id_lang', 1]
                        ])
                        ->select([
                            'qa.id', 'qa.title', 'qa.created_at', 'qa.content', 'qa.id_user',
                            'categories_lang.name as category_name', 'users.fullname as user_name'
                        ])->first();

        SeoService::seo_title('Câu hỏi của ' . $QAModel->user_name);
        SeoService::seo_description('Câu hỏi của ' . $QAModel->user_name . ', truy cập vào link để giải đáp câu hỏi.');
        SeoService::seo_keywords($QAModel->user_name . ',câu hỏi,cau hoi,question,answer');

        if ($QAModel == null) {
            return "Dữ liệu không có thực";
        }
        $QAModel->user_photo = PeopleService::get_userPhotoURLById($QAModel->id_user);

        return view($this->view_prefix . 'qaonline/detail', [
            'categories' => CategoryService::html_selectCategories('hoctap', 'exam'),
            'item' => $QAModel,
            'item_cmt' => $this->load_cmtsById($QAModel->id)
        ]);
    }

    public function post_qa_detail_save($id_qa, Request $request) {
        $QACommentModel = new QACommentModel();
        $QACommentModel->content = $request->input('content');
        $QACommentModel->id_qa = $id_qa;
        $QACommentModel->id_user = \App\Bcore\Services\UserServiceV2::current_userId(\App\Bcore\System\UserType::user());
        $QACommentModel->type = 'hoi-dap';
        if ($QACommentModel->save()) {
            NotificationService::alertRight('Bình luận của bạn đã được đăng lên hệ thống.', 'success');
        } else {
            NotificationService::alertRight('Có lỗi xảy ra, tạm thời không thể đăng bình luận.', 'warning');
        }
        return redirect()->route('mdle_client_qa_detail', $id_qa);
    }

    public function ajax(Request $request) {
        $act = $request->input('act');
        switch ($act) {
            case 'load_cmts':
                return $this->load_cmts($request);
            default:
        }
    }

    private function post_cmts($request) {
        
    }

    private function load_cmtsById($id_qa) {
        $QACModels = DB::table('qa_cmt')
                ->join('users', 'users.id', '=', 'qa_cmt.id_user')
                ->join('qa', 'qa.id', '=', 'qa_cmt.id_qa')
                ->where([
                    ['qa.id', $id_qa]
                ])
                ->orderBy('qa_cmt.created_at', 'desc')
                ->select([
                    'qa_cmt.content', 'qa_cmt.created_at', 'qa_cmt.id_user',
                    'users.fullname'
                ])
                ->paginate(5);
        foreach ($QACModels as $k => $v) {
            $v->user_photo = PeopleService::get_userPhotoURLById($v->id_user);
        }
        return $QACModels;
    }

}
