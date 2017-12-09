<?php

namespace App\Http\Controllers\pi;

use Illuminate\Http\Request;
use App\Http\Controllers\ProfessorController;
use UserModel;
use AuthService;
use Session;
use App\Bcore\Services\UserServiceV2;
use App\Bcore\System\UserType;

class LoginController extends ProfessorController {

    public function get_index() {

        if (UserServiceV2::isLoggedIn(UserType::professor())) {
            return redirect()->route('pi_index_index');
        }
        return view('pi/user/login');
    }

    public function post_index(Request $request) {
        $input_username = $request->input('username');
        $input_password = $request->input('password');

        $singin = UserServiceV2::signinWithForm($input_username, $input_password, UserType::professor());

        if (!$singin) {
            return back()->withInput();
        }

        return redirect()->route('pi_login_index');
    }

}
