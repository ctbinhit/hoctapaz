<?php

namespace App\Modules\OnlineCourse\Controllers\Pi;

use App\Bcore\PackageServicePI;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfessorController;
use View,
    DB;
use CategoryModel,
    App\Modules\OnlineCourse\Models\ExamModel,
    PhotoModel,
    FileModel;
use StorageService,
    ImageService,
    FileService,
    App\Bcore\Services\UserService;
use App\Modules\OnlineCourse\Components\ExamState;
use Carbon\Carbon,
    Session,
    Illuminate\Support\Facades\Config;
use App\Bcore\System\AjaxResponse;
use App\Bcore\Services\NotificationService;
use App\Bcore\Services\UserServiceV2;
use App\Bcore\System\UserType;

class ExamController extends PackageServicePI {

    public $module_name = 'OnlineCourse';
    public $dir = 'Pi';
    public $storage_folder = 'exam';
    public $ControllerName = 'Exam';
    public $StorageGoogle = null;
    private $MODE_FASTBOOT = true;

    use \App\Functions\AdminFunction;

    public function __construct() {
        parent::__construct($this->ControllerName);

//        $this->sendDataToView(array(
//            'route_ajax' => 'pi_exam_ajax'
//        ));
        // ----- Lấy nơi lưu trữ trên google ---------------------------------------------------------------------------
        $this->StorageGoogle = Config::get('Bcore.storage_service.google_drive.GOOGLE_DRIVE_FOLDER_EXAM');
        View::share('_ControllerName', $this->ControllerName);
    }

    public function get_index(Request $request) {
        $this->DVController = $this->registerDVC($this->ControllerName);
        $ExamModel = ExamModel::where([
                    ['id_user', UserServiceV2::current_userId(UserType::professor())],
                    ['state', ExamState::free()],
                    ['deleted_at', null]
                ])->paginate(5);

        return view('OnlineCourse::Pi/exam/index', [
            'items' => $ExamModel,
            'tbl' => 'm1_exam',
        ]);
    }

    public function get_app_phongthi(Request $request) {
        $this->DVController = $this->registerDVC($this->ControllerName);
        $ExamModel = ExamModel::where([
                    ['id_user',  UserServiceV2::current_userId(UserType::professor())],
                    ['state', ExamState::de_thi()],
                    ['deleted_at', null]
                ])->paginate(5);

        return view('OnlineCourse::Pi/exam/app_phongthi', [
            'items' => $ExamModel,
            'tbl' => 'm1_exam',
        ]);
    }

    public function get_app_dethithu(Request $request) {
        $this->DVController = $this->registerDVC($this->ControllerName);
        $ExamModel = ExamModel::where([
                    ['id_user',  UserServiceV2::current_userId(UserType::professor())],
                    ['state', ExamState::thi_thu()],
                    ['deleted_at', null]
                ])->paginate(5);

        return view('OnlineCourse::Pi/exam/app_dethithu', [
            'items' => $ExamModel,
            'tbl' => 'm1_exam',
        ]);
    }

    public function get_app_tracnghiem(Request $request) {
        $this->DVController = $this->registerDVC($this->ControllerName);
        $ExamModel = ExamModel::where([
                    ['id_user', UserService::id()],
                    ['state', ExamState::trac_nghiem_online()],
                    ['deleted_at', null]
                ])->paginate(5);

        return view('OnlineCourse::Pi/exam/app_tracnghiem', [
            'items' => $ExamModel,
            'tbl' => 'm1_exam',
        ]);
    }

    public function get_reject(Request $request) {
        $this->DVController = $this->registerDVC($this->ControllerName);
        $ExamModel = new ExamModel();
        $ExamModel->set_deleted(1)
                ->set_perPage(10)
                ->set_where([['id_user', '=', \App\Bcore\Services\UserService::id()], ['state', '=', -1]])
                ->set_keywords($request->input('keywords'))
                ->execute();
        return view('OnlineCourse::Pi/exam/reject', [
            'items' => $ExamModel->data(),
            'tbl' => 'm1_exam'
        ]);
    }

