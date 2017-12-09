<?php

namespace App\Modules\UserVIP\Models;

use Illuminate\Database\Eloquent\Model;

class UserVIPModel extends Model {

    protected $table = 'users_vip';
    protected $guarded = ['created_at', 'id', 'tbl'];
    public $timestamps = true;
    // Private options
    private $_select = null;
    private $_where = null;
    private $_type = null;
    private $_orderBy = null;

    private function set_defaultOptions() {
        if ($this->_select == null) {
            $this->_select = '*';
        }
        if ($this->_orderBy == null) {
            $this->_orderBy = ['id', 'DESC'];
        }
    }

    public function set_type($p) {
        $this->_type = $p;
        return $this;
    }

    public function set_where($w) {
        $this->_where = $w;
    }

    public function set_orderBy($p, $v) {
        $this->_orderBy = [$p, $v];
        return $this;
    }

    public function pagin($per_page) {
        return $this->exec()->paginate($per_page);
    }

    // Popular functions

    public function getAllList() {
        return $this->exec()->get();
    }

    public function getAllByType($type) {
        return $this->exec($type)->get();
    }

    private function exec() {
        $this->set_defaultOptions();
        $UserVipModels = UserVIPModel::select($this->_select);

        if ($this->_type != null) {
            $UserVipModels = $UserVipModels->where('type', $this->_type);
        }

        $UserVipModels = $UserVipModels->orderBy($this->_orderBy[0], $this->_orderBy[1]);
        return $UserVipModels;
    }

}
