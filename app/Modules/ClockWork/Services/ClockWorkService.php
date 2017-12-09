<?php

namespace App\Modules\ClockWork\Services;
use App\Modules\ClockWork\Services\Clockwork;


class ClockWorkService {

    private $API_KEY = '8f24f284ac03f69a5f01c577b61d27a9ade93366';

    function __construct() {
        
    }

    public static function sendSms() {
        try {
            $clockwork = new Clockwork('8f24f284ac03f69a5f01c577b61d27a9ade93366');
            $message = array('to' => '964247742', 'message' => 'This is a test!');
            $result = $clockwork->send($message);

            // Check if the send was successful
            if ($result['success']) {
                echo 'Message sent - ID: ' . $result['id'];
            } else {
                echo 'Message failed - Error: ' . $result['error_message'];
            }
        } catch (\Exception $ex) {
            return 'Exception sending SMS: ' . $ex->getMessage();
        }
    }

}
