<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Functions;

use Illuminate\Support\Facades\Route;
use MenuModel,
    UserModel,
    UserPermissionModel;

class ClsAdmin {

    public $_DBMENU = null;
    public $_USER = null;
    private $_ERROR = false;

    function __construct() {
        if (!isset(session('user')['role'])) {
            return;
        }
        // -------------------------------------------------------------------------------------------------------------
        if (!isset(session('user')['id'])) {
            return;
        }
        // -------------------------------------------------------------------------------------------------------------
        $LstPermissionModel = UserModel::find(session('user')['id'])->db_rela_UserPermission;

        if (session('user')['role'] >= 7777) {
            goto setContruct;
        }

        if (count($LstPermissionModel) != 0) {
            setContruct:
            $this->_USER = session('user');
            $this->_DBMENU = $LstPermissionModel;
        }
    }

    public function reload_session($pSessionUser) {
        if ($pSessionUser != null && count($pSessionUser) > 0) {
            $this->_USER = $pSessionUser;
        } else {
            return;
        }
    }

    public function check_actionPermission($pIdController, $pType, $pArray) {
        if (str_contains('\\', $pIdController)) {
            $pControllerName = array_last(explode('\\', $pControllerName));
        } else {
            $pControllerName = $pIdController . "Controller";
        }
        if (!$this->checkPagePermission($pControllerName, $pType, $pArray)) {
            return false;
        } else {
            return true;
        }
    }

    public function checkGroupPermission($pArrayPer) {
        return true;
    }

    // NEW
    /* =================================================================================================================
     * 
     * 
     * -----------------------------------------------------------------------------------------------------------------
     * Icons: font-awesome, bootstrap
     * =================================================================================================================
     */
    public function setMenu($pVisible = true, $pLabel, $pController, $pType, $pArray, $pIcon = null) {
        if ($this->_USER == null) {
            return;
        }
        // List phân quyền = null => return ----------------------------------------------------------------------------
        if (count($this->_DBMENU) == 0) {
            // role user < 7777 => không phải admin --------------------------------------------------------------------
            if (session('user')['role'] < 7777) {
                return;
            } else {
                goto step1;
            }
        }


        if (count($pArray) == 0) {
            if (session('user')['role'] < 7777) {
                return;
            } else {
                goto step1;
            }
        }

        step1:
        // -------------------------------------------------------------------------------------------------------------
        if ($pVisible == false) {
            return;
        }

        // Check Controller exists -------------------------------------------------------------------------------------

        $ThisElement = false;

        // -------------------------------------------------------------------------------------------------------------
        if ($pIcon != null) {
            $pIcon = '<i class="' . $pIcon . '"></i>';
        }
        $res = '';
        $res .= '<li>';
        $res .= '<a href="javascript:void(0)">' . $pIcon . $pLabel . ' <span class="fa fa-chevron-down"></span></a>';

        // -------------------------------------------------------------------------------------------------------------
        //echo "<script>console.log('" . $pArray . "')</script>";

        if ($this->checkPermissionGroup($pController, $pType, $pArray)) {
            if (count($pArray) != 0) {
                $res .= '<ul class="nav child_menu">';
                foreach ($pArray as $k => $v) {
                    if ($this->checkPagePermission($pController, $pType, $v[1])) {
                        $tmp_visible = @$v[0];
                        if ($tmp_visible != null && $tmp_visible == true) {
                            $tmp_label = $k;
                            $tmp_lst_per = $v[1];
                            $tmp_routeName = @$v[2];
                            $tmp_icon = @$v[3];
                            if (!isset($tmp_label)) {
                                //$tmp_label = 'Undefined!';
                            }
                            if (Route::has($tmp_routeName)) {
                                $res .= '<li><a href="' . route($tmp_routeName, [$pType]) . '">' . __($tmp_label) . '</a></li>';
                            } else {
                                
                            }
                        }
                    }
                }
                $res .= '</ul>';
            }
        }
        $res .= '</li>';
        return $res;
    }

    /* ===== checkActionPermission =====================================================================================
      |
      |
      |
      |
      | ================================================================================================================
     */

    public function checkActionPermission($pIdController, $pType = null, $pAction) {
        $res = false;
        if ($this->_USER['role'] >= 7777) {
            return true;
        }
        // -------------------------------------------------------------------------------------------------------------


        resultArea:
        return $res;
    }

    // ===== checkPagePermission =======================================================================================
    // @Param $pIdController
    // @Param $pType
    // @Param $pListPer

    public function checkPagePermission($pIdController, $pType, $pListPer) {
        $res = false;
        if ($this->_USER['role'] >= 7777) {
            return true;
        }
        foreach ($this->_DBMENU as $k1 => $v1) {
            if ($v1->id_controller == trim($pIdController) && $v1->type == trim($pType)) {
                if (is_array($pListPer)) {
                    foreach ($pListPer as $perName) {
                        if ($v1->{$perName} == 1) {
                            return true;
                        }
                    }
                    goto resultArea;
                } else if (is_string($pListPer)) {
                    if ($v1->{$pListPer} == 1) {
                        return true;
                    }
                } else {
                    return false;
                }
            }
        }
        resultArea:
        return $res;
    }

    // ===== checkPermissionGroup ======================================================================================
    // @Param $pIdController
    // @Param $pType

    public function checkPermissionGroup($pIdController, $pType, $pArrayPer) {
        if ($this->_USER['role'] >= 7777) {
            return true;
        }
        $res = false;
        // Ex  'label.quanlydanhsach' => [true,['per_view'],'admin_article_index']
        foreach ($pArrayPer as $k => $v) {
            foreach ($this->_DBMENU as $k1 => $v1) {
                if ($v1->id_controller == trim($pIdController) && $v1->type == trim($pType)) {
                    if (is_array($v[1])) {
                        foreach ($v[1] as $perName) {
                            if ($v1->{$perName} == 1) {
                                $res = true;
                                goto resultArea;
                            }
                        }
                    }
                }
            }
        }
        resultArea:
        return $res;
    }

    // ===== SET MENU ==================================================================================================
    // Example: set_menu(true, 'menu_product', 'Products');
    //
    
    public function set_menu($pDisplay, $pIdMenu, $pName, $pURL) {



        return;

        $MenuModel = new MenuModel();
        if ($MenuModel->check_item_exists($pIdMenu)) {
            // OK
        } else {
            if ($pName != '' && $pName != null) {
                $MenuModel->insert_items(array(
                    'id' => $pIdMenu,
                    'ten' => $pName
                ));
            } else {
                // Write log
                // Tên menu rỗng hoặc null
            }
        }

        // Cho phép hiển thị
        if ($pDisplay) {
            // Nếu user role = 9999 => Administrator
            if (session('user')['role'] != 9999) {
                if ($this->db_per !== null) {
                    // Xét quyền truy cập menu
                    if (key_exists($pIdMenu, $this->db_per)) {
                        // Nếu quyền hạn là true thì cho phép hiển thị
                        if ($this->db_per[$pIdMenu] === 1) {
                            // => OK
                        } else {
                            return;
                        }
                    } else {
                        return;
                    }
                } else {
                    // Danh sách = null => không có phân quyền menu nào cho user này tự động out
                    return;
                }
            }

            // ========== RESULT =======================================================================================
            return '<li><a href="' . $pURL . '">' . $pName . "</a></li>";
            // =========================================================================================================
        }
    }

}
