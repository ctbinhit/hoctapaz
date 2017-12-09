<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Storage;
use ProductModel,
    ProductLangModel,
    PhotoModel,
    CategoryModel;
use View,
    Illuminate\Support\Facades\DB,
    Input,
    Illuminate\Support\Facades\Session;
use Image;

class ProductController extends AdminController {

    public $storage_folder = 'products/';
    public $ControllerName = 'Product';

    use \App\Functions\AdminFunction;

    public function __construct() {
        parent::__construct($this->ControllerName);
        $this->sendDataToView(array(
            'route_ajax' => 'admin_product_ajax'
        ));
        // -------------------------------------------------------------------------------------------------------------
        View::share('_ControllerName', $this->ControllerName);
    }

    private function pageSize($request) {
        if ($request->has('psize')) {
            if (is_numeric($request->input('psize'))) {
                return $request->input('psize');
            }
        }
        return 6;
    }

    public function get_index($pType = null, Request $request) {
        $this->DVController = $this->registerDVC($this->ControllerName, $pType);

        $ProductModel = new ProductModel();
        $Models = $ProductModel
                ->set_orderBy(['ordinal_number', 'ASC'])
                ->set_lang(1)
                ->set_type($pType)
                ->set_perPage($this->pageSize($request))
                ->set_keyword($request->input('keyword'))
                ->execute();
        $PAI = PhotoModel::findByModels(['photo', 'photos'], $Models->data());
        $LoadCategory = CategoryModel::findByModelsWithLang($PAI);

        $CategoryModel = new CategoryModel();
        $LST_CATES = $CategoryModel
                ->set_type('sanpham')
                ->set_table('products')
                ->set_lang(1)
                ->execute();

        return view($this->_RV . 'product/index', [
            'items' => $PAI,
            'type' => $pType,
            'lst_categories' => $LST_CATES->data()
        ]);
    }

    public function get_edit($pType, $pId, Request $request) {
        try {
            $this->DVController = $this->registerDVC($this->ControllerName, $pType);
            // -------------------------------------------------------------------------------------------------------------
            $Model = ProductModel::find($pId);
            if ($Model === null) {
                $request->session()->flash('message_type', 'warning');
                $request->session()->flash('message', Lang::get('message.dulieukhongcothuc'));
                return redirect()->route('admin_product_index', [$pType]);
            }

            $Model = PhotoModel::findByModel(['photo', 'photos'], $Model);

            // ----- Category ----------------------------------------------------------------------------------------------
            $CategoryModel = new CategoryModel();
            $Lst_data = $CategoryModel->db_getItems('products', $pType);
            $Lst_data = $CategoryModel->db_getListCateGroupById($Lst_data);
            $Lst_categories = $CategoryModel->db_getListCateByType('products', $pType);

            $PhotoModel = new PhotoModel();
            $Data_Photo = array(
                'id' => $Model->id,
                'table' => $Model->tbl,
                'isDeleted' => 1
            );

            $Data_Photo = (object) $this
                            ->bcore_ListPhotoGroupByType($PhotoModel->db_getAllDataByIdObject((object) $Data_Photo));
            $Model->dbp_select = ['name', 'price', 'promotion_price', 'name_meta', 'description', 'content', 'seo_title', 'seo_keywords', 'seo_description'];
            $Lst_LangModel = $this->convert_objToListLang($Model->db_rela_Lang, true, '\App\Models\ProductLangModel');

            $PhotoModel = new PhotoModel();
            $Data_Photos = $PhotoModel->set_type('photos')
                            ->set_table('products')
                            ->set_objId($Model->id)->execute();

            //dd(Storage::disk('public')->url('a'));

            $Photos = PhotoModel::encode_urlModels($Data_Photos->data());
            
            return view($this->_RV . 'product/add', [
                'type' => $pType,
                'item' => $Model,
                'item_lang' => $Lst_LangModel,
                'item_photo' => $Data_Photo,
                'item_photos' => $Photos,
                'items_cate' => $Lst_categories,
                'items_cate_data' => $Lst_data
            ]);
        } catch (\Exception $ex) {
            // Write log
            \App\Bcore\Services\NotificationService::alertRight('Có lỗi xảy ra trên hệ thống Website, thử lại sau ít'
                    . ' phút hoặc liên hệ quản trị để biết thông tin chi tiết.', 'warning');
            return redirect()->route('admin_product_index',$pType);
        }
    }

