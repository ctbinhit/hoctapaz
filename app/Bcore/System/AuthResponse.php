<?php

namespace App\Bcore\System;

use App\Bcore\SystemComponents\ResponseComponent;
use App\Bcore\SystemComponents\ResponseOption;

class AuthResponse {

    function __construct() {
        
    }

    private static function token() {
        return str_random(10);
    }

    public static function success($extend_data = []) {
        return ResponseComponent::responseAuth([
                    ResponseOption::message('Đăng nhập thành công'),
                    ResponseOption::response_state(true),
                    ResponseOption::code(200)
                        ], $extend_data);
    }

    public static function passwordWrong($extend_data = []) {
        return ResponseComponent::responseAuth([
                    ResponseOption::message('Sai mật khẩu'),
                    ResponseOption::response_state(false),
                    ResponseOption::code(404)
                        ], $extend_data);
    }

    public static function userNotFound($extend_data = []) {
        return ResponseComponent::responseAuth([
                    ResponseOption::message('Tài khoản không tồn tại'),
                    ResponseOption::response_state(false),
                    ResponseOption::code(404)
                        ], $extend_data);
    }

    public static function userUnActive($extend_data = []) {
        return ResponseComponent::responseAuth([
                    ResponseOption::message('Tài khoản chưa được kích hoạt, vui lòng kích hoạt tài khoản trước khi '
                            . 'sử dụng dịch vụ.'),
                    ResponseOption::response_state(false),
                    ResponseOption::code(401)
                        ], $extend_data);
    }

    public static function accountTypeError($extend_data = []) {
        return ResponseComponent::responseAuth([
                    ResponseOption::message('Role error'),
                    ResponseOption::response_state(false),
                    ResponseOption::code(403)
                        ], $extend_data);
    }

}
