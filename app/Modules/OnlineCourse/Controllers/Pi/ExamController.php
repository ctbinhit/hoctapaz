<?php

namespace App\Modules\OnlineCourse\Controllers\Pi;

use DB;
use View;
use Session;
use FileService;
use Carbon\Carbon;
use App\Models\FileModel;
use App\Models\PhotoModel;
use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Bcore\PackageServicePI;
use App\Bcore\System\AjaxResponse;
use App\Bcore\Services\UserService;
use App\Bcore\Services\UserServiceV2;
use App\Bcore\Services\UserServiceV3;
use App\Bcore\Services\SearchService;
use Illuminate\Support\Facades\Config;
use App\Bcore\Services\NotificationService;
use App\Modules\OnlineCourse\App\ExamBuilder;
use App\Bcore\SystemComponents\User\UserType;
use App\Modules\OnlineCourse\Models\ExamModel;
use App\Modules\OnlineCourse\Components\ExamState;
use App\Modules\OnlineCourse\Models\ExamRegisteredModel;

class ExamController extends PackageServicePI {

    public $module_name = 'OnlineCourse';
    public $dir = 'Pi';
    public $storage_folder = 'exam';
    public $ControllerName = 'Exam';
    public $StorageGoogle = null;
    private $MODE_FASTBOOT = true;
    // PRIVATE VARIABLES
    private $_ExamModel = null;

    use \App\Functions\AdminFunction;

    public function __construct() {
        parent::__construct($this->ControllerName);




        // ----- Lấy nơi lưu trữ trên google ---------------------------------------------------------------------------
        $this->StorageGoogle = Config::get('Bcore.storage_service.google_drive.GOOGLE_DRIVE_FOLDER_EXAM');
        View::share('_ControllerName', $this->ControllerName);

        $this->middleware(function ($request, $next) {
            $this->load_userSession();
            return $next($request);
        });
    }

    public function get_index() {
        $this->DVController = $this->registerDVC($this->ControllerName);
        $ExamRegistered = ExamRegisteredModel::where([
                    ['id_user', $this->current_user->id]
                ])->select('id', 'id_exam')->get();
        $ArrayIdAppRegistered = collect($ExamRegistered->pluck('id_exam'));

        $ExamModel = ExamModel::where([
                    ['id_user', UserServiceV2::current_userId(UserType::professor())],
                    ['state', ExamState::free()],
                    ['deleted_at', null]
                ])
                ->whereNotIn('id', $ArrayIdAppRegistered)
                ->orderBy('id', 'DESC')
                ->paginate(5);
       
        return view('OnlineCourse::Pi/exam/index', [
            'items' => $ExamModel,
            'tbl' => 'm1_exam',
        ]);
    }

