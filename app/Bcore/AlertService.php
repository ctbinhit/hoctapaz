<?php

namespace App\Bcore;

use UserModel;
use Socialite;
use Session;

class AlertService {

    public function __construct() {
        
    }

    public function set_alert($pParam) {
        if (is_array($pParam)) {
            session::flash('_RESPONSE_', $pParam);
        }
    }

}
