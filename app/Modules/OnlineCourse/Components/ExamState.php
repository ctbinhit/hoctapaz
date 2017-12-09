<?php

namespace App\Modules\OnlineCourse\Components;

class ExamState {

    function __construct() {
        
    }

    public static function free() {
        return 'free';
    }

    public static function de_thi() {
        return 'de-thi';
    }

    public static function thi_thu() {
        return 'thi-thu';
    }

    public static function trac_nghiem_online() {
        return 'trac-nghiem-online';
    }

}
