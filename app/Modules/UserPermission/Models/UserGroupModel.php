<?php

/*
 * 
 */

namespace App\Modules\UserPermission\Models;

use Illuminate\Database\Eloquent\Model;

class UserGroupModel extends Model {

    protected $table = 'users_groups';
    protected $guarded = ['created_at'];
    public $timestamps = true;

}
