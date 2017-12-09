<?php

namespace App\Modules\UserPermission\Controllers\Admin;

use App\Bcore\PackageServiceAD;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;

class UserPermissionController extends PackageServiceAD {

    function __construct() {
        parent::__construct();
    }

    public function get_index() {

        return view('UserPermission::Admin/index', [
        ]);
    }

    public function get_edit() {
        
    }

    public function post_save(Request $request) {
        if ($request->has('am_path')) {

            $SCM = \App\Modules\UserPermission\Models\SystemControllersDetailModel::
                    where([
                        ['am_path', '=', $request->input('am_path')]
                    ])->first();
            if ($SCM == null) {
                return redirect()->route('mdle_userpermission_index');
            } else {
                $SCM->name = $request->input('name');
                $SCM->permission_default = $request->input('permission_default');
                $SCM->save();
                return redirect()->route('mdle_userpermission_index');
            }
        } else {
            return redirect()->route('admin_index_index');
        }
    }

    public function get_package_index() {
    
    }

    public function get_package_update() {
//        $UPService = new \App\Modules\UserPermission\Services\UPService();
//
//        $ControllersModels = $UPService->get_controllers()
//                        ->convert_controllersToModels()
//                ->CONTROLLERS_MODELS;
//
//        $DB_ = \App\Modules\UserPermission\Models\SystemControllersModel::
//                whereIn('id', $UPService->CONTROLLERS)->get();
//
//        foreach ($DB_ as $k => $controller_model) {
//            if (key_exists($controller_model->id, $ControllersModels)) {
//                unset($ControllersModels[$controller_model->id]);
//            }
//        }
//        $ControllersModels = $UPService->remove_indexOfArray($ControllersModels);
//        if (count($ControllersModels) != 0) {
//            if (!DB::table('system_controllers')->insert($ControllersModels)) {
//                return "Cập nhật thất bại";
//            }
//        }
//        return redirect()->route('mdle_userpermission_package');
    }

    public function post_package_index(Request $request) {
        $UPService = new \App\Modules\UserPermission\Services\UPService();

        $Controllers = $UPService->get_controllers()
                        ->get_controllersPermissions()
                        ->get_stateControllers()
                ->CONTROLLERS_STATE;
    }

    /* =================================================================================================================
     * USER GROUP
     * =================================================================================================================
     */

    public function get_ug_index() {
        $UserGroupModels = \App\Modules\UserPermission\Models\UserPermissionGroupsModel::orderBy('id', 'DESC')->get();

        return view('UserPermission::Admin/ug_index', [
            'items' => $UserGroupModels
        ]);
    }

    public function get_ug_add() {
        return view('UserPermission::Admin/ug_add', [
        ]);
    }

    public function post_ug_save(Request $request) {

        if ($request->has('id')) {
            $Model = \App\Modules\UserPermission\Models\UserPermissionGroupsModel::find($request->input('id'));
        } else {
            $Model = new \App\Modules\UserPermission\Models\UserPermissionGroupsModel();
        }

        $Model->name = $request->input('name');
        $Model->description = $request->input('description');

        if ($Model->save()) {
            
        } else {
            
        }
        return redirect()->route('mdle_userpermission_ug');
    }

    public function get_ug_permissions($id_group) {

        $Model = \App\Modules\UserPermission\Models\UserPermissionGroupsModel::find($id_group);

        if ($Model == null) {
            return "Dữ liệu không có thực.";
        }
        
        \App\Modules\UserPermission\Services\UPService::controllerPermissions('admin');

        $UPService = new \App\Modules\UserPermission\Services\UPService();

        $LST_CONTROLLER = $UPService->get_controllers()->get_controllersPermissions()
                        ->get_stateControllers()->CONTROLLERS_STATE;
 
        $LIST_GROUP_PERMISSIONS = \App\Modules\UserPermission\Models\UsersPermissionModel::
                where([
                    ['id_group', '=', $id_group],
                    ['id_group', '=', $id_group]
                ])->get();


        $LIST_GROUP_PERMISSIONS = \App\Modules\UserPermission\Services\UPService::
                set_indexOfModels('id_controller', $LIST_GROUP_PERMISSIONS);

        $LIST_GROUP_PERMISSIONS = \App\Modules\UserPermission\Services\UPService::
                json_decode_models('permissions', $LIST_GROUP_PERMISSIONS);

        $LIST_GROUP_PERMISSIONS = \App\Modules\UserPermission\Services\UPService::
                json_decode_models('strict_type', $LIST_GROUP_PERMISSIONS);
        // STRICT
        $STRICT_CONTROLLERS = $UPService->get_controllers()->get_controllersStricts()->CONTROLLERS_STRICTS;

        return view('UserPermission::Admin/ug_permissions', [
            'group_info' => $Model,
            'lst_controllers' => $LST_CONTROLLER,
            'lst_strict' => $STRICT_CONTROLLERS,
            'lst_permissions' => $LIST_GROUP_PERMISSIONS
        ]);
    }

    /* =================================================================================================================
     * 
     * =================================================================================================================
     */

