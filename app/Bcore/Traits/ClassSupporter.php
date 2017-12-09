<?php

/* =========================================================================================================
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * =========================================================================================================
 */

namespace App\Bcore\Traits;

use SettingModel;
use Session;

trait ClassSupporter {

    // SUPPORT METHOD

    public function cs_groupModelsById($pModels) {
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
    public function cs_groupFieldByModels($pFieldName, $pModel) {
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

    public function cs_getArrayIdFromModel($pObject) {
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

    public function cs_getArrayIdLangs() {
        $Models = $this->get_listLangs();
        if (count($Models) != 0) {
            return $this->get_arrayIdFromModel($Models);
        } else {
            return null;
        }
    }

    // ===== Lấy danh sách tất cả các ngôn ngữ hiện tại

    public function cs_getListLangs() {
        $LS = new LanguageService();
        return $LS->get_listLangs();
    }

}
