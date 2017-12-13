<?php

namespace App\Bcore\System;

use App\Models\UserModel;
use App\Bcore\SystemComponents\User\UserType;

class UserSession {

    private $_userType = null;
    private $_userModel = null;

    function __construct() {
        
    }

    public function set_model(UserModel $UserModel) {
        switch ($UserModel->type) {
            case 'user':
                $this->_userType = UserType::user();
                break;
            case 'professor':
                $this->_userType = UserType::professor();
                break;
            case 'admin':
                $this->_userType = UserType::admin();
                break;
        }
    }

    public function set_session() {
        if ($this->_userType == null ||
                $this->_userModel == null) {
            return false;
        }
        try {
            $user_model = $this->_userModel;
            $id_session = $this->_userType . '.user_' . $user_model->id;
            session()->put($id_session, array(
                'id' => $user_model->id,
                'username' => $user_model->email,
                'date_of_birth' => $user_model->date_of_birth,
                'display_name' => $user_model->fullname,
                'fullname' => $user_model->fullname,
                'id_card' => $user_model->id_card,
                'id_google' => $user_model->id_google,
                'id_facebook' => $user_model->id_facebook,
                'avatar' => $user_model->avatar,
                'google_avatar' => $user_model->google_avatar,
                'facebook_avatar' => $user_model->facebook_avatar,
                'email' => $user_model->email,
                'gender' => $user_model->gender,
                'phone' => $user_model->phone,
                'type' => $user_model->type,
                'role' => $user_model->role,
                'language' => $user_model->lang,
            ));
            $this->set_currentSession($id_session);
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }

    private function set_currentSession($id_session) {
        session::put('current_' . $this->_userType, $id_session);
    }

}
