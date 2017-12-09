<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccountModel extends Model {

    protected $table = 'bank_accounts';
    public $timestamps = true;
    protected $guarded = ['id'];

}
