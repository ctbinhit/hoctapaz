<?php

namespace App\Http\Controllers\client;

use Session,
    View,
    Storage;
use UserModel,
    ExamUserModel,
    ExamModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\UserDataModel;
use App\Bcore\Services\SeoService;
use App\Bcore\System\AjaxResponse;
use App\Bcore\Services\UserService;
use App\Bcore\Services\UserServiceV3;
use App\Http\Controllers\ClientController;
use App\Modules\UserVIP\Models\UserVIPModel;
use App\Bcore\SystemComponents\User\UserType;

class UserController extends ClientController {

    public $storage_folder = 'user/';
    public $ControllerName = 'UserController';

    use \App\Functions\AdminFunction;

    public function __construct() {
        parent::__construct();
        view::share('client_exam_ajax', route('client_user_ajax'));

        $this->middleware(function($request, $next) {
            $this->userData = (new UserServiceV3())->user()->current()->loadFromDatabase()->get_userModel();
            view::share('userData', $this->userData);
            return $next($request);
        });
    }

    public function get_info() {
        if (UserService::isProfessor()) {
            return redirect()->route('pi_me_info');
        }
        return view('client/user/info', [
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
                    ['id_user', \App\Bcore\Services\UserServiceV2::current_userId(UserType::user())],
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

    public function get_upgradeVIP() {
        SeoService::seo_title('AZ - Nâng cấp VIP');
        $UserModel = $this->get_currentDBUserData(UserType::user());
        $UserVIPModel = $UserModel->load_vip();

        $UserVIPModels = UserVIPModel::where('type', 'user')
                ->orderBy('level', 'ASC');

        return view('client/user/vip/upgrade_vip', [
            'user' => (object) $this->userdata,
            'next_package' => $this->load_nextVIP() != null ? $this->load_nextVIP() : null,
            'packages' => $UserVIPModels->get()
        ]);
    }

    public function get_donate() {
        SeoService::seo_title('AZ - Nạp thẻ');

        return view('client/user/donate/donate');
    }

    public function post_donate(Request $request) {

        $card_seri = $request->input('card_seri');
        $card_pin = $request->input('card_pin');
        $card_type = $request->input('card_type');

        $BGTC = new \App\Modules\BKPayment\Services\BKTCService();
        $BGTC->set_card($card_type, $card_seri, $card_pin);

        $UserModel = $this->get_currentDBUserData(\App\Bcore\System\UserType::user());

        $R = (object) $BGTC->payment();

        switch ($R->status_code) {
            case 200:
                $UserModel->coin = $UserModel->coin + $R->card_value;
                if ($UserModel->save()) {
                    $this->set_response('Bạn vừa nạp thành công ' . $R->card_value . ' vào tài khoản, số dư hiện tại là ' . $UserModel->coin . ' VNĐ');
                } else {
                    $this->set_response('Có lỗi xảy ra trong quá trình thao tác, vui lòng liên hệ quản trị để được hỗ trợ.');
                }
                return reidrect()->route('client_user_donate');
            case 202: //Giao dịch chưa xác định được trạng thái thành công hay không! TimeOut
                \App\Bcore\Services\NotificationService::popup_default('Không có phản hồi, thao tác thất bại.');
                break;
            case 450:
                \App\Bcore\Services\NotificationService::popup_default('Lỗi hệ thống!');
                break;
            case 460:
                $this->set_response($R->msg, 'warning');
                break;
            case 400:
                $this->set_response($R->msg, 'warning');
                break;
            default:
                $this->set_response($R->msg, 'warning');
        }
        return back()->withInput();
    }

    public function get_update_profilepicture() {
        SeoService::seo_title('Cập nhật ảnh đại diện | Thông tin cá nhân | AZ');
        $USV3 = (new UserServiceV3());
        $UserModel = $USV3->user()->current()->loadFromDatabase()->withPhotoUrl();

        return view('client/user/profile/picture', [
            'item' => $UserModel->get_userModel()
        ]);
    }

    public function get_caidat() {
        $Cities = \App\Models\CityModel::all();

        $Districts = \App\Models\DistrictModel::all();

        return view('client/user/caidat', [
            'user' => $this->current_user,
            'cities' => $Cities
        ]);
    }

    public function post_caidat(Request $request) {
        $act = $request->input('act');
        switch ($act) {
            case 'update_info':
                $this->update_info($request);
                break;
            case 'update_account':
                $this->update_account($request);
                break;
            case 'update_profilePicture':
                $this->update_profilePicture($request);
                break;
            default:
                $this->set_response('Thao tác không xác định!', 'warning');
        }
        if ($request->has('cwu')) {
            return redirect($request->input('cwu'));
        }
        return redirect()->route('client_user_caidat');
    }

    private function update_profilePicture($request) {
        $UserModel = (new UserServiceV3())->user()->current()->loadFromDatabase()->get_userModel();
        $FileUpload = $request->hasFile('profile_picture') ? $request->file('profile_picture') : null;
        if ($FileUpload == null) {
            $this->set_response('Cập nhật thất bại, File không hợp lệ!', 'warning');
            goto EndFunction;
        }
        $LocalPath = Storage::disk('localhost')->put('users/profile_picture', $FileUpload, 'public');
        if ($LocalPath == null) {
            $this->set_response('Cập nhật thất bại, File không hợp lệ!', 'warning');
            goto EndFunction;
        }

        $PhotoModel = (new \App\Models\PhotoModel());
        $PhotoModel->set_file($FileUpload);
        $PhotoModel->url = $LocalPath;
        $PhotoModel->url_encode = md5($LocalPath);
        $PhotoModel->id_user = $UserModel->id;
        $PhotoModel->obj_type = 'photo';
        $PhotoModel->obj_table = 'users';
        $PhotoModel->obj_id = $UserModel->id;
        if ($PhotoModel->save()) {
            $UserModel->avatar = $PhotoModel->id;
            $UserModel->save();
            $this->set_response('Cập nhật ảnh đại diện thành công!', 'success');
        } else {
            $this->set_response('Cập nhật ảnh đại diện không thành công!', 'warning');
        }

        EndFunction:
    }

    private function update_account($request) {
        $UserModel = $this->get_currentDBUserData(\App\Bcore\System\UserType::user());

        if ($request->has('pw') && $request->has('pw1') && $request->has('pw2')) {
            if ($UserModel->password != trim($request->input('pw'))) {
                $this->set_response('Cập nhật thất bại, mật khẩu cũ không đúng!', 'warning');
                goto EndFunction;
            }

            if (trim($request->input('pw1')) != trim($request->input('pw2'))) {
                $this->set_response('Cập nhật thất bại, 2 mật khẩu không khớp!', 'warning');
                goto EndFunction;
            }
            $UserModel->password = trim($request->input('pw1'));
        }
        EndFunction:
    }

    private function update_info($request) {
        $UserModel = (new UserServiceV3())->user()->current()->loadFromDatabase()->get_userModel();
        if ($UserModel == null) {
            $this->set_response('Dữ liệu người dùng không tồn tại, vui lòng thử lại sau.');
        }

        if ($request->has('fullname')) {
            if ($request->input('fullname') == '' && strlen($request->input('fullname')) < 10) {
                $this->set_response('Tên hiển thị không được để trống và phải lớn hơn 10 ký tự!', 'warning');
                goto EndFunction;
            }
            $UserModel->fullname = trim($request->input('fullname'));
        }

        if ($request->has('phone')) {
            $UserModel->phone = $request->input('phone');
        }

        if ($request->has('id_city')) {
            $UserModel->address = $request->input('id_city');
        }

        if ($request->has('address')) {
            $UserModel->address = $request->input('address');
        }

        if ($UserModel->save()) {
            $this->set_response('Cập nhật thành công');
        }
        EndFunction:
    }

    public function ajax(Request $request) {
        $act = $request->input('act');
        switch ($act) {
            case 'uv':
                return $this->upgrade_vip($request);
            default:
        }
    }

    // PRIVATE FUNCTIONS

    private function upgrade_vip($request) {

        if ($this->_USER == null) {
            $json_response = AjaxResponse::not_logged_in();
            goto responseArea;
        }

        $UserModel = $this->get_currentDBUserData(\App\Bcore\System\UserType::user());

        if ($UserModel == null) {
            $json_response = AjaxResponse::not_logged_in();
            goto responseArea;
        }

        $id_vip = $request->input('id');
        $next_package = $this->load_nextVIP();
        // Package not found
        if ($next_package == null) {
            $json_response = AjaxResponse::fail([
                        'msg' => 'Hiện không thể nâng cấp vào lúc này, vui lòng thử lại vào lúc khác.'
            ]);
            goto responseArea;
        }
        // ID Nâng cấp từ client khác với id load từ controller => error
        if ($next_package->id != $id_vip) {
            $json_response = AjaxResponse::fail([
                        'msg' => 'Hiện không thể nâng cấp vào lúc này, vui lòng thử lại vào lúc khác.'
            ]);
            goto responseArea;
        }

        $UserVIPModel = UserVIPModel::find($id_vip);
        if ($UserVIPModel == null) {
            $json_response = AjaxResponse::dataNotFound();
            goto responseArea;
        }

        if ($UserModel->coin < $UserVIPModel->sum) {
            $json_response = AjaxResponse::fail([
                        'msg' => 'Số dư không đủ để thực hiện giao dịch.'
            ]);
            goto responseArea;
        }

        $UserModel->id_vip = $id_vip;
        if ($UserModel->save()) {
            $json_response = AjaxResponse::success();
        } else {
            $json_response = AjaxResponse::fail([
                        'msg' => 'Có lỗi xảy ra trong quá trình nâng cấp.'
            ]);
        }
        responseArea:
        return response()->json($json_response);
    }

    private function load_nextVIP() {
        try {
            $UserModel = $this->get_currentDBUserData(UserType::user());
            $UserVIP = UserVIPModel::orderBy('level', 'ASC');
            if ($UserModel->id_vip != null) {
                $tmp_uvm = UserVIPModel::find($UserModel->id_vip);
                $UserVIP->where([
                    ['level', '>', $tmp_uvm->level]
                ]);
            }
            return $UserVIP->first();
        } catch (\Exception $ex) {
            return null;
        }
    }

    private function set_response($message, $type = 'info', $title = 'Thông báo') {
        session::flash('page-callback', (object) [
                    'title' => $title,
                    'type' => $type,
                    'message' => $message
        ]);
    }

}
