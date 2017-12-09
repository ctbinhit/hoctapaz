<?php

namespace App\Modules\Map\Models;

use Illuminate\Database\Eloquent\Model;

class MapModel extends Model {

    protected $table = 'maps';
    protected $guarded = ['id', 'created_at'];
    public $timestamps = true;

}
