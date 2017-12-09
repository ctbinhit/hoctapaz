<?php

namespace App\Bcore;

use App\Http\Controllers\AdminController;
use App\Http\Controllers;

class PackageServiceAD extends AdminController {

    public function __construct() {
        parent::__construct();
    }

    public static function has_package($class_name) {
        if (class_exists($class_name)) {
            return true;
        } else {
            return false;
        }
    }

}
