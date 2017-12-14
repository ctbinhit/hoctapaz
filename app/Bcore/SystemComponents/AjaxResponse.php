<?php

namespace App\Bcore\SystemComponents;

use App\Bcore\SystemComponents\Error\ErrorType;

class AjaxResponse {

    private $_state = false;
    private $_type = null;
    private $_code = null;
    private $_msg = null;
    private $_ex = null;

    public function __construct() {
        
    }

    public function set_code($code) {
        $this->_code = $code;
    }

    public function set_state(bool $state) {
        $this->_state = $state;
    }

    // State functions

    public function cb_success($msg = null) {
        $this->set_options($msg != null ? $msg : 'Thao tác thành công.', ErrorType::success(), 200);
        $this->set_state(true);
    }

    public function cb_error($msg = null) {
        $this->set_options($msg != null ? $msg : 'Có lỗi xảy ra trong quá trình thao tác.', ErrorType::error());
    }

    public function cb_dataNotFound($msg = null) {
        $this->set_options($msg != null ? $msg : 'Dữ liệu không tồn tại.', ErrorType::error());
    }

    // End state functions

    public function render() {
        return $this->render_response();
    }

    private function set_options($msg, $level, $code) {
        $this->_code = $code;
        $this->_msg = $msg;
        $this->_type = $level;
    }

    private function render_response() {
        return [
            'state' => $this->_state,
            'code' => $this->_code,
            'message' => $this->_msg,
            'ex' => $this->_ex
        ];
    }

    public static function unknowAction() {
        $this->set_options('Unkown', ErrorType::error(), 404);
    }

}
