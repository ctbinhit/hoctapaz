<?php

namespace App\Bcore\Services;

use App\Models\CountryModel;
use App\Models\CityModel;
use App\Models\WardModel;
use App\Models\DistrictModel;

class LocaleService {

    public static function get_countries() {
        return CountryModel::all();
    }

    public static function render_select_countries() {
        return view('components.bootstrap.locate.select_countries', ['items' => LocaleService::get_countries()]);
    }

    public static function get_cities() {
        return CityModel::all();
    }
    
    public static function render_select_cities() {
        return view('components.bootstrap.locate.select_cities', ['items' => LocaleService::get_cities()]);
    }

    public static function get_wards() {
        return WardModel::all();
    }

    public static function get_districts() {
        return DistrictModel::all();
    }

}
