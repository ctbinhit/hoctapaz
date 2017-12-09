<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingModel extends Model {

    protected $table = 'setting';
    public $timestamps = true;
    private $id_lang = null;
    public $incrementing = false;

    // Client ==========================================================================================================

    public function db_get_itemsByType($pType = 'info', $pML = null) {
        // Lấy thông tin cấu hình duy nhất 1 ngôn ngữ 
        if (is_numeric($pML)) {
            $this->id_lang = $pML;
            $Model = SettingModel::find($pType)->db_rela_settingLang;
            return $Model;
        } else {
            
        }
    }

    // =================================================================================================================

    public function getItemByType($pType) {
        if (!empty($pType)) {
            return SettingModel::where('type', $pType)->first();
        }
        return 0;
    }

    public function db_save($pId, $pArray) {
        SettingModel::where('id', (int) $pId)->update($pArray);
        return true;
    }

    public function db_rela_settingLang() {
        $r = $this->hasMany('App\Models\SettingLangModel', 'id_setting', 'id');
        //$r->where('id_lang', '=', 1);
        return $r;
    }

}
