<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StateModel extends Model {

    protected $table = 'states';
    public $timestamp = true;

    public function db_cities(){
        return $this->hasMany('App\CityModel','state_id','id');
    }
    
}
