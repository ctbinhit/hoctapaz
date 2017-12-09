<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use UserModel,
    ArticleModel,
    UserPermissionModel,
    CountryModel;
use ExamModel,
    PhotoModel,
    FileModel;
use FileService,
    ImageService;
use Socialite;

class TestController extends AdminController {

    public function index() {
        $UserModel = UserModel::find(2);
        foreach ($UserModel->UserPermission as $k => $v) {
            echo $v->id_menu;
        }
    }

    public function index2() {
        $ArticleModel = ArticleModel::find(1);
        var_dump($ArticleModel->photo());
    }

    public function get_thionline() {

        return view('test/thionline/index');
    }

    public function get_exam($tenkhongdau) {
        $Model = ExamModel::where([
                    ['name_meta', '=', trim($tenkhongdau)]
                ])->first();
        if ($Model == null) {
            echo "Bài thi không tồn tại";
            return;
        }
        if ($Model->approved_by == -1) {
            echo "Bài thi không tồn tại hoặc đã bị xóa bởi nhà quản trị!";
            return;
        }
        if ($Model->deleted != null) {
            echo "Bài thi đã bị xóa!";
            return;
        }

        $Professor = UserModel::find($Model->id_user);
        if ($Professor == null) {
            // Không load đc thông tin giáo viên
            echo "Có lỗi xảy ra!";
            return;
        }
        $Model->professor_name = $Professor->fullname;

        if ($Model->seo_keywords != null) {
            $tmp = explode(',', $Model->seo_keywords);
            $Model->seo_keywords = $tmp;
        }

        $ModelDetail = $Model->db_rela_detail;
        $Model->qc = count($ModelDetail);
        return view('test/thionline/exam', [
            'item' => $Model,
                //'item_detail' => $ModelDetail
        ]);
    }

    public function get_place() {
        $lst_city = CountryModel::find(238)->db_rela_wards;
        //var_dump($lst_city);
        foreach ($lst_city as $k => $v) {
            echo $v->name . "<br>";
        }
    }

    public function get_login_google() {
        return Socialite::driver('google')->redirect();
        return view('test/login/google', [
        ]);
    }

    public function get_login_google_callback() {
        $user = Socialite::driver('google')->user();
        dd($user->email);
    }

    public function get_login_fb() {
        return Socialite::driver('facebook')->redirect();
    }

    public function get_login_fb_callback() {
        $user = Socialite::driver('facebook')->user();
        dd($user);
    }

    public function _ajax(Request $request) {
        $response = (object) [
                    'data' => null,
                    'exam' => null,
                    'exam_detail' => null,
                    'status' => false,
        ];
        switch ($request->input('action')) {
            case 'exam_start':
                $Model = ExamModel::find($request->input('id'));
                if ($Model != null) {
                    $response->status = true;
                    $ModelDetail = $Model->db_rela_detail;
                    $response->exam = $Model;
                    $response->exam_detail = $ModelDetail;

                    $FileModel = new FileModel();
                    $FileService = new FileService();
                    $item_pdf = $FileModel->get_file($Model->id, 'm1_exam', 'document');
                    $item_pdf->sub_dir = 'documents';
                    $Model->file_pdf = $FileService->convertModelToURL($item_pdf);
                } else {
                    $response->status = false;
                }
                break;
        }
        return response()->json($response);
    }

}