    public function get_exam_score($id_exam, Request $request) {
        $SearchService = (new SearchService(['keyword', 'seb', 'orn', 'orv'], $request));
        $searchEngine = [
            'sortBy' => [['fullname', 'Họ và tên'], ['email', 'Email']],
            'orderBy' => [
                'name' => [['created_at', 'Ngày thi'], ['score', 'Điểm số'], ['time_end', 'Thời gian']],
                'value' => [['asc', 'Tăng dần | Cữ nhất'], ['DESC', 'Giảm dần | Mới nhất']]
            ]
        ];

        $ExamDetail = ExamModel::find($id_exam);
        if ($ExamDetail == null) {
            return 'Dữ liệu không có thực.';
        }
        $ExamUserModel = DB::table('m1_exam_user')
                ->join('users', 'users.id', '=', 'm1_exam_user.id_user')
                ->join('m1_exam', 'm1_exam.id', '=', 'm1_exam_user.id_exam')
                ->where([
                    ['m1_exam_user.type', 'de-thi'],
                    ['m1_exam_user.id_exam', $id_exam]
                ])
                ->select([
            'm1_exam_user.id', 'm1_exam_user.code', 'm1_exam_user.score', 'm1_exam_user.time_in', 'm1_exam_user.time_end',
            'm1_exam_user.time_out', 'm1_exam_user.type', 'm1_exam_user.created_at',
            'm1_exam.name', 'm1_exam.name_meta', 'm1_exam_user.id_user', 'm1_exam.id as id_exam', 'm1_exam.time as exam_time',
            'users.fullname', 'users.id as id_user', 'users.email'
        ]);

        if ($request->has('keyword')) {
            $keyword = $request->input('keyword');
            $search_by = $request->has('seb') ? $request->input('seb') : '';
            switch ($search_by) {
                case 'email':
                    $ExamUserModel->where('users.email', 'LIKE', "%$keyword%");
                    break;
                default:
                    $ExamUserModel->where('users.fullname', 'LIKE', "%$keyword%");
            }
        }

        if ($request->has('orn')) {
            $OrderByName = $request->input('orn');
            $OrderByValue = $request->has('orv') ? ($request->input('orv') == 'asc' ? 'asc' : 'desc') : 'desc';
            switch ($OrderByName) {
                case 'fullname':
                    $ExamUserModel->orderBy('users.fullname', $OrderByValue);
                    break;
                case 'score':
                    $ExamUserModel->orderBy('m1_exam_user.score', $OrderByValue);
                    break;
                case 'time':
                    $ExamUserModel->orderBy('m1_exam_user.time_end', $OrderByValue);
                    break;
                default:
                    goto defaultOrderBy;
            }
        } else {
            defaultOrderBy:
            $ExamUserModel->orderBy('m1_exam_user.created_at', 'DESC');
        }

        $items = $ExamUserModel->paginate(5);

        return view('OnlineCourse::Pi/exam/score/index', [
            'exam' => $ExamDetail,
            'items' => $items,
            'se' => $searchEngine,
            'search_append' => $SearchService->generate()
        ]);
    }

    public function get_app_phongthi(Request $request) {
        $this->DVController = $this->registerDVC($this->ControllerName);

        $ExamRegisteredModels = DB::table('m1_exam_registered')
                ->join('users', 'users.id', '=', 'm1_exam_registered.id_user')
                ->join('categories', 'categories.id', '=', 'm1_exam_registered.id_category')
                ->join('categories_lang', 'categories_lang.id_category', '=', 'categories.id')
                ->leftJoin('m1_exam_user', 'm1_exam_user.erm_id', '=', 'm1_exam_registered.id')
                ->where([
                    ['m1_exam_registered.id_user', $this->current_user->id],
                    ['m1_exam_registered.deleted_at', null],
                    ['categories_lang.id_lang', '=', 1]
                ])
                ->select([
                    'm1_exam_registered.id', 'm1_exam_registered.name', 'm1_exam_registered.created_at', 'm1_exam_registered.start_date', 'm1_exam_registered.expiry_date',
                    'm1_exam_registered.state', 'm1_exam_registered.price', 'm1_exam_registered.time', 'm1_exam_registered.approved_at', 'm1_exam_registered.approved_by',
                    'categories_lang.name as cate_name', DB::raw('COUNT(tbl_m1_exam_user.erm_id) as total_users')
                ])
                ->orderby('m1_exam_registered.id', 'DESC')
                ->groupBy('m1_exam_registered.id')
                ->paginate(5);
     
        return view('OnlineCourse::Pi/exam/app_phongthi', [
            'items' => $ExamRegisteredModels,
            'tbl' => 'm1_exam',
        ]);
    }

