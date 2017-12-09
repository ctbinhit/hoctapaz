<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseModel extends Model {

    protected $table = 'articles';
    protected $guarded = ['created_at', 'id_user', 'tbl'];
    public $timestamps = true;
    // ===== MODEL OPTIONS =============================================================================================
    public $_select = null;
    public $_type = null;
    public $_perPage = 10;
    public $_lang = 1;
    public $_order_by = ['ordinal_number', 'ASC'];
    public $_deleted = 1;
    public $_keyword = null;

    // =================================================================================================================

    public function set_select($pParamString) {
        $this->_select = $pParamString;
    }

    public function set_type($pParamString) {
        $this->_type = $pParamString;
    }

    public function set_lang($pParamString) {
        $this->_lang = $pParamString;
    }

    public function set_orderBy($pParamString) {
        $this->_order_by = $pParamString;
    }

    public function set_deleted($pParamString) {
        $this->_deleted = $pParamString;
    }

    public function set_keyword($pParamString) {
        $this->_keyword = $pParamString;
    }

    public function set_perPage($pParamInt) {
        if (is_numeric($pParamInt)) {
            $this->_perPage = $pParamInt;
        }
        return $this->_perPage;
    }

    // =================================================================================================================

    public function db_get_items($pType = null, $pKeyword = null, $pIdLang = 1, $pSelect = null, $pOrderBy = null) {
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
        // ----- KEYWORDS ----------------------------------------------------------------------------------------------
        if ($pKeyword == null) {
            if ($this->_keyword == null) {
                $this->_keyword = $pKeyword = null;
            } else {
                $pKeyword = $this->_keyword;
            }
        } else {
            $this->_keyword = $pKeyword;
        }
        // ----- LANG --------------------------------------------------------------------------------------------------
        if ($pIdLang == null) {
            if ($this->_lang == null) {
                return;
            } else {
                $pIdLang = $this->_lang;
            }
        } else {
            $this->_lang = $pIdLang;
        }
        // ----- SELECT ------------------------------------------------------------------------------------------------
        if ($pSelect == null) {
            if ($this->_select == null) {
                $pSelect = ['id', 'name', 'id_category', 'professor_name', 'name_meta', 'description',
                    'distributor_price', 'promotion_text', 'content', 'views', 'sell_buy_date', 'type', 'highlight',
                    'display', 'deleted', 'tbl', 'created_at', 'created_by'];
            } else {
                $pSelect = $this->_select;
            }
        } else {
            $this->_select = $pSelect;
        }
        // ----- ORDER BY ----------------------------------------------------------------------------------------------
        if ($pOrderBy == null) {
            if ($this->_order_by == null) {
                $pOrderBy = ['ordinal_number', 'ASC'];
            } else {
                $pOrderBy = $this->_order_by;
            }
        } else {
            $this->_order_by = $pOrderBy;
        }
        // ----- WHERE -------------------------------------------------------------------------------------------------
        $r = ArticleModel::where([
                    ['type', '=', $pType],
                    ['id_lang', '=', $pIdLang]
                ])->select($this->_select);
        // ----- DELETED -----------------------------------------------------------------------------------------------
        if ($this->deleted == 1) {
            $r->where('deleted', '=', null);
        } else if ($this->deleted == -1) {
            $r->where('deleted', '<>', null);
        }
        // ----- SEARCH ------------------------------------------------------------------------------------------------
        if ($pKeyword != null) {
            $r->where('name', 'LIKE', "%$pKeyword%");
            $r->whereOr('description', 'LIKE', "%$pKeyword%");
            $r->whereOr('views', 'LIKE', "%$pKeyword%");
        }
        $r->orderBy($pOrderBy[0], $pOrderBy[1]);
        return $r->paginate($this->_perPage);
    }

}
