<?php

namespace App\Bcore\System;

use App\Bcore\SystemComponents\ResponseComponent;

class AjaxResponse {

    function __construct() {
        
    }

    public static function actionUndefined($extend_data = []) {
        return array_merge(ResponseComponent::
                responseState(false, 'Thao tác không xác định.', 'warning'), (array) $extend_data);
    }

    public static function dataNotFound($extend_data = []) {
        return array_merge(ResponseComponent::
                responseState(false, 'Dữ liệu không có thực.', 'danger'), (array) $extend_data);
    }

    public static function success($extend_data = []) {
        return array_merge(ResponseComponent::
                responseState(true, 'thao tác thành công.'), (array) $extend_data);
    }

    public static function fail($extend_data = []) {
        return array_merge(ResponseComponent::
                responseState(false, 'thao tác thất bại.', 'warning'), (array) $extend_data);
    }

    public static function has_error($extend_data = [], $extend_request = []) {
        $data = array_merge((array) $extend_data, (array) $extend_request);
        return array_merge(ResponseComponent::
                responseState(false, 'Có lỗi xảy ra.', 'danger'), (array) $data);
    }

//    public static function error_permission() {
//        
//    }

    public static function not_logged_in($extend_data = [], $extend_request = []) {
        $data = array_merge((array) $extend_data, (array) $extend_request);
        return array_merge(ResponseComponent::
                responseState(false, 'Chưa đăng nhập.', 'danger'), (array) $data);
    }

}
