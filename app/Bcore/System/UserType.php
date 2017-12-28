<?php

namespace App\Bcore\System;

class UserType1 {

    function __construct() {
        
    }

    public static function user() {
        return __FUNCTION__;
    }

    public static function admin() {
        return __FUNCTION__;
    }

    public static function professor() {
        return __FUNCTION__;
    }

    public static function root() {
        return __FUNCTION__;
    }

    public static function admin_guest() {
        return __FUNCTION__;
    }

}
