<?php

namespace App\Modules\Cart\Models;

use Illuminate\Database\Eloquent\Model;

class UserCartStateModel extends Model {

    protected $table = 'users_carts_state';
    protected $guarded = ['id'];
    public $timestamps = false;

}
