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

/*
 * User Group Controller
 */

class UGController extends PackageServiceAD {

    use \App\Modules\UserPermission\RegisterPermissions;

    public function get_index() {
        $UserGroupModels = UserGroupModel::all();

        return view('UserPermission::/Admin/user_groups/index', [
            'items' => $UserGroupModels
        ]);
    }

    public function get_pers_detail($id_group) {
        $UGP_MODEL = UserGroupModel::find($id_group);

        if ($UGP_MODEL == null) {
            return "Dữ liệu không có thực.";
        }

        $UserGroupPermissions = (new UserGroupPermissionModel())->get_permissionsByIdGroup($id_group);

        $ControllersPers = $this->load_classes();

        $DATA_PERMISSIONS = [];

        foreach ($ControllersPers as $k => $class) {
            if (method_exists($class, 'register_permissions')) {
                $DATA_PERMISSIONS[$class] = (new $class)->register_permissions();
            }
        }
        dd($DATA_PERMISSIONS);

        $ControllderPermissions = \App\Modules\UserPermission\Models\SystemControllersModel::
                where('type', 'admin')->get();

        $LIST_PERS_RENDERED = UPService::render_permissionList($ControllderPermissions);

//        /dd($LIST_PERS_RENDERED);

        return view('UserPermission::/Admin/UGP/permissions', [
            'item' => $UGP_MODEL,
            'LPR' => $LIST_PERS_RENDERED
        ]);
    }

}
