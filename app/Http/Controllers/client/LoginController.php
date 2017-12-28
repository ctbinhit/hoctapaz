<?php

namespace App\Http\Controllers\client;

use Session;
use UserModel;
use Illuminate\Http\Request;
use App\Bcore\Services\SeoService;
use App\Http\Controllers\ClientController;
use App\Bcore\Services\UserServiceV3;
use App\Bcore\SystemComponents\User\UserType;
use App\Bcore\Services\AuthServiceV3;

class LoginController extends ClientController {

    // Mail service
    private $_MS;

    function __construct() {
        parent::__construct();
    }

    public function get_index(Request $request) {
        SeoService::seo_title('Học tập AZ | Đăng nhập');
        SeoService::seo_description('Đăng nhập Học Tập AZ để so tài kiến thức với bạn bè nào.');
        if ($this->current_user != null) {
            return redirect()->route('client_index');
        }
        return view($this->RV . 'login/index');
    }

    public function post_index(Request $request) {
        if (!$request->has('username') || !$request->has('password')) {
            session::flash('html_callback', (object) [
                        'message_type' => 'warning',
                        'message' => 'Vui lòng nhập tài khoản & mật khẩu!']);
            return redirect()->back();
        }
        $UserServiceV3 = (new UserServiceV3())->user();
        $BOOL_LOGGEDIN = $UserServiceV3->signinWithForm($request->input('username'), $request->input('password'));

        session::flash('html_callback', (object) [
                    'message_type' => 'warning',
                    'message' => $UserServiceV3->get_message()]);

        if (!$BOOL_LOGGEDIN) {
            return redirect()->back();
        }
        if ($request->has('cwr')) {
            return redirect($request->input('cwr'));
        }
        return redirect()->route('client_index');
    }

    public function get_signup() {
        // Keep tokenData if exists
        (new AuthServiceV3)->keep_tokenData();

        return view($this->RV . 'login/signup');
    }

    public function post_signup(Request $request) {
        $ValidateData = $this->validate($request, [
            'email' => 'bail|required|unique:users|min:10|max:255|email',
            'username' => 'bail|required|unique:users|min:10|max:255',
            'password' => 'bail|required|confirmed|min:5',
            'password_confirmation' => 'required|max:255'
                ], [
            'username.min' => 'Username bắt buộc phải lớn hơn 10 ký tự',
            'username.unique' => 'Username đã tồn tại trên hệ thống',
            'password.confirmed' => '2 password không khớp',
            'email.max' => 'Email phải dài hơn 10 ký tự',
            'email.required' => 'Trường Email là trường bắt buộc',
            'email.email' => 'Định dạng email không hợp lệ',
            'email.unique' => 'Email đã tồn tại trên hệ thống'
        ]);
        $UserModel = new UserModel();
        $AuthServiceV3 = (new AuthServiceV3());
        if ($AuthServiceV3->has_tokenData()) {
            $TokenData = $AuthServiceV3->get_tokenData();
            $UserModel->{'id_' . $UserModel->driver} = $TokenData->data->id;
            $UserModel->{$UserModel->driver . '_options'} = json_encode($TokenData->data);
        }
        $UserModel->username = $request->input('username');
        $UserModel->email = $request->input('email');
        $UserModel->password = $request->input('password');
        $UserModel->fullname = $request->input('fullname');
        $UserModel->type = UserType::user();
        $UserModel->activation_key = \App\Bcore\Services\UserService::generateCodeActive($UserModel->email);
        $r = $UserModel->save();
        if ($r) {
            // Gửi mail kích hoạt cho use
            event(new \App\Events\RegisteredEvent($UserModel));
            return \App\Bcore\Services\UserService::renderViewActive($UserModel->email);
        } else {
            session::flash('html_callback', (object) [
                        'message_type' => 'warning',
                        'message' => 'Đăng ký thất bại, server quá tải.']);
            return redirect()->route('client_login_index');
        }
    }

    /* =================================================================================================================
     *                                              access_authenticate_redirect
     * =================================================================================================================
     */

    public function access_authenticate_redirect($driver) {
        return AuthServiceV3::authRedirect($driver);
    }

    /* =================================================================================================================
     *                                              access_authenticate_callback
     * =================================================================================================================
     */

    public function access_authenticate_callback($driver) {
        $AuthService = (new AuthServiceV3())
                        ->set_driver($driver)->authWithDriver($driver);
    
        if ($AuthService->authState() == 2) {
            $driverData = $AuthService->get_driverData();

            session()->flash('_old_input', [
                'fullname' => $driverData->name,
                'email' => $driverData->email,
            ]);
            return redirect()->route('client_login_signup');
        }
        if ($AuthService->authState() != 1) {
            session::flash('html_callback', (object) ['message_type' => 'warning',
                        'message' => "Không thể xác thực $driver vào lúc này"]);
            return redirect()->route('client_login_index');
        }

        return redirect()->route('client_login_index');
    }

    public function access_destroy() {
        if (session::has('user')) {
            session::forget('user');
        }
        return redirect()->route('client_login_index');
    }

    public function get_active() {
        if (!session::has('user_registered')) {
            return redirect()->route('client_index');
        }

        return view('client/login/active', [
            'user_email' => session('user_registed')
        ]);
    }

    public function get_active_o($code) {
        $UserModel = UserModel::where([
                    ['activation_key', '=', $code]
                ])->first();
        if ($UserModel->activated_at != null) {
            return redirect()->route('client_index');
        }
        if ($UserModel != null) {
            $created_at = new \Carbon\Carbon($UserModel->created_at);
            $now = \Carbon\Carbon::now();
            // ----- Tài khoản quá 30p ko active sẽ bị block -----------------------------------------------------------
            if ($created_at->diffInMinutes($now) > 30) {
                $data = [
                    'title' => 'Thông báo',
                    'message_type' => 'danger',
                    'message' => 'Tài khoản đã bị vô hiệu hóa do chưa được xác thực!'
                ];
            } else {
                $UserModel->activated_at = \Carbon\Carbon::now();
                if ($UserModel->save()) {
                    $data = [
                        'title' => 'Thông báo',
                        'message_type' => 'success',
                        'message' => 'Kích hoạt tài khoản thành công!'
                    ];
                    \App\Bcore\Services\NotificationService
                    ::popup('Chào mừng bạn ' . $UserModel->fullname . ' đến với website, chúc bạn một ngày tốt lành.', 'success'
                            , 'Đăng ký thành công.');
                } else {
                    $data = [
                        'title' => 'Thông báo',
                        'message_type' => 'warning',
                        'message' => 'Không thể kích hoạt tài khoản, vui lòng thử lại!'
                    ];
                }
            }
        } else {
            return redirect()->route('client_login_index');
        }
        return view('client/login/active_o', $data);
    }

}
