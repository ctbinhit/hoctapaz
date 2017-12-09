<?php

namespace App\Bcore;

class UserPermission extends Bcore {

    public $id_user = null;
    private $err = false;

    function __construct() {
        
    }
    
    

    public function get_permissionByIdUser($pIdUser = null) {
        // IdUser ------------------------------------------------------------------------------------------------------
        if ($pIdUser == null) {
            if ($this->id_user == null) {
                $this->err = true;
            } else {
                $pIdUser = $this->$pIdUser;
            }
        } else {
            $this->id_user = $pIdUser;
        }
        // -------------------------------------------------------------------------------------------------------------

        $Model = UserPermission::find($pIdUser);
        if ($Model != null) {
            
        } else {
            
        }
    }

}
