<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingLangModel extends Model {

    protected $table = 'setting_lang';
    public $timestamps = true;
    protected $guarded = ['id', 'id_lang'];

    public function get_dataByIdLang($id_lang, $select = '*') {
        try {
            return SettingLangModel::where([
                        ['id_lang', $id_lang]
                    ])->select($select)->first();
        } catch (\Exception $ex) {
            return null;
        }
    }

    public function get_dataLangs($select = '*') {
        try {
            return SettingLangModel::select($select)->get();
        } catch (\Exception $ex) {
            return null;
        }
    }

}
