<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductLangModel extends Model {

    protected $table = 'products_lang';
    public $timestamps = false;
    protected $guarded = ['id', 'tbl', 'created_at', 'id_user'];

}
