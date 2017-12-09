<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationModel extends Model {

    protected $table = 'notification';
    public $timestamps = true;
    protected $guarded = ['id', 'created_at', 'from', 'to'];

}
