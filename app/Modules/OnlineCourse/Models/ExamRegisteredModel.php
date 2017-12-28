<?php

namespace App\Modules\OnlineCourse\Models;

use Illuminate\Database\Eloquent\Model;

class ExamRegisteredModel extends Model {

    protected $table = 'm1_exam_registered';
    public $timestamps = true;
    protected $guarded = ['id', 'id_exam', 'created_at'];

}
