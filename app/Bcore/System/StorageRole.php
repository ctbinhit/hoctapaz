<?php

namespace App\Bcore\System;

use App\Bcore\SystemComponents\ResponseComponent;

class StorageRole {
    
    public static function public_(){
        return 'public';
    }
    
    public static function private_(){
        return 'private';
    }
    
    public static function custom_(){
        return 'custom';
    }
    
    public static function except_id(){
        return 'except_id';
    }
    
    public static function approve_id(){
        return 'approve_id';
    }
    
}
