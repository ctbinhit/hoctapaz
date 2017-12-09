<?php

namespace App\Bcore;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class UserInterface extends UserPermission {

    private $_ROOT = "ViewController";
    private $_ViewData = null;
    private $_ViewData_conf = null;
    private $_ERR = false;
    private $_NAVS = [];

    function __construct($pOption = null) {
        $pOption = (object) $pOption;
        parent::__construct();
        if ($pOption !== null) {
            if (!is_object($pOption)) {
                $this->_ERR = true;
            }
        }

        // ----- CONFIG ------------------------------------------------------------------------------------------------
        $tmp_file_default = $this->_ROOT . '.' . $pOption->ControllerName;
        if (Config::has($tmp_file_default)) {
            $this->_ViewData_conf = (object) Config::get($tmp_file_default);
        } else {
            // ----- Config err, write log... --------------------------------------------------------------------------
            $this->_ERR = true;
        }
        if ($pOption->Type != null) {
            // ----- CUSTOM --------------------------------------------------------------------------------------------
            $tmp_file_custom = $this->_ROOT . '.Customization.' . $pOption->ControllerName . '.' . $pOption->Type;
            if (Config::has($tmp_file_custom)) {
                $this->_ViewData = (object) Config::get($tmp_file_custom);
            } else {
                if ($this->_ViewData_conf == null) {
                    $this->_ERR = true;
                }
            }
        }
    }



    public function set_defaultValue($pValue, $Default) {
        if (!isset($pValue)) {
            return;
        }
        if ($pValue == null) {
            return $Default;
        } else {
            return $pValue;
        }
    }

    public function check_displayCount() {
        $tmp = $this->ConfigVal('lenght');
        if (count($tmp) != 0) {
            return true;
        } else {
            return false;
        }
    }

    public function load_displayCount($ControllerName, $tbl, $type = null) {
        $tmp = $this->ConfigVal('lenght');

        if (count($tmp) == 0) {
            return;
        }
        $string = "";
        if ($type == null) {
            $session = "user.$ControllerName.$tbl.display_count";
        } else {
            $session = "user.$ControllerName.$tbl.$type.display_count";
        }

        foreach ($tmp as $k => $v) {
            $checked = "";
            if (session::has($session)) {
                if (is_numeric(session::get($session))) {
                    if ((int) session::get($session) == $v) {
                        $checked = 'selected';
                    }
                }
            }
            if ($v != -1) {
                $string .= "<option $checked value='$v'>$v</option>";
            } else {
                $string .= "<option $checked value='$v'>" . __('label.tatca') . "</option>";
            }
        }
        return $string;
    }

    public function field($pFieldName) {
        if ($this->_ERR == true || $this->_ViewData_conf == null) {
            return;
        }
        if (isset($this->_ViewData->columns[$pFieldName]['visible'])) {
            if ($this->_ViewData->columns[$pFieldName]['visible']) {
                return true;
            } else {
                return false;
            }
        } else if (isset($this->_ViewData_conf->columns[$pFieldName]['visible'])) {
            if ($this->_ViewData_conf->columns[$pFieldName]['visible']) {
                return true;
            } else {
                return false;
            }
        } else {
            // Write log
            return false;
        }
    }

    public function field_name($pFieldName, $pTrans = true) {
        if ($this->_ERR == true || $this->_ViewData_conf == null) {
            return;
        }
        if (isset($this->_ViewData->columns[$pFieldName]['title'])) {
            if ($this->_ViewData->columns[$pFieldName]['title'] != '') {
                if ($pTrans) {
                    return __($this->_ViewData->columns[$pFieldName]['title']);
                }
                return $this->_ViewData->columns[$pFieldName]['title'];
            } else {
                return;
            }
        } else if (isset($this->_ViewData_conf->columns[$pFieldName]['title'])) {
            if ($this->_ViewData_conf->columns[$pFieldName]['title'] != '') {
                if ($pTrans) {
                    return __($this->_ViewData_conf->columns[$pFieldName]['title']);
                }
                return $this->_ViewData_conf->columns[$pFieldName]['title'];
            } else {
                return;
            }
        } else {
            // Write log
            return;
        }
    }

    public function field_note($pFieldName, $pTrans = true) {
        if ($pTrans) {
            return __($this->get_fieldValueByColName($pFieldName, 'note'));
        }
        return $this->get_fieldValueByColName($pFieldName, 'note');
    }

    private function get_fieldValueByColName($pFieldName, $pColName) {
        if ($this->_ERR == true || $this->_ViewData_conf == null) {
            return;
        }
        if (isset($this->_ViewData->columns[$pFieldName][$pColName])) {
            if ($this->_ViewData->columns[$pFieldName][$pColName] != '') {
                if ($pTrans) {
                    return __($this->_ViewData->columns[$pFieldName][$pColName]);
                }
                return $this->_ViewData->columns[$pFieldName][$pColName];
            } else {
                return;
            }
        } else if (isset($this->_ViewData_conf->columns[$pFieldName][$pColName])) {
            if ($this->_ViewData_conf->columns[$pFieldName][$pColName] != '') {
                if ($pTrans) {
                    return __($this->_ViewData_conf->columns[$pFieldName][$pColName]);
                }
                return $this->_ViewData_conf->columns[$pFieldName][$pColName];
            } else {
                return;
            }
        } else {
            // Write log
            return;
        }
    }

    public function ckeditor($pFieldName) {
        $tmp = $this->get_fieldValueByColName($pFieldName, 'ckeditor');
        if ($tmp != null) {
            if ($tmp == true) {
                return 'ckeditor';
            }
        }
    }

    public function ConfigVal($pConfigName, $pTrans = false) {
        if ($this->_ERR == true || $this->_ViewData_conf == null) {
            return;
        }
        if (isset($this->_ViewData->{$pConfigName})) {
            if ($this->_ViewData->{$pConfigName} != '') {
                if ($pTrans) {
                    return __($this->_ViewData->{$pConfigName});
                }
                return $this->_ViewData->{$pConfigName};
            } else {
                return;
            }
        } else if (isset($this->_ViewData_conf->{$pConfigName})) {
            if ($this->_ViewData_conf->{$pConfigName} != '') {
                if ($pTrans) {
                    return __($this->_ViewData_conf->{$pConfigName});
                }
                return $this->_ViewData_conf->{$pConfigName};
            } else {
                return;
            }
        } else {
            // Write log
            return;
        }
    }

    public function fieldGroup($pFields) {
        if (!is_array($pFields))
            return flase;
        foreach ($pFields as $k => $v) {
            if ($this->field($v)) {
                return true;
            }
        }
        return false;
    }

    public function category_initSortable($pArray, $pArrayData = null, $pParentId = null) {
        if ($pArray == null) {
            return;
        }
        $res = '';
        foreach ($pArray as $k => $v) {
            $res .= '<li class="dd-item dd3-item" data-id="' . $k . '">';
            $res .= '<div class="dd-handle dd3-handle">Drag</div><div class="dd3-content" data-text="' . (isset($pArrayData[$k]->name) ? '[' . $k . '] ' . $pArrayData[$k]->name : $k) . '" data-id="' . $k . '">' . (isset($pArrayData[$k]->name) ? '[' . $k . '] ' . $pArrayData[$k]->name : $k) . '</div>';
            if ($v != null) {
                $res .= '<ol class="dd-list">';
                $res .= $this->category_initSortable($v, $pArrayData, $k);
                $res .= '</ol>';
            }
            $res .= '</li>';
        }
        return $res;
    }

}
