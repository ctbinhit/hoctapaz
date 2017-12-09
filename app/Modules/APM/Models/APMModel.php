<?php

namespace App\Modules\APM\Models;

use Illuminate\Database\Eloquent\Model;

class APMModel extends Model {

    protected $table = 'apm';
    protected $guarded = ['id', 'created_at', 'tbl'];
    public $timestamps = true;
    public $incrementing = false;
    
    
}
