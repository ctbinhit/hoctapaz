<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FileModel extends Model {

    protected $table = 'files';
    public $timestamps = true;
    protected $guarded = ['id', 'id_user', 'obj_id', 'obj_table', 'obj_type', 'url_encode', 'tbl', 'created_at'];
    // ===== OPTIONS ===================================================================================================
    private $_select = null;
    private $_orderBy = null;
    private $_keyword = null;
    private $_type = null;
    private $_lang = 1;
    private $_deleted = null;
    private $_perPage = null;
    private $_where = null;
    // ===== RESULT VARIABLES =========================================================================================
    private $_result = null;
    private $_log = null;

    // =================================================================================================================

    public function db_get_items($pKeyword = null) {
        // ----- Keywords ----------------------------------------------------------------------------------------------
        if ($pKeyword == null) {
            if ($this->_keyword == null) {
                $this->_keyword = $pKeyword = null;
            } else {
                $pKeyword = $this->_keyword;
            }
        } else {
            $this->_keyword = $pKeyword;
        }
        // ----- Order by ----------------------------------------------------------------------------------------------
        if (!isset($this->_order_by[0]) && !isset($this->_order_by[1])) {
            $this->_order_by = ['id', 'DESC'];
        }
        // ----- DELETED -----------------------------------------------------------------------------------------------
        $tmp_deleted = null;
        if (is_numeric((int) $this->_deleted)) {
            switch ((int) $this->_deleted) {
                case 1:
                    $tmp_deleted = ['deleted', '=', ''];
                    break;
                case -1:
                    $tmp_deleted = ['deleted', '<>', ''];
                    break;
                default:
                    $tmp_deleted = null; // Hiển thị cả 2 dạng (Đã xóa, chưa xóa )
                    break;
            }
        } else {
            DV_deletedArea:
            // Mặc định chỉ cho hiển thị sản phẩm chưa xóa
            $tmp_deleted = ['deleted', '=', null];
        }
        // ----- SELECT ------------------------------------------------------------------------------------------------
        if ($this->_select == null) {
            $this->_select = "*";
        }

        $r = ExamModel::select($this->_select);

        // ----- SET DELETED -------------------------------------------------------------------------------------------
        if ($tmp_deleted != null && isset($tmp_deleted[0]) && isset($tmp_deleted[1]) && isset($tmp_deleted[2])) {
            $r->where($tmp_deleted[0], $tmp_deleted[1], $tmp_deleted[2] == '' ? null : $tmp_deleted[2]);
        }
        // Add where
        if ($this->_where != null && is_array($this->_where)) {
            foreach ($this->_where as $k => $v) {
                $r->where($v[0], $v[1], $v[2]);
            }
        }

        // ----- SET SEARCH --------------------------------------------------------------------------------------------
        if ($pKeyword != null) {
            $r->where('name', 'LIKE', "%$pKeyword%");
            $r->whereOr('description', 'LIKE', "%$pKeyword%");
            $r->whereOr('views', 'LIKE', "%$pKeyword%");
        }

        // SET ORDER BY
        $r->orderBy($this->_order_by[0], $this->_order_by[1]);
        if ($this->_perPage == null) {
            return $r->get();
        } else {
            return $r->paginate($this->_perPage);
        }
    }

    public function get_file($pObjId, $pTable = null, $pType = null) {
        $Model = FileModel::where([
                    ['obj_id', '=', $pObjId],
                    ['obj_table', '=', $pTable],
                    ['obj_type', '=', $pType],
                    ['deleted', '=', null]
        ]);
        $Model->orderBy('id', 'DESC');
        return $Model->first();
    }

    public function db_deletedDoc($pObjId, $pExceptId, $pTable = null, $pType = null) {
        $Model = FileModel::where('obj_id', '=', $pObjId);
        $Model->where('id', '<>', $pExceptId);
        if ($pTable != null) {
            $Model->where('obj_table', '=', $pTable);
        }
        if ($pType != null) {
            $Model->where('obj_type', '=', $pType);
        }
        return $Model->update(['deleted' => Carbon::now()]);
    }

    // ===== SET METHOD ================================================================================================

    public function set_select($pParamString) {
        $this->_select = $pParamString;
        return $this;
    }

    public function set_type($pParamString) {
        $this->_type = $pParamString;
    }

    public function set_lang($pParamNumber) {
        if (is_numeric($pParamNumber)) {
            $this->_lang = $pParamNumber;
        } else {
            // Get lang default
        }
        return $this;
    }

    public function set_where($pArray) {
        if (is_array($pArray)) {
            foreach ($pArray as $k => $v) {
                if (count($v) == 3) {
                    $this->_where[] = [$v[0], $v[1], $v[2]];
                }
            }
        }
        return $this;
    }

    public function set_orderBy($pArray) {
        if (is_array($pArray)) {
            $this->_order_by = $pArray;
        }
        return $this;
    }

    public function set_deleted($pParamNumber) {
        if (is_numeric($pParamNumber)) {
            $this->_deleted = $pParamNumber;
        }
        return $this;
    }

    public function set_keyword($pParamString) {
        $this->_keyword = $pParamString;
        return $this;
    }

    public function set_perPage($pParamNumber) {
        if (is_numeric($pParamNumber)) {
            if ($this->_perPage == -1) {
                
            } else {
                $this->_perPage = $pParamNumber;
            }
        } else {
            $this->_perPage = 10;
        }
        return $this;
    }

}
