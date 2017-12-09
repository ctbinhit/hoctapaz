<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryLangModel extends Model {

    protected $table = 'categories_lang';
    public $timestamps = false;
    protected $guarded = ['id_lang', 'tbl', 'created_at'];

    
    
}
