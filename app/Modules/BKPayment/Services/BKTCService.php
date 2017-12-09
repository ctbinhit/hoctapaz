<?php

/* =====================================================================================================================
 *                                       THANH TOÁN THẺ CÀO API FOR LARAVEL 5.4
 * ---------------------------------------------------------------------------------------------------------------------
 * Module BKPayment - Build 04-10-2017
 * Created by Bình Cao | (+84) 964 247 742
 * Developed by ToanNang Co., Ltd
 * =====================================================================================================================
 */

namespace App\Modules\BKPayment\Services;

use App\Modules\BKPayment\Services\BKPayment;

class BKTCService extends BKPayment {

    private $thecao_url = 'https://www.baokim.vn/the-cao/restFul/send';
    public $card_seri = '';
    public $card_pin = '';
    public $mang = '';

    static function get_mang() {
        return [
            'MOBI', 'VIETEL', 'GATE', 'VTC', 'VINAPHONE'
        ];
    }

    public function set_card($mang, $card_seri, $card_pin) {
        $this->card_seri = $card_seri;
        $this->card_pin = $card_pin;
        $this->mang = $mang;
    }

    public $transaction_id = null;

    function __construct() {
        parent::__construct();
    }

    public function payment() {
        header('Content-Type: text/html; charset=utf-8');
        define('CORE_API_HTTP_USR', parent::get_merchant_id());
        define('CORE_API_HTTP_PWD', parent::get_api_password());

        $secure_code = parent::get_secure_pass();

        $arrayPost = array(
            'merchant_id' => parent::get_merchant_id(),
            'api_username' => parent::get_api_username(),
            'api_password' => parent::get_api_password(),
            'transaction_id' => time(),
            'card_id' => $this->mang,
            'pin_field' => $this->card_pin,
            'seri_field' => $this->card_seri,
            'algo_mode' => 'hmac'
        );
        ksort($arrayPost);

        $data_sign = hash_hmac('SHA1', implode('', $arrayPost), $secure_code);

        $arrayPost['data_sign'] = $data_sign;

        $curl = curl_init($this->thecao_url);

        curl_setopt_array($curl, array(
            CURLOPT_POST => true,
            CURLOPT_HEADER => false,
            CURLINFO_HEADER_OUT => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPAUTH => CURLAUTH_DIGEST | CURLAUTH_BASIC,
            CURLOPT_USERPWD => CORE_API_HTTP_USR . ':' . CORE_API_HTTP_PWD,
            CURLOPT_POSTFIELDS => http_build_query($arrayPost)
        ));

        $data = curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        $result = json_decode($data, true);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $time = time();

        if ($status == 200) {
            $amount = $result['amount'];
            switch ($amount) {
                case 10000: $xu = 10000;
                    break;
                case 20000: $xu = 20000;
                    break;
                case 30000: $xu = 30000;
                    break;
                case 50000: $xu = 50000;
                    break;
                case 100000: $xu = 100000;
                    break;
                case 200000: $xu = 200000;
                    break;
                case 300000: $xu = 300000;
                    break;
                case 500000: $xu = 500000;
                    break;
                case 1000000: $xu = 1000000;
                    break;
            }
            return (object) [
                        'status' => true,
                        'status_code' => $status,
                        'card_name' => $this->mang,
                        'card_id' => $this->card_pin,
                        'card_seri' => $this->card_seri,
                        'card_value' => $amount,
                        'time' => $time
            ];
        } else {
            return (object) [
                        'status' => false,
                        'status_code' => $status,
                        'card_name' => $this->mang,
                        'card_id' => $this->card_pin,
                        'card_seri' => $this->card_seri,
                        'time' => $time,
                        'msg' => $result['errorMessage']
            ];
        }
    }

}
