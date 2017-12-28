<?php

namespace App\Bcore;

use Session;
use LanguageModel;

class LanguageService1 extends Bcore {

    function __construct() {
        
    }

    public function get_langById($pId) {
        return LanguageModel::find($pId);
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

    public function get_listAll() {
        
    }

}
