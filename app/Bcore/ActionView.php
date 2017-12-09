<?php

namespace App\Bcore;

use Illuminate\Support\Facades\Session;
use UserModel;

class ActionView extends UserPermission {

    public $id_user = null;
    public $err = false;
    protected $user_pers = null;

    function __construct($pIdUser = null) {
        // Check -------------------------------------------------------------------------------------------------------
        if ($pIdUser == null) {
            if ($this->id_user == null) {
                if (session::has('user')) {
                    if (isset(session('user')['id'])) {
                        $this->id_user = session('user')['id'];
                        $pIdUser = session('user')['id'];
                    } else {
                        goto ErrArea;
                    }
                } else {
                    ErrArea:
                    $this->err = true;
                }
            } else {
                $pIdUser = $this->id_user;
            }
        } else {
            $this->id_user = $pIdUser;
        }
        // -------------------------------------------------------------------------------------------------------------
        if(!isset($pIdUser)){
            return;
        }
        $LstPermissionOfUser = UserModel::find($pIdUser)->db_rela_permission;
        // Nếu không tìm thấy user thì logout hoặc write log...
        if ($LstPermissionOfUser == null) {
            $this->err = false;
            return;
            // Redirect to login page
        }
        $this->user_pers = $LstPermissionOfUser;
    }

    public function register_menu($pDisplay = true, $pController = null, $pAction = null, $pName = null) {
        
    }

    public function register_action() {
        
    }

}
