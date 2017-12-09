<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model {

    protected $table = 'users';
    public $timestamps = true;
    public $select = null;
    private $_FIELDS = ['id', 'fullname', 'date_of_birth', 'email', 'phone', 'coin', 'username', 'lang', 'address',
        'id_card', 'id_city', 'id_district', 'status', 'id_vip', 'tbl', 'role', 'updated_at'];

    public function db_get_items($pKeyword = null, $pFilter = array(
        'orderBy' => ['id', 'desc']
    )) {
        $pFilter = (object) $pFilter;
        $r = UserModel::select($this->_FIELDS);

        // SEARCH ------------------------------------------------------------------------------------------------------
        if ($pKeyword != null) {
            $r->where('fullname', 'LIKE', "%$pKeyword%");
            $r->where('phone', 'LIKE', "%$pKeyword%");
            $r->where('email', 'LIKE', "%$pKeyword%");
            $r->where('address', 'LIKE', "%$pKeyword%");
        }

        $r->orderBy($pFilter->orderBy[0], $pFilter->orderBy[1]);

        return $r->paginate(10);
    }

    public function db_login($pUsername, $pPassword, $pType) {
        return UserModel::where([
                    ['username', '=', $pUsername],
                    ['password', '=', $pPassword],
                    ['type', '=', $pType]
                ])->first();
    }

    /* ===== db_rela_permission_group ==================================================================================
      |
      |
      |
      | ================================================================================================================
     */

    public function db_rela_permission_group() {
        return $this->hasMany('App\Models\UserPermissionGroupModel', 'id', 'id_group');
    }

    public function db_rela_permission() {
        return $this->hasMany('App\Models\UserPermissionModel', 'id_group', 'id_permission_group');
    }

    /* ===== db_rela_permission_group_lang =============================================================================
      | - Từ bảng user lấy thông tin chi tiết của group
      | Ex: Lấy thông tin chi tiết group permission của 1 user có id = 1
      | Syntax: $Model = UserModel::find(1)->db_rela_permission_group_lang;
      | Return: thông tin lang của group mà user(1) đang sở hữu
      |
      |
      | ================================================================================================================
     */

    public function db_rela_permission_group_lang() {
        // -------------------------------------------------------------------------------------------------------------
        // g_l : group_lang
        // g : group
        // u : user
        $d = array(
            'g_l' => ['App\Models\UserPermissionGroupLangModel', 'id_permission_group'],
            'g' => ['App\Models\UserPermissionGroupModel', 'id'],
            'u' => 'id_permission_group'
        );
        return $this
                        ->hasManyThrough($d['g_l'][0], $d['g'][0], $d['g'][1], $d['g_l'][1], $d['u']);
    }

    public static function find_userVIPByModel($models) {
        if ($models->id_vip != null) {
            $models->data_vip = \App\Modules\UserVIP\Models\UserVIPModel::find($models->id_vip);
        } else {
            $models->data_vip = (object) [
                        'name' => 'Không có'
            ];
        }
        return $models;
    }

    public static function find_userVIPByModels($models) {
        foreach ($models as $k => $user) {
            if ($user->id_vip != null) {
                $user->data_vip = \App\Modules\UserVIP\Models\UserVIPModel::find($user->id_vip);
            } else {
                $user->data_vip = (object) [
                            'name' => '0'
                ];
            }
        }
        return $models;
    }

}
