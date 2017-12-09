<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event; 
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // Xử lý khi có một KH vừa đặt 1 đơn hàng
        'App\Events\CartOrdered' => [
            'App\Listeners\AddNotificationAfterOrdered',
            'App\Listeners\SendEmailAfterOrdered'
        ],
        // Xử lý gửi mail sau khi có 1 user vừa mới đăng ký
        'App\Events\RegisteredEvent' => [
            'App\Listeners\SendMailAfterRegistered'
        ],
        // Xử lý khi có tài khoản đối tác yêu cầu xác thực một tài liệu vừa đc upload
        'App\Events\AfterSendRequestFileDoc' => [
            'App\Listeners\AddNotificationAfterSendRequestFileDoc'
        ]
        
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
