<?php

namespace App\Bcore\Services;

use UserModel;
use Socialite;
use Session,
    DB;
use Carbon\Carbon;
use App\Bcore\Services\UserServiceV2;
use App\Bcore\System\ErrorType;
use App\Bcore\SystemComponents\User\UserGender;
use App\Bcore\SystemComponents\User\UserType;

class AuthServiceV2 {

    private $_driver = null;
    private $_userData = null;
    private $_allowUserType = [];
    private $_logs = [];
    private $_log = null;

    public function __construct($dirver) {
        $this->_driver = $dirver;
    }

    // CHECK FUNCS

    public function is_social() {
        return $this->_userData == null ? false : true;
    }

    public function signinWithDriver() {
        if (!$this->is_social()) {
            $this->set_log('Dữ liệu user rỗng, không thể đăng nhập.' . $this->_driver, ErrorType::error(), 'Error');
        }
        $User = DB::table('users')->where('id_' . $this->_driver, $this->_userData->id)->first();
        if ($User == null) {
            $UserServiceV3 = (new UserServiceV3);
            if ($UserServiceV3->createWithDriver($this->_driver, $this->_userData)) {
                $User = $UserServiceV3->get_userModel();
                goto check_type;
            } else {
                $this->set_log('Tài khoản không tồn tại, không thể tạo mới tài khoản vào lúc này.', ErrorType::warning(), 'Đăng nhập');
                return false;
            }
        }
        check_type:

        if (!in_array($User->type, $this->_allowUserType)) {
            $this->set_log('Tài khoản ' . $User->email . ' này không thể đăng nhập vào hạng mục này!', ErrorType::warning(), 'Đăng nhập');
            return false;
        }

        UserServiceV2::signinWithModel($User);
        if (UserServiceV2::isLoggedIn(UserType::user())) {
            return true;
        } else {
            return false;
        }
    }

    // GET FUNCS

    public function get_authCallback() {
        try {
            $this->_userData = Socialite::driver($this->_driver)->user();
            return $this;
        } catch (\Exception $ex) {
            $this->set_log('Có lỗi xảy ra trong quá trình xác thực ' . $this->_driver, ErrorType::error(), 'Error', $ex);
            return null;
        }
    }

    public function get_log() {
        return $this->_log;
    }

    public function get_logs() {
        return $this->_logs;
    }

    // SET FUNCS

    public function set_userType($array) {
        if (is_array($array)) {
            $this->_allowUserType = $array;
        }
        return $this;
    }

    private function set_log($msg, $level, $title, $ext = []) {
        $log = [
            'message' => $msg,
            'level' => $level,
            'title' => $title,
            'detail' => $ext
        ];
        $this->_log = $log;
        $this->_logs[] = $log;
    }

    // PRIVATE FUCS

    private function check_email() {
        try {
            return (DB::table('users')->where('email', $this->_userData->email)->first()) == null ? false : true;
        } catch (\Exception $ex) {
            return null;
        }
    }

    private function check_id() {
        try {
            return (DB::table('users')->where('id_' . $this->_driver, $this->_userData->id)->first()) == null ? false : true;
        } catch (\Exception $ex) {
            return null;
        }
    }

}
