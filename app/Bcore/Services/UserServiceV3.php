<?php

namespace App\Bcore\Services;

use Carbon\Carbon;
use App\Models\UserModel;
use App\Bcore\System\UserSession;
use App\Bcore\SystemComponents\User\UserType;
use App\Bcore\SystemComponents\User\UserGender;
use App\Bcore\SystemComponents\ErrorType;

class UserServiceV3 {

    private $_userModel = null;
    private $_log = null;
    private $_logs = [];

    function __construct(UserModel $UserModel = null) {
        if ($UserModel != null)
            $this->_userModel = $UserModel;
    }

    public function signinWithForm($username, $password) {
        $User = UserModel::where('username', $username)
                ->orWhere('password', $password)
                ->first();
        if ($User == null) {
            $this->write_log('Tài khoản không tồn tại, đăng nhập thất bại.', \App\Bcore\SystemComponents\Error\ErrorType::warning(), 'Error');
            return false;
        }

        if ($User->password != $password) {
            $this->write_log('Sai tài khoản hoặc mật khẩu!.', \App\Bcore\SystemComponents\Error\ErrorType::warning(), 'Warning');
            return false;
        }

        $UserSession = new UserSession();
        $UserSession->set_model($User);
        $UserSession->set_session();
    }

    public function set_userModel(UserModel $UserModel) {
        $this->_userModel = $UserModel;
    }

    public function get_userModel() {
        return $this->_userModel;
    }

    public function createWithDriver($driver_name, $driver_data) {
        $UserModel = new UserModel();
        $UserModel->{'id_' . $driver_name} = $driver_data->id;
        $UserModel->fullname = $driver_data->name;
        $UserModel->{$driver_name . '_options'} = json_encode($driver_data);
        $UserModel->password = str_random(6);
        $UserModel->gender = isset($driver_data->gender) ? $driver_data->gender : UserGender::none();
        $UserModel->email = $driver_data->email;
        $UserModel->role = 1;
        $UserModel->type = UserType::user();
        $UserModel->activation_key = $this->pri_generateKeyActive();
        $UserModel->activated_at = Carbon::now();
        $UserModel->coin = 0;
        return $this->create($UserModel);
    }

    public function create(UserModel $UserModel) {
        try {
            $r = $UserModel->save();
            if ($r) {
                $this->_userModel = $UserModel;
                return true;
            }
            return false;
        } catch (\Exception $ex) {
            return false;
        }
    }

   

    public function get_log() {
        return $this->_log;
    }

    public function get_logs() {
        return $this->_logs;
    }

    private function write_log($msg, $level, $title, $ext = []) {
        $log = [
            'message' => $msg,
            'level' => $level,
            'title' => $title,
            'ext' => $ext
        ];
        $this->log = $log;
        $this->logs[] = $log;
    }

    // PRIVATE FUNCTIONS

    private function pri_generateKeyActive($length = 8) {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

}
