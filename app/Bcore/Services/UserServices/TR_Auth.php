<?php

namespace App\Bcore\Services\UserServices;

use App\Models\UserModel;
use App\Bcore\Services\UserService;
use App\Bcore\System\AuthResponse;

trait TR_Auth {

    public static function signinWithForm($user, $pass, $type) {
        $UserModel = UserModel::
                where('username', $user)
                ->orWhere('email', $user)
                ->first();

        if ($UserModel == null) {
            return AuthResponse::userNotFound();
        }

        if ($UserModel->password != $pass) {
            return AuthResponse::passwordWrong();
        }

        if ($UserModel->type != $type) {
            return AuthResponse::accountTypeError();
        }
        UserService::setSession($UserModel->id);
        return AuthResponse::success();
    }

    public static function signinWithModel(UserModel $UserModel) {
        try {
            UserService::setSession($UserModel->id);
            return true;
        } catch (\Exception $ex) {
            UserService::logout();
            return false;
        }
    }

    public static function setSession($id_user) {
        $UserModel = UserModel::find($id_user);
        if ($UserModel == null) {
            return false;
        }
        session()->put('user', array(
            'id' => $UserModel->id,
            'username' => $UserModel->email,
            'display_name' => $UserModel->fullname,
            'fullname' => $UserModel->fullname,
            'id_google' => $UserModel->id_google,
            'id_facebook' => $UserModel->id_facebook,
            'avatar' => $UserModel->avatar,
            'google_avatar' => $UserModel->google_avatar,
            'facebook_avatar' => $UserModel->facebook_avatar,
            'email' => $UserModel->email,
            'gender' => $UserModel->gender,
            'type' => $UserModel->type,
            'role' => $UserModel->role,
            'language' => $UserModel->lang,
        ));
        return true;
    }

    public static function check_auth() {
        
    }

}
