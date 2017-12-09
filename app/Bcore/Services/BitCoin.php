<?php

namespace App\Bcore\Services;

class BitCoin {

    function __construct() {
        
    }

    public function get_market() {
        try {
            $x = file_get_contents("https://tiendientu.org/api?market=btc");
            $x = json_decode($x, true);

            if (isset($x['buy'])) {
                //$x = explode(".",$x['bpi']['VND']['rate_float']);
                $buy = trim(str_replace(".", "", $x['buy']));
                $sell = trim(str_replace(".", "", $x['sell']));
                return [
                    'buy' => $buy,
                    'sell' => $sell
                ];
                //$this->db->query("update #_setting set price_current_btc = '" . $price . "',last_update = '" . time() . "'");
                // $_SESSION['system_price'] = $price;
            } else {
                die("ERROR SYSTEM");
            }
        } catch (\Exception $ex) {
             return [
                    'buy' => 0,
                    'sell' => 0
                ];
        }
    }

}
