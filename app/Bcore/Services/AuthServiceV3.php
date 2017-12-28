<?php

namespace App\Bcore\Services;

use Socialite;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\UserModel;
use App\Bcore\Services\UserServiceV2;
use App\Bcore\Services\UserServiceV3;
use App\Bcore\SystemComponents\User\UserGender;
use App\Bcore\SystemComponents\User\UserType;
use App\Bcore\SystemComponents\Error\ErrorType;

class AuthServiceV3 {

    private $_options = [
        'driver' => null,
        'driver_data' => null,
        'userType' => null
    ];
    private $_authState = null;
    private $_log = null;
    private $_logs = [];

    public function __construct() {
        $this->_options = (object) $this->_options;
    }

    public function has_tokenData() {
        return session()->has('social_tokenData') ? true : false;
    }

    public function set_options($options) {
        
    }

    public function get_tokenData() {
        return session()->has('social_tokenData') ? session('social_tokenData') : null;
    }

    public function keep_tokenData() {
        if ($this->has_tokenData()) {
            session()->keep('social_tokenData');
        }
    }

    public function get_driverData() {
        return $this->_options->driver_data;
    }

    public function authState() {
        return $this->_authState;
    }

    public function authWithDriver($driver) {
        $driver_data = $this->pri_loadDriverData($driver);
        if (!$this->pri_hasSocialData()) {
            $this->set_log('Không thể xác thực ' . $driver . ' vào lúc này.', ErrorType::warning());
            $this->_authState = -1;
            goto endFunction;
        }

        $UserModel = UserModel::where([
                    ['id_' . $driver, $driver_data->id]
                ])->first();

        if ($UserModel == null) {
            $this->set_log('Không tồn tại ID DRIVER trên hệ thống.', ErrorType::info());
            $this->pri_setSocialTokenData();
            $this->_authState = 2;
            goto endFunction;
        }
        (new UserServiceV3())->signinWithModel($UserModel);
        $this->_authState = 1;
        endFunction:
        return $this;
    }

    public static function authRedirect($driver_name = null) {
        try {
            return Socialite::driver($driver_name)->redirect();
        } catch (\Exception $ex) {
            $this->set_log($ex->getMessage(), \App\Bcore\System\ErrorType::danger(), $ex);
            session::flash('info_callback', (object) [
                        'message_type' => 'danger',
                        'message' => "Không thể xác thực $driver_name vào lúc này!"]);
            return redirect()->route('client_login_index');
        }
    }

    // USER TYPE 

    public function user() {
        $this->_options->userType = __FUNCTION__;
        return $this;
    }

    public function admin() {
        $this->_options->userType = __FUNCTION__;
        return $this;
    }

    // SET FUNCTIONS

    public function set_driver($driver_name) {
        $this->_options->driver = $driver_name;
        return $this;
    }

    // PRIVATE FUNCTIONS

    private function pri_setSocialTokenData() {
        session()->flash('social_tokenData', (object) [
                    'driver' => $this->_options->driver,
                    'data' => $this->_options->driver_data
        ]);
    }

    private function pri_hasSocialData() {
        return $this->_options->driver_data != null ? true : false;
    }

    private function pri_loadDriverData($driver_name) {
        try {
            $this->set_driver($driver_name);
            $this->_options->driver_data = Socialite::driver($driver_name)->user();
        } catch (\Exception $ex) {
            
        }
        return $this->_options->driver_data;
    }

    // LOG


    private function set_log($message, $level, $ex_data = null) {
        $this->_log = (object) [
                    'message' => $message,
                    'level' => $level,
                    'ex' => $ex_data
        ];
        $this->push_logs($this->_log);
        return $this->_log;
    }

    private function push_logs($log) {
        $this->_logs[] = $log;
    }

}
