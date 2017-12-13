<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Modules\OnlineCourse\Models\ExamModel,
    PhotoModel;
use ImageService;
use Session;
use DB;

class ExamManController extends AdminController {

    public $storage_folder = 'exam/';
    public $ControllerName = 'ExamManController';

    use \App\Functions\AdminFunction;

    public function __construct() {
        parent::__construct();
    }

    public function get_approver() {

        $ExamModels = DB::table('m1_exam')
                ->join('categories', 'categories.id', '=', 'm1_exam.id_category')
                ->join('categories_lang', 'categories_lang.id_category', '=', 'categories.id')
                ->join('users', 'users.id', '=', 'm1_exam.id_user')
                ->where([
                    ['m1_exam.approved_by', '=', null],
                    ['m1_exam.state', '=', 'de-thi'],
                    ['categories_lang.id_lang', 1]
                ])
                ->select([
                    'm1_exam.id', 'm1_exam.id_user', 'm1_exam.id_category', 'm1_exam.name', 'm1_exam.name_meta', 'm1_exam.time',
                    'm1_exam.ordinal_number', 'm1_exam.views', 'm1_exam.highlight', 'm1_exam.price', 'm1_exam.display',
                    'm1_exam.created_at',
                    'categories_lang.name as category_name',
                    'users.fullname as pi_name'
                ])
                ->orderBy('created_at', 'DESC')
                ->paginate(5);
       


        renderViewArea:
        return view($this->_RV . 'exam/approver', [
            'items' => $ExamModels,
            // 'items_photo' => $items_photo,
            'tbl' => 'm1_exam'
        ]);
    }

    public function post_approver(Request $request) {
        
    }

    public function get_approver_reject($id) {
        $ExamModel = ExamModel::find($id);
        if ($ExamModel == null) {
            session::flash('message_type', 'error');
            session::flash('message', __('message.dulieukhongcothuc'));
            return redirect()->route('admin_examman_approver');
        }



        return view($this->_RV . 'exam/approver_reject', [
            'item' => $ExamModel
        ]);
    }

    public function get_approver_detail($id) {
        $ExamModel = ExamModel::find($id);
        if ($ExamModel == null) {
            session::flash('message_type', 'error');
            session::flash('message', __('message.dulieukhongcothuc'));
            return redirect()->route('admin_examman_approver');
        }

        return view($this->_RV . 'exam/approver_detail', [
            'item' => $ExamModel
        ]);
    }

    public function post_approver_detail(Request $request) {
        if (!$request->has('id')) {
            session::flash('message_type', 'error');
            session::flash('message', __('message.coloixayratrongquatrinhxuly'));
            goto redirectArea;
        }
        $ExamModel = ExamModel::find($request->input('id'));
        if ($ExamModel == null) {
            session::flash('message_type', 'error');
            session::flash('message', __('message.dulieukhongcothuc'));
            goto redirectArea;
        }

        $ExamModel->approved_by = \App\Bcore\Services\UserServiceV2::current_userId(\App\Bcore\System\UserType::admin());
        $ExamModel->approved_date = \Carbon\Carbon::now();
        $r = $ExamModel->save();
        if ($r) {
            session::flash('message', 'Xác thực thành công.');
        } else {
            session::flash('message_type', 'error');
            session::flash('message', 'Có lỗi xảy ra trong quá trình xác thực');
        }

        redirectArea:
        return redirect()->route('admin_examman_approver');
    }

}
