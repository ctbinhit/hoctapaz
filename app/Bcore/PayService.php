<?php

namespace App\Bcore;

class PayService extends Bcore {

    function __construct() {
        
    }

    public function get_marketInfo($pName) {
        switch($pName) {
            case 'bitcoin':
                return new Services\BitCoin();
        }
        return null;
    }

}
