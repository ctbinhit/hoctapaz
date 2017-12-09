<?php

/* =====================================================================================================================
 *                                                  BẢO KIM PAYMENT API FOR LARAVEL 5.4
 * ---------------------------------------------------------------------------------------------------------------------
 * Module BKPayment - Build 04-10-2017
 * Created by Bình Cao | (+84) 964 247 742
 * Developed by ToanNang Co., Ltd
 * =====================================================================================================================
 */

namespace App\Modules\BKPayment\Services;

class BKPayment {

    protected $_CF = null;

    function __construct($conf = [
        'bk_url' => 'https://www.baokim.vn/payment/customize_payment/order',
        'bk_merchant_id' => '30919',
        'bk_secure_pass' => 'fb2f1694c2b796cb',
        'bk_api_username' => 'hoctapazcomvn',
        'bk_api_password' => 'afvCKevcnH4ZZBjRMbsT'
    ]) {
        $this->_CF = (object) [
                    'bk_url' => $conf['bk_url'],
                    'bk_merchant_id' => $conf['bk_merchant_id'],
                    'bk_secure_pass' => $conf['bk_secure_pass'],
                    'bk_api_username' => $conf['bk_api_username'],
                    'bk_api_password' => $conf['bk_api_password'],
        ];
    }

    protected function get_merchant_id() {
        return $this->_CF->bk_merchant_id;
    }

    protected function get_url() {
        return $this->_CF->bk_url;
    }

    protected function get_secure_pass() {
        return $this->_CF->bk_secure_pass;
    }

    protected function get_api_username() {
        return $this->_CF->bk_api_username;
    }

    protected function get_api_password() {
        return $this->_CF->bk_api_password;
    }

    /**
     * Hàm xây dựng url chuyển đến BaoKim.vn thực hiện thanh toán, trong đó có tham số mã hóa (còn gọi là public key)
     * @param $order_id				Mã đơn hàng
     * @param $business 			Email tài khoản người bán
     * @param $total_amount			Giá trị đơn hàng
     * @param $shipping_fee			Phí vận chuyển
     * @param $tax_fee				Thuế
     * @param $order_description                Mô tả đơn hàng
     * @param $url_success			Url trả về khi thanh toán thành công
     * @param $url_cancel			Url trả về khi hủy thanh toán
     * @param $url_detail			Url chi tiết đơn hàng
     * @return url cần tạo
     */
    public function createRequestUrl(
    $order_id, $business, $total_amount, $shipping_fee, $tax_fee, $order_description, $url_success, $url_cancel, $url_detail
    ) {
        $params = array(
            'merchant_id' => strval($this->_CF->bk_merchant_id),
            'order_id' => strval($order_id),
            'business' => strval($business),
            'total_amount' => strval($total_amount),
            'shipping_fee' => strval($shipping_fee),
            'tax_fee' => strval($tax_fee),
            'order_description' => strval($order_description),
            'url_success' => strtolower($url_success),
            'url_cancel' => strtolower($url_cancel),
            'url_detail' => strtolower($url_detail)
        );
        ksort($params);
        $str_combined = $this->_CF->bk_secure_pass . implode('', $params);
        $params['checksum'] = strtoupper(md5($str_combined));
        $redirect_url = $this->_CF->bk_url;
        if (strpos($redirect_url, '?') === false) {
            $redirect_url .= '?';
        } else if (substr($redirect_url, strlen($redirect_url) - 1, 1) != '?' && strpos($redirect_url, '&') === false) {
            $redirect_url .= '&';
        }
        $url_params = '';
        foreach ($params as $key => $value) {
            if ($url_params == '')
                $url_params .= $key . '=' . urlencode($value);
            else
                $url_params .= '&' . $key . '=' . urlencode($value);
        }
        return $redirect_url . $url_params;
    }

    /**
     * Hàm thực hiện xác minh tính chính xác thông tin trả về từ BaoKim.vn
     * @param $_GET chứa tham số trả về trên url
     * @return true nếu thông tin là chính xác, false nếu thông tin không chính xác
     */
    public function verifyResponseUrl($PARAM = array()) {
        $checksum = $PARAM['checksum'];
        unset($PARAM['checksum']);
        ksort($PARAM);
        $str_combined = $this->_CF->bk_secure_pass . implode('', $PARAM);
        $verify_checksum = strtoupper(md5($str_combined));
        if ($verify_checksum === $checksum)
            return true;
        return false;
    }

}
