<?php

/* =====================================================================================================================
 * Module Slider - Build at: 10-02-2017
 * Created By Bình Cao | info@binhcao.com | (+84) 964 247 742
 * Homepage: http://binhcao.com
 * Package URL:  http://binhcao.com/package/laravel-5.4/slider
 * ---------------------------------------------------------------------------------------------------------------------
 * Controller: App\Modules\Slider\Controller\Admin\SliderController.php
 * Model: null
 * Views: App\Modules\Slider\Admin\ index | add | ...
 * + Database: {prefix}photo
 * + Insert: insert into table photo (title, desc, content, url path)
 * + Update: delete file -> update title,desc,content,url path, url redirect,...
 * =====================================================================================================================
 */

namespace App\Modules\Slider\Controllers\Admin;

use Illuminate\Http\Request;
use App\Bcore\PackageServiceAD;
use PhotoModel;
use SessionService;
use App\Bcore\Services\ListViewService;
use ImageService;
use Session,
    Storage,
    Carbon\Carbon;

class SliderController extends PackageServiceAD {

    public $module_name = 'Slider';
    public $dir = 'Admin';
    private $storage_folder = 'slider';
    private $display_count = [
        'header' => [
            '5' => 5,
            '10' => 10,
            '25' => 25,
            'Tất cả' => -1
        ]
    ];

    public function get_viewcount($pType) {
        try {
            if (Session(__CLASS__)->{$pType}->display_count == -1) {
                return 500;
            } else {
                return Session(__CLASS__)->{$pType}->display_count;
            }
        } catch (\Exception $ex) {
            return 5;
        }
    }

    public function __construct() {
        parent::__construct();
    }

    public function get_index($pType, Request $request) {
        // ----- View count --------------------------------------------------------------------------------------------
        $VIEWCOUNT = ListViewService::getDataView();
        // -------------------------------------------------------------------------------------------------------------
        $PM = PhotoModel::where([
                    ['obj_type', '=', trim($pType)],
                    ['deleted_at', '=', null]
                ])
                ->orderBy('ordinal_number', 'ASC')
                ->orderBy('id', 'DESC')
                ->paginate($VIEWCOUNT);
        if (count($PM) != 0) {
            foreach ($PM as $k => $v) {
                $v->image = $v->url_encode;
                $time_human = new Carbon($v->created_at);
                $v->created_at = $time_human;
                $v->created_at_human = $time_human->diffForHumans(Carbon::now());
            }
        }
        
        return view("$this->module_name::$this->dir/index", [
            'type' => $pType,
            'view_count' => $VIEWCOUNT,
            'items' => $PM
        ]);
    }

    public function post_index(Request $request) {
        ListViewService::setDataView($request->input('vc'));
        return redirect()->route('mdle_slider_index', $request->input('type'));
    }

    public function get_add($pType) {
        return view("$this->module_name::$this->dir/add", [
            'type' => $pType,
        ]);
    }

