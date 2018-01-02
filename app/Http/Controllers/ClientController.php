<?php

namespace App\Http\Controllers;

use App\Bcore\ControllerService;
use View,
    Config;
use Illuminate\Support\Facades\Cache;
// Module Background
use App\Modules\Background\Services\BackgroundService;
use App\Bcore\Services\AppService;
use App\Bcore\Services\UserServiceV2;
use App\Bcore\Services\UserServiceV3;
use App\Bcore\SystemComponents\User\UserType;

class ClientController extends ControllerService {

    public $RV = 'client/';
    public $current_user;
    public $_USER = null;

    public function __construct() {
        parent::__construct();


        $website_info = AppService::get_info(UserServiceV2::get_currentLangId(UserType::user()));
        View::share('website_info', $website_info);

        // Background footer
        $bg_footer = BackgroundService::convertCssByType('footer');
        View::share('bg_footer', $bg_footer);

        // THÔNG BÁO ĐẦU TRANG
        if (class_exists('\App\Modules\PMN\Models\PMNModel')) {
            $PMN_HEADER = \App\Modules\PMN\Models\PMNModel::where('type', 'header')->first();
            if ($PMN_HEADER != null) {
                View::share('pmn_header', $PMN_HEADER);
            }
        }

        $this->middleware(function($request, $next) {
            $this->load_userSession();
            //  dd(  $this->current_user);
            return $next($request);
        });
    }

    public function load_userSession() {
        $UserSession = (new UserServiceV3)->user()->load_session()->get_session();
        $this->current_user = $UserSession != null ? (object) json_decode(json_encode($UserSession)) : null;
        View::share('current_user', $this->current_user != null ? (object) $this->current_user : null);
        return $this->current_user;
    }

    public function load_user($use_cache = true) {
        if ($use_cache) {
            return (new UserServiceV3())->user()->current()->loadFromDatabase()->get_userModel();
        } else {
            // Chữa cháy
            return (new UserServiceV3())->user()->current()->loadFromDatabase()->get_userModel();
        }
    }

}
