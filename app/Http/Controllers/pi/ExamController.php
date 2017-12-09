<?php

namespace App\Http\Controllers\pi;

use Illuminate\Http\Request;
use App\Http\Controllers\ProfessorController;
use View,
    DB;
use CategoryModel,
    ExamModel,
    PhotoModel,
    FileModel;
use StorageService,
    ImageService,
    FileService;
use Carbon\Carbon,
    Session,
    Illuminate\Support\Facades\Config;

class ExamController extends ProfessorController {

    public $storage_folder = 'exam';
    public $ControllerName = 'Exam';
    public $StorageGoogle = null;

    use \App\Functions\AdminFunction;

    public function __construct() {
        parent::__construct($this->ControllerName);

        $this->sendDataToView(array(
            'route_ajax' => 'pi_exam_ajax'
        ));
        // ----- Lấy nơi lưu trữ trên google ---------------------------------------------------------------------------
        $this->StorageGoogle = Config::get('Bcore.storage_service.google_drive.GOOGLE_DRIVE_FOLDER_EXAM');
        View::share('_ControllerName', $this->ControllerName);
    }

    public function get_index() {
        if (session::has("user.$this->ControllerName.m1_exam.display_count")) {
            $PERPAGE = session::get("user.$this->ControllerName.m1_exam.display_count");
        } else {
            $PERPAGE = 5;
        }
        $this->DVController = $this->registerDVC($this->ControllerName);
        $ExamModel = new ExamModel();
        $ExamModel->set_deleted(1);
        $ExamModel->set_perPage($PERPAGE);
        $ExamModel->set_where([['id_user', '=', session('user')['id']]]);
        $LST_EXAM = $ExamModel->db_get_items();
        // Lấy danh sách ID trong list models
        if (count($LST_EXAM) != 0) {
            $ListExamId = $this->get_arrayIdFromModel($LST_EXAM);
            // Tạo mới đối tượng
            $PhotoModel = new PhotoModel();
            $items_photo = $PhotoModel
                    ->set_type('photo')
                    ->set_table('m1_exam')
                    ->set_whereIn([
                        ['obj_id', $ListExamId]
                    ])
                    ->set_deleted(1)
                    ->set_orderBy(['id', 'DESC'])
                    ->db_getPhoto('photo', 'm1_exam');

            $items_photo = $PhotoModel->db_groupIdPhoto($items_photo);
            $ImageService = new ImageService();
            $items_photo = $ImageService->convertModelsToURL($items_photo, $ListExamId);
        } else {
            $items_photo = null;
        }


        return view($this->_RV . 'exam/index', [
            'items' => $LST_EXAM,
            'items_photo' => $items_photo,
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
        $this->DVController = $this->registerDVC($this->ControllerName);
        // ----- Load danh mục cấp 1 -----------------------------------------------------------------------------------
        $CategoryModel = new CategoryModel();
        $CategoryModel->set_where([['categories.id_category', '=', null]]);
        $CategoryModel->set_perPage(-1);
        $CategoryModel->set_orderBy(['ordinal_number', 'ASC']); // Sort theo stt
        $CategoryModel->set_deleted(1); // 1: Danh mục chưa xóa, 0: Danh mục chưa xóa & đã xóa, -1: Danh mục đã xóa
        $CategoryModel->set_lang(1);
        $LST_CATE = $CategoryModel->db_get_items('hoctap');

        return view($this->_RV . 'exam/add', [
            'cates' => $LST_CATE
        ]);
    }

    function secondToTime($seconds) {
        $t = round($seconds);
        $r = sprintf('%02d:%02d:%02d', ($t / 3600), ($t / 60 % 60), $t % 60);
        return explode(':', $r);
    }

    public function get_edit($pId, Request $request) {
        $this->DVController = $this->registerDVC($this->ControllerName);
        if ($pId == null) {
            $request->session()->flash('message_type', 'error');
            $request->session()->flash('message', __('message.dulieukhongcothuc'));
            return redirect()->route('pi_exam_index');
        }

        // ----- Load thông tin exam -----------------------------------------------------------------------------------

        $ExamModel = ExamModel::find($pId);
        if ($ExamModel == null) {
            $request->session()->flash('message_type', 'error');
            $request->session()->flash('message', __('message.dulieukhongcothuc'));
            return redirect()->route('pi_exam_index');
        }
        if ($ExamModel->approved_by == -1) {
            $request->session()->flash('message_type', 'error');
            $request->session()->flash('message', __('schools.baithinaydabituchoi'));
            return redirect()->route('pi_exam_index');
        }
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
        $CategoryModel = new CategoryModel();
        $CategoryModel->set_where([['categories.id_category', '=', null]]);
        $CategoryModel->set_perPage(-1);
        $CategoryModel->set_orderBy(['ordinal_number', 'ASC']); // Sort theo stt
        $CategoryModel->set_deleted(1); // 1: Danh mục chưa xóa, 0: Danh mục chưa xóa & đã xóa, -1: Danh mục đã xóa
        $CategoryModel->set_lang(1);
        $LST_CATE = $CategoryModel->db_get_items('hoctap');

        // Load photo
        $PhotoModel = new PhotoModel();
        $ImageService = new ImageService();
        // Get hình ảnh photo từ database
        $item_photo = $PhotoModel->get_photo($ExamModel->id, 'm1_exam', 'photo');
        $ExamModel->photo_url = $ImageService->convertModelToURL($item_photo, 300, 300);

        $FileModel = new FileModel();
        $FileService = new FileService();

        $item_pdf = $FileModel->get_file($ExamModel->id, 'm1_exam', 'document');
        if ($item_pdf != null) {
            $item_pdf->sub_dir = 'documents';
        }

        //$urlEncode = $item_pdf->dir_name . '|documents|' . $item_pdf->url;

        $ExamModel->file_pdf = $FileService->convertModelToURL($item_pdf);
        return view($this->_RV . 'exam/add', [
            'item' => $ExamModel,
            'items' => $ExamDetailModel,
            'cates' => $LST_CATE
        ]);
    }

    public function post_save(Request $request) {

        if (!$request->has('question_count')) {
            $request->session()->flash('message_type', 'error');
            $request->session()->flash('message', __('message.coloixayratrongquatrinhxuly'));
            goto resultArea;
        }

        // ----- Check err ---------------------------------------------------------------------------------------------
        if (!isset(session('user')['id'])) {
            $request->session()->flash('message_type', 'error');
            $request->session()->flash('message', __('message.loitaikhoan'));
            goto resultArea;
        }
        if (!$request->has('id_category2')) {
            $request->session()->flash('message_type', 'error');
            $request->session()->flash('message', __('message.chuachondanhmuc'));
            return redirect()->back()->withInput();
        }
        if (!$request->input('id_category2') == -1) {
            $request->session()->flash('message_type', 'error');
            $request->session()->flash('message', __('message.chuachondanhmuc'));
            return redirect()->back()->withInput();
        }

        if ($request->input('name') == null) {
            $request->session()->flash('message_type', 'warning');
            $request->session()->flash('message', __('message.vuilongnhapten'));
            return redirect()->back()->withInput();
        }

        // ----- Time access -------------------------------------------------------------------------------------------
        if (!$request->has('time_h') || !$request->has('time_m') || !$request->has('time_s')) {
            $request->session()->flash('message_type', 'error');
            $request->session()->flash('message', __('message.loithoigian'));
            goto resultArea;
        }

        $question_count = (int) $request->input('question_count');
        if (!is_numeric($question_count)) {
            $request->session()->flash('message_type', 'error');
            $request->session()->flash('message', __('message.coloixayratrongquatrinhxuly'));
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
                    goto resultArea;
                }
            }

            $FILE_EXTENSION = explode(',', $this->_SETTING->type_document);
            if (!in_array($pdf->getClientOriginalExtension(), $FILE_EXTENSION)) {
                $request->session()->flash('message_type', 'error');
                $request->session()->flash('message', __('message.khonghotrodinhdangnay'));
                goto resultArea;
            }

            if ($pdf->getType() != 'file') {
                $request->session()->flash('message_type', 'error');
                $request->session()->flash('message', __('message.chiduocuploadfile'));
                goto resultArea;
            }
        } else {
            $request->session()->flash('message_type', 'error');
            $request->session()->flash('message', __('message.vuilongchonfile'));
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
                    goto resultArea;
                }
            }

