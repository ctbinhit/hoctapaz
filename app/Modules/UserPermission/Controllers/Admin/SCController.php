<?php

namespace App\Modules\UserPermission\Controllers\Admin;

use App\Bcore\PackageServiceAD;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use App\Modules\UserPermission\Services\UPService;

class SCController extends PackageServiceAD {

    function __construct() {
        parent::__construct();
    }

    public function get_index() {
        $Controllers = UPService::get_controllers();

        $DB_Controllers = \App\Modules\UserPermission\Models\SystemControllersModel::all();

        foreach ($Controllers as $k => $v) {
            $r = $DB_Controllers->where('id', $v)->first();
            if ($r != null) {
                unset($Controllers[$k]);
            }
        }



        return view('UserPermission::Admin/SC/sc_index', [
            'controllers' => $Controllers,
            'db_controllers' => $DB_Controllers,
        ]);
    }

    public function get_add($controller_name) {

        return view('UserPermission::Admin/SC/sc_add', [
        ]);
    }

    public function post_save(Request $request) {
        try {
            $SCM = new \App\Modules\UserPermission\Models\SystemControllersModel();
            $SCM->id = $request->input('id');
            $SCM->controller_name = $request->input('id');
            $SCM->name = $request->input('controller_name');
            $SCM->type = $request->input('type');
            if ($SCM->save()) {
                \App\Bcore\Services\NotificationService::alertRight('Lưu thành công.', 'success');
            } else {
                \App\Bcore\Services\NotificationService::alertRight('Lưu không thành công, vui lòng thử lại sau'
                        . ' ít phút', 'warning');
            }
        } catch (\Exception $ex) {
            \App\Bcore\Services\NotificationService::alertRight('Có lỗi xảy ra trong hệ thống, vui lòng liên hệ'
                    . ' nhà cung cấp dịch vụ để được hỗ trợ.' . $ex->getMessage(), 'danger', 'Lỗi hệ thống.');
        }
        return redirect()->route('mdle_userpermission_sc_index');
    }

    public function ajax(Request $request) {
        $act = $request->input('act');
        switch ($act) {
            case 'rc':
                return $this->remove_controller($request);
            default:
                return response()->json(\App\Bcore\System\AjaxResponse::actionUndefined());
        }
    }

    private function remove_controller($request) {
        $id_controller = $request->input('id');
        $SCM = \App\Modules\UserPermission\Models\SystemControllersModel::where('id', $id_controller)->first();
        if ($SCM->delete()) {
            $JsonResponse = \App\Bcore\System\AjaxResponse::success();
        } else {
            $JsonResponse = \App\Bcore\System\AjaxResponse::faild($request);
        }
        return response()->json($JsonResponse);
    }

}
