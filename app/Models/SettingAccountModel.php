<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingAccountModel extends Model {

    protected $table = 'setting_accounts';
    public $timestamps = true;
    protected $guarded = ['id', 'type', 'tbl', 'created_at'];
    public $incrementing = false;
    public $_select = '*';

    public function set_select($select_query) {
        $this->_select = $select_query;
        return $this;
    }

    public function get_accountById($id_account) {
        return SettingAccountModel::select($this->_select)->find($id_account);
    }

    public function get_accounts() {
        return SettingAccountModel::select($this->_select)->get();
    }

}
