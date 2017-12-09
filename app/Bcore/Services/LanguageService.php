<?php

namespace App\Bcore\Services;

use App\Models\LanguageModel;
use Illuminate\Support\Facades\DB;

class LanguageService {

    public static function get_idLanguageDefault() {
        $lang = LanguageService::get_languageDefault();
        return $lang != null ? $lang->id : null;
    }

    public static function get_languageDefault() {
        $lang = DB::table('languages')->where('id_user', -1)->first();
        return $lang == null ? null : $lang;
    }

}
