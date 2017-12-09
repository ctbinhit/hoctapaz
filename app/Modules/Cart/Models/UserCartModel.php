<?php

namespace App\Modules\Cart\Models;

use Illuminate\Database\Eloquent\Model;

class UserCartModel extends Model {

    protected $table = 'users_carts';
    protected $guarded = ['id', 'id_user', 'created_at'];
    public $timestamps = true;
    

}
