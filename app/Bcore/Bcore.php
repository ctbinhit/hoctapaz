<?php

namespace App\Bcore;

class Bcore {

    private $_SERVICES = [
        'ControllerService'
    ];

    function __construct() {
        
    }

    public function loadService() {
        
    }

    public function getFormKey() {
        if ($this->benc(env('APP_FORM_KEY')) == 'be674223d7aefc4dac0ffc59a2ef735c')
            return env('APP_FORM_KEY');
        else
            return '';
    }

//
//    public function getFormKey() {
//        if ($this->benc(env('APP_FORM_KEY')) == 'be674223d7aefc4dac0ffc59a2ef735c')
//            return env('APP_FORM_KEY');
//        else
//            return '';
//    }

    public function benc($param) {
        $IP_LEN = strlen($param);
        $IP_ARR = '';
        for ($i = 0; $i < $IP_LEN; $i++) {
            $IP_ARR .= md5(ord(substr($param, $i, 1)));
        }
        return md5(\Illuminate\Support\Facades\Config::get('bcore.Author') . $IP_ARR . env('APP_FORM_KEY'));
    }

    public function registerController() {
        $this->_CONF_BCORE = \Illuminate\Support\Facades\Config::has('bcore.ClientSecret') ? \Illuminate\Support\Facades\Config::get('bcore.ClientSecret') : null;
        if (!is_array($this->_CONF_BCORE))
            return;
        if ($this->_CONF_BCORE == null)
            return;
    }

    // Input: 1 model bất kì
    // Output: array field
    // ex: [1,2,3,4,5,6] => danh sách field lấy đc từ model

    public function get_ArrayFieldByModels($pFields, $pModels) {
        if (!is_object($pModels)) {
            return null;
        }
        if (count($pModels) == 0) {
            return null;
        }
        $RESPONSE = [];
        foreach ($pModels as $v) {
            if (isset($v->{$pFields})) {
                $RESPONSE[] = $v->{$pFields};
            }
        }
        return $RESPONSE;
    }

    public function group_fieldFromModels($pField, $pModels) {
        if ($pField == '') {
            return null;
        }
        if (!is_object($pModels)) {
            return null;
        }
        if (count($pModels) == 0) {
            return null;
        }
        $RESPONSE = [];
        foreach ($pModels as $v) {
            if (isset($v->{$pField})) {
                if (!isset($RESPONSE[$v->{$pField}])) {
                    $RESPONSE[$v->{$pField}] = $v;
                }
            }
        }
        return $RESPONSE;
    }

    public function group_IdFromModels($pModels) {
        if (!is_object($pModels)) {
            return null;
        }
        if (count($pModels) == 0) {
            return null;
        }
        $RESPONSE = [];
        foreach ($pModels as $v) {
            $RESPONSE[$v->id] = $pModels;
        }
        return $RESPONSE;
    }

}
