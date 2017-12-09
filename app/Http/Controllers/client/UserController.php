<?php

namespace App\Http\Controllers\client;

use Illuminate\Http\Request;
use App\Http\Controllers\ClientController;
use App\Bcore\Services\UserService;
use App\Bcore\Services\UserDataService;
use App\Bcore\Services\SeoService;
use Carbon\Carbon;
use UserModel,
    ExamUserModel,
    ExamModel;
use App\Models\UserDataModel;
use App\Models\FileModel;
use Session,
    View;
use Storage;

class UserController extends ClientController {

    public $storage_folder = 'user/';
    public $ControllerName = 'UserController';

    use \App\Functions\AdminFunction;

    public function __construct() {
        parent::__construct();
        view::share('client_exam_ajax', route('client_user_ajax'));
    }

    public function get_info() {
        if (UserService::isProfessor()) {
            return redirect()->route('pi_me_info');
        }

        return view('client/user/info', [
            'user' => (object) $this->get_user()
        ]);
    }

    public function get_friends() {
        return view('client/user/friends', [
            'user' => (object) $this->get_user()
        ]);
    }

    public function get_exam() {
        $UserModel = $this->get_user();
        $ExamUserModel = ExamUserModel::where([
                    ['id_user', '=', $UserModel->id]
                ])->orderBy('id', 'DESC')->paginate(10);

        if (count($ExamUserModel) != 0) {
            $LST_ID = $this->get_arrayIdFromField('id_exam', $ExamUserModel);
            $ExamModel = ExamModel::whereIn('id', $LST_ID)->get();

            $ExamModel = $this->groupModelsById($ExamModel);
            $LST_ID = $this->get_arrayIdFromField('id_user', $ExamUserModel);
            $UserModel_ = UserModel::whereIn('id', $LST_ID)->get();
            $UserModel__ = $this->groupModelsById($UserModel_);
        }

        if (count($ExamUserModel) != 0) {
            foreach ($ExamUserModel as $v) {
                if (isset($ExamModel[$v->id_exam])) {
                    $v->exam_name = $ExamModel[$v->id_exam]->name;
                    $v->exam_time = $ExamModel[$v->id_exam]->time;
                }
                if (isset($UserModel__[$v->id_user])) {
                    $v->user_fullname = $UserModel__[$v->id_user]->fullname;
                }
            }
        }



        return view('client/user/ketquahoctap', [
            'user' => (object) $UserModel,
            'exams_user' => $ExamUserModel,
            'exams' => isset($ExamModel) ? (object) $ExamModel : null
        ]);
    }

    public function get_tldm() {

        SeoService::seo_title('Tài liệu đã mua | Học Tập AZ');

        $UserData = UserDataModel::where([
                    ['id_user', UserService::id()],
                    ['obj_table', 'files'],
                    ['obj_type', 'tai-lieu-hoc']
                ])
                ->orderBy('created_at', 'DESC')
                ->paginate(8);

        foreach ($UserData as $k => $v) {
            $v->do = json_decode($v->data_object);
            //$v->download_link = route('');
        }

        return view('client/user/tldm', [
            'files' => $UserData
        ]);
    }

    public function get_tldm_download($id) {
        $UserDataModel = UserDataModel::find($id);


        if ($UserDataModel == null) {
            return "File Không tồn tại";
        }
        
        $UserDataModel->do = json_decode($UserDataModel->data_object);

        if (!Storage::disk('localhost')->exists($UserDataModel->do->url)) {
            return "File đã bị xóa khỏi hệ thống!";
        }

        return view('client/user/tldm_filedownload', [
            'item' => $UserDataModel
        ]);
    }

    public function get_lsgd() {
        return view('client/user/lichsugiaodich', [
            'user' => (object) $this->get_user()
        ]);
    }

    public function get_caidat() {
        return view('client/user/caidat', [
            'user' => (object) $this->get_user()
        ]);
    }

    public function post_caidat(Request $request) {
        $RESPONSE = (object) [
                    'message' => 'Có lỗi xảy ra',
                    'message_type' => 'warning',
                    'message_title' => 'Thông báo'
        ];

        $UserModel = UserModel::find(session('user')['id']);
        if ($UserModel == null) {
            $RESPONSE->message = 'Cập nhật thất bại!';
            $RESPONSE->message_type = 'error';
            $RESPONSE->message = 'Lỗi!';
        } else {
            // ----- Cập nhật tên --------------------------------------------------------------------------------------
            if ($request->has('fullname')) {
                if ($request->input('fullname') == '' && strlen($request->input('fullname')) < 10) {
                    $RESPONSE->message = 'Tên hiển thị không được để trống và phải lớn hơn 10 ký tự!';
                    goto responseArea;
                }
                $UserModel->fullname = trim($request->input('fullname'));
            }


            // ----- Cập nhật mật khẩu ---------------------------------------------------------------------------------
            if ($request->has('pw') && $request->has('pw1') && $request->has('pw2')) {
                if ($UserModel->password != trim($request->input('pw'))) {
                    $RESPONSE->message = 'Cập nhật thất bại, mật khẩu cũ không đúng!';
                    goto responseArea;
                }

                if (trim($request->input('pw1')) != trim($request->input('pw2'))) {
                    $RESPONSE->message = 'Cập nhật thất bại, 2 mật khẩu không khớp!';
                    goto responseArea;
                }
                $UserModel->password = trim($request->input('pw1'));
            }

            $r = $UserModel->save();
            if ($r) {
                $RESPONSE->message = 'Cập nhật thành công!';
                $RESPONSE->message_type = 'success';
                $RESPONSE->message_title = 'Thông báo';
                goto responseArea;
            } else {
                $RESPONSE->message = 'Cập nhật thất bại, có lỗi xảy ra!';
            }
        }

        responseArea:
        session::flash('info_callback', $RESPONSE);
        return redirect()->route('client_user_caidat');
    }

    private function get_user() {
        $UserModel = UserModel::find(session('user')['id']);
        if ($UserModel == null) {
            
        } else {
            $UserModel = $this->get_avatar($UserModel);
        }
        return $UserModel;
    }

    private function get_avatar($Model) {
        if ($Model->facebook_avatar != null) {
            $Model->avatar = $Model->facebook_avatar;
        } elseif ($Model->google_avatar != null) {
            $Model->avatar = $Model->google_avatar;
        } else {
            $Model->avatar = null;
        }
        return $Model;
    }

}
