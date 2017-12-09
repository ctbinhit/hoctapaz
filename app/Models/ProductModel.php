<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LanguageModel;
use Illuminate\Support\Facades\DB;

class ProductModel extends Model {

    protected $table = 'products';
    public $timestamps = true;
    protected $guarded = ['id', 'tbl', 'created_at', 'id_user'];
    //
    private $_default_fields = [];
    // 
    private $_keyword = null;
    private $_lang = 1;
    private $_select = null;
    private $_select_rela = null;
    private $_deleted = null;
    private $_perPage = null;
    private $_orderBy = null;
    private $_highlight = null;
    private $_where = null;
    private $_whereIn = null;
    //
    private $_data = null;
    public $dbp_select = null;
    // Mở rộng:
    // Các options khởi tạo
    public $options = null;

    public function data() {
        if ($this->_perPage != null) {
            return $this->_data->paginate($this->_perPage);
        }
        return $this->_data->get();
    }

    /* ========================================= db_get_items ==========================================================
     * Lấy tất cả danh sách sản phẩm cho quản trị
     * 
     * =================================================================================================================
     */

    public function get_items($pType, $pLang = 'vi', $deleted = 1) {
        $r = ArticleModel::where([
                    ['articles.type', '=', $pType],
                    ['articles_lang.id_lang', '=', 1]
                ])
                ->join('articles_lang', 'articles_lang.id_article', 'articles.id')
                ->join('languages', 'languages.id', 'articles_lang.id_lang')
                ->select(
                "articles.id", "articles.ordinal_number", "articles.views", "articles.created_at", "articles_lang.name", "articles.tbl", "articles.display", "articles.highlight"
        );
        // Nếu $deleted=true => hiển thị những item đã xóa tạm
        if (!$deleted)
            $r->where('articles.deleted', '=', null);
        $r->orderBy('ordinal_number', 'ASC');
        return $r->get();
    }

    public function execute() {

        $RWHERE = [
            ['type', $this->_type],
            ['products_lang.id_lang', $this->_lang]
        ];

        if ($this->_highlight != null) {
            $RWHERE[] = ['highlight', '=', $this->_highlight];
        }

        $ProductModels = DB::table('products')
                ->join('products_lang', 'products.id', '=', 'products_lang.id_product')
                ->select('products.id', 'products.id_user', 'products.id_category', 'products.price',
                        'products.promotion_price', 'products.ordinal_number', 'products.highlight', 'products.display', 
                        'products.views', 'products.tbl', 'products.type', 'products.deleted_at', 'products.created_at',
                        'products.updated_at', 'products_lang.name', 'products_lang.description', 'products_lang.content',
                        'products_lang.id_product', 'products_lang.id_lang', 'products_lang.name_meta', 'products_lang.seo_title',
                        'products_lang.seo_description', 'products_lang.seo_keywords', 'products_lang.price as pprice'
        );

        $ProductModels->orderBy('ordinal_number', 'ASC');

        $ProductModels->where($RWHERE);

        if ($this->_keyword != null) {

            $ProductModels->where('products_lang.name', 'LIKE', "%$this->_keyword%");

            $ProductModels->orWhere('products.price', 'LIKE', "%$this->_keyword%");
            $ProductModels->where($RWHERE);
        }
        $this->_data = $ProductModels;

        return $this;
    }

    public function db_get_items($pType, $pSearch = null, $pOrderBy = null, $pLang = 'vi', $deleted = 1) {
        $r = ProductModel::where([
                    ['products.type', '=', $pType],
                    ['products_lang.id_lang', '=', 1],
                ])
                ->leftJoin('products_lang', 'products_lang.id_product', 'products.id')
                ->join('languages', 'languages.id', 'products_lang.id_lang')
                ->leftJoin('photos', function($join) {
                    $join->on('photos.obj_id', '=', 'products.id')
                    ->where([['photos.obj_table', '=', 'products.tbl'], ['photos.obj_type', '=', 'photo'], ['photos.deleted', '=', null]]);
                })
                ->select(
                "products.id", "products.ordinal_number", "products.views", "products.created_at", "products_lang.name", "products.tbl", "products.display", "products.highlight", "products.price", "products.promotion_price", "photos.name as photo", "photos.sync_google"
        );
        // SEARCH
        if ($pSearch != null) {
            $r->where('products_lang.name', 'LIKE', "%$pSearch%");
            $r->whereOr('products_lang.description', 'LIKE', "%$pSearch%");
            $r->whereOr('products.price', 'LIKE', "%$pSearch%");
            $r->whereOr('products.promotion_price', 'LIKE', "%$pSearch%");
            $r->whereOr('products.views', 'LIKE', "%$pSearch%");
        }

        switch ($deleted) {
            case 1:
                $r->where('products.deleted', '=', null);
                break;
            case -1:
                $r->where('products.deleted', '<>', null);
                break;
        }
        if ($pOrderBy == null) {
            $r->orderBy('ordinal_number', 'ASC');
        }

        return $r->paginate(10);
    }

    /* ===================================== db_get_listByIdLang =======================================================
     * Lấy tất cả danh sách sản phẩm theo 1 ngôn dữ duy nhất
     * 
     * =================================================================================================================
     */

    public function db_get_listByIdLang($pIdLang = 1, $pType) {
        // Đang cập nhật...
    }

    public function db_rela_lang() {
        if ($this->dbp_select != null) {
            // Tự động thêm trường [id_lang] *Bắt buộc để truy vấn đa ngôn ngữ =========================================
            if (!isset($this->dbp_select['id_lang']))
                $this->dbp_select[] = 'id_lang';
            if (!isset($this->dbp_select['id']))
                $this->dbp_select[] = 'id';
            // =========================================================================================================
            return $this->hasMany('App\Models\ProductLangModel', 'id_product', 'id')
                            ->select($this->dbp_select);
        }
        // Truy vấn mặc định ===========================================================================================
        return $this->hasMany('App\Models\ProductLangModel', 'id_product', 'id')
                        ->select(['name', 'name_meta', 'id_lang']);
    }

    // ===== SET METHOD ================================================================================================

    public function set_select($pParamString) {
        $this->_select = $pParamString;
        return $this;
    }

    public function set_selectRela($pArray) {
        $this->_select_rela = $pArray;
    }

    public function set_type($pParamString) {
        $this->_type = $pParamString;
        return $this;
    }

    public function set_table($pParamString) {
        $this->_table = $pParamString;
        return $this;
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

    public function set_whereIn($pArray) {
        if (is_array($pArray)) {
            foreach ($pArray as $k => $v) {
                if (count($v) == 2) {
                    $this->_whereIn[] = [$v[0], $v[1]];
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

    public function set_highlight($param) {
        $this->_highlight = $param;
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
