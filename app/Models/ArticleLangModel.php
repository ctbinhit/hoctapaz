<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleLangModel extends Model {

    protected $table = 'articles_lang';
    protected $guarded = ['id'];
    public $timestamps = false;

}
