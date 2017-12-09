<?php

namespace App\Bcore\Services;

use Illuminate\Support\Facades\DB;

class AppService {

    function __construct() {
        
    }

    public static function find($option_name) {
        return DB::table('website')->where('name', $option_name)->first();
    }

    public static function update_option($name, $value) {
        try {
            return DB::table('website')->where('name', $name)->update([
                        'value' => $value
            ]);
        } catch (\Exception $ex) {
            return false;
        }
    }

    public static function get_info($id_lang = 1) {
        return \App\Models\SettingLangModel::where('id_lang', 1)->first();
    }

}
