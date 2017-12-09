<?php

namespace App\Bcore\Services;

use Session,
    UserModel;
use Storage;
use App\Bcore\System\UserType;

class UserService {

    use UserServices\TR_Payment;
    use UserServices\TR_Auth;

    public $_STATE = false;
    public static $_ProfilePictureFromSocials = ['gg', 'fb'];

    public function __construct() {
        parent::__construct();
    }

    public static function account_type() {
        try {
            return UserService::info()['type'];
        } catch (\Exception $ex) {
            return null;
        }
    }

    public static function generateCodeActive($user_email) {
        return md5($user_email . \Carbon\Carbon::now());
    }

    public static function renderViewActive($user_email) {
        session::flash('user_registered', $user_email);
        return redirect()->route('client_login_active');
    }

    public static function getCodeActiveByEmail($email) {
        return $UserModel = UserModel::where([['activation_key', $email]])->first()->activation_key;
    }

   

    public static function updateInfo() {
        $id_session = session('user')['id'];
        UserService::setSession($id_session);
    }

    public static function info($use_session = true) {
        if (Session::has('user')) {
            if ($use_session) {
                return session('user');
            } else {
                return UserService::db_info();
            }
        } else {
            return null;
        }
    }

    public static function db_info() {
        try {
            return \App\Models\UserModel::find(session('user')['id']);
        } catch (\Exception $ex) {
            return null;
        }
    }

    public static function isLocked() {
        if (!session::has('user')) {
            return null;
        }
        $user = \App\Models\UserModel::find(session('user')['id']);
        if ($user == null) {
            return -1;
        }
        return $user->lock_dy == null ? false : true;
    }

    public static function logout() {
        session::forget('user');
    }

    public static function isLogged() {
        return Session::has('user') ? true : false;
    }

    public static function isLoggedIn() {
        return session::has('user');
    }

    public static function isAdmin() {
        try {
            return UserService::db_info()->type == 'admin' ? true : false;
        } catch (\Exception $ex) {
            return null;
        }
    }

    public static function is(UserType $user_type, $cache = true) {
        try {
            if ($cache) {
                $user = UserService::info();
            } else {
                $user = UserService::db_info();
            }
            return ($user->type == $user_type) ? true : false;
        } catch (\Exception $ex) {
            // Write log
            return false;
        }
    }

    public static function isProfessor() {
        try {
            return UserService::db_info()->type == 'professor' ? true : false;
        } catch (\Exception $ex) {
            return null;
        }
    }

    public static function isUser() {
        try {
            return UserService::db_info()->type == 'user' ? true : false;
        } catch (\Exception $ex) {
            return null;
        }
    }

    public static function fullName() {
        return UserService::info()['fullname'];
    }

    public static function firstName() {
        try {
            $name = explode(' ', UserService::info()['fullname']);
            return end($name);
        } catch (\Exception $ex) {
            return UserService::fullName();
        }
    }

    public static function displayName() {
        try {
            $name = explode(' ', UserService::info()['fullname']);
            return array_last($name) . '    ' . array_first($name);
        } catch (\Exception $ex) {
            return "Error.";
        }
    }

    public static function id() {
        try {
            return UserService::info()['id'];
        } catch (\Exception $ex) {
            return false;
        }
    }

    public static function photo_url() {
        try {
            $UserInfo = UserService::info();
            switch ($UserInfo['avatar']) {
                case null:
                    $PM = UserService::db_photo();
                    if ($PM != null)
                        return Storage::disk('localhost')->url($PM->url);
                    goto responseArea;
                case 'fb':
                    if ($UserInfo->facebook_avatar) {
                        return $UserInfo->facebook_avatar;
                    }
                    goto responseArea;
                case 'gg':
                    if ($UserInfo->google_avatar) {
                        return $UserInfo->google_avatar;
                    }
                    goto responseArea;
                default:
                    goto responseArea;
            }
            responseArea:
            return Storage::disk('localhost')->url('default/no-image.png');
        } catch (\Exception $ex) {
            return Storage::disk('localhost')->url('default/no-image.png');
        }
    }

    public static function photo_thumbnail($w = 200, $h = 200) {
        try {
            $UserInfo = UserService::info();
            switch ($UserInfo['avatar']) {
                case null:
                    $PM = UserService::db_photo();
                    if ($PM != null)
                        return html_thumbnail($PM->url_encode, $w, $h);
                    goto responseArea;
                case 'fb':
                    if ($UserInfo['facebook_avatar'] != null) {
                        return $UserInfo['facebook_avatar'];
                    }
                    goto responseArea;
                case 'gg':
                    if ($UserInfo['google_avatar'] != null) {
                        return $UserInfo['google_avatar'];
                    }
                    goto responseArea;
                default:
                    goto responseArea;
            }
            responseArea:
            return Storage::disk('localhost')->url('default/no-image.png');
        } catch (\Exception $ex) {
            return Storage::disk('localhost')->url('default/no-image.png');
        }
    }

    public static function db_photo() {
        return \App\Models\PhotoModel::where([
                    ['obj_type', 'photo'],
                    ['obj_table', 'user'],
                    ['obj_id', UserService::id()]
                ])->first();
    }

}
