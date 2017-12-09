<?php

// Created at 2017-09-24 - 1.3

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleOModel extends Model {

    protected $table = 'article';
    protected $guarded = ['created_at', 'id_lang', 'id_user', 'tbl'];
    public $timestamps = true;
    public $_type = null;
    public $_lang = null;
    private $_where = null;

    public function set_where($pArray) {
        if (is_array($pArray)) {
            foreach ($pArray as $k => $v) {
                if (count($v) == 3) {
                    $this->_where[] = [$v[0], $v[1], $v[2]];
                }
            }
        }
    }

    public function set_type($pParamString) {
        $this->_type = $pParamString;
        return $this;
    }

    public function set_lang($pParamString) {
        $this->_lang = $pParamString;
        return $this;
    }

    public function db_get_item($pType = null) {
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

        $Model = ArticleOModel::where([
                    ['type', '=', $this->_type]
        ]);
        return $Model->first();
    }

}
