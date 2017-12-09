<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Config;
use Illuminate\View\View;
use Illuminate\Http\Request;

class SystemController extends AdminController {

    use \App\Functions\AdminFunction;

    public function __construct() {
        parent::__construct();
    }

    public function get_service() {
        $SM = \App\Models\ServiceModel::get();

        return view('admin/system/services', [
            'items' => $SM
        ]);
    }

    public function get_service_add() {
        return view('admin/system/services_add');
    }

    public function post_service_save(Request $request) {
        if (!$request->has('service_path')) {
            goto redirectArea;
        }

        $Model = new \App\Models\ServiceModel();
        $Model->service_path = $request->input('service_path');
        $Model->service_name = $request->input('service_name');
        $Model->active = $request->input('status') == 'on' ? true : false;
        $Model->save();
        redirectArea:
        return redirect()->route('admin_system_service');
    }

}
