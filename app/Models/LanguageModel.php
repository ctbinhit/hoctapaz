<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class LanguageModel extends Model {

    protected $table = 'languages';
    public $timestamps = true;
    protected $fillable = ['hienthi'];

    public function db_getListLang() {
        return LanguageModel::select('id', 'display', 'id_user', 'fullname', 'name', 'currency_unit', 'tbl', 'created_at')
                        ->get();
    }

    public function db_getListLangAvailible() {
        return LanguageModel::where('display', '=', 1)
                        ->select('id', 'display', 'fullname', 'name')
                        ->get();
    }

    public function db_getLangDefault() {
        return LanguageModel::where('display', '=', 1)
                        ->select('id', 'display', 'name')
                        ->get();
    }

    public function db_getCurrentLanguage() {
        return Config::get('bcore.DefaultLanguage');
    }

    public function db_save($pId = null, $pArray) {
        if ($pId !== null) {
            LanguageModel::where('id', (int) $pId)->update($pArray);
        } else {
            LanguageModel::insert($pArray);
        }
        return true;
    }

}
