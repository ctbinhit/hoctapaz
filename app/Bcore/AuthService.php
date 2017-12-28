<?php

/* =====================================================================================================================
  |                                     AuthService 1.0 - Created By Bình Cao
  | --------------------------------------------------------------------------------------------------------------------
  |
  |
  |
  | =====================================================================================================================
 */

namespace App\Bcore;

use UserModel;
use Socialite;
use Session;
use App\Bcore\SystemComponents\User\UserType;

class AuthService extends Bcore {

    private $_RESULT = [
        'state' => null,
        'driver_data' => null,
        'local_data' => null
    ];
    public $_driver = null;
    private $_type_require = null;
    private $_log = null;
    public $_USERDATA = null;
    public $_SOCIALDATA = null;

    function __construct($pDirver = null) {
        parent::__construct();
        $this->_driver = $pDirver;
    }

    public function set_typeRequire($pType) {
        $this->_type_require[] = $pType;
        return $this;
    }

    public function set_driver($pDriver) {
        if (!is_string($pDriver)) {
            $this->_log = [
            ];
            return -1;
        }
    }

    public function checkUser($pCheckName, $pModel) {
        switch (trim($pCheckName)) {
            case 'lock':
                if ($pModel->lock_by == null) {
                    return true;
                }
                return false;
            case 'activation':
                if ($pModel->activated_at != null) {
                    return true;
                } return false;
            case 'type':
                if (in_array($pModel->type, $this->_type_require)) {
                    return true;
                }
                return false;
            default:
                return false;
        }
    }

