<?php

namespace App\Modules\UserPermission\Models;

use Illuminate\Database\Eloquent\Model;

class SystemControllersDetailModel extends Model {

    protected $table = 'system_controllers_detail';
    protected $guarded = ['created_at', 'id'];
    public $timestamps = true;

}
