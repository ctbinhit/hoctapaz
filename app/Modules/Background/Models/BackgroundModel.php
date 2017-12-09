<?php

namespace App\Modules\Background\Models;

use Illuminate\Database\Eloquent\Model;

class BackgroundModel extends Model {

    protected $table = 'background';
    protected $guarded = ['created_at', 'id_user', 'tbl'];
    public $timestamps = true;
    public $_type = null;
    public $_lang = 1;
    public $_deleted = 1;

    public function db_get_background($pType = null) {
        // ----- TYPE --------------------------------------------------------------------------------------------------
        if ($pType == null) {
            if ($this->_type == null) {
                return;
            } else {
                $pType = $this->_type;
            }
        } else {
            $this->_type = $pType;
        }

        $Model = BackgroundModel::where([
                    ['type', '=', $this->_type],
                    ['deleted_at', '=', null]
                ])
                ->orderBy('id', 'DESC')
                ->first();
        return $Model;
    }

    public function db_deleteOldBg() {
        try {
            if ($this->type == null || $this->id == null) {

                return false;
            }
            $WH = [
                ['type', '=', $this->type],
                ['id', '<>', $this->id],
                ['deleted_at', '=', null]
            ];

            $COUNT = BackgroundModel::where($WH)->count();
            if ($COUNT != 0) {
                $BM = BackgroundModel::where($WH)->update(['deleted_at' => \Carbon\Carbon::now()]);
                if (!$BM) {
                    return false;
                }
            }
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }

    // ===== SET METHOD ================================================================================================

    public function set_select($pParamString) {
        $this->_select = $pParamString;
    }

    public function set_type($pParamString) {
        $this->_type = $pParamString;
    }

    public function set_deleted($pParamString) {
        $this->_deleted = $pParamString;
    }

}
