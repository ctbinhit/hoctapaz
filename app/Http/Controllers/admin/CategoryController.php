<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Config;
use CategoryModel,
    CategoryLangModel,
    PhotoModel;
use View;
use Input;
use App\Bcore\Services\ViewService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CategoryController extends AdminController {

    public $storage_folder = 'categories/';
    public $ControllerName = 'Category';

    use \App\Functions\AdminFunction;

    public function __construct(Request $request) {
        parent::__construct($this->ControllerName);
        // Default datatable config ====================================================================================
        $this->ViewDataController = (object) Config::get('ViewController.' . $this->ControllerName);
        // =============================================================================================================
        $this->sendDataToView(array(
            'route_ajax' => 'admin_category_ajax'
        ));
        // =============================================================================================================
        View::share('_ControllerName', $this->ControllerName);
    }

    public function get_index($pTable = null, $pType = null, Request $request) {

        // -------------------------------------------------------------------------------------------------------------
        switch ($pTable) {
            case 'san-pham':$pTable = 'products';
                break;
            case 'products':$pTable = 'products';
                break;
            case 'product':$pTable = 'products';
                break;
            case 'bai-viet':$pTable = 'articles';
                break;
            case 'article': $pTable = 'articles';
                break;
            case 'articles': $pTable = 'articles';
                break;
            case 'exam':
                $pTable = 'exam';
                break;
            default:
                $request->session()->flash('message_type', 'warning');
                $request->session()->flash('message', __('message.coloixayra'));
                return redirect()->route('admin_index');
        }
        // -------------------------------------------------------------------------------------------------------------
        $this->DVController = $this->registerDVC($this->ControllerName, $pType);
        // -------------------------------------------------------------------------------------------------------------
        $IdLang = 1;
        if (session::has("user.$this->ControllerName.$pTable.$pType.display_count")) {
            $PERPAGE = session::get("user.$this->ControllerName.$pTable.$pType.display_count");
        } else {
            $PERPAGE = 5;
        }
        $SORT = 'ASC';
        $keyword = $request->input('keyword');
        $filter = [];

        $Model = new CategoryModel();
        // ----- FILTER ------------------------------------------------------------------------------------------------
        if (Input::has('id_category')) {
            $filter[] = ['categories.id_category', '=', $request->input('id_category')];
        } else {
            $filter[] = ['categories.id_category', '=', null];
        }


        $Model->set_where($filter);
        $Model->set_perPage($PERPAGE);
        $Model->set_orderBy(['ordinal_number', $SORT]); // Sort theo stt
        $Model->set_deleted(0); // 1: Danh mục chưa xóa, 0: Danh mục chưa xóa & đã xóa, -1: Danh mục đã xóa
        $Model->set_lang($IdLang);
        $LstModel = $Model->db_get_items($pType, $keyword);
        $PhotoModel = new PhotoModel();
        $Data_Photo = array(
            'isDeleted' => 1,
            'type' => 'photo',
            'table' => 'categories',
        );
        $Data_Photo = $this
                ->bcore_ListPhotoGroupByType($PhotoModel->db_getListPhotoByObjType((object) $Data_Photo));


        $CategoryModel = new CategoryModel();
        $Lst_data = $CategoryModel->db_getItems($pTable, $pType);
        $Lst_data = $CategoryModel->db_getListCateGroupById($Lst_data);
        $Lst_categories = $CategoryModel->db_getListCateByType($pTable, $pType);

        return view($this->_RV . 'category/index', [
            'items' => $LstModel,
            'paginate' => $PERPAGE == -1 ? false : true,
            'items_photo' => (object) $Data_Photo,
            'type' => $pType,
            'tbl' => $pTable,
            'items_cate' => $Lst_categories,
            'items_cate_data' => $Lst_data
        ]);
    }

    public function post_index(Request $request) {
        if (!$request->has('type') || !$request->has('tbl')) {
            $request->session()->flash('message_type', 'error');
            $request->session()->flash('message', __('message.coloixayratrongquatrinhxuly'));
            goto resultArea;
        }
        $type = $request->input('type');
        $tbl = $request->input('tbl');
        // ----- Thay đổi display count/length -------------------------------------------------------------------------
        if ($request->has('display_count')) {
            $dc = (int) $request->input('display_count');
            if (is_numeric($dc)) {
                // Set session
                session::put("user.$this->ControllerName.$tbl.$type.display_count", $dc);
            }
        }
        resultArea:
        return redirect()->route('admin_category_index', [$tbl, $type]);
    }

    public function post_save(Request $request) {
        dd($request->all());
        if ($request->input('type') === null || $request->input('type') === null)
            return redirect()->route('admin_index');
        if (Input::get('id') == null) {
            $Model = new CategoryModel();
        } else {
            $Model = CategoryModel::find(trim(Input::get('id')));
        }
        $ModelFunction = new CategoryModel();
        $Model->id_user = session('user')['id'];
        $Model->highlight = check_formInputResult('checkbox', Input::get('highlight'));
        $Model->display = check_formInputResult('checkbox', Input::get('display'));
        $Model->views = is_numeric(Input::get('views')) ? Input::get('views') : 0;
        $Model->ordinal_number = is_numeric(Input::get('ordinal_number')) ? Input::get('ordinal_number') : 0;
        $Model->obj_table = $request->input('tbl');
        if (Input::get('id') != null) {
            if ($request->input('id') == $request->input('id_category')) {
                $Model->id_category = null;
            } else {
                $Model->id_category = @$request->input('id_category');
            }
        } else {
            $Model->id_category = @$request->input('id_category');
        }
        $Model->type = $request->input('type');
        $Model->save();
        $ModelId = $Model->id;
        $path = null;
        $photo = null;

        // ----- PHOTO -------------------------------------------------------------------------------------------------
        // -------------------------------------------------------------------------------------------------------------
        redirectArea:

        // ===== REDIRECT AREA =====
        if (Input::get('id') == null)
            goto ADD_AREA;
        else {
            goto EDIT_AREA;
        }
        ADD_AREA:
        $form_fields = $this->form_field_generator($request->all(), array(
            'id_category' => $ModelId
        ));
        $r = CategoryLangModel::insert($form_fields);
        if ($r === true) {
            $request->session()->flash('message', __('message.themthanhcong'));
        } else {
            $request->session()->flash('message_type', 'error');
            $request->session()->flash('message', __('message.themkhongthanhcong'));
        }
        resultArea:
        return redirect()->route('admin_category_index', [
                    $request->input('tbl'),
                    $request->input('type')
        ]);
        EDIT_AREA:

        $form_fields = $this->form_field_generator($request->all(), array(
            'id_category' => $ModelId
                ), true); // Tham số cuối = true => return object
        // [3] Cập nhật article lang
        $Log = [];
        foreach ($form_fields as $k => $v) {
            // Bẫy lỗi phải tồn tại id mới xử lý
            if (isset($v->id)) {
                $tmp_id = $v->id;
                unset($v->id);
                $LangModel = CategoryLangModel::where('id', '=', $tmp_id)->first();
                // [1] Nếu chưa có ngôn ngữ đó trong bài viết => thêm mới đối tượng
                if ($LangModel == null) {
                    $r = CategoryLangModel::insert($v);
                } else {
                    unset($v->id_lang);
                    unset($v->id_category);
                    $r = $LangModel->update((array) $v);
                }
            }
        }

        if ($r === true) {
            $request->session()->flash('message', __('message.capnhatthanhcong'));
        } else {
            $request->session()->flash('message_type', 'error');
            $request->session()->flash('message', __('message.capnhatkhongthanhcong'));
        }
        return redirect()->route('admin_category_index', [$request->input('tbl'), $request->input('type')]);
    }

    public function get_add($pTable = null, $pType = null, Request $request) {
        if ($pType === null || $pTable === null)
            return redirect()->route('admin_index');
        $this->DVController = $this->registerDVC($this->ControllerName, $pType);
        // ===== Category =====
        $CategoryModel = new CategoryModel();
        $Lst_data = $CategoryModel->db_getItems($pTable, $pType);
        $Lst_data = $CategoryModel->db_getListCateGroupById($Lst_data);
        $Lst_categories = $CategoryModel->db_getListCateByType($pTable, $pType);

        // dump($Lst_categories, $pTable, $pType);

        return view($this->_RV . 'category/add', [
            'tbl' => $pTable,
            'type' => $pType,
            'items_cate' => $Lst_categories,
            'items_cate_data' => $Lst_data
        ]);
    }

    public function get_edit($pTable, $pType, $pId, Request $request) {
        if ($pType === null || $pTable === null)
            return redirect()->route('admin_index');
        $this->DVController = $this->registerDVC($this->ControllerName, $pType);
        // -------------------------------------------------------------------------------------------------------------
        $Model = CategoryModel::find($pId);
        if ($Model === null) {
            $request->session()->flash('message_type', 'warning');
            $request->session()->flash('message', Lang::get('message.dulieukhongcothuc'));
            return redirect()->route('admin_category_index', [$pType]);
        }

        // ===== Category =====
        $CategoryModel = new CategoryModel();
        $Lst_data = $CategoryModel->db_getItems($pTable, $pType);
        $Lst_data = $CategoryModel->db_getListCateGroupById($Lst_data);
        $Lst_categories = $CategoryModel->db_getListCateByType($pTable, $pType);

        $PhotoModel = new PhotoModel();
        $Data_Photo = array(
            'id' => $Model->id,
            'table' => $Model->tbl,
            'isDeleted' => 1
        );

        $Data_Photo = (object) $this
                        ->bcore_ListPhotoGroupByType($PhotoModel->db_getAllDataByIdObject((object) $Data_Photo));
        $Model->dbp_select = ['name', 'name_meta', 'description', 'content', 'seo_title', 'seo_keywords', 'seo_description'];
        $Lst_LangModel = $this->convert_objToListLang($Model->db_rela_Lang, true, '\App\Models\ProductLangModel');


        return view($this->_RV . 'category/add', [
            'type' => $pType,
            'tbl' => $pTable,
            'item' => $Model,
            'item_lang' => $Lst_LangModel,
            'item_photo' => $Data_Photo,
            'items_cate' => $Lst_categories,
            'items_cate_data' => $Lst_data
        ]);
    }

    public function get_edit1($pTable, $pType = null, $pId, Request $request) {
//        $this->ViewDataController = $this->setViewData($request->viewdata);
//        if ($pType === null || $pTable === null)
//            return redirect()->route('admin_index');
//        // =============================================================================================================
//
//        $Model = CategoryModel::find($pId);
//        // $ArticleModel = null => dữ liệu không có thực
//        if ($Model === null) {
//            $request->session()->flash('message_type', 'warning');
//            $request->session()->flash('message', Lang::get('message.dulieukhongcothuc'));
//            return redirect()->route('admin_category_index', [$pType]);
//        }
//
//        $PhotoModel = new PhotoModel();
//        $Data_ModelPhoto = array(
//            'id' => $Model->id,
//            'table' => $Model->tbl,
//        );
//        $Data_Photo = $this
//                ->bcore_ListPhotoGroupByType($PhotoModel->db_getAllDataByIdObject((object) $Data_ModelPhoto));
//
//        $Model->dbp_select = ['name', 'name_meta', 'description', 'content',
//            'seo_title', 'seo_keywords', 'seo_description'];
//        $Lst_LangModel = $this->convert_objToListLang($Model->db_rela_Lang, true, '\App\Models\CategoryLangModel');
//
//        return view($this->_RV . 'category/add', [
//            'type' => $pType,
//            'tbl' => $pTable,
//            'item' => $Model,
//            'item_lang' => $Lst_LangModel,
//            'item_photo' => $Data_Photo
//        ]);
    }

    // ===== AJAX REQUEST ==============================================================================================

    public function ajax(Request $request) {
        $act = $request->input('act');
        switch ($act) {
            case 'load_childrens':
                return response()->json($this->load_childsByIdParent($request->input('id')));
        }
    }

    public function load_childsByIdParent($id_parent) {
        $CategoryModels = DB::table('categories')
                        ->join('categories_lang', 'categories_lang.id_category', '=', 'categories.id')
                        ->where([
                            ['categories.id_category', $id_parent], ['categories_lang.id_lang', 1]
                        ])
                        ->select(['categories.id', 'categories_lang.name'])
                        ->orderBy('categories.ordinal_number', 'asc')->get();
        return ['state' => true, 'data' => $CategoryModels];
    }

    public function ajax_(Request $request) {
        $requestAction = $request->input('bcore_action');
        $data = null;
        $result = false;
        switch ($requestAction) {
            case 'get_items':
                goto getItemsArea;
                break;
            case 'update_checkbox':
                goto updateCheckboxArea;
                break;
            case 'delete': // Xóa vào bộ nhớ tạm
                goto deleteArea;
                break;
            case 'undo':
                break;
            case 'update_lst_cate_position':
                $lst_cate = $request->input('categories');
                goto update_lst_cate_positionArea;
                break;
            case 'remove': // Xóa vĩnh viễn

                break;
            default:
        }

        update_lst_cate_positionArea:
        $data = $lst_cate;
        $r = new CategoryModel();
        $r = $r->db_updateCatePosition($data);

        $result = $r;
        goto resultArea;

        // UndoArea ====================================================================================================
        undoArea:
        if ($request->has('data')) {
            foreach ($request->input('data') as $v) {
                $CategoryModel = CategoryModel::find($v);
                if ($CategoryModel !== null) {
                    $CategoryModel->deleted = null;
                    $result = $CategoryModel->save();
                    $data[] = $CategoryModel->id;
                    if (!$result) {
                        $message = __('message.coloixayratrongquatrinhxuly');
                    } else {
                        $message = __('message.hoantacthanhcong');
                    }
                } else {
                    // Error: Truy vấn dữ liệu theo id không tồn tại trên CSDL 
                    // => bão lỗi dữ liệu đã bị xóa hoặc id không tồn tại
                }
            }
        } else {
            // Error: Không nhận được id => không biết undo cái nào
        }
        goto resultArea;
        // DeleteArea ==================================================================================================

        deleteArea:
        if ($request->has('data')) {
            foreach ($request->input('data') as $v) {
                $CategoryModel = CategoryModel::find($v);
                if ($CategoryModel !== null) {
                    $CategoryModel->deleted = \Carbon\Carbon::now()->toDateTimeString();
                    $result = $CategoryModel->save();
                    $data[] = $CategoryModel->id;
                    // Set thông điệp cho người dùng
                    if (!$result) {
                        $message = __('message.coloixayratrongquatrinhxuly');
                    }
                } else {
                    // Error: Truy vấn dữ liệu theo id không tồn tại trên CSDL 
                    // => bão lỗi dữ liệu đã bị xóa hoặc id không tồn tại
                }
            }
        } else {
            // Error: Không nhận được id => không biết xóa cái nào
        }
        goto resultArea;
        // updateDisplayArea ===========================================================================================
        updateCheckboxArea:
        // Duyệt tất cả các fields data từ [JS]datatables gửi lên
        foreach ($request->input('data') as $k => $v) {
            // [1] Truy vấn CSDL theo id để lấy thông tin bài viết
            $CategoryModel = CategoryModel::find($k);

            if ($CategoryModel->ordinal_number != $v['ordinal_number']) {
                $CategoryModel->ordinal_number = $v['ordinal_number'];
            }
            // [2] Cập nhật 2 trường [display] & [highlight]
            $CategoryModel->display = $v['display'] != null ? $v['display'] : $CategoryModel->display;
            $CategoryModel->highlight = $v['highlight'] != null ? $v['highlight'] : $CategoryModel->highlight;
            // [3] Gán biến kết quả = true nếu save thành công
            $result = $CategoryModel->save();
            // [4] Tiếp tục truy vấn lại lên CSDL để lấy thông tin từ CSDL trả về cho giao diện người dùng
            // [5] Mục đích truy vấn lại để đảm bảo dữ liệu hiển thị cho người dùng là chính xác 100% (Bỏ đi cũng được)
            $tmp_CategoryModel = CategoryModel::find($k);
            // [6] Lấy dữ liệu ngôn ngữ
            $tmp_ArticleLangModel = $tmp_CategoryModel->db_rela_Lang()->where('id_lang', '=', 1)->first();
            // [7] Ghép 2 Object $tmp_CategoryModel & $tmp_ArticleLangModel thành 1 object mới
            $tmp_obj_merge = (object) $this->bcore_merge_object($tmp_CategoryModel, $tmp_ArticleLangModel);
            $data[] = array(
                'id' => $k,
                'name' => $tmp_obj_merge->name,
                'display' => $tmp_CategoryModel->display,
                'highlight' => $tmp_CategoryModel->highlight,
                'ordinal_number' => $tmp_CategoryModel->ordinal_number,
                'views' => $tmp_obj_merge->views,
                'created_at' => $tmp_obj_merge->created_at->format('Y-m-d H:i:s')
            );
        }

        goto resultArea;
        // getItemsArea ================================================================================================
        getItemsArea:
        $CategoryModel = new CategoryModel();
        $data = $CategoryModel->db_getItems($request->input('tbl'), $request->input('type'));
        goto resultArea;
        // =============================================================================================================
        resultArea:
        return response()->json([
                    'data' => @$data,
                    'result' => @$result,
                    'message' => @$message,
        ]);
        // =============================================================================================================
    }

}
