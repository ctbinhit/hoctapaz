<?php

namespace App\Http\Controllers\admin;

use DB;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Modules\OnlineCourse\Models\ExamModel;
use App\Modules\OnlineCourse\Models\ExamRegisteredModel;

class ExamManController extends AdminController {

    public $storage_folder = 'exam/';
    public $ControllerName = 'ExamManController';

    use \App\Functions\AdminFunction;

    public function __construct() {
        parent::__construct();
    }

    public function get_approver() {
        $ERMS = DB::table('m1_exam_registered')
                        ->join('categories', 'categories.id', '=', 'm1_exam_registered.id_category')
                        ->join('categories_lang', 'categories_lang.id_category', '=', 'categories.id')
                        ->join('users', 'users.id', '=', 'm1_exam_registered.id_user')
                        ->where([
                            ['m1_exam_registered.approved_by', '=', 0],
                            ['m1_exam_registered.state', 0],
                            ['categories_lang.id_lang', 1]
                        ])
                        ->select([
                            'm1_exam_registered.id', 'm1_exam_registered.id_user', 'm1_exam_registered.id_category'
                            , 'm1_exam_registered.name', 'm1_exam_registered.time', 'm1_exam_registered.views', 'm1_exam_registered.price',
                            'm1_exam_registered.price2', 'm1_exam_registered.state', 'm1_exam_registered.created_at',
                            'categories_lang.name as category_name',
                            'users.fullname as pi_name'
                        ])
                        ->orderBy('created_at', 'DESC')->paginate(5);



        renderViewArea:
        return view($this->_RV . 'exam/approver', [
            'items' => $ERMS,
            'tbl' => 'm1_exam'
        ]);
    }

    public function get_app_registered(Request $request) {
        $ERMS = DB::table('m1_exam_registered')
                        ->join('categories', 'categories.id', '=', 'm1_exam_registered.id_category')
                        ->join('categories_lang', 'categories_lang.id_category', '=', 'categories.id')
                        ->join('users', 'users.id', '=', 'm1_exam_registered.id_user')
                        ->where([
                            ['m1_exam_registered.approved_by', '<>', 0],
                            ['m1_exam_registered.state', 1],
                            ['categories_lang.id_lang', 1]
                        ])
                        ->select([
                            'm1_exam_registered.id', 'm1_exam_registered.id_user', 'm1_exam_registered.id_category'
                            , 'm1_exam_registered.name', 'm1_exam_registered.time', 'm1_exam_registered.views', 'm1_exam_registered.price',
                            'm1_exam_registered.price2', 'm1_exam_registered.state', 'm1_exam_registered.created_at',
                            'm1_exam_registered.start_date', 'm1_exam_registered.expiry_date',
                            'categories_lang.name as category_name',
                            'users.fullname as pi_name', 'users.email as user_email'
                        ])
                        ->orderBy('created_at', 'DESC')->paginate(5);

        renderViewArea:
        return view($this->_RV . 'exam/app_registered', [
            'items' => $ERMS,
            'tbl' => 'm1_exam'
        ]);
    }

    public function get_approver_reject($id) {
        $ERM = ExamRegisteredModel::find($id);
        if ($ERM == null) {
            session::flash('message_type', 'error');
            session::flash('message', __('message.dulieukhongcothuc'));
            return redirect()->route('admin_examman_approver');
        }

        $ERM->state = -1;
        $ERM->updated_by = $this->current_admin->id;
        if ($ERM->save()) {
            session::flash('message', 'Xác thực thành công.');
        } else {
            session::flash('message_type', 'error');
            session::flash('message', 'Xác thực không thành công.');
        }

        return redirect()->route('admin_examman_approver');
    }

    public function get_approver_detail($id) {
        $ERM = DB::table('m1_exam_registered')
                ->join('categories', 'categories.id', '=', 'm1_exam_registered.id_category')
                ->join('categories_lang', 'categories_lang.id_category', '=', 'categories.id')
                ->join('users', 'users.id', '=', 'm1_exam_registered.id_user')
                ->where([
                    ['m1_exam_registered.id', $id]
                ])
                ->select([
                    'm1_exam_registered.id', 'm1_exam_registered.name', 'm1_exam_registered.description',
                    'm1_exam_registered.price', 'm1_exam_registered.price2', 'm1_exam_registered.time',
                    'm1_exam_registered.id_category', 'm1_exam_registered.id_user', 'm1_exam_registered.id_exam',
                    'm1_exam_registered.seo_title', 'm1_exam_registered.seo_description', 'm1_exam_registered.seo_keywords',
                    'm1_exam_registered.created_at',
                    'users.fullname as user_fullname',
                    'categories_lang.name as cate_name'
                ])
                ->first();

        $PDF = \App\Models\FileModel::where([
                    ['obj_id', $ERM->id_exam],
                    ['id_user', $ERM->id_user],
                    ['obj_table', 'm1_exam'],
                ])->select('url')->orderBy('id', 'DESC')->first();
        $ERM->file_pdf_url = \Illuminate\Support\Facades\Storage::disk('localhost')->url($PDF->url);

        if ($ERM == null) {
            session::flash('message_type', 'error');
            session::flash('message', __('message.dulieukhongcothuc'));
            return redirect()->route('admin_examman_approver');
        }

        return view($this->_RV . 'exam/approver_detail', [
            'item' => $ERM
        ]);
    }

    public function post_approver_detail(Request $request) {
        if (!$request->has('id')) {
            session::flash('message_type', 'error');
            session::flash('message', __('message.coloixayratrongquatrinhxuly'));
            goto redirectArea;
        }
        $ERM = ExamRegisteredModel::find($request->input('id'));

        if ($ERM == null) {
            session::flash('message_type', 'error');
            session::flash('message', __('message.dulieukhongcothuc'));
            goto redirectArea;
        }

        $ERM->approved_by = $this->current_admin->id;
        $ERM->approved_at = \Carbon\Carbon::now();
        $ERM->state = 1;
        if ($ERM->save()) {
            session::flash('message', 'Xác thực thành công.');
        } else {
            session::flash('message_type', 'error');
            session::flash('message', 'Có lỗi xảy ra trong quá trình xác thực');
        }
        redirectArea:
        return redirect()->route('admin_examman_approver');
    }

}
