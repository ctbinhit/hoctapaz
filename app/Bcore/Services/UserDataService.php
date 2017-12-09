<?php

namespace App\Bcore\Services;

use App\Bcore\Bcore;
use App\Models\UserDataModel;
use LanguageService;
use Config,
    Session,
    Cache,
    View;
use App\Bcore\System\StorageRole;
use Illuminate\Support\Facades\Log;

class UserDataService extends Bcore {

    public function __construct() {
        parent::__construct();
    }

    // ===== Lấy toàn bộ dữ liệu data user
    public static function user_data($table, $type) {
        return UserDataModel::where([
                    ['obj_table', $table],
                    ['obj_type', $type]
                ])->get();
    }

    public static function get_arrayIdData($object_table, $object_type) {
        try {
            $Models = UserDataModel::where([
                        'obj_table' => $object_table,
                        'obj_type' => $object_type,
                        'id_user' => UserService::id()
                    ])->get();
            if (count($Models) == 0) {
                return [];
            }
            $ArrayId = [];
            foreach ($Models as $k => $v) {
                $ArrayId[] = $v->obj_id;
            }
            return $ArrayId;
        } catch (\Exception $ex) {
            return [];
        }
    }

    public static function user_data_paginate($type, $perPage = 10) {
        return UserDataModel::where([
                    ['obj_type', $type]
                ])->paginate(is_numeric($perPage) ? $perPage : 10);
    }

    public static function save_dataByModel($Model) {
        try {
            $UserDataModel = new UserDataModel();
            $UserDataModel->data_object = json_encode($Model);

            $UserDataModel->obj_table = $Model->tbl;
            $UserDataModel->obj_id = $Model->id;
            $UserDataModel->obj_type = $Model->obj_type;
            $UserDataModel->state = 1;
            $UserDataModel->role = StorageRole::private_();
            $UserDataModel->id_user = UserService::id();

            $r = $UserDataModel->save();
            if ($r) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $ex) {
            Log::error(__FUNCTION__, ['msg' => $ex->getMessage()]);
            return false;
        }
    }

    public static function has_exception($ex = null) {
        if ($ex != null) {
            // Write log
        }
        return __FUNCTION__;
    }

}