    private function checkUserType($pType) {
        if ($this->_type_require == $pType) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserModelByFormInput($pParams) {
        if (!is_object($pParams)) {
            return false;
        }
        $wr = [
            ['password', '=', $pParams->password]
        ];
        return UserModel::
                        // ----- Login via username
                        where([
                            ['username', '=', $pParams->username]
                        ])->where($wr)
                        // ----- Login via email
                        ->orWhere([
                            ['email', '=', $pParams->username]
                        ])->where($wr)
                        ->first();
    }

    /* 102: Sai tài khoản hoặc mật khẩu
     * 100: Chưa active
     * 101: TK Bị khóa
     * 
     */

    private function check_formSignin($username, $password) {
        $UserModel = UserModel::where([
                    ['username', '=', $username],
                    ['password', '=', $password],
                ])->first();
        if ($UserModel == null) {
            $this->set_log('Sai tài khoản hoặc mật khẩu', 102, __FUNCTION__);
            return false;
        }
        $this->_USERDATA = $UserModel;
        if (!$this->checkUser('lock', $UserModel)) {
            $this->set_log('Tài khoản bị khóa', 101, __FUNCTION__);
            return false;
        }
        if (!$this->checkUser('activation', $UserModel)) {
            $this->set_log('Tài khoản chưa được kích hoạt', 101, __FUNCTION__);
            return false;
        }
        if (!$this->checkUser('type', $UserModel)) {
            $this->set_log('Tài khoản chưa được kích hoạt', 101, __FUNCTION__);
            return false;
        }
        return true;
    }

    /*
     * Trả về Usermodel nếu tồn tại session user id | false
     */

    public function user_info() {
        if ($this->is_user()) {
            $USER_ID = Services\UserServiceV2::current_userId(UserType::user());
            $UserModel = UserModel::find($USER_ID);
            if ($UserModel == null) {
                return false;
            } else {
                return $UserModel;
            }
        } else {
            return false;
        }
    }

    public function is_user() {
        if (Services\UserServiceV2::isLoggedIn(UserType::user())) {
            if (Services\UserServiceV2::isUser()) {
                return true;
            } else {
                return -1;
            }
        } else {
            return false;
        }
    }

    public function auth_redirect($pDriver = null) {
        if ($pDriver == null) {
            if ($this->_driver == null) {
                // Log
                return -1;
            } else {
                $pDriver = $this->_driver;
            }
        } else {
            $this->_driver = $pDriver;
        }
        try {
            return Socialite::driver($pDriver)->redirect();
        } catch (\Exception $ex) {
            session::flash('info_callback', (object) [
                        'message_type' => 'danger',
                        'message' => "Không thể xác thực $pDriver vào lúc này!"]);
            return redirect()->route('client_login_index');
        }
    }

    private function get_userModelByEmail($pEmail) {
        return UserModel::where('email', '=', $pEmail)->first();
    }

    private function get_userModelByIdDriver($pDriver, $pIdDriver) {
        return UserModel::where("id_$pDriver", '=', $pIdDriver)->first();
    }

    /* =================================================================================================================
      |                                             auth_callback
      | ----------------------------------------------------------------------------------------------------------------
      | =================================================================================================================
     */

    public function auth_callback($pDriver) {
        try {
            $user = Socialite::driver($pDriver)->user();
            return $user;
        } catch (\Exception $ex) {
            return -1;
        }
    }

    private function setSession($pIdUser = null) {
        if ($this->_USERDATA != null) {
            $pIdUser = $this->_USERDATA->id;
        }
        $UserModel = UserModel::find($pIdUser);
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
            'google_avatar' => $UserModel->google_avatar,
            'facebook_avatar' => $UserModel->facebook_avatar,
            'email' => $UserModel->email,
            'gender' => $UserModel->gender,
            'role' => $UserModel->role,
            'language' => $UserModel->lang,
        ));
        return true;
    }

    public function get_codeActive() {
        $tmp = str_random(10);
        $tmp .= '-' . md5(\Carbon\Carbon::now());
        return $tmp;
    }

    public function registerWithSocialModel($pDirver, $SM) {
        $UM = new UserModel();
        if ($SM->email != null) {
            $UM->email = $SM->email;
        }
        $UM->{"id_$pDirver"} = $SM->id;
        $UM->{$pDirver . '_avatar'} = $SM->avatar;
        $UM->type = 'user';
        $UM->fullname = $SM->name;
        $UM->activation_key = $this->get_codeActive();
        $UM->activated_at = \Carbon\Carbon::now();
        if (isset($SM->user['gender'])) {
            $UM->gender = $SM->user['gender'];
        }
        if ($UM->save()) {
            if ($this->get_userById($UM->id) != null) {
                return true;
            } else {
                $this->set_log('Lỗi CSDL, không tìm thấy id ' . $UM->id, null, __FUNCTION__);
                return false;
            }
            return true;
        } else {
            $this->set_log('Không thể lưu vào CSDL!', null, __FUNCTION__);
            return false;
        }
    }

    public function get_userById($pId) {
        $tmp = UserModel::find($pId);
        if ($tmp != null) {
            $this->_USERDATA = $tmp;
            return true;
        } else {
            return null;
        }
    }

    public function signin_with_form($username, $password) {
        
    }

    public function signin_with_model($pUserModel) {
        try {
            if ($pUserModel->activated_at == null) {
                return null;
            }
            return $this->setSession($pUserModel->id);
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function signin_with_driver($pDriver, $pData) {
        $this->_SOCIALDATA = $pData;
        $State = $this->checkSocial($pDriver, $pData);
        switch ((int) $State) {
            case 200:
                if ($this->setSession()) {
                    return true;
                } else {
                    $this->set_log('Không thể set session!', 200, __FUNCTION__);
                    return false;
                }
                break;
            case 199:
                if ($this->registerWithSocialModel($pDriver, $pData)) {
                    return $this->setSession();
                } else {
                    return false;
                }
                break;
            case 188:
                $this->set_log('Email đã tồn tại trên hệ thống, nhưng chưa được xác thực với tài khoản này!', 188, __FUNCTION__);
                return false;
                break;
            default:
                $this->set_log('Lỗi không xác định!', __LINE__, __FUNCTION__);
                return false;
        }
    }

    public function set_log($msg, $code = null, $func = null) {
        $this->_log = [
            'code' => $code,
            'msg' => $msg,
            'func' => $func
        ];
    }

    public function log() {
        if ($this->_log == null) {
            $this->_log = [
                'code' => null,
                'msg' => null,
                'func' => null
            ];
        }
        return (object) $this->_log;
    }

    /* =================================================================================================================
     * @Param Driver | String
     * @Param Data social | Object
      User {#522 ▼
      +token: "EAAU3hebWZCQMBAOTpZBxpvUY0fgMWMHN0uK71bz5n7w32ZA9UVZAc1actozukJN2KAyj8vqHaNt83b8SWg2LrHpZB6BCPwwIZCNyyec5
     * WpEBj3ypAwI9gDD7LiXVyroSqtHUC1yM78ZBBHZAl4REovbRQhtwaguJeWyqRaXnTFZBLlOqDHSZA1eZCJt ◀"
      +refreshToken: null
      +expiresIn: 5098066
      +id: "1112494878887437"
      +nickname: null
      +name: "Bình Cao"
      +email: "ctbinhit@gmail.com"
      +avatar: "https://graph.facebook.com/v2.10/1112494878887437/picture?type=normal"
      +user: array:6 [▼
      "name" => "Bình Cao"
      "email" => "ctbinhit@gmail.com"
      "gender" => "male"
      "verified" => true
      "link" => "https://www.facebook.com/app_scoped_user_id/1112494878887437/"
      "id" => "1112494878887437"
      ]
      +"avatar_original": "https://graph.facebook.com/v2.10/1112494878887437/picture?width=1920"
      +"profileUrl": "https://www.facebook.com/app_scoped_user_id/1112494878887437/"
      }
     * =================================================================================================================
     * 200 => OK
     * 199 => Add new chưa có tk db & social
     * 188 => Chưa có id driver
     * 189 => Email OK, Id Driver !=
     * 201 => Lỗi không xác định
     * 
     */

    public function checkSocial($pDriver, $pData) {
        $this->_SOCIALDATA = $pData;
        // TK MXH Có email => Check email
        if ($pData->email != null) {
            $UserEmailModel = $this->get_userModelByEmail($pData->email);
            // Không có email tồn tại trên local
            if ($UserEmailModel == null) {
                // Không có email -> check id driver
                $TMP = $this->get_userModelByIdDriver($pDriver, $pData->id);
                if ($TMP == null) {
                    // TK chưa có đăng ký trên hệ thống => tạo mới
                    return 199;
                } else {
                    // 200 OK => id driver có trên hệ thống => xác thực thành công
                    $this->_USERDATA = $TMP;
                    return 200;
                }
            } else {
                if ($UserEmailModel->{"id_$pDriver"} == null) {
                    // Email tồn tại trên local, Id không tồn tại => đồng bộ tk
                    return 188;
                } elseif ($UserEmailModel->{"id_$pDriver"} == $pData->id) {
                    // 2 ID giống nhau => xác thực thành công
                    $this->_USERDATA = $UserEmailModel;
                    return 200;
                } elseif ($UserEmailModel->{"id_$pDriver"} != $pData->id) {
                    // Email trùng với tk trên local nhưng id driver không trùng => đã bị xác thực bởi tk driver khác
                    return 189;
                } else {
                    return 201;
                    // Lỗi không xác định
                }
            }
        } else {
            // Email MXH = null => check ID
            $TMP = $this->get_userModelByIdDriver($pDriver, $pData->id);
            if ($TMP == null) {
                // Email social = null , ID DRIVER chưa tồn tại trên local => thêm mới
                return 199;
            } else {
                // ID driver tồn tại trên hệ thống => xác thực thành công
                $this->_USERDATA = $TMP;
                return 200;
            }
        }
    }

}
