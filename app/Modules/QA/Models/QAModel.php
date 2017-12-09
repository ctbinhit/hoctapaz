<?php

namespace App\Modules\Qa\Models;

use Illuminate\Database\Eloquent\Model;

class QAModel extends Model {

    protected $table = 'qa';
    protected $guarded = ['id', 'created_at', 'tbl'];
    public $timestamps = true;

}
