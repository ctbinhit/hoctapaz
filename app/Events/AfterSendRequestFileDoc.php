<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AfterSendRequestFileDoc {

    use Dispatchable,
        InteractsWithSockets,
        SerializesModels;

    public $FileModel;
    public $UserModel;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(\App\Models\FileModel $FileModel, \App\Models\UserModel $UserModel) {
        $this->FileModel = $FileModel;
        $this->UserModel = $UserModel;
      
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn() {
        return new PrivateChannel('Professor.Send.Request.FileDoc');
    }

}