    public function get_edit($pType, $pId) {
        try {
            $PM = PhotoModel::find($pId);
            if ($PM == null) {
                session::flash('info_callback', (object) [
                            'message_title' => 'Thông báo',
                            'message_type' => 'danger',
                            'message' => 'Dữ liệu không có thực!'
                ]);
                return redirect()->route('mdle_slider_index', $pType);
            }
            $IS = new ImageService();

            return view("$this->module_name::$this->dir/add", [
                'type' => $pType,
                'item' => $PM
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('mdle_slider_index', $pType);
        }
    }

    public function post_save(Request $request) {

        if ($request->input('type') == null) {
            session::flash('info_callback', (object) [
                        'message_title' => 'Thông báo',
                        'message_type' => 'warning',
                        'message' => 'Lưu không thành công, có lỗi xảy ra!'
            ]);
            return redirect()->route('admin_index');
        }

        // ----- Has id => update else insert
        if ($request->has('id')) {
            $Model = PhotoModel::find(trim($request->input('id')));
        } else {
            $Model = new PhotoModel();
            $Model->id_user = Session('user')['id'];
        }
        $OLD_MODEL = null;
        // ----- Nếu có file thì mới cập nhật...
        if ($request->hasFile('file')) {
            if ($request->has('id')) {
                $OLD_MODEL = $Model;
                $Model = new PhotoModel();
            }
            // Upload file to local storage
            $file = $request->file;

            $PARENT_FOLDER = $this->storage_folder . '/' . $request->input('type');

            $LocalPath = Storage::disk('localhost')->putFile($PARENT_FOLDER, $file, 'public');

            if ($LocalPath == null) {
                session::flash('info_callback', (object) [
                            'message_title' => 'Thông báo',
                            'message_type' => 'warning',
                            'message' => 'Lưu không thành công, có lỗi xảy ra!'
                ]);
                goto redirectArea;
            }
            // ------ Photo options ------------------------------------------------------------------------------------
            $Model->obj_type = $request->input('type');
            $Model->name = $file->getClientOriginalName();
            $Model->size = $file->getSize();
            $Model->mimetype = $file->getMimetype();
            $Model->url_encode = md5($LocalPath);
            $Model->url = $LocalPath;
            // ---------------------------------------------------------------------------------------------------------
            // ----- Xóa file cũ ---------------------------------------------------------------------------------------
            if ($OLD_MODEL != null) {
                Storage::disk('localhost')->delete($OLD_MODEL->url);
                $OLD_MODEL->delete();
            }
        }

        $Model->title = $request->input('title');
        $Model->description = $request->input('description');
        $Model->content = $request->input('content');
        $Model->title = $request->input('title');
        $Model->url_redirect = $request->input('url_redirect');

        if ($Model->save()) {

            session::flash('info_callback', (object) [
                        'message_title' => 'Thông báo',
                        'message_type' => 'success',
                        'message' => 'Lưu thành công!'
            ]);
            goto redirectArea;
        } else {
            session::flash('info_callback', (object) [
                        'message_title' => 'Thông báo',
                        'message_type' => 'warning',
                        'message' => 'Lưu không thành công, có lỗi xảy ra!'
            ]);
            goto redirectArea;
        }

        redirectArea:
        return redirect()->route('mdle_slider_index', $request->input('type'));
    }

    public function ajax(Request $request) {
        $act = $request->input('act');

        switch ($act) {
            case 'ud':
                return $this->update_display($request);
            case 'uh':
                return $this->update_highlight($request);
            case 'ri':
                return $this->remove_item($request);
            case 'ris':
                return $this->remove_items($request);
            default:
                return response()->json(\App\Bcore\System\AjaxResponse::actionUndefined());
        }
    }

    private function update_highlight($request) {
        try {
            $id_photo = $request->input('id');
            $photo_model = \App\Models\PhotoModel::find($id_photo);
            if ($photo_model == null) {
                $state = false;
                $message = 'Dữ liệu không có thực';
                goto responseArea;
            }
            $photo_model->highlight = !$photo_model->highlight;
            if ($photo_model->save()) {
                $state = true;
                $message = 'Cập nhật thành công.';
            } else {
                $state = false;
                $message = 'Cập nhật không thành công, có lỗi xảy ra.';
            }
            $rs = $photo_model->highlight;
        } catch (\Exception $ex) {
            $state = false;
            $message = 'Lỗi hệ thống!';
        }
        responseArea:
        return response()->json([
                    'state' => @$state,
                    'messsage' => @$messages,
                    'current_state' => @$rs
        ]);
    }

    private function update_display($request) {
        try {
            $id_photo = $request->input('id');
            $photo_model = \App\Models\PhotoModel::find($id_photo);
            if ($photo_model == null) {
                $state = false;
                $message = 'Dữ liệu không có thực';
                goto responseArea;
            }
            $photo_model->display = !$photo_model->display;
            if ($photo_model->save()) {
                $state = true;
                $message = 'Cập nhật thành công.';
            } else {
                $state = false;
                $message = 'Cập nhật không thành công, có lỗi xảy ra.';
            }
            $rs = $photo_model->display;
        } catch (\Exception $ex) {
            $state = false;
            $message = 'Lỗi hệ thống!';
        }
        responseArea:
        return response()->json([
                    'state' => @$state,
                    'messsage' => @$messages,
                    'current_state' => @$rs
        ]);
    }

    private function remove_item($request) {
        $JsonResponse = \App\Bcore\System\AjaxResponse::actionUndefined();
        try {
            $id = $request->input('id');
            $photo_model = \App\Models\PhotoModel::find($id);
            if ($photo_model == null) {
                $JsonResponse = \App\Bcore\System\AjaxResponse::dataNotFound();
                goto responseArea;
            }
            if (Storage::disk('localhost')->exists($photo_model->url)) {
                $file_deleted = Storage::disk('localhost')->delete($photo_model->url);
            } else {
                $file_deleted = true;
            }

            if ($photo_model->delete() && $file_deleted) {
                $JsonResponse = \App\Bcore\System\AjaxResponse::success();
            } else {
                $JsonResponse = \App\Bcore\System\AjaxResponse::fail($request->all());
            }
        } catch (\Exception $ex) {
            $JsonResponse = \App\Bcore\System\AjaxResponse::has_error($ex, $request->all());
        }
        responseArea:
        return response()->json($JsonResponse);
    }

    private function remove_items($request) {
        $JsonResponse = \App\Bcore\System\AjaxResponse::actionUndefined();
        try {
            $array_id = (array) $request->input('items');
            $PhotoModels = \App\Models\PhotoModel::whereIn('id', $array_id)->get();
            if (count($PhotoModels) == 0) {
                $JsonResponse = \App\Bcore\System\AjaxResponse::dataNotFound();
                goto responseArea;
            }
            foreach ($PhotoModels as $PhotoModel) {
                if ($PhotoModel != null) {
                    $photo_url = $PhotoModel->url;
                    if (Storage::disk('localhost')->exists($photo_url)) {
                        $file_deleted = Storage::disk('localhost')->delete($photo_url);
                        $file_deleted = true;
                    }
                    if (isset($file_deleted) ? $file_deleted : false) {
                        $PhotoModel->delete();
                        $JsonResponse = \App\Bcore\System\AjaxResponse::success();
                    } else {
                        $JsonResponse = \App\Bcore\System\AjaxResponse::fail();
                    }
                }
            }
        } catch (\Exception $ex) {
            $JsonResponse = \App\Bcore\System\AjaxResponse::has_error($ex, $request->all());
        }
        responseArea:
        return response()->json($JsonResponse);
    }

    public function ajax_(Request $request) {
        $RESPONSE = (object) [
                    'status' => false,
                    'message' => null,
                    'data' => $request->all()
        ];
        try {
            if (!$request->has('act')) {
                return response()->json($RESPONSE);
            }
            switch (trim($request->input('act'))) {
                case 'rs':
                    $PM = PhotoModel::whereIn('id', (array) $request->input('items'));
                    if ($PM->update(['deleted_at' => Carbon::now()])) {
                        $RESPONSE->status = true;
                        $RESPONSE->lst_id = $request->input('items');
                    } else {
                        $RESPONSE->status = false;
                    }
                    break;
                case 'ri':
                    $PM = PhotoModel::find(trim($request->input('id')));
                    if ($PM != null) {
                        if ($PM->update(['deleted_at' => Carbon::now()])) {
                            $RESPONSE->status = true;
                        } else {
                            $RESPONSE->status = false;
                        }
                    } else {
                        $RESPONSE->status = false;
                    }
                    break;
                case 'ud':
                    $PM = PhotoModel::find(trim($request->input('id')));
                    if ($PM != null) {
                        $PM->display = !$PM->display;
                        if ($PM->save()) {
                            $RESPONSE->status = true;
                        }
                    } else {
                        $RESPONSE->status = false;
                    }
                    break;
                case 'uf':
                    $PM = PhotoModel::find(trim($request->input('id')));
                    if ($PM != null) {
                        switch ($request->input('field')) {
                            case 'ordinal_number':
                                $PM->ordinal_number = $request->input('field_val');
                                break;
                            case 'title' :
                                $PM->title = $request->input('field_val');
                                break;
                            default:
                                break;
                        }
                        if ($PM->save()) {
                            $RESPONSE->status = true;
                        } else {
                            $RESPONSE->status = false;
                        }
                    } else {
                        $RESPONSE->status = false;
                    }
                    break;
            }
            return response()->json($RESPONSE);
        } catch (\Exception $ex) {
            $RESPONSE->data = 'ERROR';
            return response()->json($RESPONSE);
        }
    }

}