    public function get_add($pType) {
        try {
            // Function registerDVC: (Controller name, Type, Variable name )
            // Return DVController
            $this->DVController = $this->registerDVC($this->ControllerName, $pType);

            // ===== Category ==============================================================================================
            $CategoryModel = new CategoryModel();
            $Lst_data = $CategoryModel->db_getItems('products', $pType);
            $Lst_data = $CategoryModel->db_getListCateGroupById($Lst_data);
            $Lst_categories = $CategoryModel->db_getListCateByType('products', $pType);

            return view($this->_RV . 'product/add', [
                'type' => $pType,
                'items_cate' => $Lst_categories,
                'items_cate_data' => $Lst_data
            ]);
        } catch (\Exception $ex) {
            // Write log
            \App\Bcore\Services\NotificationService::alertRight('Có lỗi xảy ra trên hệ thống Website, thử lại sau ít'
                    . ' phút hoặc liên hệ quản trị để biết thông tin chi tiết.', 'warning');
            return redirect()->route('admin_product_index', $pType);
        }
    }

    // =================================================================================================================

    public function post_save(Request $request) {
        try {
            if ($request->input('type') === null)
                return redirect()->route('admin_index');
            // ========== GENERAL AREA =====================================================================================
            // [1] Check nếu id không tồn tại => Thao tác thêm mới
            // Ngược lại => thao tác cập nhật
            if (Input::get('id') == null) {
                $Model = new ProductModel();
            } else {
                $Model = ProductModel::find(trim(Input::get('id')));
            }
            // [2] Set data cho model
            $Model->id_user = session('user')['id'];
            $Model->highlight = check_formInputResult('checkbox', Input::get('highlight'));
            $Model->display = check_formInputResult('checkbox', Input::get('display'));
            $Model->views = is_numeric(Input::get('views')) ? Input::get('views') : 0;
            $Model->price = is_numeric(Input::get('price')) ? Input::get('price') : 0;
            $Model->promotion_price = is_numeric(Input::get('promotion_price')) ? Input::get('promotion_price') : 0;
            $Model->ordinal_number = is_numeric(Input::get('ordinal_number')) ? Input::get('ordinal_number') : 0;
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
            $saved_products = $Model->save();

            if ($saved_products) {
                \App\Bcore\Services\NotificationService::alertRight('Lưu thành công!', 'success');
            } else {
                \App\Bcore\Services\NotificationService::alertRight('Lưu không thành công!', 'warning');
                goto redirectArea;
            }

            // [3] Lấy id của article vừa save (* Bước quan trọng)
            $ModelId = $Model->id;
            // HINHANH

            $path = null;
            $photo = null;
            // Nếu tồn tại file photo thì sẽ INSERT và XÓA dữ liệu cũ
            // [1] Thêm mới hình ảnh
            if (Input::hasFile('photo')) {
                // ========== XỬ LÝ HÌNH ẢNH ===============================================================================
                // [1] Khai báo thông tin cho objDataModel
                $objPhotoModel = array(
                    'type' => 'photo', // Hình đại diện mặc định là [photo]
                    'id' => $ModelId,
                    'table' => $Model->tbl,
                    // 1: Chỉ hiển thị những hình ảnh được phép hiển thị
                    // 0: Hiển thị tất cả hình ảnh (ẩn hay ko ẩn cũng hiển thị)
                    // -1: Chỉ hiển thị những hình ảnh bị ẩn (field display = false)
                    'display' => 1
                );
                //  [2] Lấy dữ liệu hình ảnh hiện tại
                $tmp_Photo = new PhotoModel();
                $tmp_Photo = $tmp_Photo->db_getItem((object) $objPhotoModel);

                // [3] Thêm mới hình ảnh
                // ===== INSERT PHOTO ======================================================================================
                $photo = Input::file('photo');
                $path = Storage::disk('public')->putFile($this->storage_folder . $request->input('type') . '/photo', $photo, 'public');
                $PhotoModel = new PhotoModel();
                $PhotoModel->obj_id = $ModelId;
                $PhotoModel->obj_table = 'products';
                $PhotoModel->obj_type = 'photo';
                $PhotoModel->url = $path;
                $PhotoModel->url_encode = md5($path);
                $PhotoModel->name = $photo->getClientOriginalName();
                $PhotoModel->id_user = session('user')['id'];
                $r = $PhotoModel->save();
                // =========================================================================================================
                // [4] Nếu thêm hình ảnh mới thành công
                // => Xóa hình ảnh cũ
                // Ngược lại tiến hành bước tiếp theo, giữ nguyên hình ảnh cũ
                // Tránh trường hợp up hình mới ko được rồi mất luôn hình cũ
                if ($r) {
                    // Thêm thành công hình mới -> check nếu có hình cũ thì xóa bỏ
                } else {
                    // Thêm không thành công => không xóa hình cũ => di chuyển tới bước tiếp theo
                    goto uploadPhotosArea;
                }
                // ===== Xóa hình đại diện cũ ==============================================================================
                // Dữ liệu hình ảnh = null => bài viết chưa có hình ảnh hoặc đã xóa
                if ($tmp_Photo != null) {
                    if ($tmp_Photo->db_deleteItem($tmp_Photo->id)) {
                        // Xóa hình cũ thành công
                    } else {
                        // Không xóa được hình cũ => ... ghi log, ghi action delay
                    }
                } else {
                    // Không có hình cũ
                }
            }
            // ----- Upload photos ------------------------------------------------------------------
            uploadPhotosArea:
            if ($request->hasFile('photos')) {

                $photos = $request->photos;

                $data_photos = [];

                foreach ($photos as $k => $image) {
                    $path = Storage::disk('localhost')->
                            putFile($this->storage_folder . $request->input('type') . '/photos', $image, 'public');
                    $data_photos[] = [
                        'obj_id' => $ModelId,
                        'obj_table' => 'products',
                        'obj_type' => 'photos',
                        'size' => $image->getSize(),
                        'url' => $path,
                        'dir_name' => trim($this->storage_folder, '/'),
                        'mimetype' => $image->getMimetype(),
                        'url_encode' => md5($path),
                        'name' => $image->getClientOriginalName(),
                        'id_user' => session('user')['id']
                    ];
                }

                $inserted_photo = DB::table('photos')->insert($data_photos);

                if ($inserted_photo) {
                    
                } else {
                    // Không thể insert vào CSDL => xóa file (Updating...)
                }
            }

            $datalang = $request->input('data_lang');
            foreach ($datalang as $lang_id => $model) {
                if ($model['id'] == null) {
                    $tmp = [
                        'name' => @$model['name'],
                        'name_meta' => $model['name_meta'],
                        'id_product' => $ModelId,
                        'id_lang' => $lang_id,
                        'description' => @$model['description'],
                        'content' => @$model['content'],
                        'seo_title' => @$model['seo_title'],
                        'seo_description' => @$model['seo_description'],
                        'seo_keywords' => @$model['seo_keywords'],
                    ];
                    DB::table('products_lang')->insert($tmp);
                } else {
                    $TMP_AM = ProductLangModel::find($model['id']);
                    if (!$this->check_nameMeta($model['name_meta'], $lang_id, $model['id'])) {
                        \App\Bcore\Services\NotificationService::alertRight("Đường dẫn URL " . $model['name_meta']
                                . ' đã tồn tại trên hệ tống', 'danger');
                        return back()->withInput();
                    }
                    if ($TMP_AM != null) {
                        $TMP_AM->name = @$model['name'];
                        $TMP_AM->name_meta = @$model['name_meta'];
                        $TMP_AM->description = @$model['description'];
                        $TMP_AM->content = @$model['content'];
                        $TMP_AM->seo_title = @$model['seo_title'];
                        $TMP_AM->seo_description = @$model['seo_description'];
                        $TMP_AM->seo_keywords = @$model['seo_keywords'];
                        $TMP_AM->save();
                    }
                }
            }
        } catch (\Exception $ex) {
            // Write log
            \App\Bcore\Services\NotificationService::alertRight("Có lỗi xảy ra trên hệ thống!, vui lòng thử lại sau "
                    . "hoặc liên hệ quản trị để biết thêm thông tin", 'danger');
        }
        redirectArea:
        return redirect()->route('admin_product_index', $request->input('type'));
    }

