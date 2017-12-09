<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryModel extends Model {

    protected $table = 'countries';
    public $timestamps = false;

    public function db_get_all() {
        return CountryModel::all();
    }

    // DB RELATIONSHIP =================================================================================================

    public function db_rela_states() {
        return $this->hasMany('App\Models\StateModel', 'country_id', 'id');
    }

    public function db_rela_cities() {
        return $this->hasMany('App\Models\CityModel', 'country_id', 'id');
    }

    public function db_rela_districts() {
        return $this->hasMany('App\Models\DistrictModel', 'country_id', 'id');
    }

    public function db_rela_streets() {
        return $this->hasManyThrough('App\Models\StreetModel', 'App\Models\CityModel', 'country_id', 'city_id', 'id');
    }

    public function db_rela_wards() {
        return $this->hasManyThrough('App\Models\WardModel', 'App\Models\CityModel', 'country_id', 'city_id', 'id');
    }

}
