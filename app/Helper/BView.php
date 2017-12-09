<?php

/* =============================== TOANNANG Co., Ltd ===================================================================
  | Author: Bình Cao | Phone: (+84) 964 247 742 | Email: ctbinhit@gmail.com or binhcao.toannang@gmail.com
  | Version: 1.0 | 28/08/2017 01:00:00 AM
  | --------------------------------------------------------------------------------------------------------------------
  | ====================================================================================================================
 */

namespace App\Helper;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;

class BView {

    protected $_VIEWDATA = null;
    protected $_CONTROLLER = null;
    protected $_ENV = null;
    private $_DEBUG = false;

    function __construct($pControllerName, $pViewData) {
        $this->_CONTROLLER = $pControllerName;
        $this->_VIEWDATA = $pViewData; // Data type: Object
        $this->_ENV = (object) Config::get("ViewController.$this->_CONTROLLER");
        $this->_DEBUG = @Config::get('bcore.Debug');
    }

    public function __call($name, $arguments) {
        if (Config::get('bcore.Debug')) {
            dump("Method: $name không tồn tại trong class " . __CLASS__ . " file " . __FILE__ . "<br>");
        }
    }

    public function get_fieldTitle($pFieldName) {
        if (isset($this->_ENV->columns[$pFieldName]['title'])) {
            return __($this->_ENV->columns[$pFieldName]['title']);
        } else {
            
        }
    }

    public function get_OptionString($pOptionName) {
        $Param = $this->get_Option($pOptionName);
        switch ($pOptionName) {
            case 'lenght':
                return $this->_option_length($Param);
                break;
            default:
                return;
        }
    }

    public function get_Option($pOptionName) {
        if (isset($this->_VIEWDATA->{$pOptionName})) {
            return $this->_VIEWDATA->{$pOptionName};
        } else {
            if (isset($this->_ENV->{$pOptionName})) {
                return $this->_ENV->{$pOptionName};
            } else {
                if ($this->_DEBUG) {
                    dump("[BVIEW] Cảnh báo dữ liệu chưa được khai báo " . __METHOD__ . " tại dòng " . __LINE__);
                }
                return '';
            }
        }
    }

    public function _option_length($pVal) {
        if ($pVal === null) {
            return;
        }
        $res1 = '[';
        $res2 = '[';
        if (is_array($pVal)) {
            for ($i = 0; $i < count($pVal); $i++) {
                if ($i != count($pVal) - 1) {
                    $res1 .= $pVal[$i] . ',';
                    if ($pVal[$i] != -1) {
                        $res2 .= $pVal[$i] . ',';
                    } else {
                        $res2 .= "'label.tatca'";
                    }
                } else {
                    $res1 .= $pVal[$i];
                    if ($pVal[$i] != -1) {
                        $res2 .= $pVal[$i];
                    } else {
                        $res2 .= "'label.tatca'";
                    }
                }
            }
        }
        $res1 .= ']';
        $res2 .= ']';
        return ($res1 . ',' . $res2);
    }

    // @Param $pFieldAndKey: name.title
    // @Param $pTrans: true => auto trans | return string

    public function get_fieldValueSring($pFieldAndKey, $pTrans = false) {
        if (is_string($pFieldAndKey)) {
            try {
                $tmp = explode('.', $pFieldAndKey);
                if (isset($this->_VIEWDATA->columns[$tmp[0]][$tmp[1]])) {
                    // Ex: $this->_VIEWDATA['name']['title']
                    if ($tmp[1] == 'title') {
                        TransArea:
                        return @__($this->_VIEWDATA->columns[$tmp[0]][$tmp[1]]);
                    } else {
                        if ($pTrans) {
                            goto TransArea;
                        } else {
                            if ($tmp[1] == 'visible') {
                                if ($this->_VIEWDATA->columns[$tmp[0]][$tmp[1]]) {
                                    return 'true';
                                } else {
                                    return 'false';
                                }
                            } else {
                                return $this->_VIEWDATA->columns[$tmp[0]][$tmp[1]];
                            }
                        }
                    }
                } else {
                    // Lấy dữ liệu từ config 
                    if (isset($this->_ENV->columns[$tmp[0]][$tmp[1]])) {
                        if ($tmp[1] == 'title') {
                            TransArea1:
                            return @__($this->_ENV->columns[$tmp[0]][$tmp[1]]);
                        } else {
                            if ($pTrans) {
                                goto TransArea1;
                            } else {
                                if ($tmp[1] == 'visible') {
                                    if ($this->_ENV->columns[$tmp[0]][$tmp[1]]) {
                                        return 'true';
                                    } else {
                                        return 'false';
                                    }
                                } else {
                                    return $this->_ENV->columns[$tmp[0]][$tmp[1]];
                                }
                            }
                        }
                    } else {
                        if ($this->_DEBUG) {
                            dump("[BVIEW] Cảnh báo dữ liệu chưa được khai báo " . __METHOD__ . " tại dòng " . __LINE__);
                        }
                        return '';
                    }
                }
            } catch (Exception $ex) {
                if ($this->_DEBUG) {
                    dump("[BVIEW] Có lỗi xảy ra tại phương thức " . __METHOD__ . " tại dòng " . __LINE__);
                }
                return '';
            }
        } else {
            if (Config::get('bcore.Debug')) {
                dump("[BVIEW] Sai tham số! <br> Tham số thứ 1 của phương thức " . __METHOD__ .
                        " bắt buộc phải là dạng String tại dòng " . __LINE__ . " file: " . __FILE__);
            }
            return '';
        }
    }

