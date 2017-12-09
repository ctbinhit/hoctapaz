<?php

namespace App\Modules\PMN\Models;

use Illuminate\Database\Eloquent\Model;

class PMNModel extends Model {

    protected $primaryKey = 'type';
    protected $table = 'm_pmn';
    protected $guarded = ['created_at'];
    public $timestamps = true;
    public $incrementing = false;

}
