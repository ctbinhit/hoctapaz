<?php

namespace App\Bcore\System;

use Illuminate\Support\Facades\Config;

class RouteArea {

    function __construct() {
        
    }

    public static function admin_area() {
        return config('bcore.Route.Admin');
    }

    public static function collaborator() {
        return config('bcore.Route.Collaborator');
    }

    public static function client_area() {
        return config('bcore.Route.Client');
    }

}
