<?php

namespace App\Modules\UserPermission\Models;

use Illuminate\Database\Eloquent\Model;

class UserGroupPermissionModel extends Model {

    protected $table = 'users_groups_permissions';
    protected $guarded = ['created_at'];
    public $timestamps = true;
    public $_select = '*';

    public function get_permissionsByIdGroup($id_group) {
        return UserGroupPermissionModel::where([
                    ['id_group', $id_group]
                ])->select($this->_select)->get();
    }

}
