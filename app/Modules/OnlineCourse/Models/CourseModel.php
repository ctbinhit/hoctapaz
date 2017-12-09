<?php

namespace App\Modules\OnlineCourse\Models;

use Illuminate\Database\Eloquent\Model;

class CourseModel extends Model {

    protected $table = 'm1_courses';
    protected $guarded = ['created_at', 'id_user', 'tbl'];
    public $timestamps = true;

 

}
