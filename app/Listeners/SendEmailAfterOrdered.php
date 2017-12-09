<?php

namespace App\Listeners;

use App\Events\CartOrdered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailAfterOrdered implements ShouldQueue {

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
        
    }

}
