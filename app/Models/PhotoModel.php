<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class PhotoModel extends Model {

    protected $table = 'photos';
    public $timestamps = true;
    protected $guarded = ['id', 'tbl', 'created_at', 'id_user'];
    public $default_fields = ['id', 'obj_id', 'name', 'description', 'content', 'dir_name', 'url', 'url_encode',
        'sync_google', 'thumb', 'highlight', 'display', 'deleted', 'note', 'ordinal_number', 'obj_type'];
    private $_keyword = null;
    private $_lang = 1;
    private $_select = null;
    private $_deleted = null;
    private $_perPage = null;
    private $_orderBy = null;
    private $_where = null;
    private $_whereIn = null;
    // ===== SET =======================================================================================================
    private $_type = 'photo';
    private $_table = null;
    private $_obj_id = null;
    // ===== RESULT VARIABLES ==========================================================================================
    private $_result = null;
    private $_data = null;

    public function data() {
        return $this->_data->get();
    }

    // ===== STATIC FUNCTIONS ==========================================================================================

    public static function findByModel($array_type, $model) {
        $tmp_model = $model;
        try {
            foreach ($array_type as $k => $type) {
                $data = PhotoModel::where([
                            ['obj_id', '=', $model->id],
                            ['obj_type', '=', $type],
                            ['obj_table', '=', $model->tbl]
                        ])
                        ->orderBy('id', 'DESC');
                if ($type == 'photo') {
                    $data1 = $data->first();
                    $model->{'data_' . $type} = PhotoModel::encode_urlModel($data1);
                } else {
                    $data1 = $data->get();
                    $model->{'data_' . $type} = PhotoModel::encode_urlModels($data1);
                }
            }
            return $model;
        } catch (\Exception $ex) {
            foreach ($array_type as $k => $type) {
                $tmp_model->{'data_' . $type} = null;
            }
            return $tmp_model;
        }
    }

    public static function findByModels($array_type, $models) {
        $tmp_model = $models;
        try {
            foreach ($array_type as $k => $type) {
                foreach ($models as $k1 => $model) {
                    $data = PhotoModel::where([
                                ['obj_id', '=', $model->id],
                                ['obj_type', '=', $type],
                                ['obj_table', '=', $model->tbl]
                            ])
                            ->orderBy('id', 'DESC');
                    if ($type == 'photo') {
                        $data1 = $data->first();
                        if ($data1 != null) {
                            $model->{'data_' . $type} = PhotoModel::encode_urlModel($data1);
                        } else {
                            $model->{'data_' . $type} = (object) [
                                        'url_encode' => 'default/no-image.png',
                                        'url' => 'default/no-image.png'
                            ];
                        }
                    } else {
                        $data1 = $data->get();
                        if (count($data1) != 0) {
                            $model->{'data_' . $type} = PhotoModel::encode_urlModels($data1);
                        } else {
                            $model->{'data_' . $type} = (object) [
                                        'url_encode' => 'default/no-image.png',
                                        'url' => 'default/no-image.png'
                            ];
                        }
                    }
                }
            }
            return $models;
        } catch (\Exception $ex) {
            // Có lỗi xảy ra tự động trả về kết quả cũ
            return $ex->getMessage();
        }
    }

    public static function encode_urlModels($models) {
        try {
            foreach ($models as $k => $v) {
                $v->url_encode = $v->url_encode; // Crypt::encryptString($v->url);
            }
            return $models;
        } catch (\Exception $ex) {
            return null;
        }
    }

    public static function encode_urlModel($model) {
        try {
            $model->url_encode = $model->url_encode; // Crypt::encryptString($model->url);
            return $model;
        } catch (\Exception $ex) {
            return null;
        }
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

    public function GroupByType($pArray) {
        $res = [];
        if (is_object($pArray)) {
            foreach ($pArray as $k => $v) {
                $res[$v->obj_type][] = $v;
            }
            return $res;
        } else {
            return null;
        }
    }

    public function set_objId($id) {
        $this->_obj_id = $id;
        return $this;
    }

    public function get_listItemsByType($pTable = null, $pType = null, $pOrderBy = null, $pDeleted = null, $pPerPage = null) {
        // Nếu tham số [$pObjectData] không là object => lỗi truyền tham số => return null & write log
        if (!is_object($pObjectData)) {
            if (is_array($pObjectData)) {
                $pObjectData = (object) $pObjectData;
                goto step_2;
            }
            return null;
        }
        step_2:
        // ----- TABLE -------------------------------------------------------------------------------------------------
        if ($pTable == null) {
            if ($this->tbl == null) {
                return;
            } else {
                $pTable = $this->tbl;
            }
        } else {
            $this->tbl = $pTable;
        }
        // ----- TYPE --------------------------------------------------------------------------------------------------
        if ($pType == null) {
            if ($this->type == null) {
                return;
            } else {
                $pType = $this->type;
            }
        } else {
            $this->type = $pType;
        }
        // ----- Deleted -----------------------------------------------------------------------------------------------
        if ($pDeleted == null) {
            if ($this->deleted == null) {
                $this->deleted = $pDeleted = 1;
            } else {
                $pDeleted = $this->deleted;
            }
        } else {
            $this->deleted = $pDeleted;
        }
        // ----- ORDER BY ----------------------------------------------------------------------------------------------
        if ($pOrderBy == null) {
            if ($this->order_by == null) {
                $this->order_by = $pOrderBy = 1;
            } else {
                $pOrderBy = $this->order_by;
            }
        } else {
            $this->order_by = $pOrderBy;
        }
        // ----- PER PAGE ----------------------------------------------------------------------------------------------
        if ($pPerPage == null) {
            if ($this->per_page == null) {
                $this->per_page = $pPerPage = 10;
            } else {
                $pPerPage = $this->per_page;
            }
        } else {
            $this->per_page = $pPerPage;
        }
        // ---- MODEL ACCESS --------------------------------------------|
        $MODEL = PhotoModel::where([
                    ['obj_type', '=', $this->type],
                    ['obj_table', '=', $this->tbl]
        ]);
        // ----- DELETE ---------------------------------------------------|
        switch ($pDeleted) {
            case 1:
                $MODEL->where('deleted', '=', null);
                break;
            case -1:
                $MODEL->where('deleted', '<>', null);
                break;
        }
        // ----- DISPLAY ----------------------------------------------------|
        $MODEL->where('display', '=', $this->display);
        // ----- ORRDER BY --------------------------------------------------|
        $MODEL->orderBy([$this->order_by[0], $this->order_by[1]]);

        return $MODEL->paginate($this->per_page);
    }

    // Data Object Example =============================================================================================
    /*
      type => 'photo',
      table => 'articles',
      id=> 11,
      select => ['name','url'...],
      orderBy => ['id','DESC']
     */
    // =================================================================================================================
    // Get all data by id object
    public function db_getAllDataByIdObject($pObjectData) {
        // Nếu tham số [$pObjectData] không là object => lỗi truyền tham số => return null & write log
        if (!is_object($pObjectData)) {
            if (is_array($pObjectData)) {
                $pObjectData = (object) $pObjectData;
                goto step_2;
            }
            return null;
        }
        step_2:
        // Bẫy lỗi rỗng [id] hoặc [table] => write log
        if (!isset($pObjectData->id) || !isset($pObjectData->table)) {
            return null;
        }
        // Nếu id không là số || <= 0
        // => write log
        if (!is_numeric((int) $pObjectData->id) || ((int) $pObjectData->id) <= 0) {
            return null;
        }
        // Check lỗi nếu bảng không tồn tại => write log
        if (!Schema::hasTable($pObjectData->table)) {
            return null;
        }
        $res = PhotoModel::where([
                    ['obj_id', '=', $pObjectData->id],
                    ['obj_table', '=', $pObjectData->table]
        ]);
        // Mặc định không set cho tham số [isDeleted] => chỉ hiển thị những hình ảnh chưa xóa
        if (is_numeric(@$pObjectData->isDeleted)) {
            switch ($pObjectData->isDeleted) {
                case 1:
                    $res->where([['deleted', '=', null]]);
                    break;
                case -1:
                    $res->where([['deleted', '<>', null]]);
                    break;
            }
        }
        // Mặc định nếu không set giá trị display => chỉ hiển thị hình ảnh có display=true
        // display=1 => chỉ hiển thị hình ảnh có value = true
        // display=0 => hiển thị tất cả hình ảnh
        // display=-1 => chỉ hiển thị những hình ảnh bị ẩn
        if (isset($pObjectData->display)) {
            switch ($pObjectData->display) {
                case 1:$res->where([['display', '=', true]]);
                    break;
                case 0: break;
                case -1:$res->where([['display', '=', false]]);
                    break;
            }
        } else {
            $res->where([['display', '=', 1]]);
        }
        $res->orderBy('id', 'desc');
        return $res->select($this->default_fields)->get();
    }

    public function db_getListPhotoByObjType($pObjectData) {
        // Nếu tham số [$pObjectData] không là object => lỗi truyền tham số => return null & write log
        if (!is_object($pObjectData)) {
            return null;
        }
        // Bẫy lỗi rỗng [id] hoặc [table] => write log
        if (!isset($pObjectData->type) || !isset($pObjectData->table)) {
            return null;
        }
        // Check lỗi nếu bảng không tồn tại => write log
        if (!Schema::hasTable($pObjectData->table)) {
            return null;
        }
        if ($pObjectData->type == null || $pObjectData->type == '') {
            return null;
        }
        if (!isset($pObjectData->isDeleted)) {
            $pObjectData->isDeleted = 1;
        }

        $res = PhotoModel::where([
                    ['obj_type', '=', $pObjectData->type],
                    ['obj_table', '=', $pObjectData->table]
        ]);
        // Mặc định không set cho tham số [isDeleted] => chỉ hiển thị những hình ảnh chưa xóa
        if (is_numeric($pObjectData->isDeleted)) {
            switch ($pObjectData->isDeleted) {
                case 1:
                    $res->where('deleted', '=', null);
                    break;
                case -1:
                    $res->where('deleted', '<>', null);
                    break;
            }
        }
        if (isset($pObjectData->display)) {
            switch ($pObjectData->display) {
                case 1:$res->where([['display', '=', true]]);
                    break;
                case 0: break;
                case -1:$res->where([['display', '=', false]]);
                    break;
            }
        } else {
            $res->where([['display', '=', 1]]);
        }
        return $res->select($this->default_fields)->get();
    }

    public function db_get_photoOrderByType() {
        
    }

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

        $r = PhotoModel::select("*");

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

        // Add where
        if ($this->_whereIn != null && is_array($this->_whereIn)) {
            foreach ($this->_whereIn as $k => $v) {
                $r->whereIn($v[0], $v[1]);
            }
        }

        if ($this->_type != null) {
            $r->where('obj_type', '=', $this->_type);
        }

        if ($this->_table != null) {
            $r->where('obj_table', '=', $this->_table);
        }

        // ----- SET SEARCH --------------------------------------------------------------------------------------------
        if ($pKeyword != null) {
            $r->where('name', 'LIKE', "%$pKeyword%");
            $r->whereOr('url', 'LIKE', "%$pKeyword%");
            $r->whereOr('description', 'LIKE', "%$pKeyword%");
        }

        // SET ORDER BY
        $r->orderBy($this->_order_by[0], $this->_order_by[1]);
        if ($this->_perPage == null) {
            return $r->get();
        } else {
            return $r->paginate($this->_perPage);
        }
    }

    public function db_getPhoto($pTable, $pType = null) {
        $this->_table = $pTable;
        if ($pType == null) {
            $pType = $this->_type;
        }
        $this->set_type($this->_type)
                ->set_table($pTable);
        $r = $this->db_get_items();
        $this->_result = $r;
        return $r;
    }

    // Get all items by type
    public function db_getItems($pObjectData) {
        // Nếu tham số [$pObjectData] không là object => lỗi truyền tham số => return null & write log
        if (!is_object($pObjectData)) {
            return null;
        }

        $r = null;
        $r = PhotoModel::
                // ===== Điều kiện mặc định & bắt buộc =====
                where([
                    ['obj_type', '=', $pObjectData->type],
                    ['obj_id', '=', $pObjectData->id],
                    ['obj_table', '=', $pObjectData->table]
        ]);
        // Nếu có tham số [select] => thay đổi truy vấn select
        if (isset($pObjectData->select))
            $r->select($pObjectData->select);
        else
            $r->select($this->default_fields);
        // Mặc định không set cho tham số [isDeleted] => chỉ hiển thị những hình ảnh chưa xóa
        if (isset($pObjectData->isDeleted)) {
            if ($pObjectData->isDeleted == false)
                $r->where([['deleted', '=', null]]);
        }else {
            $r->where([['deleted', '=', null]]);
        }

        if (isset($pObjectData->orderBy)) {
            switch ($pObjectData->orderBy) {
                case 'random': // Sắp xếp ngẫu nhiên ===================================================================
                    $r->inRandomOrder();
                    break;
                case 'asc': // Sắp xếp theo chiều tăng dần =============================================================
                    $r->orderBy('id', 'ASC');
                    break;
                default:
                    $r->orderBy('id', 'DESC');
            }
        } else {
            // Mặc định sắp xếp theo thứ tự id giảm dần ================================================================
            $r->orderBy('id', 'DESC');
        }
        return $r->get();
    }

    public function db_getItem($pObjectData) {
        // Nếu tham số [$pObjectData] không là object => lỗi truyền tham số => return null & write log =================
        if (!is_object($pObjectData)) {
            return null;
        }

        $r = null;
        $r = PhotoModel::
                // ===== Điều kiện mặc định & bắt buộc =====
                where([
                    ['obj_type', '=', $pObjectData->type],
                    ['obj_id', '=', $pObjectData->id],
                    ['obj_table', '=', $pObjectData->table]
        ]);
        // Mặc định lấy id mới nhất (Không cần biết giá trị những thằng con đã xóa hay chưa) ===========================
        $r->orderBy('id', 'DESC');

        return $r->first();
    }

    public function db_deleteItem($pIdItem) {
        $r = PhotoModel::find($pIdItem);
        if ($r !== null) {
            $r->deleted = \Carbon\Carbon::now();
            return $r->save();
        } else
            return false;
    }

    public function db_groupPhoto($pArray, $IdLimit = null) {
        if (!is_object($pArray)) {
            return -1;
        }
        if (count($pArray) <= 0) {
            return -1;
        }
        $r = [];
        foreach ($pArray as $k => $v) {
            if (!isset($r[$v->obj_id])) {
                $r[$v->obj_id] = $v;
            }
        }
        if ($IdLimit != null) {
            if (count($IdLimit) != 0) {
                foreach ($IdLimit as $k => $v) {
                    if (!isset($r[$v])) {
                        $r[$v] = null;
                    }
                }
            }
        }
        return $r;
    }

    public function db_groupIdPhoto($pArray, $IdLimit = null) {
        if (!is_object($pArray)) {
            return -1;
        }
        if (count($pArray) <= 0) {
            return -1;
        }
        $r = [];
        foreach ($pArray as $k => $v) {
            if (!isset($r[$v->obj_id])) {
                $r[$v->obj_id] = $v;
            }
        }
        if ($IdLimit != null) {
            if (count($IdLimit) != 0) {
                foreach ($IdLimit as $k => $v) {
                    if (!isset($r[$v])) {
                        $r[$v] = null;
                    }
                }
            }
        }
        return $r;
    }

    public function db_deletedPhoto($pObjId, $pExceptId, $pTable = null, $pType = null) {
        $Model = PhotoModel::where('obj_id', '=', $pObjId);
        $Model->where('id', '<>', $pExceptId);
        if ($pTable != null) {
            $Model->where('obj_table', '=', $pTable);
        }
        if ($pType != null) {
            $Model->where('obj_type', '=', $pType);
        }
        return $Model->update(['deleted' => Carbon::now()]);
    }

    // Lấy hình photo của 1 object - return 1 row duy nhất
    public function get_photo($pObjId, $pTable = null, $pType = null) {
        $Model = PhotoModel::where([
                    ['obj_id', '=', $pObjId],
                    ['obj_table', '=', $pTable],
                    ['obj_type', '=', $pType],
                    ['deleted', '=', null]
        ]);
        $Model->orderBy('id', 'DESC');
        return $Model->first();
    }

    public function execute() {

        $Models = PhotoModel::
                where([
                    ['obj_type', '=', $this->_type],
                    ['obj_table', '=', $this->_table],
                    ['obj_id', '=', $this->_obj_id]
        ]);
        $Models->orderBy('id', 'DESC');

        $this->_data = $Models;

        return $this;
    }

}
