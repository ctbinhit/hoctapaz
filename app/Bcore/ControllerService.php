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

class ControllerService extends BaseController {

    public $_SETTING = null;
    public $_SETTING_LANG = null;
    public $_SETTING_LANGS = null;
    public $_SETTING_ACCOUNT;
    public $_STORAGE_GOOGLE;
    public $_Agent = null;

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;
    use Traits\SettingSupporter;

    function __construct() {
       
        $this->_Agent = new Agent();

        // -------------------------------------------------------------------------------------------------------------
        $Model = Cache::remember('SETTING_SYNC_GOOGLEDRIVE', 3600, function() {
                    return SettingAccountModel::find('google-drive');
                });
        // -------------------------------------------------------------------------------------------------------------

        if ($Model->client_id == null || $Model->app_key == null || $Model->token == null || $Model->storage_parent == null
        ) {
            Cache::forget('SETTING_SYNC_GOOGLEDRIVE');
            $Model->active = 0;
            $Model->save();
        }

        if ($Model != null) {
            config(['bcore.Sync.Google.Active' => $Model->active]);
            config(['bcore.Sync.Google.AutoSync' => $Model->auto_sync]);
            $this->_STORAGE_GOOGLE['state'] = $Model->active;
            if ($Model->active) {
//                $this->_STORAGE_GOOGLE['GOOGLE_DRIVE_CLIENT_ID'] = $Model->client_id;
//                $this->_STORAGE_GOOGLE['GOOGLE_DRIVE_CLIENT_SECRET'] = $Model->app_key;
//                $this->_STORAGE_GOOGLE['GOOGLE_DRIVE_REFRESH_TOKEN'] = $Model->token;
//                $this->_STORAGE_GOOGLE['GOOGLE_DRIVE_FOLDER_ID'] = $Model->storage_parent;
                config(['Bcore.storage_service.google_drive.GOOGLE_DRIVE_CLIENT_ID' => $Model->client_id]);
                config(['Bcore.storage_service.google_drive.GOOGLE_DRIVE_CLIENT_SECRET' => $Model->app_key]);
                config(['Bcore.storage_service.google_drive.GOOGLE_DRIVE_REFRESH_TOKEN' => $Model->token]);
                config(['Bcore.storage_service.google_drive.GOOGLE_DRIVE_FOLDER_ID' => $Model->storage_parent]);
                // SUB PARENT ID
                // ----- ARTICLE ---------------------------------------------------------------------------------------
                config(['Bcore.storage_service.google_drive.GOOGLE_DRIVE_FOLDER_ARTICLE' => $Model->storage_article]);
                $this->_STORAGE_GOOGLE['GOOGLE_DRIVE_FOLDER_ARTICLE'] = $Model->client_id;
                // ----- PRODUCT ---------------------------------------------------------------------------------------
                config(['Bcore.storage_service.google_drive.GOOGLE_DRIVE_FOLDER_PRODUCT' => $Model->storage_article]);
                // ----- CATEGORY --------------------------------------------------------------------------------------
                config(['Bcore.storage_service.google_drive.GOOGLE_DRIVE_FOLDER_CATEGORY' => $Model->storage_article]);
                // ----- GOOGLE_DRIVE_FOLDER_EXAM ----------------------------------------------------------------------
                config(['Bcore.storage_service.google_drive.GOOGLE_DRIVE_FOLDER_EXAM' => $Model->storage_exam]);

                $this->_STORAGE_GOOGLE['GOOGLE_DRIVE_FOLDER_DOC'] = '1ZqfSCqm_c1P65l3ZXT62IThUa3i4LCAN';
            } else {
                
            }
        }

        // LOAD SESSION
        $this->_SETTING = $this->get_setting();
        $this->_SETTING_LANGS = $this->get_settingLangs();
        
        
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

    private function array_convertSettingAccoutn($pArray) {
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