    public function post_index(Request $request) {
        if (!$request->has('tbl')) {
            $request->session()->flash('message_type', 'error');
            $request->session()->flash('message', __('message.coloixayratrongquatrinhxuly'));
            goto resultArea;
        }
        $tbl = $request->input('tbl');
        // ----- Thay đổi display count/length -------------------------------------------------------------------------
        if ($request->has('display_count')) {
            $dc = (int) $request->input('display_count');
            if (is_numeric($dc)) {
                // Set session
                session::put("user.$this->ControllerName.$tbl.display_count", $dc);
            }
        }
        resultArea:
        return redirect()->route('pi_exam_index');
    }

    public function get_user($examId = null, Request $request) {
        if ($examId == null) {
            $request->session()->flash('message_type', 'error');
            $request->session()->flash('message', __('message.coloixayratrongquatrinhxuly'));
            return redirect()->route('pi_exam_index');
        }
        $Model = ExamModel::find($examId);
        if ($Model == null) {
            $request->session()->flash('message_type', 'error');
            $request->session()->flash('message', __('message.dulieukhongcothuc'));
            return redirect()->route('pi_exam_index');
        }




        return view($this->_RV . 'exam/user');
    }

    public function get_recycle() {
        if (session::has("user.$this->ControllerName.m1_exam.display_count")) {
            $PERPAGE = session::get("user.$this->ControllerName.m1_exam.display_count");
        } else {
            $PERPAGE = 5;
        }
        $this->DVController = $this->registerDVC($this->ControllerName);
        $ExamModel = new ExamModel();
        $ExamModel->set_deleted(-1);
        $ExamModel->set_perPage($PERPAGE);
        $ExamModel->set_where([['id_user', '=', session('user')['id']]]);
        $LST_EXAM = $ExamModel->db_get_items();
        return view($this->_RV . 'exam/recycle', [
            'items' => $LST_EXAM,
            'tbl' => 'm1_exam',
            'template_recycle' => true,
        ]);
    }

    public function post_recycle(Request $request) {
        if (!$request->has('tbl')) {
            $request->session()->flash('message_type', 'error');
            $request->session()->flash('message', __('message.coloixayratrongquatrinhxuly'));
            goto resultArea;
        }
        $tbl = $request->input('tbl');
        // ----- Thay đổi display count/length -------------------------------------------------------------------------
        if ($request->has('display_count')) {
            $dc = (int) $request->input('display_count');
            if (is_numeric($dc)) {
                // Set session
                session::put("user.$this->ControllerName.$tbl.display_count", $dc);
            }
        }
        resultArea:
        return redirect()->route('pi_exam_recycle');
    }

    public function get_add() {
        $HTML_Categories = \App\Bcore\Services\CategoryService::html_selectCategories('hoctap', 'exam');
        $this->DVController = $this->registerDVC($this->ControllerName);
        // ----- Load danh mục cấp 1 -----------------------------------------------------------------------------------
        $CategoryModel = new CategoryModel();
        $CategoryModel->set_where([['categories.id_category', '=', null]]);
        $CategoryModel->set_perPage(-1);
        $CategoryModel->set_orderBy(['ordinal_number', 'ASC']); // Sort theo stt
        $CategoryModel->set_deleted(1); // 1: Danh mục chưa xóa, 0: Danh mục chưa xóa & đã xóa, -1: Danh mục đã xóa
        $CategoryModel->set_lang(1);
        $LST_CATE = $CategoryModel->db_get_items('hoctap');

        return view("OnlineCourse::Pi/exam/add", [
            'cates' => $LST_CATE,
            'categories' => $HTML_Categories
        ]);
    }

    function secondToTime($seconds) {
        $t = round($seconds);
        $r = sprintf('%02d:%02d:%02d', ($t / 3600), ($t / 60 % 60), $t % 60);
        return explode(':', $r);
    }

    private function get_categoryLv1() {
        $CategoryModel = new CategoryModel();
        $CategoryModel->set_where([['categories.id_category', '=', null]]);
        $CategoryModel->set_perPage(-1);
        $CategoryModel->set_orderBy(['ordinal_number', 'ASC']); // Sort theo stt
        $CategoryModel->set_deleted(1); // 1: Danh mục chưa xóa, 0: Danh mục chưa xóa & đã xóa, -1: Danh mục đã xóa
        $CategoryModel->set_lang(1);
        return $CategoryModel->db_get_items('hoctap');
    }

