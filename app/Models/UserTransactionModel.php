<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserTransactionModel extends Model {

    protected $table = 'users_transactions';
    protected $guarded = ['created_at', 'id_user', 'id_receiver', 'type', 'card_type', 'amount', 'time', 'card_seri', 'card_pin'];
    public $timestamps = true;
    protected $dates = [
        'created_at',
        'updated_at',
        'time'
    ];
    // =================================================================================================================

    public $_type = null;
    public $_timeFrom = null;
    public $_timeTo = null;
    public $_perPage = null;
    public $_keywords = null;
    public $_orderBy = null;
    public $_data = null;
    public $_where = null;

    public function data() {
        return $this->_data;
    }

    public function set_where($pArray) {
        $this->_where = $pArray;
        return $this;
    }

    public function set_orderBy($pArray) {
        $this->_orderBy = $pArray;
        return $this;
    }

    public function set_type($type) {
        $this->_type = $type;
        return $this;
    }

    public function set_keywords($keywords) {
        $this->_keywords = $keywords;
        return $this;
    }

    public function set_perPage($paramInt) {
        if (is_numeric($paramInt)) {
            $this->_perPage = $paramInt;
        }
        return $this;
    }

    public function get_total($field) {
        try {
            return DB::table('users_transactions')->where([
                        ['state', '=', 'success']
                    ])->sum($field);
        } catch (Exception $ex) {
            return false;
        }
    }

    public function get_listCardTypeWithCount() {
        $r = DB::table('users_transactions')->select(DB::raw('card_type,  COUNT(id) as sl'))
                ->where('card_type', '<>', '')
                ->groupBy('card_type')
                ->get();
        return $r;
    }

    public function get_countByCardType($card_type) {
        return DB::table('users_transactions')->where([
                    ['card_type', '=', $card_type]
                ])->count();
    }

    public function get_trans_success_count() {
        return DB::table('users_transactions')->where([
                    ['state', '=', 'success']
                ])->count();
    }

    public function get_trans_error_count() {
        return DB::table('users_transactions')->where([
                    ['state', '=', 'error']
                ])->count();
    }

    public function execute() {

        if ($this->_orderBy == null) {
            $this->_orderBy = ['created_at', 'DESC'];
        }

        $Models = UserTransactionModel::orderBy($this->_orderBy[0], $this->_orderBy[1]);
        $RE_WHERE = [];
        if ($this->_where != null) {
            foreach ($this->_where as $k => $v) {
                if ($v[2] != '' && $v[2] != null) {
                    //  $Models->where($v[0], $v[1], $v[2]);
                    $RE_WHERE[] = [$v[0], $v[1], $v[2]];
                }
            }
        }

        $Models->where($RE_WHERE);

        if ($this->_keywords != null) {
            $Models->where('card_seri', '=', $this->_keywords);

            $Models->orWhere('card_pin', '=', $this->_keywords);
            $Models->where($RE_WHERE);

            $Models->orWhere('amount', '=', $this->_keywords);
            $Models->where($RE_WHERE);
        }



        $data = null;
        if ($this->_perPage != null) {
            $data = $Models->paginate($this->_perPage);
        } else {
            $data = $Models->get();
        }

        $ARRAY_ID = [];

        foreach ($data as $k => $ut) {
            if (!in_array($ut->id_user, $ARRAY_ID) || !in_array($ut->id_receiver, $ARRAY_ID)) {
                $ARRAY_ID[] = $ut->id_user;
            }
        }

        $UserModel = $this->users($ARRAY_ID);

        foreach ($data as $k => $ut) {
            $ut->user = $UserModel->find($ut->id_user);
            if ($ut->id_receiver != null) {
                $ut->receiver = $UserModel->find($ut->id_user);
            }
        }

        $this->_data = $data;
        return $this;
    }

    private function users($pArrayId = null) {
        return UserModel::whereIn('id', $pArrayId)->get();
    }

}
