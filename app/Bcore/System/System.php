<?php

namespace App\Bcore\System;

class System {

    public $_url;
    public $_config;
    public $_configLang;
    public $_googleDrive;
    public $_agent;

    function __construct() {
        
    }

    public function set_webConfig($p) {
        $this->_config = $p;
        return $this;
    }

    public function set_webConfigLang($p) {
        $this->_configLang = $p;
        return $this;
    }

    public function set_googleDrive($p) {
        $this->_googleDrive = $p;
        return $this;
    }

    public function set_agent($p) {
        $this->_agent = $p;
        return $this;
    }

    public function build() {
        $this->build_googleDrive();
        return $this;
    }

    private function build_googleDrive() {
        $Model = $this->_googleDrive;
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
    }

}