    public function get_edit($pId, Request $request) {
        $HTML_Categories = \App\Bcore\Services\CategoryService::html_selectCategories('hoctap', 'exam');
        $this->DVController = $this->registerDVC($this->ControllerName);
        // ----- Load thông tin exam -----------------------------------------------------------------------------------
        $ExamModel = ExamModel::find($pId);
        if ($ExamModel == null) {
            \App\Bcore\Services\NotificationService::alertRight('Dữ liệu không có thực!', 'danger');
            return redirect()->route('mdle_oc_pi_exam_index');
        }
//        if ($ExamModel->approved_by == -1) {
//            $request->session()->flash('message_type', 'error');
//            $request->session()->flash('message', __('schools.baithinaydabituchoi'));
//            return redirect()->route('mdle_oc_pi_exam_index');
//        }
        $tmp_time = is_numeric((int) $ExamModel->time) ? (int) $ExamModel->time : 2700;
        $time = $this->secondToTime($tmp_time);
        $ExamModel->time_h = $time[0];
        $ExamModel->time_m = $time[1];
        $ExamModel->time_s = $time[2];
        // Load chi tiết bài thi
        $ExamDetailModel = $ExamModel->db_rela_detail;

        // Load thông tin danh mục
        $CategoryModel_TMP = new CategoryModel();
        $CATE_PARENT_ID = $CategoryModel_TMP->db_getParentIdByIdCate($ExamModel->id_category);
        if ($CATE_PARENT_ID != null) {
            $ExamModel->id_category_parent = $CATE_PARENT_ID;
        }

        // Load danh mục cấp 1
        $LST_CATE = $this->get_categoryLv1();

        // Load photo
        $PhotoModel = new PhotoModel();
        $ImageService = new ImageService();
        // Get hình ảnh photo từ database
//        $item_photo = $PhotoModel->get_photo($ExamModel->id, 'm1_exam', 'photo');
//        $ExamModel->photo_url = $ImageService->convertModelToURL($item_photo, 300, 300);


        $FileModel = new FileModel();
        $FileService = new FileService();

        $item_pdf = $FileModel->get_file($ExamModel->id, 'm1_exam', 'document');

        //$ExamModel->file_pdf = $FileService->convertModelToURL($item_pdf);
        return view('OnlineCourse::Pi/exam/add', [
            'item' => $ExamModel,
            'items' => $ExamDetailModel,
            'cates' => $LST_CATE,
            'file_pdf' => $item_pdf,
            'categories' => $HTML_Categories
        ]);
    }

