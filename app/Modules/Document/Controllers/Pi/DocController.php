<?php

namespace App\Modules\Document\Controllers\Pi;

use App\Bcore\PackageServicePI;
use Illuminate\Http\Request;
use App\Bcore\Services\NotificationService;
//use App\Events\AfterSendRequestFileDoc;
use App\Models\FileModel;
use App\Modules\Document\Components\DocumentState;
use App\Bcore\Services\CategoryService;
use App\Bcore\Services\UserServiceV2;
use App\Bcore\System\UserType;
use Config;
use App\Modules\UserVIP\Models\UserVIPModel;

class DocController extends PackageServicePI {

    public static function info() {
        return (object) [
                    'storage' => 'documents',
                    'storage_google' => '1ZqfSCqm_c1P65l3ZXT62IThUa3i4LCAN',
                    'version' => 2.0
        ];
    }

    public function __construct() {
        parent::__construct();
    }

    public function get_index($type) {

        $FileModels = FileModel::where([
                    ['obj_type', $type],
                    ['deleted_at', null],
                    ['display', true],
                    ['state', '<>', DocumentState::approve()],
                    ['id_user', UserServiceV2::current_userId(UserType::professor())]
                ])->orderBy('id', 'DESC')->paginate(5);

        return view('Document::Pi/Document/index', [
            'type' => $type,
            'items' => DocumentState::set_documentStateTextByModels($FileModels)
        ]);
    }

    public function get_add($type, Request $request) {
        // Get List User VIP from database
        $db_uservipmodels = $this->load_userVIP();

        $Categories_Select = $this->load_categories();
        return view('Document::Pi/Document/add', [
            'type' => $type,
            'categories' => $Categories_Select,
            'db_uservipmodels' => $db_uservipmodels
        ]);
    }

    public function get_edit($type, $id, Request $request) {
        // Get List User VIP from database
        $db_uservipmodels = $this->load_userVIP();
        
        $Categories_Select = $this->load_categories();
        
        $FileModel = FileModel::find($id);
        
        if ($FileModel == null) {
            NotificationService::alertRight('Dữ liệu không có thực.', 'danger');
            return redirect()->route('mdle_pi_doc_index', $type);
        }

        return view('Document::Pi/Document/add', [
            'type' => $type,
            'item' => $FileModel,
            'categories' => $Categories_Select,
            'db_uservipmodels' => $db_uservipmodels
        ]);
    }

    public function post_save($type, Request $request) {

        if ($type != $request->input('type')) {
            abort(500);
        }
        $OLD_DATA = null;
        if ($request->has('id')) {
            $FileModel = \App\Models\FileModel::find($request->input('id'));
            if ($FileModel == null) {
                \App\Bcore\Services\NotificationService::alertRight('Dữ liệu không có thực.', 'danger');
                goto responseArea;
            }
            $OLD_DATA = $FileModel;
        } else {
            $FileModel = new \App\Models\FileModel();
            $FileModel->id_user = UserServiceV2::current_userId(UserType::professor());
            $FileModel->obj_type = $type;
        }

        // ----- Upload file -------------------------------------------------------------------------------------------
        if ($request->hasFile('file')) {
            // UPLOAD FILE
            $StorageServiceV2 = new \App\Bcore\Services\StorageServiceV2();
            $local_file = $StorageServiceV2->disk('localhost')
                            ->folder('file_doc')->set_file($request->file)->upload();
            if ($local_file == null) {
                NotificationService::alertRight('Có lỗi xảy ra, không thể upload file lên server,'
                        . 'vui lòng thử lại sau ít phút.', 'danger');
                goto responseArea;
            }

            // GOOGLE DRIVE
            $storage_folder = $this->_STORAGE_GOOGLE['GOOGLE_DRIVE_FOLDER_DOC']; // Thay đổi đường dẫn/ thư mục trên google drive
            $google_data = $local_file->sync_google($storage_folder);
            $FileModel->sync_google = json_encode($google_data);


            $flag = $request->has('id') ? Storaqge::disk('localhost')->delete($OLD_DATA->url) : true;
            if ($flag) {
                $FileModel->url = $local_file->file_uploaded_path();
                $FileModel->url_encode = md5($FileModel->url);
                $FileModel->size = $request->file->getSize();
                $FileModel->mimetype = $request->file->getMimetype();
            }
        }
        // -------------------------------------------------------------------------------------------------------------

        $FileModel->name = $request->input('name');
        $FileModel->description = $request->input('description');
        $FileModel->content = $request->input('content');
        $FileModel->price = $request->input('price');
        $FileModel->state = DocumentState::free();
        $FileModel->allow_uservip = json_encode($request->input('allow_uservip'));

        $FileModel->id_category = $request->input('id_category');

        $FileModel->seo_description = $request->input('seo_description');
        $FileModel->seo_keywords = $request->input('seo_keywords');
        $FileModel->seo_title = $request->input('seo_title');

        $r = $FileModel->save();

        if ($r) {
            //event(new AfterSendRequestFileDoc($FileModel, \App\Bcore\Services\UserService::db_info()));

            NotificationService::alertRight('Cập nhật thành công.', 'success');
        } else {
            NotificationService::alertRight('Cập nhật không thành công, vui lòng thử lại.'
                    . '', 'danger');
        }

        responseArea:
        return redirect()->route('mdle_pi_doc_index', $type);
    }

