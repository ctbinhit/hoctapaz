<?php

namespace App\Bcore\Services;

use DB;
use Carbon\Carbon;
use App\Models\UserModel;
use App\Models\PhotoModel;
use App\Bcore\System\UserSession;
use App\Bcore\Services\ImageService;
use Illuminate\Support\Facades\Storage;
use App\Bcore\SystemComponents\User\UserType;
use App\Bcore\SystemComponents\User\UserGender;
use App\Bcore\SystemComponents\Error\ErrorType;

class UserServiceV3 {

    private $_userModel = null;
    private $_log = null;
    private $_logs = [];
    private $_userType = null;
    private $_userSession = null;
    private $_currentSessionName = null;
    private $_prefixSession = 'current_';
    private $_options = [
        'query' => [
            'select' => ['*'],
        ],
        'withPhotoUrl' => false
    ];

    function __construct(UserModel $UserModel = null) {
        if ($UserModel != null) {
            $this->_userModel = $UserModel;
        }
    }

    public function isLoggedIn() {
        return (new UserSession($this->_userType))->has_currentSession();
    }

    public function current() {
        if ($this->_userType != null) {
            $this->_currentSessionName = Session($this->_prefixSession . $this->_userType);
        } else {
            $this->write_log('Phiên làm việc ' . $this->_userType . ' không tồn tại.', ErrorType::warning(), __FUNCTION__);
        }
        return $this;
    }

    public function withPhotoUrl() {
        if ($this->_userModel == null) {
            $this->_options['withPhotoUrl'] = true;
            goto EndFunction;
        }
        if ($this->_userModel->avatar == null || !is_numeric($this->_userModel->avatar)) {
            noUserPhoto:
            $this->_userModel->photo_url = ImageService::no_userPhoto();
        } else {
            $PhotoModel = DB::table('photos')->select('url')->find($this->_userModel->avatar);
            if (StorageServiceV2::fileExists($PhotoModel->url)) {
                $this->_userModel->photo_url = StorageServiceV2::url($PhotoModel->url);
            } else {
                goto noUserPhoto;
            }
        }
        EndFunction:
        return $this;
    }

    public function load_session() {
        if ($this->_userType == null) {
            return null;
        }
        $current_session = (new UserSession($this->_userType))->get_currentSession();
        if ($current_session) {
            if (session()->has($current_session)) {
                $this->_userSession = session($current_session);
            } else {
                $this->_userSession = null;
            }
        }
        //$this->_userSession['avatar'] = $this->find_userPhoto($this->_userSession['avatar']);

        return $this;
    }

    public function loadFromDatabase() {
        if ($this->_currentSessionName == null) {
            return null;
        }
        if (!session()->has($this->_currentSessionName)) {
            return null;
        }
        $SESSION_DATA = Session($this->_currentSessionName);
        if (!isset($SESSION_DATA['id'])) {
            $this->pri_dropCurrentSession($this->_currentSessionName);
            return null;
        }
        // $UserModel = DB::table('users')->select($this->_options['query']['select'])->find(trim($SESSION_DATA['id']));
        $UserModel = UserModel::select($this->_options['query']['select'])->find($SESSION_DATA['id']);
        if ($UserModel == null) {
            $this->write_log('User không tồn tại.', ErrorType::error(), __FUNCTION__);
            $this->pri_dropCurrentSession($this->_currentSessionName);
            return null;
        }
        $this->_userModel = $UserModel;
        if ($this->_options['withPhotoUrl']) {
            $this->withPhotoUrl();
        }
        return $this;
    }

    public function reloadSessionUser() {
        if ($this->_userType == null) {
            
        }
    }

    public function signinWithForm($username, $password) {
        $User = UserModel::where('username', $username)->first();

        if ($User == null) {
            $this->write_log('Tài khoản không tồn tại, đăng nhập thất bại.', \App\Bcore\SystemComponents\Error\ErrorType::warning(), 'Error');
            return false;
        }
        if ($User->password != $password) {
            $this->write_log('Sai tài khoản hoặc mật khẩu!.', \App\Bcore\SystemComponents\Error\ErrorType::warning(), 'Warning');
            return false;
        }

        $UserSession = (new UserSession());
        $UserSession->set_model($User);
        $UserSession->set_session();

        $this->write_log('Đăng nhập thành công!.', ErrorType::success(), 'Login');
        EndFunction:
        return true;
    }

