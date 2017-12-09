<?php

namespace App\Modules\UserPermission\Controllers\Admin;

use App\Bcore\PackageServiceAD;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use App\Bcore\System\AjaxResponse;
use App\Modules\UserPermission\Services\UPService;
use App\Modules\UserPermission\Models\UserGroupModel;
use App\Modules\UserPermission\Models\UserGroupPermissionModel;
use View;

class UGPController extends PackageServiceAD {

    use \App\Modules\UserPermission\RegisterPermissions;

    public function __construct() {
        parent::__construct();
    }

    public function get_index() {
        $UserGroupModels = UserGroupModel::all();

        return view('UserPermission::/Admin/UGP/index', [
            'items' => $UserGroupModels
        ]);
    }

    public function get_ugp($id_group) {
        $UserGroupModel = UserGroupModel::find($id_group);

        if ($UGP_MODEL == null)
            return "Dữ liệu không có thực.";

        $UserGroupPermissions = (new UserGroupPermissionModel())->get_permissionsByIdGroup($UserGroupModel->id);

        $ControllderPermissions = \App\Modules\UserPermission\Models\SystemControllersModel::
                where('type', 'admin')->get();

        $DB_PERMISSIONS = $this->APP_PERMISSIONS;

        $LIST_PERS_RENDERED = UPService::render_permissionList($ControllderPermissions);

//        /dd($LIST_PERS_RENDERED);

        return view('UserPermission::/Admin/UGP/permissions', [
            'item' => $UGP_MODEL,
            'LPR' => $LIST_PERS_RENDERED
        ]);
    }

    public function post_save(Request $request) {
        $permissions = $request->input('permissions');
        $LIST_CONTROLLER_PERMISSION_JSON = [];
        foreach ($permissions as $k => $v) {
            $LIST_CONTROLLER_PERMISSION_JSON = json_encode($v);
            $UserGroupPermissionModel = UserGroupPermissionModel::where('id_controller', $k)->first();

            if ($UserGroupPermissionModel == null) {
                $UserGroupPermissionModel_New = new UserGroupPermissionModel();

                $UserGroupPermissionModel_New->id_group = $request->input('id');
                $UserGroupPermissionModel_New->id_controller = $k;
                $UserGroupPermissionModel_New->permissions = $LIST_CONTROLLER_PERMISSION_JSON;
                if ($UserGroupPermissionModel_New->save()) {
                    return "OK";
                } else {
                    return "fail";
                }
            }
        }



        dd($LIST_CONTROLLER_PERMISSION_JSON);
    }

    public function ajax(Request $request) {
        $act = $request->input('act');
        switch ($act) {

            default:
                return AjaxResponse::actionUndefined();
        }
    }

}