    public function get_app_dethithu(Request $request) {
        $this->DVController = $this->registerDVC($this->ControllerName);
        $ExamModel = ExamModel::where([
                    ['id_user', UserServiceV2::current_userId(UserType::professor())],
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
            NotificationService::alertRight('Dữ liệu không có thực!', 'danger');
            return redirect()->route('mdle_oc_pi_exam_index');
        }
        $tmp_time = is_numeric((int) $ExamModel->time) ? (int) $ExamModel->time : 2700;
        $time = $this->secondToTime($tmp_time);
        $ExamModel->time_h = $time[0];
        $ExamModel->time_m = $time[1];
        $ExamModel->time_s = $time[2];


        // Load thông tin danh mục
        $CategoryModel_TMP = new CategoryModel();
        $CATE_PARENT_ID = $CategoryModel_TMP->db_getParentIdByIdCate($ExamModel->id_category);
        if ($CATE_PARENT_ID != null) {
            $ExamModel->id_category_parent = $CATE_PARENT_ID;
        }

        // Load thông tin đáp án
        if ($ExamModel->app_data != null) {
            $app_data = (object) json_decode($ExamModel->app_data);
            $questions_data = $app_data->data;
        }



        // Load danh mục cấp 1
        $LST_CATE = $this->get_categoryLv1();


        $FileModel = new FileModel();
        $FileService = new FileService();

        $item_pdf = $FileModel->get_file($ExamModel->id, 'm1_exam', 'document');

        //$ExamModel->file_pdf = $FileService->convertModelToURL($item_pdf);
        return view('OnlineCourse::Pi/exam/add', [
            'item' => $ExamModel,
            'questions' => @$questions_data,
            'build_at' => @(new Carbon($app_data->build_at->date))->format('d-m-Y h:i:s A'),
            'cates' => $LST_CATE,
            'file_pdf' => $item_pdf,
            'categories' => $HTML_Categories
        ]);
    }

    public function post_save(Request $request) {

        if (!$request->has('time_start') || !$request->has('time_end')) {
            NotificationService::alertRight('Không tìm thấy thời gian bắt đầu & thời gian kết thúc, vui lòng kiểm tra lại dữ liệu.', 'danger');
            goto resultArea;
        }

        if (!$request->has('questions')) {
            NotificationService::alertRight('Không tìm thấy dữ liệu đáp án, có lỗi xảy ra trong quá trình tạo bài thi.', 'danger');
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

        // ----- FILE PDF ----------------------------------------------------------------------------------------------

        if ($request->hasFile('file_pdf')) {
            $pdf = $request->file_pdf;
            $LimitFileSize = $this->_SETTING->limit_document;
            if ($LimitFileSize != null) {
                if ($pdf->getSize() / 1024 > $LimitFileSize) {
                    NotificationService::alertRight(__('message.dungluongfilevuotquagioihanchophep'), 'error');
                    return back()->withInput();
                }
            }
            $FILE_EXTENSION = explode(',', $this->_SETTING->type_document);
            if (!in_array($pdf->getClientOriginalExtension(), $FILE_EXTENSION)) {
                NotificationService::alertRight(__('message.khonghotrodinhdangnay'), 'error');
                return back()->withInput();
            }
            if ($pdf->getType() != 'file') {
                NotificationService::alertRight(__('message.chiduocuploadfile'), 'error');
                return back()->withInput();
            }
        } else {
            if (!$request->has('id')) {
                NotificationService::alertRight('File mà bạn upload có vẻ không khả dụng, vui lòng thử lại hoặc báo cáo '
                        . 'quản trị để được khắc phục.', 'warning', 'Lỗi file');
                return redirect()->back()->withInput();
            }
        }

        $ExamBuilder = (new \App\Modules\OnlineCourse\App\ExamBuilder());

        if ($request->input('id') != null) {
            $ExamBuilder->do_update($request->input('id'));
        } else {
            $ExamBuilder->do_insert();
        }

        try {
            $ExamBuilder->set_modelByRequest($request);
            if (!$ExamBuilder->save()) {
                NotificationService::alertRight(__('message.coloixayratrongquatrinhxuly'), 'error');
                goto resultArea;
            }
            $this->_ExamModel = $ExamBuilder->get_examModel();
        } catch (\Exception $ex) {
            NotificationService::alertRight('Có lỗi xảy ra trong quá trình tạo đề thi, vui lòng kiểm tra lại.', 'danger');
            goto resultArea;
        }

        // ----- UPLOAD FILE PDF ---------------------------------------------------------------------------------------
        uploadPDFArea:
        if ($request->hasFile('file_pdf')) {
            $this->upload_filePDF($request->file_pdf);
        }
        uploadPDFArea_:
        if ($this->_ExamModel != null) {
            NotificationService::alertRight('Thêm thành công', 'success');
        }
        resultArea:
        return redirect()->route('mdle_oc_pi_exam_index');
    }

    private function upload_filePDF($pdf) {
        $ExamModel = $this->_ExamModel;
        $StorageServiceV2 = new \App\Bcore\Services\StorageServiceV2();
        $uploaded = $StorageServiceV2->disk('localhost')
                        ->folder($this->storage_folder . '/documents/dethi')
                        ->set_file($pdf)->upload();
        if ($uploaded->file_uploaded() != null) {
            if (false) {
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
            $FileModel->obj_id = $this->_ExamModel->id;
            $FileModel->obj_table = 'm1_exam';
            $FileModel->obj_type = 'document';
            $FileModel->dir_name = $this->storage_folder;
            $FileModel->mimetype = $pdf->getMimetype();
            $FileModel->size = $pdf->getSize();
            $FileModel->url = $uploaded->file_uploaded_path();
            $FileModel->url_encode = md5($FileModel->url);
            $FileModel->sync_google = @$FileGooglePath;
            $FileModel->name = $pdf->getClientOriginalName();
            $FileModel->id_user = UserServiceV2::current_userId(UserType::professor());
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

    public function ajax(Request $request) {
        $act = $request->input('act');
        switch ($act) {
            case '779b01b6ac7f4d64459a3e1f52c0e90f': return $this->remove_item($request);
            case 'e1e9130e17e60b2dce990bea6bb0c5da': return $this->create_examOnlineMode($request); //Mode 1
            //case '5efd453f68aac1ffc4156e76a7aebdfa': return $this->create_examCustomMode($request); //Mode 2
            //case 'c98b5521a0f9123f84e93c16a12b5b2c': return $this->create_examTestMode($request); //Mode 3
        }
    }

    public function get_test() {
        $ExamBuilder = (new ExamBuilder())->load_app(66);
        $r = $ExamBuilder->register_app();




        dd($r);
    }

    // Tạo dữ liệu bài thi, sao chép APP DATA

    private function create_examOnlineMode($request) {
        $ExamBuilder = (new ExamBuilder())->load_app((int) $request->input('id'));
        if ($ExamBuilder->get_examModel() == null) {
            $JsonResponse = AjaxResponse::dataNotFound();
            goto responseArea;
        }
        $AppRegistered = $ExamBuilder->register_app();
        if ($AppRegistered) {
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

        // DELETE FILE - LOCALHOST
//        $file = $this->load_fileByModel($ExamModel);
//        if ($file != null) {
//            if (Storage::disk('localhost')->exists($file->url)) {
//                Storage::disk('localhost')->delete($file->url);
//                $file = null;
//            }
//        }

        $ExamModel->deleted_at = Carbon::now();

        $JsonResponse = $ExamModel->save() ? AjaxResponse::success() : AjaxResponse::fail();

        responseArea:
        return response()->json($JsonResponse);
    }

    private function load_fileByModel($model) {
        try {
            return \App\Models\FileModel::
                            where([
                                ['id_user', UserServiceV2::current_userId(UserType::professor())],
                                ['obj_id', $model->id],
                                ['obj_table', $model->tbl]
                            ])
                            ->first();
        } catch (\Exception $ex) {
            return null;
        }
    }

    ///////////

    private function upload_photo() {
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

}
