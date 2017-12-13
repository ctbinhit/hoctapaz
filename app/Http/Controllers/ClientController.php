<?php

namespace App\Http\Controllers;

use App\Bcore\ControllerService;
use View,
    Config;
use Illuminate\Support\Facades\Cache;
// Module Background
use App\Modules\Background\Models\BackgroundModel;
use App\Modules\Background\Services\BackgroundService;
use App\Bcore\Services\AppService;
use App\Bcore\Services\UserServiceV2;
use App\Bcore\System\UserType;
use App\Models\UserModel;

class ClientController extends ControllerService {

    public $RV = 'client/';
    public $_USER = null;

    public function __construct() {
        parent::__construct();

        $this->middleware(function($request, $next) {
            $this->_USER = UserServiceV2::get_currentSessionData(UserType::user());
            return $next($request);
        });


        $website_info = AppService::get_info(UserServiceV2::get_currentLangId(UserType::user()));
        View::share('website_info', $website_info);

        // Background footer
        $bg_footer = BackgroundService::convertCssByType('footer');
        View::share('bg_footer', $bg_footer);

        // THÔNG BÁO ĐẦU TRANG
        if (class_exists('\App\Modules\PMN\Models\PMNModel')) {
            $PMN_HEADER = \App\Modules\PMN\Models\PMNModel::where([
                        ['type', '=', 'header']
                    ])->first();
            if ($PMN_HEADER != null) {
                View::share('pmn_header', $PMN_HEADER);
            }
        }
    }

    public function get_currentDBUserData() {
        if ($this->_USER == null) {
            return null;
        }
        return UserModel::find($this->_USER['id']);
    }
    

}
