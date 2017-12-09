<?php

namespace App\Modules\Background\Controllers;

use Illuminate\Http\Request;
use App\Bcore\PackageService;
use App\Modules\Pavn\Services\APIService;

class BackgroundController extends PackageService {

    public $module_name = 'Background';

    public function __construct() {
        parent::__construct();
    }

    public function get_index() {

        return view("$this->module_name::index");
    }

    public function post_index() {
        echo "a";
    }

}
