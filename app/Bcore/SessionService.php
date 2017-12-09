<?php

namespace App\Bcore;

use Session;

class SessionService extends Bcore {

    function __construct() {
        parent::__construct();
    }

    public function set_displayCount($pControllerName, $pCount = 5, $pType = null) {
        if ($pControllerName == null) {
            return null;
        }

        Session::put("$pControllerName", (object) [
                    "$pType" => (object) [
                        'display_count' => $pCount
                    ]
        ]);
    }

}
