<?php

namespace App\Listeners;

use App\Events\RegisteredEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailAfterRegistered {

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param  RegisteredEvent  $event
     * @return void
     */
    public function handle(RegisteredEvent $event) {
        $UserModel = $event->UserModel;
        $MailService = new \App\Bcore\Services\MailService();
        $MAIL_SENDED = $MailService->set_subject('Đăng ký tài khoản tại Học Tập AZ')
                ->set_template('cart')
                ->set_data([
            'website_name' => 'Học Tập AZ',
            'link' => route('client_login_active_o', $UserModel->activation_key),
            'user' => $UserModel
        ])->send($UserModel->email);

        if ($MAIL_SENDED) {
            
        } else {
            // Có lỗi xảy ra trong quá trình gửi mail.
        }
    }

}
