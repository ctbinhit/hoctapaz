<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CategoryModel extends Model {

    protected $table = 'categories';
    public $timestamps = true;
    protected $guarded = ['id', 'id_user', 'obj_table', 'tbl', 'created_at'];
    public $dbp_select = null;
    private $pr_result = null;
    // ===== OPTIONS ===================================================================================================
    private $_select = [
        'categories.id', 'categories.id_category as id_parent', 'categories.obj_id', 'categories.obj_table',
        'categories.views', 'categories.display', 'categories.highlight', 'categories.deleted',
        'categories.ordinal_number', 'categories.id_user', 'categories.note',
        'categories.type', 'categories.type', 'categories.tbl', 'categories.created_at', 'categories.updated_at',
        'categories_lang.id_lang', 'categories_lang.name', 'categories_lang.name_meta',
        'categories_lang.description', 'categories_lang.content', 'categories_lang.seo_title',
        'categories_lang.seo_description', 'categories_lang.seo_keywords'
    ];
    private $_orderBy = ['categories.ordinal_number', 'ASC'];
    private $_keywords = null;
    private $_type = null;
    private $_table = null;
    private $_lang = 1;
    private $_deleted = null;
    private $_perPage = null;
    private $_where = null;
    // ===== RESULT VARIABLES ==========================================================================================
    private $_result = null;
    private $_data = null;

    // ===== STATIC METHOD ================================================================================================

    public static function findByModels($models) {
        foreach ($models as $k => $v) {
            if ($v->id_category != null) {
                $v->data_category = CategoryModel::find($v->id_category);
            } else {
                $v->data_category = null;
            }
        }
        return $models;
    }

    public static function findByModelsWithLang($models) {

        foreach ($models as $k => $v) {
            if ($v->id_category != null) {
                $v->data_category = CategoryModel::findLangById($v->id_category);
            } else {
                $v->data_category = null;
            }
        }
        return $models;
    }

    public static function findLangById($id) {
        try {
            $model = DB::table('categories')
                            ->join('categories_lang', 'categories_lang.id_category', '=', 'categories.id')
                            ->select([
                                'categories.id', 'categories.id_category as id_parent', 'categories.obj_id', 'categories.obj_table',
                                'categories.views', 'categories.display', 'categories.highlight', 'categories.deleted',
                                'categories.ordinal_number', 'categories.id_user', 'categories.note',
                                'categories.type', 'categories.type', 'categories.tbl', 'categories.created_at', 'categories.updated_at',
                                'categories_lang.id_lang', 'categories_lang.name', 'categories_lang.name_meta',
                                'categories_lang.description', 'categories_lang.content', 'categories_lang.seo_title',
                                'categories_lang.seo_description', 'categories_lang.seo_keywords'
                            ])->where('categories.id', '=', $id)->first();
            return $model;
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function load_data() {
        if ($this->_perPage != null) {
            return $this->_data->paginate($this->_perPage);
        } else {
            return $this->_data->get();
        }
    }

    public function data() {
        if ($this->_perPage != null) {
            return $this->_data->paginate($this->_perPage);
        } else {
            return $this->_data->get();
        }
    }

    public function execute() {

        $RWHERE = [
            ['categories_lang.id_lang', '=', 1],
            ['categories.type', '=', $this->_type],
            ['categories.obj_table', '=', $this->_table]
        ];

        $models = DB::table('categories')
                ->join('categories_lang', 'categories_lang.id_category', '=', 'categories.id')
                ->select([
            'categories.id', 'categories.id_category as id_parent', 'categories.obj_id', 'categories.obj_table',
            'categories.views', 'categories.display', 'categories.highlight', 'categories.deleted',
            'categories.ordinal_number', 'categories.id_user', 'categories.note',
            'categories.type', 'categories.type', 'categories.tbl', 'categories.created_at', 'categories.updated_at',
            'categories_lang.id_lang', 'categories_lang.name', 'categories_lang.name_meta',
            'categories_lang.description', 'categories_lang.content', 'categories_lang.seo_title',
            'categories_lang.seo_description', 'categories_lang.seo_keywords'
        ]);

        $models->where($RWHERE);

        $models->orderBy($this->_orderBy[0], $this->_orderBy[1]);

        if ($this->_keywords != null) {
            $models->where('categories_lang.name', 'LIKE', "%$this->_keywords%");
        }
        $this->_data = $models;

        return $this;
    }

    // ===== SET METHOD ================================================================================================

    public function set_select($pParamString) {
        $this->_select = $pParamString;
        return $this;
    }

    public function set_type($pParamString) {
        $this->_type = $pParamString;
        return $this;
    }

    public function set_lang($pParamNumber) {
        if (is_numeric($pParamNumber)) {
            $this->_lang = $pParamNumber;
        } else {
            return 1;
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

    public function set_table($table) {
        $this->_table = $table;
        return $this;
    }

// ===== SUPPORT METHOD ================================================================================================


    public function db_getListCateGroupById($pArray) {
        $res = [];
        if ($pArray != null && is_object($this->pr_result)) {
            foreach ($pArray as $k => $v) {
                $res[$v->id] = $v;
            }
        } else {
            return null;
        }
        return $res;
    }

    /* ===== db_get_items ==============================================================================================
      | @Param $pType
      | @Param $pKeyword
      | @Param $pOrderBy
      | @Param $pIdLang
      | [x] @Param $pSelect ( Removed from v1.1_update by Bình Cao)
      | @Param $deleted
      | ================================================================================================================
     */

    public function db_get_items($pType, $pKeyword = null, $pIdLang = null) {
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
        // ----- DELETED -----------------------------------------------------------------------------------------------
        $tmp_deleted = null;
        if (is_numeric((int) $this->_deleted)) {
            switch ((int) $this->_deleted) {
                case 1:
                    $tmp_deleted = ['categories.deleted', '=', ''];
                    break;
                case -1:
                    $tmp_deleted = ['categories.deleted', '<>', ''];
                    break;
                default:
                    $tmp_deleted = null; // Hiển thị cả 2 dạng (Đã xóa, chưa xóa )
                    break;
            }
        } else {
            DV_deletedArea:
            // Mặc định chỉ cho hiển thị sản phẩm chưa xóa
            $tmp_deleted = ['categories.deleted', '=', null];
        }
        // ----- SELECT ------------------------------------------------------------------------------------------------
        if ($this->_select == null) {
            $this->_select = ["articles.id", "articles.ordinal_number", "articles.views", "articles.created_at", "articles_lang.name", "articles.tbl", "articles.display", "articles.highlight"];
        }

        $r = CategoryModel::where([
                    ['categories.type', '=', $pType],
                    ['categories_lang.id_lang', '=', 1],
                ])
                ->leftJoin('categories_lang', 'categories_lang.id_category', 'categories.id')
                ->join('languages', 'languages.id', 'categories_lang.id_lang')
                ->select(
                "categories.id", "categories.ordinal_number", "categories.views", "categories.created_at", "categories_lang.name", "categories.tbl", "categories.display", "categories.highlight"
        );
        // SET DELETED
        if ($tmp_deleted != null && isset($tmp_deleted[0]) && isset($tmp_deleted[1]) && isset($tmp_deleted[2])) {
            $r->where($tmp_deleted[0], $tmp_deleted[1], $tmp_deleted[2] == '' ? null : $tmp_deleted[2]);
        }

        // Add where
        if ($this->_where != null && is_array($this->_where)) {
            foreach ($this->_where as $k => $v) {
                $r->where($v[0], $v[1], $v[2]);
            }
        }

        // SET SEARCH
        if ($pKeyword != null) {
            $r->where('categories_lang.name', 'LIKE', "%$pKeyword%");
            $r->whereOr('categories_lang.description', 'LIKE', "%$pKeyword%");
            $r->whereOr('categories.views', 'LIKE', "%$pKeyword%");
        }

        // SET ORDER BY
        $r->orderBy($this->_order_by[0], $this->_order_by[1]);
        if ($this->_perPage == -1) {
            return $r->get();
        } else {
            return $r->paginate($this->_perPage);
        }
    }

    public function db_getParentIdByIdCate($pId) {
        $Model = CategoryModel::find($pId);
        if ($Model != null) {
            return $Model->id_category;
        } else {
            return null;
        }
    }

    public function db_getItems($pTable, $pType, $deleted = false, $pLang = 1) {
        // -------------------------------------------------------------------------------------------------------------
        $r = CategoryModel::where([
                    ['categories.type', '=', $pType],
                    ['id_lang', '=', $pLang],
                    ['obj_table', '=', $pTable]
                ])
                ->join('categories_lang', 'categories_lang.id_category', 'categories.id')
                ->join('languages', 'languages.id', 'categories_lang.id_lang')
                ->select(
                "categories.id", "categories.ordinal_number", "categories.views", "categories.created_at", "categories_lang.name", "categories.tbl", "categories.display", "categories.highlight"
        );
        // Nếu $deleted=true => hiển thị những item đã xóa tạm =========================================================
        if (!$deleted)
            $r->where('deleted', '=', null);
        $this->pr_result = $r->get();
        return $this->pr_result;
    }

    // =================================================================================================================
    // @Param $pTable
    // @Param $pType
    // @Param $pLevel

    public function get_CategoriesByCateLevel($pLevel = 0, $pTable = null, $pType = null, $pId = null, $pRequestLevel = null) {
        $TMP_LV = 0;
        // Get list categories from database
        $TMP_CATE = $this->db_getListArray($pTable, $pType, null);
        if (count($TMP_CATE) == 0) {
            return;
        }
        // Đệ quy ----->
        if ($pId != null && $pRequestLevel != null) {
            $TMP_LV = $pRequestLevel;
        }
        // -------------------------------------------------------------------------------------------------------------
        $TMP_VAR = $TMP_CATE;
        LoopArea:
        $RES = [];

        if ($TMP_LV == $pLevel) {
            if ($TMP_LV == 0) {
                foreach ($TMP_CATE as $v) {
                    $RES[] = $v;
                }
            } else {
                return CategoryModel::find($pId);
            }
            return $RES;
        } else {
            $TMP_LV++;
            if ($TMP_LV == 0) {
                foreach ($TMP_CATE as $k => $v) {
                    if ($v['categories'] == null) {
                        
                    } else {
                        foreach ($v['categories'] as $k1 => $v1) {
                            $RES[] = $this->get_CategoriesByCateLevel($pLevel, $pTable, $pType, $k1, $TMP_LV);
                        }
                    }
                }
            } else {
                $RES[] = $this->get_CategoriesByCateLevel($pLevel, $pTable, $pType, $pId, $TMP_LV);
            }

            dd($RES);
            return $RES;
        }
    }

    /* ================================== get_categoriesLevel ==========================================================
      | @Param table name
      | @Param type
      | @Param db_getListArray
      | Return level of the tree (INT)
      | ----------------------------------------------------------------------------------------------------------------
      | Ex: $tmp = $this->db_getListArray($pTable, $pType, $pIdCate);
      | $tmp = get_categoriesLevel($pTable, $pType, $tmp)
      | Result: 4
      | ================================================================================================================
     */

    public function get_categoriesLevel($pTable, $pType, $pData) {
        $LV = 0;
        if (count($pData) != 0) {
            $LV++;
            foreach ($pData as $v) {
                $LV += $this->get_categoriesLevel($pTable, $pType, $v['categories']);
            }
        } else {
            return null;
        }
        return $LV;
    }

    public function db_getListCateByCateLevel($pLevel, $pTable, $pType, $pCurrentLv = null, $pArray = null) {
        $res = [];
        if ($pCurrentLv == null) {
            $this_lv = 0;
            $pArray = $this->db_getListArray(null, $pTable, $pType);
        } else {
            $this_lv = $pCurrentLv;
        }

// Nếu level = 0 => lấy danh sách mảng cấp 1
        if ($pLevel == $this_lv) {

            if ($pLevel == null || $pLevel == 0) {
                foreach ($pArray as $k => $v) {
                    $res[] = $k;
                }
                return $res;
            } else {
                foreach ($pArray as $k => $v) {
                    $res[] = $k;
                }
                return $res;
            }
        } else {
// Nếu chưa đủ cấp => lv ++
            $this_lv += 1;
            if ($pArray != null) {
                foreach ($pArray as $k => $v) {
                    if ($v != null)
                        $res[] = $this->db_getListCateByCateLevel($pLevel, $pTable, $pType, $this_lv, $v);
                    else
                        return;
                }
            }
        }
        if ($pCurrentLv != null) {
            return;
        }
        resultArea:
        $r2 = null;
        foreach ($res as $k => $v) {
            foreach ($v as $k1 => $v1) {
                $r2[] = $v1;
            }
        }
        return $r2;
    }

    private function db_getCateDetail($pId) {
        $tmp_cate = CategoryModel::find($pId);
        return $tmp_cate->id;
    }

    public function db_getListCateByType($pTable, $pType, $pIdCate = null, $pView = 'tree') {
        switch ($pView) {
            case 'tree':
                $res = null;
                $TMP_CATE = $this->db_getListCateByIdCategory($pIdCate, $pTable, $pType);
                if (count($TMP_CATE) != 0) {
                    foreach ($TMP_CATE as $v) {
                        $res[$v->id] = $this->db_getListCateByType($pTable, $pType, $v->id);
                    }
                }
                break;
        }
        return $res;
    }

    /* =================================================================================================================
     * Lấy danh sách tất cả danh mục của 1 danh mục cha
     * Nếu tham số $pId = null => nó không có danh mục cha => danh mục cấp 0
     * Nếu tham số $pId = 14,56... => kết quả trả về tất cả danh mục có field id_category = 14,56... 
     * =================================================================================================================
     */

    private function db_getListCateByIdCategory($pId, $pTable, $pType, $pOrderby = ['ordinal_number', 'asc']) {
        $tmp_cate = CategoryModel::where([
                    ['obj_table', '=', $pTable],
                    ['type', '=', $pType],
                    ['id_category', '=', $pId]
                ])->orderBy($pOrderby[0], $pOrderby[1])->get();
        if (count($tmp_cate) != 0) {
            return $tmp_cate;
        } else {
            return null;
        }
    }

    public function db_updateCatePosition($pListCateId, $pParentId = null) {
        $res = [];
        if ($pListCateId == null) {
            return null;
        }
        foreach ($pListCateId as $k => $v) {
            $tmp = CategoryModel::find($v['id']);
            $tmp->id_category = $pParentId;
            $tmp->ordinal_number = $k;
            $res[$v['id']] = $tmp->save();
            if (isset($v['children'])) {
                $this->db_updateCatePosition($v['children'], $v['id']);
            }
        }
        if ($pParentId == null) {
            return $res;
        }
    }

    public function db_rela_Lang() {
        if ($this->dbp_select != null) {
// Tự động thêm trường [id_lang] *Bắt buộc để truy vấn đa ngôn ngữ =========================================
            if (!isset($this->dbp_select['id_lang']))
                $this->dbp_select[] = 'id_lang';
            if (!isset($this->dbp_select['id']))
                $this->dbp_select[] = 'id';
// =========================================================================================================
            return $this->hasMany('App\Models\CategoryLangModel', 'id_category', 'id')
                            ->select($this->dbp_select);
        }
// Truy vấn mặc định ===========================================================================================
        return $this->hasMany('App\Models\CategoryLangModel', 'id_category', 'id')
                        ->select(['name', 'name_meta', 'id_lang']);
    }

//    public function db_rela_articles() {
//        return $this->hasMany('App\Models\CategoryLangModel', 'id_category', 'id')->where('obj_table', '=', 'articles');
//    }
}