    public function post_save(Request $request) {

        if (!$request->has('question_count')) {
            NotificationService::alertRight('Không tìm thấy danh sách câu trả lời, có lỗi xảy ra trong quá trình tạo bài thi.', 'danger');
            goto resultArea;
        }

        if ($request->input('name') == null) {
            NotificationService::alertRight('Thiếu tên bài thi, vui lòng kiểm tra đầy đủ thông tin trước khi thêm', 'warning');
            return redirect()->back()->withInput();
        }

        // ----- Time access -------------------------------------------------------------------------------------------
        if (!$request->has('time_h') || !$request->has('time_m') || !$request->has('time_s')) {
            NotificationService::alertRight('Có lỗi xảy ra trong quá trình tạo bài thi, vui lòng kiểm tra lại thông tin.', 'warning');
            goto resultArea;
        }

        $question_count = (int) $request->input('question_count');
        if (!is_numeric($question_count)) {
            NotificationService::alertRight('Lỗi định dạng câu hỏi, vui lòng thử lại sau!', 'warning');
            goto resultArea;
        }

        // ----- FILE PDF ----------------------------------------------------------------------------------------------

        if ($request->hasFile('file_pdf')) {
            $pdf = $request->file_pdf;
            $LimitFileSize = $this->_SETTING->limit_document;
            if ($LimitFileSize != null) {
                if ($pdf->getSize() / 1024 > $LimitFileSize) {
                    $request->session()->flash('message_type', 'error');
                    $request->session()->flash('message', __('message.dungluongfilevuotquagioihanchophep'));
                    return back()->withInput();
                }
            }

            $FILE_EXTENSION = explode(',', $this->_SETTING->type_document);
            if (!in_array($pdf->getClientOriginalExtension(), $FILE_EXTENSION)) {
                $request->session()->flash('message_type', 'error');
                $request->session()->flash('message', __('message.khonghotrodinhdangnay'));
                return back()->withInput();
            }

            if ($pdf->getType() != 'file') {
                $request->session()->flash('message_type', 'error');
                $request->session()->flash('message', __('message.chiduocuploadfile'));
                return back()->withInput();
            }
        } else {
            NotificationService::alertRight('File mà bạn upload có vẻ không khả dụng, vui lòng thử lại hoặc báo cáo '
                    . 'quản trị để được khắc phục.', 'warning', 'Lỗi file');
            return redirect()->back()->withInput();
        }

        // ----- FILE --------------------------------------------------------------------------------------------------

        if ($request->hasFile('photo')) {
            $photo = $request->photo;
            // ----- SET LIMIT -----------------------------------------------------------------------------------------
            $ImageSizeLimit = $this->_SETTING->limit_photo;

            // $ImageSizeLimit == null => không giới hạn
            if ($ImageSizeLimit != null) {
                if ($photo->getSize() > $ImageSizeLimit) {
                    $request->session()->flash('message_type', 'error');
                    $request->session()->flash('message', __('message.dungluongfilevuotquagioihanchophep'));
                    return back()->withInput();
                }
            }

            $FILE_EXTENSION = explode(',', $this->_SETTING->type_photo);
            if (!in_array($photo->getClientOriginalExtension(), $FILE_EXTENSION)) {
                $request->session()->flash('message_type', 'error');
                $request->session()->flash('message', __('message.khonghotrodinhdangnay'));
                return back()->withInput();
            }

            if ($photo->getType() != 'file') {
                $request->session()->flash('message_type', 'error');
                $request->session()->flash('message', __('message.chiduocuploadfile'));
                return back()->withInput();
            }
        }

        $request->question_count = $question_count;

        if ($request->input('id') != null) {
            // ----- EDIT ----------------------------------------------------------------------------------------------
            $ExamModel = ExamModel::find($request->input('id'));
        } else {
            // ----- ADD -----------------------------------------------------------------------------------------------
            $ExamModel = new ExamModel();
            $ExamModel->id_user = UserServiceV2::current_userId(\App\Bcore\System\UserType::professor());
        }

        try {
            $ExamModel->id_category = $request->input('id_category');
            $ExamModel->name = $request->input('name');
            $ExamModel->time = (int) ($request->input('time_h') * 60 * 60) + (int) ($request->input('time_m') * 60) + (int) $request->input('time_s');
            $ExamModel->views = 0;
            $ExamModel->name_meta = str_slug($request->input('name'), '-');
            $ExamModel->description = $request->input('description');
            $ExamModel->state = ExamState::free();

            // ----- SEO ---------------------------------------------------------------------------------------------------
            $ExamModel->seo_title = $request->input('seo_title');
            $ExamModel->seo_description = $request->input('seo_description');
            $ExamModel->seo_keywords = $request->input('seo_keywords');



            $r = $ExamModel->save();

            // Insert | Update thành công => Insert | Update ExamDetail
            if (!$r) {
                $request->session()->flash('message_type', 'error');
                $request->session()->flash('message', __('message.coloixayratrongquatrinhxuly'));
                goto resultArea;
            }
        } catch (\Exception $ex) {
            NotificationService::alertRight('Có lỗi xảy ra trong quá trình tạo đề thi, vui lòng kiểm tra lại.', 'danger');
            return $ex->getMessage();
            goto resultArea;
        }

        // ----- UPLOAD FILE PDF ---------------------------------------------------------------------------------------

        uploadPDFArea:

        if ($request->hasFile('file_pdf')) {
            $pdf = $request->file_pdf;

            $StorageServiceV2 = new \App\Bcore\Services\StorageServiceV2();
            $uploaded = $StorageServiceV2->disk('localhost')
                            ->folder($this->storage_folder . '/documents')
                            ->set_file($pdf)->upload();
            if ($uploaded->file_uploaded() != null) {


                if (true) {
                    goto uploadPDFToGoogleStorageArea;
                } else {
                    goto skip_uploadPDFToGoogleStorageArea;
                }
            } else {
                // Upload thất bại
            }

            uploadPDFToGoogleStorageArea:
            $FileGooglePath = $google_uploaded = $uploaded->sync_google('0B76IYXdgtJXfY3RTSWctWUdYcW8');
            if ($google_uploaded != null) {
                $FileGooglePath = json_encode($FileGooglePath);
            }
            skip_uploadPDFToGoogleStorageArea:

            savePDFModelArea:
            if ($uploaded->file_uploaded() != null) {
                $FileModel = new FileModel();
                $FileModel->obj_id = $ExamModel->id;
                $FileModel->obj_table = 'm1_exam';
                $FileModel->obj_type = 'document';
                $FileModel->dir_name = $this->storage_folder;
                $FileModel->mimetype = $pdf->getMimetype();
                $FileModel->size = $pdf->getSize();
                $FileModel->url = $uploaded->file_uploaded_path();
                $FileModel->url_encode = md5($FileModel->url);
                $FileModel->sync_google = @$FileGooglePath;
                $FileModel->name = $pdf->getClientOriginalName();
                $FileModel->id_user = UserServiceV2::current_userId(\App\Bcore\System\UserType::professor());
                $ModelSaved = $FileModel->save();
                if ($ModelSaved) {
                    if ($FileModel->db_deletedDoc($ExamModel->id, $FileModel->id, 'm1_exam', 'document')) {
                        // Xóa thành công!
                    } else {
                        // Xóa không thành công => write log
                    }
                } else {
                    // Không thể lưu vào database
                    // Write log, xóa hình đã up...
                }
            }
        }

        uploadPDFArea_:

        ChildAccessArea:

        if ($request->has('id')) {
            $this->save_edit($ExamModel->id, $request);
        } else {
            $this->save_add($ExamModel->id, $request);
        }

        resultArea:
        return redirect()->route('mdle_oc_pi_exam_index');
    }