    public function get_fieldValue($pFieldAndKey, $pTrans = false) {
        if (is_string($pFieldAndKey)) {
            try {
                $tmp = explode('.', $pFieldAndKey);
                if (isset($this->_VIEWDATA->columns[$tmp[0]][$tmp[1]])) {
                    // Ex: $this->_VIEWDATA['name']['title']
                    if ($tmp[1] == 'title') {
                        TransArea:
                        return @__($this->_VIEWDATA->columns[$tmp[0]][$tmp[1]]);
                    } else {
                        if ($pTrans) {
                            goto TransArea;
                        } else {
                            return $this->_VIEWDATA->columns[$tmp[0]][$tmp[1]];
                        }
                    }
                } else {
                    // Lấy dữ liệu từ config 
                    if (isset($this->_ENV->columns[$tmp[0]][$tmp[1]])) {
                        if ($tmp[1] == 'title') {
                            TransArea1:
                            return @__($this->_ENV->columns[$tmp[0]][$tmp[1]]);
                        } else {
                            if ($pTrans) {
                                goto TransArea1;
                            } else {
                                return $this->_ENV->columns[$tmp[0]][$tmp[1]];
                            }
                        }
                    } else {
                        if ($this->_DEBUG) {
                            dump("[BVIEW] Cảnh báo dữ liệu chưa được khai báo " . __METHOD__ . " tại dòng " . __LINE__);
                        }
                        return '';
                    }
                }
            } catch (Exception $ex) {
                if ($this->_DEBUG) {
                    dump("[BVIEW] Có lỗi xảy ra tại phương thức " . __METHOD__ . " tại dòng " . __LINE__);
                }
                return '';
            }
        } else {
            if (Config::get('bcore.Debug')) {
                dump("[BVIEW] Sai tham số! <br> Tham số thứ 1 của phương thức " . __METHOD__ .
                        " bắt buộc phải là dạng String tại dòng " . __LINE__ . " file: " . __FILE__);
            }
            return '';
        }
    }

    public function get_fieldFromEnv($pFieldName, $pDefaultValue = false) {
        if (isset($this->_ENV->columns[$pFieldName]['visible'])) {
            return $this->_ENV->columns[$pFieldName]['visible'];
        } else {
            DefaultValue:
            if (is_bool($pDefaultValue)) {
                return $pDefaultValue;
            } else {
                if ($this->_DEBUG) {
                    dump("[BVIEW] Sai tham số! <br> Tham số thứ 2 của phương thức " . __METHOD__ .
                            " bắt buộc phải là dạng Boolean (True hoặc false) tại dòng " .
                            __LINE__ . " file: " . __FILE__);
                }
                return false;
            }
        }
    }

    public function fieldGroup($pFields) {
        if (is_array($pFields)) {
            foreach ($pFields as $fieldName) {
                if ($this->field($fieldName)) {
                    return true;
                }
            }
            return false;
        } else if (is_string($pFields)) {
            return $this->check_field($pFields);
        } else {
            if ($this->_DEBUG) {
                dump("[BVIEW] Sai tham số! <br> Tham số thứ 1 của phương thức " . __METHOD__ .
                        " bắt buộc phải là dạng Array hoặc String tại dòng " . __LINE__ .
                        " file: " . __FILE__);
            }
            return false;
        }
    }

    public function field($pFieldName, $pDefault = false) {
        if (!isset($this->_VIEWDATA->columns)) {
            goto getFromEnvArea;
        }
        // [1] Nếu key đã tồn tại trong viewdata(middleware)
        // Ngược lại: lấy viewdata từ config
        if (key_exists($pFieldName, $this->_VIEWDATA->columns)) {
            if (isset($this->_VIEWDATA->columns[$pFieldName]['visible'])) {
                return $this->_VIEWDATA->columns[$pFieldName]['visible'];
            } else {
                goto getFromEnvArea;
//                if (is_bool($pDefault)) {
//                    if ($pDefault) {
//                        return true;
//                    } else {
//                        return false;
//                    }
//                } else {
//                    if ($this->_DEBUG) {
//                        dump("[BVIEW] Sai tham số! <br> Tham số thứ 2 của phương thức " . __METHOD__ .
//                                " bắt buộc phải là dạng Boolean tại dòng " . __LINE__ . " file: " . __FILE__);
//                    }
//                    return false;
//                }
            }
        } else {
            getFromEnvArea:
            return $this->get_fieldFromEnv($pFieldName, $pDefault);
        }
    }

}
