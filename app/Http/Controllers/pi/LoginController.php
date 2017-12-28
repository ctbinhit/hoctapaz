<?php

namespace App\Http\Controllers\pi;

use Illuminate\Http\Request;
use App\Http\Controllers\ProfessorController;
use UserModel;
use AuthService;
use Session;
use App\Bcore\Services\UserServiceV2;
use App\Bcore\Services\UserServiceV3;
use App\Bcore\SystemComponents\User\UserType;

class LoginController extends ProfessorController {

    public function get_index() {

        if (UserServiceV2::isLoggedIn(UserType::professor())) {
            return redirect()->route('pi_index_index');
        }
        return view('pi/user/login');
    }

    public function post_index(Request $request) {
        $this->validate($request,[
            'username' => 'required',
            'password' => 'required'
        ]);
        $input_username = $request->input('username');
        $input_password = $request->input('password');
        
        $UserServiceV3 = (new UserServiceV3())->collaborator()->signinWithForm($input_username, $input_password);

        if (!$UserServiceV3) {
            return back()->withInput();
        }

        return redirect()->route('pi_login_index');
    }

}