    private function upload_photo() {
        $PhotoModel = new PhotoModel();
        $PhotoModel->obj_id = $ExamModel->id;
        $PhotoModel->obj_table = 'm1_exam';
        $PhotoModel->obj_type = 'photo';
        $PhotoModel->dir_name = $this->storage_folder;
        $PhotoModel->mimetype = $request->file('photo')->getMimetype();
        $PhotoModel->size = $request->file('photo')->getSize();
        $PhotoModel->url = $filename;
        $PhotoModel->url_encode = md5($filename);
        $PhotoModel->sync_google = json_encode($FileGooglePath);
        $PhotoModel->name = $photo->getClientOriginalName();
        $PhotoModel->id_user = session('user')['id'];
        $PhotoUploaded = $PhotoModel->save();
    }

    public function ajax_(Request $request) {
        $data = null;
        $result = false;
        $message = null;
        if ($request->has('action')) {
            switch ($request->input('action')) {
                case 'loadCate2':
                    if ($request->has('id')) {
                        // Load danh mục cấp 1
                        $CategoryModel = new CategoryModel();
                        $CategoryModel->set_where([['categories.id_category', '=', $request->input('id')]]);
                        $CategoryModel->set_perPage(-1);
                        $CategoryModel->set_orderBy(['ordinal_number', 'ASC']); // Sort theo stt
                        $CategoryModel->set_deleted(1); // 1: Danh mục chưa xóa, 0: Danh mục chưa xóa & đã xóa, -1: Danh mục đã xóa
                        $CategoryModel->set_lang(1);
                        $LST_CATE = $CategoryModel->db_get_items('hoctap');
                        $data = $LST_CATE;
                        $result = true;
                        $message = __('message.themthanhcong');
                        goto resultArea;
                    }

                    break;
                default:
            }
        }

        resultArea:
        return response()->json([
                    'data' => $data,
                    'result' => $result,
                    'message' => $message,
        ]);
    }

    // ===== PROTECTED FUNCTIONS =======================================================================================
    //                                                  Đang cập nhật...
    // ===== PRIVATE FUNCTIONS =========================================================================================


