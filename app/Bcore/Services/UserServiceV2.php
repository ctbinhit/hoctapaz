<?php

namespace App\Bcore\Services;

use Session;
use Storage;
use App\Bcore\SystemComponents\User\UserType;
use App\Models\UserModel;
use Illuminate\Support\Facades\DB;
use App\Bcore\Type\SocialType;
use App\Bcore\System\UserSession;
use App\Bcore\Services\ImageService;

class UserServiceV2 {

    private $_security = [
        'mode' => '',
        'mode_supported' => ['safe', 'fast', 'rnd', 'realtime']
    ];
    private $_select = [
        'users.id', 'users.fullname', 'users.created_at'
    ];

    public static function isLoggedIn($account_type) {
        $CurrentUser = UserServiceV2::get_currentSessionData($account_type);
        if ($CurrentUser == null) {
            return false;
        }
        return true;
    }

    public static function isUser() {
        
    }

    public static function isAdmin() {
        try {
            $current_admin_session_data = UserServiceV2::get_currentSessionData(UserType::admin());
            if ($current_admin_session_data == null) {
                return false;
            }
            // ----- Random Mode ---------------------------------------------------------------------------------------
            // ----- Safe Mode -----------------------------------------------------------------------------------------
            if (false) {
                $UserModel = UserModel::find($current_admin_session_data['id']);
                if ($UserModel === null) {
                    UserServiceV2::drop_session(); // Danger!
                }
                if ($UserModel->type != UserType::admin()) {
                    return false; // Danger!
                }
            }

            // ----- Real time mode ------------------------------------------------------------------------------------
            if (false) {
                // The column [users][time_signin] in [database] doesn't match with [current_admin][user.(int)] => block this IP
            }
            // ----- Fast Mode -----------------------------------------------------------------------------------------
            return true;
        } catch (\Exception $ex) {
            UserServiceV2::drop_session();
        }
    }

    public static function isType($account_type, $use_cache = true) {
        $User = UserServiceV2::get_currentSessionData($account_type);
        if ($User == null) {
            return false;
        }
        if (!$use_cache) {
            $DB_USER = UserModel::find($User['id']);
            if ($DB_USER == null) {
                UserServiceV2::drop_session();
            }
            $User['type'] = $DB_USER->type;
        }
        return $User['type'] == $account_type ? true : false;
    }

    public static function get_currentSessionData($account_type) {
        if (Session::has("current_$account_type")) {
            $current_session_id = session("current_$account_type");
            return session($current_session_id);
        }
        return null;
    }

    public static function get_currentLangId($account_type) {
        try {
            $current_id = UserServiceV2::current_userId($account_type);
            return UserModel::find($current_id)->lang;
        } catch (\Exception $ex) {
            // Write log
            return LanguageService::get_idLanguageDefault();
        }
    }

    public static function current_userId($account_type) {
        try {
            if (Session::has("current_$account_type")) {
                $current_session_id = session("current_$account_type");
                return session($current_session_id)['id'];
            }
        } catch (\Exception $ex) {
            UserServiceV2::drop_session();
            return null;
        }
    }

    public static function is_socialExist($social) {
        try {
            if ($social == null) {
                return false;
            }
            $s_id = $social->id;
            $s_email = $social->email;
            $db = DB::table('users')
                    ->where('email', $s_email)
                    ->orWhere('id_google', $s_id)
                    ->orWhere('id_facebook', $s_id)
                    ->first();
            return $db == null ? false : true;
        } catch (\Exception $ex) {
            return null;
        }
    }

    public static function siginWithDriver($data) {
        
    }

    public static function signinWithForm($username, $password, $account_type) {
        $UserModel = DB::table('users')
                        ->where([
                            ['username', $username],
                            ['password', $password],
                            ['type', $account_type]
                        ])->first();
        if ($UserModel == null) {
            return false;
        }
        return UserServiceV2::setSession($account_type, $UserModel);
    }

    public static function signinWithModel($model) {
        return UserServiceV2::setSession($model->type, $model);
    }

    public static function get_currentSession($account_type = 'user') {
        $current_id = "current_$account_type";
        return Session::has($current_id) ? session($current_id) : null;
    }

    public static function set_currentSession($id_session, $account_type) {
        session::put('current_' . $account_type, $id_session);
    }

    public static function get_current_avatar($user_info) {
        if (!is_object($user_info)) {
            return ImageService::no_userPhoto();
        }
        $avatar = $user_info->avatar;
        switch ($avatar) {
            case 'fb':
                return $user_info->facebook_avatar;
            case 'gg':
                return $user_info->google_avatar;
            default:
                if ($user_info->avatar != null) {
                    if (Storage::disk('localhost')->exists($user_info->avatar)) {
                        return Storage::disk('localhost')->url($user_info->avatar);
                    }
                } else {
                    return $user_info->facebook_avatar != null ? $user_info->facebook_avatar :
                            $user_info->google_avatar != null ? $user_info->google_avatar :
                            ImageService::no_userPhoto();
                }
        }
    }

    public static function get_socialAvatar($social_type) {
        
    }

    public static function drop_currentSession($account_type) {
        try {
            $id_session = 'current_' . $account_type;
            $session = session($id_session);
            Session::forget($session);
            Session::forget($id_session);
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public static function drop_session($id_session = null) {
        if ($id_session == null) {
            if (Session::has($id_session)) {
                Session::forget($id_session);
            }
        }
        Session::flush();
    }

    public static function load_dbUserBySession($session_data) {
        try {
            $sd = (object) $session_data;
            $r = UserModel::select([
                        'id', 'fullname', 'date_of_birth', 'email', 'coin', 'phone', 'phone_active', 'username', 'lang', 'address', 'gender',
                        'id_card', 'id_city', 'id_district', 'status', 'id_vip', 'tbl', 'role', 'avatar', 'id_google', 'id_facebook',
                        'google_avatar', 'facebook_avatar', 'type', 'lock_date', 'lock_by', 'lock_message', 'activated_at', 'created_at',
                        'updated_at'
                    ])->find($sd->id);
            return $r;
        } catch (\Exception $ex) {
            return null;
        }
    }

    public static function get_sesssionData($account_type) {
        $current_id_session = UserServiceV2::get_currentSession($account_type);
        return $current_id_session != null ? session($current_id_session) : null;
    }

    protected static function setSession($account_type, $user_model) {
        try {
            $id_session = $account_type . '.user_' . $user_model->id;
            $US = (new UserSession());
            $US->set_model($user_model);
            $US->set_session();
            UserServiceV2::set_currentSession($id_session, $account_type);
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public static function generate_key() {
        return str_random(4) . time();
    }

}
