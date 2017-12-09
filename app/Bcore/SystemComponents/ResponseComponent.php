<?php

namespace App\Bcore\SystemComponents;

use App\Bcore\Services\UserService;

class ResponseComponent {

    function __construct() {
        
    }

    public static function responseAuth($data, $extend_data) {
        $data_ = [];
        foreach ($data as $k => $v) {
            $data_ = array_merge($data_, $v);
        }
        return array_merge($data_, $extend_data);
    }

    public static function responseState($state, $message = null, $error_level = null, $code = 200) {
        return [
            'is_logged_in' => UserService::isLoggedIn(),
            'account_type' => UserService::account_type(),
            'response_code' => $code,
            'response_state' => $state,
            'response_text' => $message,
            'error_level' => $error_level
        ];
    }

}
