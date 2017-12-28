<?php

namespace App\Bcore;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use SettingModel,
    SettingLangModel,
    SettingAccountModel;
use LanguageService;
use Config,
    Session,
    Cache,
    View;
use Jenssegers\Agent\Agent;
use App\Bcore\Services\StorageServiceV2;
use App\Bcore\SystemComponents\Accounts\StorageDisk;
use App\Bcore\System\System;

class ControllerService extends BaseController {

    public $_SETTING = null;
    public $_SETTING_LANG = null;
    public $_SETTING_LANGS = null;
    public $_SETTING_ACCOUNT;
    public $_STORAGE_GOOGLE;
    public $_Agent = null;
    public $_SYSTEM = null;

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;
    use Traits\SettingSupporter;

    function __construct() {
        $this->_SYSTEM = (new System())->set_googleDrive((new StorageServiceV2())->set_timeCache(3600)->google_config())
                ->build();
        $this->buildConfig();
    }

    private function buildConfig() {
        // ----- SETTING -----------------------------------------------------------------------------------------------
        $this->_SETTING = $this->get_setting();
        $this->_SETTING_LANG = $this->get_settingLangs();
        $this->_SETTING_LANGS = $this->_SYSTEM->_configLang;
        // ----- AGENT -------------------------------------------------------------------------------------------------
        $this->_Agent = new Agent();
    }

    public function view($pView, $data = []) {
        if (Config::get('bcore.Template.Mobile')) {
            if ($this->_Agent->isMobile()) {
                return view('client/mobile/' . $pView, $data);
            }
        }
        return view('client/' . $pView, $data);
    }

    public function get_sync_state($pConfigFromController) {
        foreach ($pConfigFromController as $k => $v) {
            if ($v['state'] == null) {
                if (isset($this->_SETTING_ACCOUNT[$k])) {
                    $pConfigFromController[$k]['state'] = $this->_SETTING_ACCOUNT[$k]->active;
                    $pConfigFromController[$k]['data'] = $this->_SETTING_ACCOUNT[$k];
                } else {
                    $pConfigFromController[$k]['state'] = false;
                }
            }
        }
        return $pConfigFromController;
    }

    public function remove_cache() {
        $this->remove_cache_setting;
    }

    public function remove_cache_setting() {
        Cache::forget('CACHE_SETTING');
        Cache::forget('CACHE_SETTING_LANGS');
        Cache::forget('CACHE_SETTING_ACCOUNT');
    }

//    private function array_convertSettingAccoutn($pArray) {
//        if ($pArray == null) {
//            return null;
//        }
//        if (count($pArray) <= 0) {
//            return null;
//        }
//        $r = [];
//        foreach ($pArray as $k => $v) {
//            $r[$v->id] = $v;
//        }
//        return $r;
//    }

    // SUPPORT METHOD

    public function groupModelsById($pModels) {
        if (!is_object($pModels)) {
            return -1;
        }
        if (count($pModels) == 0) {
            return -1;
        }
        $r = [];
        foreach ($pModels as $k => $v) {
            $r[$v->id] = $v;
        }
        return $r;
    }

    // Update 1.3
    public function groupFieldByModels($pFieldName, $pModel) {
        if (count($pModel) == 0) {
            return null;
        }
        $r = [];
        foreach ($pModel as $v) {
            if (isset($v->{$pFieldName})) {
                $r[$v->{$pFieldName}] = $v;
            }
        }
        return $r;
    }

    // Removed from 1.3 ------------------------------------------------------------------------------------------------
    public function get_arrayIdFromField($pFieldName, $pModel) {
        if (count($pModel) == 0) {
            return null;
        }
        $r = [];
        foreach ($pModel as $v) {
            if (isset($v->{$pFieldName})) {
                $r[] = $v->{$pFieldName};
            }
        }
        return $r;
    }

    // xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

    public function get_arrayIdFromModel($pObject) {
        if (!is_object($pObject)) {
            return -1;
        }
        if (count($pObject) <= 0) {
            return -1;
        }
        $r = [];
        foreach ($pObject as $k => $v) {
            $r[] = $v->id;
        }
        return $r;
    }

    public function get_arrayIdLangs() {
        $Models = $this->get_listLangs();
        if (count($Models) != 0) {
            return $this->get_arrayIdFromModel($Models);
        } else {
            return null;
        }
    }

    // ===== Lấy danh sách tất cả các ngôn ngữ hiện tại

    public function get_listLangs() {
        $LS = new LanguageService();
        return $LS->get_listLangs();
    }

}
