<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceModel extends Model {

    protected $table = 'system_services';
    protected $guarded = ['id'];
    public $timestamps = false;

}
    