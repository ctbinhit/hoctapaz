<?php

namespace App\Bcore\SystemComponents;

use App\Bcore\Services\UserService;

class ResponseOption {

    function __construct() {
        
    }

    public static function is_logged_in() {
        $tmp[__FUNCTION__] = UserService::isLoggedIn();
        return $tmp;
    }

    public static function account_type() {
        return ([
            __FUNCTION__ => UserService::account_type()
        ]);
    }

    public static function response_type($response_type) {
        return [
            __FUNCTION__ => $response_type
        ];
    }



    public static function response_state($response_state) {
        return [
            __FUNCTION__ => $response_state
        ];
    }

    public static function message($msg) {
        return [
            __FUNCTION__ => $msg
        ];
    }

    public static function code($code = 200) {
        if (!is_numeric($code)) {
            $code = 'unknow';
        }
        return [
            __FUNCTION__ => $code
        ];
    }

}