    public function ajax(Request $request) {
        $RESPONSE = (object) [
                    'status' => false,
                    'message' => 'Thao tác không xác định',
                    'type' => 'warning',
                    'data' => null
        ];

        if (!$request->has('act')) {
            goto responseArea;
        }

        $act = $request->input('act');

        switch ($act) {

            case 'rp':
                if ($this->remove_photo($request)) {
                    $RESPONSE->status = true;
                    $RESPONSE->message = 'Xóa file thành công.';
                    $RESPONSE->type = 'success';
                } else {
                    $RESPONSE->message = 'Có lỗi xảy ra trong quá trình thao tác.';
                    $RESPONSE->type = 'warning';
                    $RESPONSE->data = $request->all();
                }
                break;
            default:
                $RESPONSE->message = 'Thao tác không xác định';
                $RESPONSE->type = 'warning';
        }
        responseArea:
        return response()->json($RESPONSE);
    }

    private function check_nameMeta($name_meta, $id_lang, $except_id = null) {
        $duplicateNameMeta = ProductLangModel::where([
                    ['name_meta', $name_meta],
                    ['id_lang', $id_lang]
        ]);
        if ($except_id != null) {
            $duplicateNameMeta->where('id', '<>', $except_id);
        }
        $r = $duplicateNameMeta->first();
        return $r == null ? true : false;
    }

    private function remove_photo($request) {
        if (!$request->has('id')) {
            return false;
        }
        $photo = PhotoModel::find($request->input('id'));
        if ($photo != null) {
            return $photo->delete();
        } else {
            return false;
        }
    }

}
