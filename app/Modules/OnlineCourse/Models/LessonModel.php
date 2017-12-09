<?php

namespace App\Modules\OnlineCourse\Models;

use Illuminate\Database\Eloquent\Model;

class LessonModel extends Model {

    protected $table = 'm1_lessons';
    protected $guarded = ['created_at', 'tbl'];
    public $timestamps = true;

}
