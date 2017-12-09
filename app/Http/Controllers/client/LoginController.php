<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\ClientController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Socialite;
use AuthService;
use Session;
use UserModel,
    MailService;
use \App\Bcore\Services\UserService;
use App\Bcore\System\UserType;
use App\Bcore\Services\SeoService;
use App\Bcore\Services\NotificationService;

class LoginController extends ClientController {

    private $_AuthService = null;
    // Mail service
    private $_MS;

    function __construct() {
        parent::__construct();
        $this->_AuthService = new AuthService();
    }

    public function get_index(Request $request) {
        SeoService::seo_title('Học tập AZ | Đăng nhập');
        SeoService::seo_description('Đăng nhập Học Tập AZ để so tài kiến thức với bạn bè nào.');
        if (session::has('user')) {
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

        $SigninResponse = UserService::signinWithForm($request->input('username'), $request->input('password'), UserType::user());
        $response_code = $SigninResponse['code'];
        if ($response_code == 404) {
            session::flash('html_callback', (object) [
                        'message_type' => 'warning',
                        'message' => 'Sai tài khoản hoặc mật khẩu!']);
            return redirect()->back();
        }

        if ($response_code == 401) {
            session::flash('html_callback', (object) [
                        'message_type' => 'warning',
                        'message' => 'Tài khoản chưa được kích hoạt, vui lòng kiểm tra hộp thư ' . $request->has('username') . ' để xác thực tài khoản.']);
            return redirect()->back();
        }

        if ($response_code == 403) {
            session::flash('html_callback', (object) [
                        'message_type' => 'warning',
                        'message' => 'Tài khoản của bạn không thể đăng nhập vào mục này.']);
            return redirect()->back();
        }

        if (!$SigninResponse['response_state']) {
            session::flash('html_callback', (object) [
                        'message_type' => 'warning',
                        'message' => 'Có lỗi xảy ra trong quá trình xác thực']);
            return redirect()->back();
        }

        if ($request->has('cwr')) {
            return redirect($request->input('cwr'));
        }
        return redirect()->route('client_index');
    }

    public function get_signup() {
        if (session::has('user')) {
            return redirect()->route('client_index');
        }
        return view($this->RV . 'login/signup');
    }

    public function post_signup(Request $request) {
        if (!$request->has('email')) {
            session::flash('html_callback', (object) [
                        'message_type' => 'warning',
                        'message' => 'Địa chỉ email không hợp lệ!']);
            return redirect()->back()->withInput();
        }
        $UserModel = UserModel::where([
                    ['email', '=', $request->input('email')]
                ])->get();
        if (count($UserModel) > 0) {
            session::flash('html_callback', (object) [
                        'message_type' => 'warning',
                        'message' => 'Email ' . $request->input('email') . ' đã được đăng ký trên hệ thống!']);
            return redirect()->back()->withInput();
        }
        if (!$request->has('username')) {
            session::flash('html_callback', (object) [
                        'message_type' => 'warning',
                        'message' => 'Username không được bỏ trống!']);
            return redirect()->back()->withInput();
        }
        $UserModel = UserModel::where([
                    ['username', '=', $request->input('username')]
                ])->get();
        if (count($UserModel) > 0) {
            session::flash('html_callback', (object) [
                        'message_type' => 'warning',
                        'message' => 'Username ' . $request->input('username') . ' đã có người sử dụng!']);
            return redirect()->back()->withInput();
        }
        if (!$request->has('fullname')) {
            session::flash('html_callback', (object) [
                        'message_type' => 'warning',
                        'message' => 'Họ và tên không được bỏ trống!']);
            return redirect()->back()->withInput();
        }
        if (strlen($request->input('fullname')) < 6) {
            session::flash('html_callback', (object) [
                        'message_type' => 'warning',
                        'message' => 'Họ và tên quá ngắn!']);
            return redirect()->back()->withInput();
        }
        if (!$request->has('password') || !$request->has('password2')) {
            session::flash('html_callback', (object) [
                        'message_type' => 'warning',
                        'message' => 'Password không được bỏ trống!']);
            return redirect()->back()->withInput();
        }
        if ($request->input('password') != $request->input('password2')) {
            session::flash('html_callback', (object) [
                        'message_type' => 'warning',
                        'message' => '2 Password không khớp!']);
            return redirect()->back()->withInput();
        }
        $UserModel = new UserModel();
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
        return $this->_AuthService->auth_redirect($driver);
    }

    /* =================================================================================================================
     *                                              access_authenticate_callback
     * =================================================================================================================
     */

    public function access_authenticate_callback($driver) {
        $AuthCallback = $this->_AuthService->auth_callback($driver);
        // Lỗi xảy ra trong quá trình xác thực tài khoản
        
        if (!is_object($AuthCallback)) {
            session::flash('html_callback', (object) ['message_type' => 'warning',
                        'message' => "Không thể xác thực $driver vào lúc này"]);
            return redirect()->route('client_login_index');
        }
        $TMP = $this->_AuthService->signin_with_driver($driver, $AuthCallback);
        if ($TMP) {
            return redirect()->route('client_login_index');
        } else {
            session::flash('html_callback', (object) ['message_type' => 'warning',
                        'message' => $this->_AuthService->log()->msg]);
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
