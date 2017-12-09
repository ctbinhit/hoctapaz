<?php

namespace App\Modules\Qa\Models;

use Illuminate\Database\Eloquent\Model;

class QACommentModel extends Model {

    protected $table = 'qa_cmt';
    protected $guarded = ['id', 'created_at'];
    public $timestamps = true;

}
