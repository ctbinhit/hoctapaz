<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CityModel extends Model {

    protected $table = 'cities';
    public $timestamp = true;
    
    public function db_rela_city(){
        return $this->belongsTo('App\Models\CountryModel', 'id', $ownerKey, $relation);
    }

    public function db_rela_districts() {
        return $this->hasMany('App\Models\DistrictModel', 'city_id', 'id');
    }

    public function db_rela_streets() {
        return $this->hasMany('App\Models\StreetModel', 'city_id', 'id');
    }

    public function db_rela_wards() {
        return $this->hasMany('App\Models\WardModel', 'city_id', 'id');
    }

    // =================================================================================================================
    // Lấy danh sách tất cả các thành phố theo id của country ==========================================================
    // =================================================================================================================
//    public function db_get_byIdCountry($pId, $pSelectQuery = null) {
//        $r;
//        // Using Query Builder to get the data
//        $r = DB::table($this->table)
//                ->join('states', $this->table . '.state_id', 'states.id')
//                ->where('states.country_id', '=', $pId)
//                ->select($pSelectQuery !== null ? $pSelectQuery : [
//            $this->table . '.id',
//            $this->table . '.name'
//        ])->get();
//
//        // Using Eloquent ORM to get the data
//        // Đang xây dựng...
//        // ===== RESULT ================================================================================================
//        return $r;
//    }
}
