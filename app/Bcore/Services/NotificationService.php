<?php

namespace App\Bcore\Services;

use Session;

class NotificationService {

    private $_type = null;
    private $_title = null;
    private $_message = null;
    private $_content = null;
    private $_Link = null;
    private $_from = null;
    private $_to = null;

    public function __construct() {
        
    }

    public function send() {
        $NotificationModel = new \App\Models\NotificationModel();
        $NotificationModel->noti_from = $this->_from;
        $NotificationModel->noti_to = $this->_to;
        $NotificationModel->title = $this->_title;
        $NotificationModel->message = $this->_message;
        $NotificationModel->content = $this->_content;
        $NotificationModel->link = $this->_link;
        $NotificationModel->type = $this->_type;
        $r = $NotificationModel->save();
        if ($r) {
            return true;
        } else {
            return false;
        }
    }

    public static function sendToAdmin($type = 'sendToAdmin') {
        $model = new \App\Models\NotificationModel();
    }

    public static function info() {
        return (object) [
                    'version' => 2.0
        ];
    }

    public static function alertRight($message, $type = 'info', $title = 'Thông báo') {
        session::flash('info_callback', (object) [
                    'message_title' => $title,
                    'message' => $message,
                    'message_type' => $type
        ]);
    }

    public static function popup($message, $type = 'info', $title = 'Thông báo') {
        session::flash('html_popup', (object) [
                    'message_title' => $title,
                    'message' => $message,
                    'message_type' => $type
        ]);
    }

    public static function popup_default($message, $type = 'info', $title = 'Thông báo') {
        session::flash('html_popup_normal', (object) [
                    'message_title' => $title,
                    'message' => $message,
                    'message_type' => $type
        ]);
    }

    /* =================================================================================================================
     * SET METHOD
     * =================================================================================================================
     */

    public function set_type($type) {
        $this->_type = $type;
        return $this;
    }

    public function set_title($title) {
        $this->_title = $title;
        return $this;
    }

    public function set_content($content) {
        $this->_content = $content;
        return $this;
    }

    public function set_message($msg) {
        $this->_message = $msg;
        return $this;
    }

    public function from($from) {
        $this->_from = $from;
        return $this;
    }

    public function set_link($link) {
        $this->_link = $link;
        return $this;
    }

    public function to($to) {
        $this->_to = $to;
        return $this;
    }

}
