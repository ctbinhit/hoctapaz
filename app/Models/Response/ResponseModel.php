<?php

namespace App\Models\Response;

use Illuminate\Database\Eloquent\Model;

class ResponseModel extends Model
{
    public $code = null;
    public $name = null;
    public $msg = null;
    public $footer = null;
}