    public function get_index_approved($type, Request $request) {
        $FileModel = FileModel::where([
                    ['obj_type', $type],
                    ['deleted_at', null],
                    ['state', DocumentState::approve()],
                    ['id_user', UserServiceV2::current_userId(UserType::professor())]
                ])->orderBy('id', 'DESC')->paginate(5);

        return view('Document::Pi/Document/approved', [
            'type' => $type,
            'items' => $FileModel
        ]);
    }

    public function ajax($type, Request $request) {
        $act = $request->input('act');
        switch ($act) {
            case 'sta':
                return $this->setFileToPendingState($request);
            case 'ri':
                return $this->remove_item($request);
            case 'cr':
                return $this->cancel_request($request);
            case 'hide':
                return $this->hide_item($request);
            default: return response()->json();
        }
    }

    private function load_userVIP() {
        return (new UserVIPModel())->getAllByType('user');
    }

    private function load_categories() {
        return CategoryService::html_selectCategories('hoctap', 'exam');
    }

    private function hide_item($request) {
        $id = $request->input('id');
        $FileModel = FileModel::find($id);
        $FileModel->display = false;
        if ($FileModel->save()) {
            $JsonResponse = \App\Bcore\System\AjaxResponse::success();
        } else {
            $JsonResponse = \App\Bcore\System\AjaxResponse::fail();
        }
        responseArea:
        return response()->json($JsonResponse);
    }

    private function cancel_request($request) {
        $id = $request->input('id');
        $FileModel = FileModel::find($id);
        $FileModel->state = DocumentState::free();
        if ($FileModel->save()) {
            $JsonResponse = \App\Bcore\System\AjaxResponse::success();
        } else {
            $JsonResponse = \App\Bcore\System\AjaxResponse::fail();
        }
        responseArea:
        return response()->json($JsonResponse);
    }

    private function remove_item($request) {
        $id = $request->input('id');
        $FileModel = FileModel::find($id);
        if ($FileModel == null) {
            $JsonResponse = \App\Bcore\System\AjaxResponse::dataNotFound();
            goto responseArea;
        }
        $FileModel->deleted_at = \Carbon\Carbon::now();
        if ($FileModel->save()) {
            $JsonResponse = \App\Bcore\System\AjaxResponse::success();
        } else {
            $JsonResponse = \App\Bcore\System\AjaxResponse::fail();
        }
        responseArea:
        return response()->json($JsonResponse);
    }

    private function setFileToPendingState($request) {
        $id = $request->input('id');
        $type = $request->input('rt');
        $FileModel = FileModel::find($id);
        if ($FileModel == null) {
            $JsonResponse = \App\Bcore\System\AjaxResponse::dataNotFound();
            goto responseArea;
        }
        $FileModel->type = $type;
        $FileModel->state = DocumentState::pending();
        if ($FileModel->save()) {
            $JsonResponse = \App\Bcore\System\AjaxResponse::success([
                        'msg' => 'Gửi file thành công, file của bạn sẽ được xử lý trong vòng 6h kể từ lúc đăng lên'
                        . ', nếu file đủ điều kiện sẽ được tự động đăng bán trên trang chủ.'
            ]);
        } else {
            $JsonResponse = \App\Bcore\System\AjaxResponse::fail([
                        'msg' => 'Server quá tải, gửi yêu cầu thất bại!'
            ]);
        }
        responseArea:
        return response()->json($JsonResponse);
    }

}