    private function save_add($pIdExam, $request = null) {
        if ($request == null || $pIdExam == null) {
            return -1;
        }
        $EXAM_ID = $pIdExam;
        $ModelQuestion = [];
        for ($i = 1; $i <= (int) $request->question_count; $i++) {
            if ($request->has("question$i")) {
                if ((int) is_numeric($request->input("question$i"))) {
                    $Model = [
                        'id_exam' => $EXAM_ID,
                        'result' => $request->input("question$i")
                    ];
                    $ModelQuestion[] = $Model;
                } else {
                    // Kết quả # số nguyên => err
                }
            } else {
                // Err, thiếu câu hỏi i
            }
        }
        if (count($ModelQuestion) != 0) {
            
        } else {
            // Thêm câu hỏi thất bại...
            $request->session()->flash('message_type', 'error');
            $request->session()->flash('message', __('message.coloixayratrongquatrinhxuly'));
            goto resultArea;
        }
        $r = DB::table('m1_exam_detail')->insert($ModelQuestion);

        if ($r) {
            // Thành công
            $request->session()->flash('message', __('message.themthanhcong'));
            goto resultArea;
        } else {
            $ExamModel_TMP = ExamModel::find($EXAM_ID);
            if ($ExamModel_TMP != null) {
                $r = $ExamModel_TMP->delete();
            }
            if ($r) {
                // Giải phóng bộ nhớ thành công
                echo "Giải phóng bộ nhớ thành công!";
            } else {
                echo "Giải phóng bộ nhớ không thành công!";
            }
            $request->session()->flash('message_type', 'error');
            $request->session()->flash('message', __('message.coloixayratrongquatrinhxuly'));
        }
        resultArea:
        //////////////////////////////////////// 
    }

    private function save_edit($pIdExam, $request = null) {
        if ($request == null) {
            return null;
        }
        $request->session()->flash('message', __('message.capnhatthanhcong'));
    }

    public function ajax(Request $request) {
        $act = $request->input('act');
        switch ($act) {
            case '779b01b6ac7f4d64459a3e1f52c0e90f': return $this->remove_item($request);
            case 'e1e9130e17e60b2dce990bea6bb0c5da': return $this->create_examOnlineMode($request); //Mode 1
            case '5efd453f68aac1ffc4156e76a7aebdfa': return $this->create_examCustomMode($request); //Mode 2
            case 'c98b5521a0f9123f84e93c16a12b5b2c': return $this->create_examTestMode($request); //Mode 3
        }
    }

    private function create_examOnlineMode($request) {
        $id_exam = $request->input('id');
        $ExamModel = ExamModel::find($id_exam);
        if ($ExamModel == null) {
            $JsonResponse = AjaxResponse::dataNotFound();
            goto responseArea;
        }

        $ExamModel->state = ExamState::de_thi();
        if ($ExamModel->save()) {
            $JsonResponse = AjaxResponse::success();
        } else {
            $JsonResponse = AjaxResponse::fail();
        }

        responseArea:
        return response()->json($JsonResponse);
    }

    private function create_examTestMode($request) {
        $id_exam = $request->input('id');
        $ExamModel = ExamModel::find($id_exam);
        if ($ExamModel == null) {
            $JsonResponse = AjaxResponse::dataNotFound();
            goto responseArea;
        }

        $ExamModel->state = ExamState::thi_thu();
        if ($ExamModel->save()) {
            $JsonResponse = AjaxResponse::success();
        } else {
            $JsonResponse = AjaxResponse::fail();
        }

        responseArea:
        return response()->json($JsonResponse);
    }

    private function create_examCustomMode($request) {
        $id_exam = $request->input('id');
        $ExamModel = ExamModel::find($id_exam);
        if ($ExamModel == null) {
            $JsonResponse = AjaxResponse::dataNotFound();
            goto responseArea;
        }

        $ExamModel->state = ExamState::trac_nghiem_online();
        if ($ExamModel->save()) {
            $JsonResponse = AjaxResponse::success();
        } else {
            $JsonResponse = AjaxResponse::fail();
        }

        responseArea:
        return response()->json($JsonResponse);
    }

    private function remove_item($request) {
        $ExamModel = ExamModel::find($request->input('id'));
        if ($ExamModel == null) {
            $JsonResponse = AjaxResponse::dataNotFound();
            goto responseArea;
        }
        $ExamModel->deleted_at = Carbon::now();
        if ($ExamModel->save()) {
            $JsonResponse = AjaxResponse::success();
        } else {
            $JsonResponse = AjaxResponse::fail();
        }
        responseArea:
        return response()->json($JsonResponse);
    }

}
