<?php

namespace App\Bcore\Services;

use Session,
    UserModel;
// System
use App\Bcore\System\UserType;
use App\Bcore\Services\ImageService;
use Storage;
use Illuminate\Support\Facades\DB;

class PeopleService {

    public function __construct() {
        
    }

    public static function get_infoById($id_user) {
        return DB::table('users')->find($id_user);
    }

    public static function get_userPhotoURLById($id_user) {
        $response_url = '';
        $user = PeopleService::get_infoById($id_user);
        if ($user == null) {
            defaultProfile:
            $response_url = ImageService::no_userPhoto();
            goto responseArea;
        }

        if (in_array($user->avatar, UserService::$_ProfilePictureFromSocials)) {
            switch ($user->avatar) {
                case 'gg':
                    $response_url = $user->google_avatar;
                    break;
                case 'fb':
                    $response_url = $user->facebook_avatar;
                    break;
                default:
                    goto defaultProfile;
            }
        } else {
            $response_url = $user->avatar;
        }
        responseArea:
        return $response_url;
    }

}
