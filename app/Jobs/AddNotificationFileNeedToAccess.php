<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AddNotificationFileNeedToAccess implements ShouldQueue {

    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;
    public $tries = 2;
    public $timeout = 60;

    public $FileModel;
    public $UserModel;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(\App\Models\FileModel $FileModel, \App\Models\UserModel $UserModel) {
        $this->FileModel = $FileModel;
        $this->UserModel = $UserModel;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    
    public function handle() {
        $Notification = new \App\Bcore\Services\NotificationService();
        $Notification->set_type('sendToAdmin')
                ->set_title('Duyệt tài liệu')
                ->set_message('Có một đơn yêu cầu duyệt tài liệu từ đối tác vào lúc ' . \Carbon\Carbon::now())
                ->set_link('http://toannang.com.vn')
                ->from('System')
                ->to('admin')
                ->send();
    }

}
