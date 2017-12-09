<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ArticleModel extends Model {

    protected $table = 'articles';
    protected $guarded = ['created_at', 'id_user', 'tbl'];
    public $timestamps = true;
    // ===== MODEL OPTIONS =============================================================================================
    private $_select = [
        'articles.id', 'articles.id_user', 'articles.id_category', 'articles.ordinal_number', 'articles.highlight',
        'articles.display', 'articles.private', 'articles.views', 'articles.tbl', 'articles.type', 'articles.deleted_at',
        'articles.created_at', 'articles.updated_at',
        'articles_lang.name', 'articles_lang.name_meta', 'articles_lang.description', 'articles_lang.description2',
        'articles_lang.content', 'articles_lang.seo_title', 'articles_lang.seo_description', 'articles_lang.seo_keywords',
        'articles_lang.id_lang',
        'languages.name as lang_name'
    ];
    private $_type = null;
    private $_perPage = null;
    private $_lang = 1;
    private $_order_by = ['ordinal_number', 'ASC'];
    private $_deleted = 1;
    private $_keyword = null;
    private $_where = null;
    private $_withPhoto = null;
    private $_highlight = null;
    private $_data = null;
    // ===== LOG
    private $_log = [
        'state' => null,
        'level' => null,
        'message' => null
    ];

    public function execute() {
        $RWHERE = [
            ['articles.type', '=', $this->_type],
            ['articles_lang.id_lang', '=', 1]
        ];

        if ($this->_where != null) {
            foreach ($this->_where as $k => $v) {
                $RWHERE[] = [$v[0], $v[1], $v[2]];
            }
        }

        if ($this->_highlight != null) {
            $RWHERE[] = ['highlight', $this->_highlight];
        }

        if ($this->_deleted == 1) {
            $RWHERE[] = ['deleted_at', '=', null];
        } else if ($this->_deleted == -1) {
            $RWHERE[] = ['deleted_at', '<>', null];
        }
        $Models = DB::table('articles')
                ->join('articles_lang', 'articles.id', '=', 'articles_lang.id_article')
                ->join('languages', 'languages.id', '=', 'articles_lang.id_lang')
                ->select($this->_select);
        $Models->orderBy($this->_order_by[0], $this->_order_by[1]);
        $Models->where($RWHERE);
        if ($this->_keyword != null) {
            $Models->where('articles_lang.name', 'LIKE', "%$this->_keyword%");
        }
        $this->_data = $Models;
        return $this;
    }

    // ===== Relationship ==============================================================================================

    public function db_photo($pType = 'photo') {
        $r = PhotoModel::where([
                    'obj_id' => $this->id,
                    'obj_table' => $this->table,
                    'obj_type' => $pType
                ])->get();
        if (PhotoModel::count() > 0) {
            return $r;
        } else {
            return null;
        }
    }

    public function db_photos($pType = 'photos') {
        $r = PhotoModel::where([
                    'obj_id' => $this->id,
                    'obj_table' => $this->table,
                    'obj_type' => $pType
                ])->get();
        if (PhotoModel::count() > 0) {
            return $r;
        } else {
            return null;
        }
    }

    public function db_rela_articleLang() {
        if ($this->_select != null) {
            // Tự động thêm trường [id_lang] *Bắt buộc để truy vấn đa ngôn ngữ =========================================
            if (!isset($this->_select['id_lang']))
                $this->_select[] = 'id_lang';
            if (!isset($this->_select['id']))
                $this->_select[] = 'id';
            // =========================================================================================================
            return $this->hasMany('App\Models\ArticleLangModel', 'id_article', 'id')
                            ->select($this->_select);
        }
        // Truy vấn mặc định ===========================================================================================
        return $this->hasMany('App\Models\ArticleLangModel', 'id_article', 'id')
                        ->select(['name', 'name_meta', 'id_lang']);
    }

    /* =================================================================================================================
     * GET METHOD
     * =================================================================================================================
     */

    public function data() {
        $data = null;
        if ($this->_perPage == null) {
            $data = $this->_data->get();
        } else {
            $data = $this->_data->paginate((int) $this->_perPage);
        }
        if ($this->_withPhoto != null && is_array($this->_withPhoto)) {
            $data = PhotoModel::findByModels($this->_withPhoto, $data);
        }
        return $data;
    }

    /* =================================================================================================================
     * Support method (With )
     * =================================================================================================================
     */

    public function with_photo($array_type) {
        $this->_withPhoto = $array_type;
        return $this;
    }

    /* =================================================================================================================
     * SET METHOD
     * =================================================================================================================
     */

    public function set_select($pParamString) {
        $this->_select = $pParamString;
        return $this;
    }

    public function set_type($pParamString) {
        $this->_type = $pParamString;
        return $this;
    }

    public function set_lang($pParamString) {
        $this->_lang = $pParamString;
        return $this;
    }

    public function set_orderBy($pArray) {
        if (is_array($pArray)) {
            $this->_order_by = $pArray;
        }
        return $this;
    }

    public function set_perPage($pParamInt) {
        if (is_numeric($pParamInt)) {
            $this->_perPage = $pParamInt;
        }
        return $this;
    }

    public function set_deleted($pParamString) {
        $this->_deleted = $pParamString;
        return $this;
    }

    public function set_keyword($pParamString) {
        $this->_keyword = $pParamString;
        return $this;
    }

    public function set_where($array) {
        $this->_where = $array;
        return $this;
    }

    public function set_highlight($boolean) {
        $this->_highlight = $boolean;
        return $this;
    }

}
