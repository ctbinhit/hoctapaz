<?php

namespace App\Listeners;

use App\Events\AfterSendRequestFileDoc;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddNotificationAfterSendRequestFileDoc {

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
     * @param  AfterSendRequestFileDoc  $event
     * @return void
     */
    public function handle(AfterSendRequestFileDoc $event) {
        $Notification = new \App\Bcore\Services\NotificationService();
        $Notification->set_type('sendToAdmin')
                ->set_title('Duyệt tài liệu')
                ->set_message('Có một đơn yêu cầu duyệt tài liệu từ đối tác vào lúc ' . \Carbon\Carbon::now())
                ->set_link('http://toannang.com.vn')
                ->from('System')
                ->to('admin')
                ->send();
//        $job = (new \App\Jobs\AddNotificationFileNeedToAccess($event->FileModel, $event->UserModel))
//                ->delay(\Carbon\Carbon::now()->addMinutes(1));
//        dispatch($job);
    }

}
