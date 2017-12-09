<?php

/* =========================================================================================================
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * =========================================================================================================
 */

namespace App\Bcore\Traits;

use SettingModel,
    App\Models\SettingLangModel,
    SettingAccountModel;
use App\Bcore\Services\LanguageService;
use Session,
    Cache;

trait SettingSupporter {

    private $_CACHE_PREFIX = 'CACHE_';
    private $_CACHE_LIFETIME = 3600;
    private $_CACHE = [
        'SETTING', 'SETTING_LANG', 'SETTING_LANGS'
    ];

    // Ver 1.1 - 30-11-2017 ============================================================================================

    /*
     * XÓA CACHE HỆ THỐNG
     * Nếu có param {$cache_name} thì xóa cache đó ngược lại xóa toàn bộ
     */
    public function drop_cache($cache_name = null) {
        if ($cache_name == null) {
            if (count($this->_CACHE) != 0) {
                foreach ($this->_CACHE as $cache) {
                    Cache::forget($this->_CACHE_PREFIX . $cache);
                }
            }
        } else {
            Cache::forget($this->_CACHE_PREFIX . $cache_name);
        }
    }

    public function get_setting($return_cache = true) {
        if ($return_cache) {
            return Cache::remember($this->_CACHE_PREFIX . 'SETTING', $this->_CACHE_LIFETIME, function() {
                        return $this->get_setting(false);
                    });
        }
        return SettingModel::find('info');
    }

    public function get_settingLang($id_language, $return_cache = true) {
        if (!$return_cache) {
            $languages = $this->get_settingLangs(false);
        } else {
            $languages = Cache::get($this->_CACHE_PREFIX . 'SETTING_LANGS', function() {
                        return $this->get_settingLangs();
                    });
        }
        return $languages->where('id_lang', $id_language)->first();
    }

    public function get_settingLangs($return_cache = true) {
        if ($return_cache) {
            return Cache::remember($this->_CACHE_PREFIX . 'SETTING_LANGS', $this->_CACHE_LIFETIME, function() {
                        return (new SettingLangModel())->get_dataLangs();
                    });
        }
        return (new SettingLangModel())->get_dataLangs();
    }

    public function get_setting_account($id_account, $return_cache = true) {
        return $this->get_setting_accounts($return_cache)->find($id_account);
    }

    public function get_setting_accounts($return_cache = true) {
        if ($return_cache) {
            return Cache::remember($this->_CACHE_PREFIX . 'SETTING_ACCOUNTS', $this->_CACHE_LIFETIME, function() {
                        return (new \App\Models\SettingAccountModel())->set_select('*')->get_accounts();
                    });
        }
        return (new \App\Models\SettingAccountModel())->set_select('*')->get_accounts();
    }

    // =================================================================================================================
    // Ver 1.0

    public function ss_getSetting($return_cache = true) {
        if ($return_cache) {
            return Cache::get('CACHE_SETTING', function() {
                        return $this->ss_getSetting(false);
                    });
        }
        return SettingModel::find('info');
    }

    static public function ss_getSettingLang($return_cache = true) {
        if ($return_cache) {
            return Cache::get('CACHE_SETTING_LANG', function() {
                        return $this->ss_getSettingLang(false);
                    });
        }
        return SettingModel::find('info')->db_rela_settingLang;
    }

    public function ss_getSettingAccountName($pName) {
        try {
            return $this->ss_getSettingAccount()[$pName];
        } catch (\Exception $ex) {
            return null;
        }
    }

    public function ss_getSettingAccount($return_cache = true) {
        if ($return_cache) {
            return Cache::get('CACHE_SETTING_ACCOUNT', function() {
                        return $this->ss_getSettingAccount(false);
                    });
        }
        return $this->pv_array_convertSettingAccoutnts(SettingAccountModel::all());
    }

    private function pv_array_convertSettingAccoutnts($pArray) {
        if ($pArray == null) {
            return null;
        }
        if (count($pArray) <= 0) {
            return null;
        }
        $r = [];
        foreach ($pArray as $k => $v) {
            $r[$v->id] = $v;
        }
        return $r;
    }

}
