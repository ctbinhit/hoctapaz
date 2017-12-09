<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use AdminController;
use App\Bcore\System\UserType;
use App\Bcore\Services\UserServiceV2;
use Illuminate\Support\Facades\Session;

class LoginController extends AdminController {

    public function index() {
       
        
        
//        if (session()->has('user')) {
//            return redirect()->route('admin_index');
//        }
        return $this->render_view('login/index', array(), false);
    }

    public function signin(Request $request) {
        $signin_response = UserServiceV2::signinWithForm($request->input('username'), $request->input('password'), UserType::admin());


        if (!$signin_response) {
            $request->session()->flash('message', 'Thông tin đăng nhập chưa chính xác!');
            return redirect()->route('admin_login_index')->with('message', 'Thông tin đăng nhập chưa chính xác!');
        }
        return redirect()->route('admin_index');
    }

}
