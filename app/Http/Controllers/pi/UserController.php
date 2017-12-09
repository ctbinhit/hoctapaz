<?php

namespace App\Http\Controllers\pi;

use Illuminate\Http\Request;
use App\Http\Controllers\ProfessorController;
use App\Bcore\Services\NotificationService;
use App\Bcore\Services\UserService;
use Storage;
use UserModel;
use AuthService;
use Session,
    View;
use App\Bcore\Services\UserServiceV2;
use App\Bcore\System\UserType;

class UserController extends ProfessorController {

    public $storage = 'user_files';

    public function __construct() {
        parent::__construct();
    }

    public function get_index() {
        return view('pi/info/index');
    }

    public function get_me_detail() {
        return view('pi/info/detail', [
            'select_countries' => \App\Bcore\Services\LocaleService::render_select_countries()->render(),
        ]);
    }

    public function post_me_detail_save(Request $request) {
        $act = $request->input('act');
        switch ($act) {
            case 'si':
                if ($this->save_info($request)) {
                    NotificationService::alertRight('Cập nhật thông tin thành công!', 'success');
                } else {
                    NotificationService::alertRight('Cập nhật không thành công, vui lòng thử lại sau!', 'warning');
                }
                break;
            case 'sl':
                if ($this->save_info_locale($request)) {
                    NotificationService::alertRight('Cập nhật thông tin thành công!', 'success');
                } else {
                    NotificationService::alertRight('Cập nhật không thành công, vui lòng thử lại sau!', 'warning');
                }
                break;
            default:
                NotificationService::alertRight('Thao tác không xác định!', 'warning');
                return redirect()->route('pi_me_info');
        }
        redirectArea:
        return redirect()->route('pi_me_detail');
    }

    public function get_me_friends() {

        return view('pi/info/friends');
    }

    public function get_me_transaction() {

        return view('pi/info/transaction');
    }

    public function get_me_security() {
        return view('pi/info/security');
    }

    public function get_me_setting() {

        return view('pi/info/setting');
    }

    // ===== PRIVATE FUNCTION ==========================================================================================

    private function save_info($request) {

        try {
            if ($request->hasFile('user_photo')) {
                $PhotoModel = \App\Models\PhotoModel::where([
                            ['obj_type', 'photo'],
                            ['obj_table', 'user'],
                            ['obj_id', UserService::id()]
                        ])->first();

                if ($PhotoModel != null) {
                    $PM_O = $PhotoModel;
                }
                $FILE = $request->user_photo;
                $PathLocal = Storage::disk('localhost')->put('user_files', $FILE, 'public');
                if ($PathLocal != null) {
                    $PM_N = new \App\Models\PhotoModel();
                    $PM_N->obj_type = 'photo';
                    $PM_N->dir_name = $this->storage;
                    $PM_N->obj_table = 'user';
                    $PM_N->obj_id = UserService::id();
                    $PM_N->id_user = UserService::id();
                    $PM_N->name = $FILE->getClientOriginalName();
                    $PM_N->mimetype = $FILE->getMimetype();
                    $PM_N->size = $FILE->getSize();
                    $PM_N->url = $PathLocal;
                    $PM_N->url_encode = md5($PathLocal);
                    $photo_saved = $PM_N->save();

                    if ($photo_saved) {
                        if (isset($PM_O) && $PM_O != null) {
                            Storage::disk('localhost')->delete($PM_O->url);
                            $PM_O->delete();
                        }
                    }
                } else {
                    return false;
                }
            }

            $UserModel = \App\Bcore\Services\UserService::db_info();
            $UserModel->fullname = $request->input('fullname');
            $UserModel->phone = $request->input('phone');
            $UserModel->email = $request->input('email');
            $UserModel->avatar = $request->input('profile_picture');
            $UserModel->gender = $request->input('gender');
            $UserModel->id_card = $request->input('id_card');
            $UserModel->date_of_birth = $request->input('date_of_birth');
            if ($UserModel->save()) {
                UserService::updateInfo();
                return true;
            } else {
                return false;
            }
        } catch (\Exception $ex) {
            return false;
        }
    }

    private function save_info_locale($request) {
        try {
            $UserModel = UserService::db_info();

            $UserModel->address = $request->input('address');
            return $UserModel->save();
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function save_info_account($request) {
        try {
            
        } catch (\Exception $ex) {
            
        }
    }

}
