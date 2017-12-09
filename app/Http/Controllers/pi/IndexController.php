<?php

namespace App\Http\Controllers\pi;

use Illuminate\Http\Request;
use App\Http\Controllers\ProfessorController;
use App\Bcore\Services\UserServiceV2;
use App\Bcore\System\UserType;

class IndexController extends ProfessorController {

    public function get_index() {
        return view($this->_RV . 'index/index');
    }

}