            $FILE_EXTENSION = explode(',', $this->_SETTING->type_photo);
            if (!in_array($photo->getClientOriginalExtension(), $FILE_EXTENSION)) {
                $request->session()->flash('message_type', 'error');
                $request->session()->flash('message', __('message.khonghotrodinhdangnay'));
                goto resultArea;
            }

            if ($photo->getType() != 'file') {
                $request->session()->flash('message_type', 'error');
                $request->session()->flash('message', __('message.chiduocuploadfile'));
                goto resultArea;
            }
        }

        $request->question_count = $question_count;

        if ($request->input('id') != null) {
            // ----- EDIT ----------------------------------------------------------------------------------------------
            $ExamModel = ExamModel::find($request->input('id'));
        } else {
            // ----- ADD -----------------------------------------------------------------------------------------------
            $ExamModel = new ExamModel();
            $ExamModel->id_user = session('user')['id'];
        }

        $ExamModel->id_category = $request->input('id_category2');
        $ExamModel->name = $request->input('name');
        $ExamModel->time = (int) ($request->input('time_h') * 60 * 60) + (int) ($request->input('time_m') * 60) + (int) $request->input('time_s');
        $ExamModel->views = 0;
        $ExamModel->name_meta = str_slug($request->input('name'), '-');
        $ExamModel->description = $request->input('description');

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

        // ----- UPLOAD FILE PDF ---------------------------------------------------------------------------------------

        _____UPLOAD_PDF_____:

        if (!$request->hasFile('file_pdf')) {
            $pdf = $request->file_pdf;
            $StorageService = new StorageService();
            $filename = 'file_' . md5(Carbon::now() . $pdf->getClientOriginalName()) . '.' . $pdf->extension();
            // ----- Upload SV -----------------------------------------------------------------------------------------
            uploadPDFLocalStorageArea:
            $LocalPath = $StorageService->upload_file('public', $filename, $pdf, $this->storage_folder . '/documents');
            if ($LocalPath != null) {
                if ($this->_SETTING_ACCOUNT['google-drive']->active) {
                    goto uploadPDFToGoogleStorageArea;
                } else {
                    goto skip_uploadPDFToGoogleStorageArea;
                }
            }

            uploadPDFToGoogleStorageArea:
            $FolderGooglePath = $StorageService->createFolderIfNotExitst('google', $this->storage_folder);
            if ($FolderGooglePath == null) {
                // Write log... (Không thể upload lên google drive vì folder không tồn tại & không được khởi tạo
            } else {
                $StorageService->setParentFolder($FolderGooglePath);
                $FileGooglePath = $StorageService
                        ->upload_file('google', $filename, file_get_contents($pdf->path()));
            }
            skip_uploadPDFToGoogleStorageArea:

            _____SAVE_PDF_MODEL_____:
            if ($LocalPath != null) {
                $FileModel = new FileModel();
                $FileModel->obj_id = $ExamModel->id;
                $FileModel->obj_table = 'm1_exam';
                $FileModel->obj_type = 'document';
                $FileModel->dir_name = $this->storage_folder;
                $FileModel->mimetype = $pdf->getMimetype();
                $FileModel->size = $pdf->getSize();
                $FileModel->url = $filename;
                $FileModel->url_encode = md5($filename);
                $FileModel->sync_google = json_encode($FileGooglePath);
                $FileModel->name = $pdf->getClientOriginalName();
                $FileModel->id_user = session('user')['id'];
                $PDFUploaded = $FileModel->save();
                if ($PDFUploaded) {
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
        _____SKIP_UPLOAD_PDF_____:

        // ----- UPLOAD PHOTO ------------------------------------------------------------------------------------------
        _____UPLOAD_PHOTO_____:
        if ($request->hasFile('photo')) {
            $photo = $request->photo;
            $StorageService = new StorageService();
            $filename = 'photo_' . md5(Carbon::now() . $photo->getClientOriginalName()) . '.' . $photo->extension();
            // ----- Upload SV -----------------------------------------------------------------------------------------

            uploadLocalStorageArea:
            $LocalPath = $StorageService->upload_file('public', $filename, $photo, $this->storage_folder);
            if ($LocalPath != null) {
                if ($this->_SETTING_ACCOUNT['google-drive']->active) {
                    goto _____UPLOAD_PHOTO_SYNC_GOOGLE_____;
                } else {
                    goto _____SKIP_UPLOAD_PHOTO_SYNC_GOOGLE_____;
                }
            }

            _____UPLOAD_PHOTO_SYNC_GOOGLE_____:
            $FolderGooglePath = $StorageService->createFolderIfNotExitst('google', $this->storage_folder);
            if ($FolderGooglePath == null) {
                // Write log... (Không thể upload lên google drive vì folder không tồn tại & không được khởi tạo
            } else {
                $StorageService->setParentFolder($FolderGooglePath);
                $FileGooglePath = $StorageService
                        ->upload_file('google', $filename, file_get_contents($photo->path()));
            }
            _____SKIP_UPLOAD_PHOTO_SYNC_GOOGLE_____:

            _____SAVE_PHOTO_MODEL_____:
            if ($LocalPath != null) {
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
                if ($PhotoUploaded) {
                    if ($PhotoModel->db_deletedPhoto($ExamModel->id, $PhotoModel->id, 'm1_exam', 'photo')) {
                        // Xóa thành công!
                    } else {
                        // Xóa không thành công => write log
                    }
                } else {
                    // Không thể lưu vào database
                    // Write log, xóa hình đã up...
                }
            }
            _____SKIP_SAVE_PHOTO_MODEL_____:
        }
        _____SKIP_UPLOAD_PHOTO_____:

        ChildAccessArea:

        if ($request->has('id')) {
            $this->save_edit($ExamModel->id, $request);
        } else {
            $this->save_add($ExamModel->id, $request);
        }

        resultArea:
        return redirect()->route('pi_exam_index');
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

}
