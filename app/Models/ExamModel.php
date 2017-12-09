<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamModel1 extends Model {

    protected $table = 'm1_exam';
    public $timestamps = true;
    protected $guarded = ['id', 'id_user', 'tbl', 'created_at'];
// ===== OPTIONS ===================================================================================================
    private $_select = null;
    private $_orderBy = null;
    private $_keyword = null;
    private $_type = null;
    private $_lang = 1;
    private $_deleted = null;
    private $_perPage = 10;
    private $_where = null;
// ===== RESULT VARIABLES =========================================================================================
    private $_result = null;
    private $_log = null;

// ===== SET METHOD ================================================================================================

    public function set_select($pParamString) {
        $this->_select = $pParamString;
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
    }

    public function set_where($pArray) {
        if (is_array($pArray)) {
            foreach ($pArray as $k => $v) {
                if (count($v) == 3) {
                    $this->_where[] = [$v[0], $v[1], $v[2]];
                }
            }
        }
    }

    public function set_orderBy($pArray) {
        if (is_array($pArray)) {
            $this->_order_by = $pArray;
        }
    }

    public function set_deleted($pParamNumber) {
        if (is_numeric($pParamNumber)) {
            $this->_deleted = $pParamNumber;
        }
    }

    public function set_keyword($pParamString) {
        $this->_keyword = $pParamString;
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
    }

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
            $this->_order_by = ['ordinal_number', 'ASC'];
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
            $tmp_deleted = ['m1_exam.deleted', '=', null];
        }
        // ----- SELECT ------------------------------------------------------------------------------------------------
        if ($this->_select == null) {
            $this->_select = ["m1_exam.id", "m1_exam.ordinal_number", "m1_exam.views", "m1_exam.created_at",
                "m1_exam.name", "m1_exam.tbl", "m1_exam.display", "m1_exam.highlight"];
        }

        $r = ExamModel::
                select(
                        "m1_exam.id", "m1_exam.ordinal_number","name_meta","m1_exam.price", 'm1_exam.id_user', "m1_exam.views",
                        'm1_exam.approved_by','approved_date','state','state_message', "m1_exam.time", "m1_exam.created_at", "m1_exam.name", "m1_exam.tbl", "m1_exam.display", "m1_exam.highlight"
        );

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
            $r->where('m1_exam.name', 'LIKE', "%$pKeyword%");
            $r->whereOr('m1_exam.description', 'LIKE', "%$pKeyword%");
            $r->whereOr('m1_exam.views', 'LIKE', "%$pKeyword%");
        }

        // SET ORDER BY
        $r->orderBy($this->_order_by[0], $this->_order_by[1]);
        if ($this->_perPage == -1) {
            return $r->get();
        } else {
            return $r->paginate($this->_perPage);
        }
    }

// ===== db_getExamById ================================================================================================
// Lấy thông tin bài thi

    public function db_getExamById($pId = null) {
        if ($pId == null) {
// Id invalid
            return -1;
        }
        $Model = ExamModel::find($pId);
        if ($Model == null) {
// Exam not found
            return null;
        } else {
            return $Model;
        }
    }

// ===== RELA MODEL ====================================================================================================

    public function db_rela_detail() {
        try {
            return $this->hasMany('App\Models\ExamDetailModel', 'id_exam', 'id')
                            ->select($this->_select != null ? $this->_select : '*');
        } catch (\Exception $ex) {
            // Write log...
            return -1;
        }
    }

}