    public function post_ug_permissions_save(Request $request) {

        $list_pers = $request->input('pers');
        $list_stricts = $request->input('stricts');
        $ARRAY_ID_CONTROLLERS = [];
        
        foreach ($list_pers as $controller_name => $permissions_json) {
            $ARRAY_ID_CONTROLLERS[] = $controller_name;
        }
        // Lấy danh sách các quyền đã tồn tại trên CSDL => update
        $UPMS = \App\Modules\UserPermission\Models\UsersPermissionModel::
                        where('id_group', '=', $request->input('ipg'))
                        ->whereIn('id_controller', $ARRAY_ID_CONTROLLERS)->get();

        foreach ($UPMS as $k => $v) {
            $tmp = \App\Modules\UserPermission\Models\UsersPermissionModel::find($v->id);

            if ($list_pers[$v->id_controller] == '') {
                $tmp->permissions = null;
            } else {
                $tmp->permissions = json_encode($list_pers[$v->id_controller]);
            }

            if (isset($list_stricts[$v->id_controller])) {
                $tmp->strict_type = json_encode($list_stricts[$v->id_controller]);
            }
            //$tmp->save();
            $tmp->save();

            unset($list_pers[$v->id_controller]);
        }

        $UPMS1 = \App\Modules\UserPermission\Models\UsersPermissionModel::
                        where('id_group', '=', $request->input('ipg'))
                        ->whereNotIn('id_controller', $ARRAY_ID_CONTROLLERS)->get();
        foreach ($UPMS1 as $k => $v) {
            $v->permissions = null;
            $v->save();
        }
   
        // $list_per != 0 => insert new permission
        if (count($list_pers) != 0) {
            $LIST_PERMISSION_MODELS = [];
            foreach ($list_pers as $controller_name => $permissions_json) {
                $LIST_PERMISSION_MODELS[] = [
                    'id_group' => $request->input('ipg'),
                    'id_controller' => $controller_name,
                    'strict_type' => isset($list_stricts[$controller_name]) ?
                    json_encode($list_stricts[$controller_name]) : null,
                    'permissions' => json_encode($permissions_json)
                ];
            }
            $tmp = DB::table('users_permission')->insert($LIST_PERMISSION_MODELS);
        }
        return redirect()->route('mdle_userpermission_ug');
    }

    public function get_key_index() {
        $LIST_AMPATH = [];

        $CONTROLLER_MODELS = [];

        $LIST_CONTROLLERS_NAME = [];

        foreach (Route::getRoutes()->getRoutes() as $route) {

            $Param_count = 0;

            $action = $route->getAction();

            $UPService = new \App\Modules\UserPermission\Services\UPService();

            if (isset($action->complied['variables'])) {

                $Param_count = count($action['complied']['variables']);
            }

            if (isset($action['controller']) && str_contains($action['prefix'], 'admin')) {

                $TMP = explode('@', $action['controller']);

                $LIST_AMPATH[] = $action['controller'];

                $LIST_CONTROLLERS_NAME[] = $TMP[0];

                $CONTROLLER_MODELS[$action['controller']] = array(
                    'controller' => $TMP[0],
                    'action' => $TMP[1],
                    'method' => $TMP[1],
                    'am_path' => $action['controller'],
                    'permission_default' => false,
                    'status' => 1,
                );
            }
        }

        $UPService->update_controllers($LIST_CONTROLLERS_NAME);
        // Cập nhật số lượng & dữ liệu controllers
        $UPService->group_controllersByName($LIST_CONTROLLERS_NAME);

        $UPService->remove_unsedSCMS($LIST_AMPATH);

        $SCM = \App\Modules\UserPermission\Models\SystemControllersDetailModel::orderBy('id', 'ASC')->get();

        $SystemControllerModels = $UPService->remove_duplicateKey($CONTROLLER_MODELS, $UPService->convert_ModelsToArrayAMPath($SCM));

        $CONTROLLER_MODELS_ = $UPService->remove_indexOfArray($SystemControllerModels);

        DB::table('system_controllers_detail')->insert($CONTROLLER_MODELS_);

        $CONTROLLERS_MODELS = \App\Modules\UserPermission\Models\SystemControllersDetailModel::orderBy('controller', 'ASC')->get();

        $CONTROLLERS_MODELS_ = $UPService->add_amPathEncodeModels($CONTROLLERS_MODELS);

        return view('UserPermission::Admin/keys', [
            'SCMS' => $CONTROLLERS_MODELS_
        ]);
    }

    public function get_key_edit($AMPATH_ENCODE) {
        $AM_PATH = Crypt::decryptString($AMPATH_ENCODE);

        $Model = \App\Modules\UserPermission\Models\SystemControllersModel::where([
                    ['am_path', '=', $AM_PATH]
                ])->first();
        return view('UserPermission::Admin/keys_add', [
            'item' => $Model
        ]);
    }

    public function get_key_group_index() {

        $SCM = DB::table('system_controllers')
                ->get();

        return view('UserPermission::Admin/key_group', [
            'items' => $SCM,
        ]);
    }

    public function get_sup_index($id_user) {

        if (method_exists(\App\Http\Controllers\admin\ArticleOController::class, 'system_permission')) {
            dd(\App\Http\Controllers\admin\ArticleOController::system_permission());
        }


        return;
        $UserInfo = \App\Models\UserModel::find($id_user);

        if ($UserInfo == null) {
            return "ERROR! User not found!";
        }

        $SystemControllersModels = \App\Modules\UserPermission\Models\SystemControllersModel
                ::orderBy('controller_name', 'ASC')->get();



        return view('UserPermission::Admin/sup_index', [
            'user_info' => $UserInfo,
            'lst_permission' => $SystemControllersModels
        ]);
    }

    public function ajax() {
        
    }

}
