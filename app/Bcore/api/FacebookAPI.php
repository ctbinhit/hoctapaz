<?php

namespace App\Bcore\API;

class FacebookAPI {

    function __construct() {
        
    }

    private static function api() {
        return (object) [
                    'app_id' => '',
                    'app_key' => '',
                    'app_version' => '',
                    'token' => '',
                    'addons' => '',
        ];
    }
    
    public static function license(){
        return '';
    }

}
