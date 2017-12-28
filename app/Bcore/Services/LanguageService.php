<?php

namespace App\Bcore\Services;

use Session;
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

    public function get_currentLang() {
        if (session::has('user')) {
            if (isset(session('user')['language'])) {
                $tmp = $this->get_langById(session('user')['language']);
                if ($tmp == null) {
                    goto langDefault;
                } else {
                    return $tmp;
                }
            } else {
                goto langDefault;
            }
        } else {
            langDefault:
            $Model = LanguageModel::where([
                        ['id_user', '=', -1]
                    ])->first();
            return $Model;
        }
    }

    public function get_listLangs() {
        return LanguageModel::where([
                    ['display', '=', 1]
                ])->get();
    }

}
