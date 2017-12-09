<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPermissionGroupModel extends Model {

    protected $table = 'users_permission_groups';
    public $timestamps = true;
    protected $guarded = ['id', 'tbl', 'created_at'];

    public function db_rela_lang() {
        return $this->hasMany('App\Models\UserPermissionGroupLangModel', 'id_permission_group', 'id');
    }

    

}
