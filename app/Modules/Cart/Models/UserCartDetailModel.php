<?php

namespace App\Modules\Cart\Models;

use Illuminate\Database\Eloquent\Model;

class UserCartDetailModel extends Model {

    protected $table = 'users_carts_detail';
    protected $guarded = ['id', 'id_user', 'created_at'];
    public $timestamps = false;
    

}
