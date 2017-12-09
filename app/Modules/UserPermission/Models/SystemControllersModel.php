<?php
/*
 * 
 */
namespace App\Modules\UserPermission\Models;

use Illuminate\Database\Eloquent\Model;

class SystemControllersModel extends Model {

    protected $table = 'system_controllers';
    protected $guarded = ['created_at'];
    public $timestamps = true;
    public $incrementing = false;

}
