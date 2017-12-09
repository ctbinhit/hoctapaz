<?php

namespace App\Modules\Document\Controllers\Admin;

use App\Bcore\PackageServiceAD;
use Illuminate\Http\Request;
use App\Bcore\Services\NotificationService;
use App\Events\AfterSendRequestFileDoc;
use App\Models\FileModel;
use App\Bcore\System\AjaxResponse;
use Carbon\Carbon;
use App\Bcore\Services\UserService;
use App\Modules\Document\Components\DocumentState;
use App\Bcore\Services\UserServiceV2;
use App\Bcore\System\UserType;

class DocController extends PackageServiceAD {

    public static function info() {
        return (object) [
                    'storage' => 'documents',
                    'version' => 2.0
        ];
    }

    public function __construct() {
        parent::__construct();
    }

    public function get_index($type) {
        $FileModel = FileModel::where([
                    ['obj_type', $type],
                    ['deleted_at', null],
                    ['state', DocumentState::pending()]
                ])->orderBy('created_at', 'ASC')->paginate(5);


        return view('Document::Admin/Document/index', [
            'type' => $type,
            'items' => $FileModel
        ]);
    }

    public function get_tailieudangban($type) {
      
        $FileModel = FileModel::where([
                    ['obj_type', $type],
                    ['deleted_at', null],
                    ['state', DocumentState::approve()]
                ])->orderBy('created_at', 'ASC')->paginate(5);

       
        
        return view('Document::Admin/Document/tailieudangban', [
            'type' => $type,
            'items' => $FileModel
        ]);
    }

    public function get_tailieudahuy($type) {
        $FileModel = FileModel::where([
                    ['obj_type', $type],
                    ['deleted_at', null],
                    ['state', DocumentState::reject()]
                ])->orderBy('created_at', 'ASC')->paginate(5);

        return view('Document::Admin/Document/tailieudahuy', [
            'type' => $type,
            'items' => $FileModel
        ]);
    }

    public function get_add($type, Request $request) {
        return view('Document::Pi/Document/add', [
            'type' => $type
        ]);
    }

    public function get_edit($type, $id, Request $request) {
        $FileModel = FileModel::find($id);
        if ($FileModel == null) {
            NotificationService::alertRight('Dữ liệu không có thực.', 'danger');
            return redirect()->route('mdle_doc_index', $type);
        }

        return view('Document::Pi/Document/add', [
            'type' => $type,
            'item' => $FileModel
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
            $FileModel->id_user = \App\Bcore\Services\UserService::id();
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
        $FileModel->state = $request->input('state');

        $FileModel->id_category = $request->input('id_category');

        $FileModel->seo_description = $request->input('seo_description');
        $FileModel->seo_keywords = $request->input('seo_keywords');
        $FileModel->seo_title = $request->input('seo_title');

        $r = $FileModel->save();

        if ($r) {
            event(new AfterSendRequestFileDoc($FileModel, \App\Bcore\Services\UserService::db_info()));
            NotificationService::alertRight('Cập nhật thành công.', 'success');
        } else {
            NotificationService::alertRight('Cập nhật không thành công, vui lòng thử lại.'
                    . '', 'danger');
        }

        responseArea:
        return redirect()->route('mdle_doc_index', $type);
    }

    public function ajax($type, Request $request) {
        $act = $request->input('act');
        switch ($act) {
            case 'dd':
                return $this->doc_detail($request);
            case '60ffe9ee2b97ce26b86e97f365882ae1': // Approve
                return $this->approve($request);
            case '6bfaf02d9f3b165809fb7f056665a6bd': // Reject
                return $this->reject($request);
            default: return response()->json();
        }
    }

    private function approve($request) {
        $document_id = $request->input('id');

        $FileModel = FileModel::find($document_id);
        if ($FileModel == null) {
            $JsonResponse = AjaxResponse::dataNotFound();
        }

        if (!UserServiceV2::isLoggedIn(UserType::admin())) {
            $JsonResponse = AjaxResponse::not_logged_in();
            goto responseArea;
        }

        if ($this->change_document_state($FileModel, DocumentState::approve())) {
            $JsonResponse = AjaxResponse::success();
            // Event
        } else {
            $JsonResponse = AjaxResponse::fail();
        }

        responseArea:
        return response()->json($JsonResponse);
    }

    private function reject($request) {
        $document_id = $request->input('id');

        $FileModel = FileModel::find($document_id);
        if ($FileModel == null) {
            $JsonResponse = AjaxResponse::dataNotFound();
            goto responseArea;
        }

        if (!UserService::isAdmin()) {
            $JsonResponse = AjaxResponse::not_logged_in();
            goto responseArea;
        }

        if ($this->change_document_state($FileModel, DocumentState::reject())) {
            $JsonResponse = AjaxResponse::success($FileModel);
            // Event
        } else {
            $JsonResponse = AjaxResponse::fail();
        }

        responseArea:
        return response()->json($JsonResponse);
    }

    private function change_document_state(FileModel $FileModel, $state) {
        switch ($state) {
            case DocumentState::approve():
                $FileModel->state = DocumentState::approve();
                $FileModel->changed_by = UserService::id();
                $FileModel->approved_date = Carbon::now();
                break;
            case 'reject':
                $FileModel->state = DocumentState::reject();
                $FileModel->changed_by = UserService::id();
                break;
            case 'pending':
                $FileModel->state = DocumentState::pending();
                $FileModel->changed_by = UserService::id();
                break;
            case 'free':
                $FileModel->state = DocumentState::free();
                $FileModel->changed_by = null;
                $FileModel->approved_date = null;
                break;
            default:
        }
        return $FileModel->save();
    }

    private function doc_detail($request) {
        $id = $request->input('id');
        $FileModel = FileModel::find($id);
        if ($FileModel == null) {
            $JsonResponse = \App\Bcore\System\AjaxResponse::dataNotFound();
            goto responseArea;
        }

        $JsonResponse = \App\Bcore\System\AjaxResponse::success([
                    'view' => view('Document::Admin/Document/components/doc_detail', ['item' => $FileModel])->render()
        ]);
        responseArea:
        return response()->json($JsonResponse);
    }

}
