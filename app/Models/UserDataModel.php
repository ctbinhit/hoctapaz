<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDataModel extends Model {

    protected $table = 'users_data';
    protected $dates = ['created_at','updated_at'];
    protected $guarded = ['id', 'created_at', 'obj_id', 'created_by', 'tbl'];
    public $timestamps = true;

}