    public function signinWithModel($user_model) {
        $UserSession = (new UserSession());
        $UserSession->set_model($user_model);
        $UserSession->set_session();
    }

    public function get_userModel() {
        return $this->_userModel;
    }

    public function get_jsonModel() {
        return json_encode($this->_userModel);
    }

    public function get_session() {
        if ($this->_userSession == null) {
            return null;
        }
        return $this->_userSession;
    }

    public function createWithDriver($driver_name, $driver_data) {
        $UserModel = new UserModel();
        $UserModel->{'id_' . $driver_name} = $driver_data->id;
        $UserModel->fullname = $driver_data->name;
        $UserModel->{$driver_name . '_options'} = json_encode($driver_data);
        $UserModel->password = str_random(6);
        $UserModel->gender = isset($driver_data->gender) ? $driver_data->gender : UserGender::none();
        $UserModel->email = $driver_data->email;
        $UserModel->role = 1;
        $UserModel->type = UserType::user();
        $UserModel->activation_key = $this->pri_generateKeyActive();
        $UserModel->activated_at = Carbon::now();
        $UserModel->coin = 0;
        return $this->create($UserModel);
    }

    public function create(UserModel $UserModel) {
        try {
            $r = $UserModel->save();
            if ($r) {
                $this->_userModel = $UserModel;
                return true;
            }
            return false;
        } catch (\Exception $ex) {
            return false;
        }
    }

    private function find_userPhoto($id) {
        if (!is_numeric($id)) {
            noUserPhoto:
            return ImageService::no_userPhoto();
        }
        $PhotoModel = PhotoModel::find($id);
        if ($PhotoModel == null) {
            goto noUserPhoto;
        }

        if (Storage::disk('localhost')->exists($PhotoModel->url)) {
            return Storage::disk('localhost')->url($PhotoModel->url);
        } else {
            goto noUserPhoto;
        }
    }

    // SET

    public function set_options($options) {
        if (isset($options['select'])) {
            $this->_options['query']['select'] = $options['select'];
        }
        return $this;
    }

    public function set_userModel(UserModel $UserModel) {
        $this->_userModel = $UserModel;
    }

    public function user() {
        $this->_userType = __FUNCTION__;
        return $this;
    }

    public function professor() {
        $this->_userType = __FUNCTION__;
        return $this;
    }

    public function collaborator() {
        $this->_userType = 'professor';
        return $this;
    }

    public function admin() {
        $this->_userType = __FUNCTION__;
        return $this;
    }

    public static function find_photoURLByModels($models) {
        $ArrayID = [];
        foreach ($models as $v) {
            $ArrayID[] = $v->id;
        }
        $PhotoArray = DB::table('photos')
                ->where([
                    ['obj_table', 'user'], ['obj_type', 'photo']
                ])
                ->whereIn('obj_id', $ArrayID)
                ->get();
        foreach ($models as $k => $v) {
            $r = $PhotoArray->where('obj_id', $v->id)->first();
            if ($r) {
                if (Storage::disk('localhost')->exists($r->url)) {
                    $v->photo_url = $r->url_encode;
                } else {
                    $v->photo_url = ImageService::no_userPhoto();
                }
            } else {
                $v->photo_url = ImageService::no_userPhoto();
            }
        }
        return $models;
    }

    // LOGS

    public function get_log() {
        return $this->_log;
    }

    public function get_message() {
        return $this->_log['message'];
    }

    public function get_logs() {
        return $this->_logs;
    }

    private function write_log($msg, $level, $title, $ext = []) {
        $log = [
            'message' => $msg,
            'level' => $level,
            'title' => $title,
            'ext' => $ext
        ];
        $this->_log = $log;
        $this->_logs[] = $log;
    }

    // PRIVATE FUNCTIONS

    private function pri_generateKeyActive($length = 8) {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    private function pri_dropCurrentSession($session_name) {
        session()->flush($session_name);
        session()->flush($this->_prefixSession . $this->_userType);
    }

}
