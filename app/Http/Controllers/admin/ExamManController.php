<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use ExamModel,
    PhotoModel;
use ImageService;
use Session;

class ExamManController extends AdminController {

    public $storage_folder = 'exam/';
    public $ControllerName = 'ExamManController';

    use \App\Functions\AdminFunction;

    public function __construct() {
        parent::__construct();
    }

    public function get_approver() {
        if (session::has("user.$this->ControllerName.m1_exam.display_count")) {
            $PERPAGE = session::get("user.$this->ControllerName.m1_exam.display_count");
        } else {
            $PERPAGE = 5;
        }
        $ExamModel = new ExamModel();
        $ExamModel->set_orderBy(['id', 'DESC']);
        $ExamModel->set_deleted(1);
        $ExamModel->set_perPage($PERPAGE);
        $LST_EXAM = $ExamModel->db_get_items();
        if (count($ExamModel) == 0) {
            goto renderViewArea;
        }
        // Lấy tất cả hình ảnh theo từng bài viết & gán vào model
        $ImageServie = new ImageService();
        $items_ = $ImageServie->get_photoByModels((object) $LST_EXAM);
        $items = $ImageServie->convertUrlImageFromModels('photo', $items_);
        renderViewArea:
        return view($this->_RV . 'exam/approver', [
            'items' => $LST_EXAM,
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

        $ExamModel->approved_by = session('user')['id'];
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
