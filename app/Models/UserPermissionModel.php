<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPermissionModel extends Model {

    protected $table = 'users_groups_permissions';
    public $timestamps = false;

    public function db_rela_group() {
        return $this->belongsTo('App\Models\UserPermissionGroupModel','id','');
    }

}
