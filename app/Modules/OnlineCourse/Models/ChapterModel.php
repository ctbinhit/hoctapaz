<?php

namespace App\Modules\OnlineCourse\Models;

use Illuminate\Database\Eloquent\Model;

class ChapterModel extends Model {

    protected $table = 'm1_chapters';
    protected $guarded = ['created_at', 'id_user', 'tbl'];
    public $timestamps = true;

 

}