<?php

namespace App\Bcore\System;

class DataType {

    function __construct() {
        
    }

    public static function json() {
        return __FUNCTION__;
    }

    public static function text() {
        return __FUNCTION__;
    }

    public static function view() {
        return __FUNCTION__;
    }

    public static function application_pdf() {
        return 'application/pdf';
    }

    public static function model() {
        return __FUNCTION__;
    }

}
