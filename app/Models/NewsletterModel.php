<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NewsletterModel extends Model {

    protected $table = 'newsletter';
    protected $guarded = ['created_at', 'id_user', 'tbl'];
    public $timestamps = true;

}
