<?php

namespace App\Bcore\System;

use Carbon\Carbon;
use App\Models\UserModel;
use App\Bcore\Services\ImageService;
use App\Bcore\SystemComponents\User\UserType;
use Illuminate\Support\Facades\Session;

class UserSession {

    private $_userType = null;
    private $_userModel = null;
    private $_allowUserType = ['user', 'professor', 'admin'];

    function __construct($type = null) {
        if ($type != null) {
            if (in_array($type, $this->_allowUserType)) {
                $this->_userType = $type;
            }
        }
    }

    public function user() {
        $this->_userType = UserType::user();
        return $this;
    }

    public function admin() {
        $this->_userType = UserType::admin();
        return $this;
    }

    public function professor() {
        $this->_userType = UserType::professor();
        return $this;
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
        $this->_userModel = $UserModel;
    }

    public function reload_session() {
        
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
                'coin' => $user_model->coin,
                'username' => $user_model->email,
                'id_card' => $user_model->id_card,
                'fullname' => $user_model->fullname,
                'display_name' => $user_model->fullname,
                'id_google' => $user_model->id_google,
                'id_facebook' => $user_model->id_facebook,
                'date_of_birth' => $user_model->date_of_birth,
                'avatar' => (new ImageService())->getImageUrlById($user_model->avatar),
                'google_avatar' => $user_model->google_avatar,
                'facebook_avatar' => $user_model->facebook_avatar,
                'email' => $user_model->email,
                'gender' => $user_model->gender,
                'phone' => $user_model->phone,
                'type' => $user_model->type,
                'role' => $user_model->role,
                'language' => $user_model->lang,
                'signin_at' => Carbon::now()
            ));
            $this->set_currentSession($id_session);
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function get_currentSession() {
        if ($this->_userType == null) {
            return null;
        }
        if (!$this->has_currentSession()) {
            return null;
        }
        return session('current_' . $this->_userType);
    }

    public function has_currentSession($user_type = null) {
        if ($user_type != null) {
            $this->_userType = $user_type;
        }
        if (Session::has('current_' . $this->_userType)) {
            $session_data = Session('current_' . $this->_userType);
            if (!Session::has($session_data)) {
                Session::flush('current_' . $this->_userType);
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    private function set_currentSession($id_session) {
        session::put('current_' . $this->_userType, $id_session);
    }

}
