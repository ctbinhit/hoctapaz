<?php

namespace App\Listeners;

use App\Events\CartOrdered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddNotificationAfterOrdered implements ShouldQueue {

    /**
     * Create the event listener.
     *
     * @return void
     */
    use InteractsWithQueue;

    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CartOrdered  $event
     * @return void
     */
    public function handle(CartOrdered $event) {
        if (true) {
            $this->release(10);
        }
        $action = new \App\Bcore\Services\NotificationService();
        $User = \App\Models\UserModel::find($event->id_user);
        $action->set_type('sendToAdmin')
                ->set_title('Thông báo')
                ->set_message('Có đơn hàng mới từ ' . $User->email)
                ->set_link('http://toannang.com.vn')
                ->from('System')
                ->to(null)
                ->send();
    }

    public function failed(CartOrdered $event, $exception) {
        
    }

}
