<?php

namespace App\Http\Controllers\admin;

use AdminController;
use Illuminate\Http\Request;
use App\Bcore\Services\UserServiceV3;
use Illuminate\Support\Facades\Session;
use App\Bcore\SystemComponents\User\UserType;

class LoginController extends AdminController {

    public function index() {



//        if (session()->has('user')) {
//            return redirect()->route('admin_index');
//        }
        return $this->render_view('login/index', array(), false);
    }

    public function signin(Request $request) {
        $signin_response = (new UserServiceV3())->admin()->signinWithForm($request->input('username'), $request->input('password'));
        if (!$signin_response) {
            $request->session()->flash('message', 'Thông tin đăng nhập chưa chính xác!');
            return redirect()->route('admin_login_index')->with('message', 'Thông tin đăng nhập chưa chính xác!');
        }
        return redirect()->route('admin_index');
    }

}
