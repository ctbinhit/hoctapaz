<?php

namespace App\Http\Controllers\client;

use Illuminate\Http\Request;
use App\Http\Controllers\ClientController;
use App\Modules\OnlineCourse\Models\ExamModel,
    PhotoModel,
    UserModel,
    FileModel,
    App\Modules\OnlineCourse\Models\ExamUserModel;
use ImageService,
    AuthService,
    FileService;
use Carbon\Carbon;
use Session,
    View,
    Illuminate\Support\Facades\DB;
use App\Bcore\Services\SeoService;

class ExamController extends ClientController {

    public $storage_folder = 'exam/';
    public $ControllerName = 'ExamManController';

    use \App\Functions\AdminFunction;

    public function __construct() {
        parent::__construct();
        view::share('client_exam_ajax', route('client_exam_ajax'));
    }

    public function get_exam_ketquathi($ExamCode) {
        if ($ExamCode == null) {
            return redirect()->route('client_index');
        }

        $ExamUserModel = ExamUserModel::where('code', '=', $ExamCode)->first();

        $UserModel = UserModel::find($ExamUserModel->id_user);

        $ExamModel = ExamModel::find($ExamUserModel->id_exam);
        return view('client/ketqua/thionline', [
            'exam' => $ExamModel,
            'user_result' => $ExamUserModel,
            'user' => $UserModel
        ]);
    }

    public function get_exam_thionline() {
        return view('client/thionline/thionline', [
        ]);
    }

    public function get_exam_detail($pNameMeta) {
        if ($pNameMeta == null) {
            return redirect()->route('client_index');
        }
        return view('client/thionline/thionline', [
        ]);
    }

    // PHÒNG THI

    public function get_exam_phongthi(Request $request) {
        $Categories = \App\Bcore\Services\CategoryService::get_baseCategories('hoctap', 'exam');
        SeoService::seo_title('Phòng thi online');

        $ExamModel = DB::table('m1_exam')
                ->join('users', 'users.id', '=', 'm1_exam.id_user')
                ->where([
                    ['users.type', 'professor'],
                    //['m1_exam.id_user','<>', \App\Bcore\Services\UserService::id()],
                    ['m1_exam.deleted', null],
                    ['m1_exam.approved_by', '>', 0],
                    ['m1_exam.state', \App\Modules\OnlineCourse\Components\ExamState::de_thi()]
                ])
                ->select([
                    'users.google_avatar', 'users.facebook_avatar',
                    'users.fullname', 'm1_exam.name', 'm1_exam.name_meta', 'm1_exam.id_category', 'm1_exam.description',
                    'm1_exam.time', 'm1_exam.price', 'm1_exam.seo_description', 'm1_exam.created_at'
                ])
                ->orderBy('m1_exam.id', 'DESC');

        if ($request->has('keywords')) {
            if ($request->has('filterBy')) {
                switch ($request->input('filterBy')) {
                    case 'keywords':
                        goto defaultFilterArea;
                        break;
                    case 'username':
                        $ExamModel->where('users.fullname', 'LIKE', '%' . $request->input('keywords') . '%');
                        break;
                    default:
                        goto defaultFilterArea;
                }
            } else {
                defaultFilterArea:
                $ExamModel->where('m1_exam.seo_keywords', 'LIKE', '%' . $request->input('keywords') . '%');
            }
        }


        $ExamModel = $ExamModel->paginate(10);
        foreach ($ExamModel as $k => $v) {

            $v->avatar = $v->google_avatar != null ? $v->google_avatar : $v->facebook_avatar;

            $tmp = new Carbon($v->created_at);
            $v->created_at = $tmp->format('d/m/Y');
        }

        // Chữa cháy
        $UserModel = UserModel::where([
                    ['type', '=', 'professor'],
                    ['role', '>', 0]
                ])->get();

        $ListNameProfessor = $this->groupModelsById($UserModel);

        foreach ($Categories as $k => $v) {
            
        }

        return view('client/phongthi/index', [
            'items' => $ExamModel,
            'professor' => $ListNameProfessor,
            'categories_hoctap' => $Categories
        ]);
    }

    public function get_exam_phongthi_danhmuc($name_meta,Request $request) {
        $ArrayId = [];
        $this_cate = \App\Bcore\Services\CategoryService::find_byNameMeta($name_meta);
        $sub_cate_ = \App\Bcore\Services\CategoryService::get_childCateByIdParent($this_cate->id);
        $ArrayId[] = $this_cate->id;

        if (count($sub_cate_) != 0) {
            foreach ($sub_cate_ as $k => $v) {
                $ArrayId[] = $v->id;
                $items = DB::table('m1_exam')
                                ->join('users', 'users.id', '=', 'm1_exam.id_user')
                                ->where([
                                    ['users.type', 'professor'],
                                    ['m1_exam.deleted', null],
                                    ['m1_exam.approved_by', '>', 0],
                                    ['m1_exam.state', \App\Modules\OnlineCourse\Components\ExamState::de_thi()]
                                ])->whereIn('m1_exam.id_category', [$v->id])
                                ->select([
                                    'users.google_avatar', 'users.facebook_avatar',
                                    'users.fullname', 'm1_exam.name', 'm1_exam.name_meta', 'm1_exam.id_category', 'm1_exam.description',
                                    'm1_exam.time', 'm1_exam.price', 'm1_exam.seo_description', 'm1_exam.created_at'
                                ])->orderBy('m1_exam.id', 'DESC')->paginate(4);
                foreach ($items as $k1 => $v1) {
                    $v1->avatar = $v1->google_avatar != null ? $v1->google_avatar : $v1->facebook_avatar;
                    $tmp = new Carbon($v1->created_at);
                    $v1->created_at = $tmp->format('d/m/Y');
                }
                $v->html_list_items = view('client/phongthi/components/list_exam', [
                    'items' => @$items
                        ])->render();
            }
        }

        $ExamModel = DB::table('m1_exam')
                ->join('users', 'users.id', '=', 'm1_exam.id_user')
                ->where([
                    ['users.type', 'professor'],
                    ['m1_exam.deleted', null],
                    ['m1_exam.approved_by', '>', 0],
                    ['m1_exam.state', \App\Modules\OnlineCourse\Components\ExamState::de_thi()]
                ])
                ->whereIn('m1_exam.id_category', $ArrayId)
                ->select([
                    'users.google_avatar', 'users.facebook_avatar',
                    'users.fullname', 'm1_exam.name', 'm1_exam.name_meta', 'm1_exam.id_category', 'm1_exam.description',
                    'm1_exam.time', 'm1_exam.price', 'm1_exam.seo_description', 'm1_exam.created_at'
                ])
                ->orderBy('m1_exam.id', 'DESC');

        if ($request->has('keywords')) {
            if ($request->has('filterBy')) {
                switch ($request->input('filterBy')) {
                    case 'keywords':
                        goto defaultFilterArea;
                        break;
                    case 'username':
                        $ExamModel->where('users.fullname', 'LIKE', '%' . $request->input('keywords') . '%');
                        break;
                    default:
                        goto defaultFilterArea;
                }
            } else {
                defaultFilterArea:
                $ExamModel->where('m1_exam.seo_keywords', 'LIKE', '%' . $request->input('keywords') . '%');
            }
        }
        $ExamModel = $ExamModel->paginate(10);
        foreach ($ExamModel as $k => $v) {
            $v->avatar = $v->google_avatar != null ? $v->google_avatar : $v->facebook_avatar;
            $tmp = new Carbon($v->created_at);
            $v->created_at = $tmp->format('d/m/Y');
        }


        SeoService::seo_title('Phòng thi online | ' . $this_cate->name);

        return view('client/phongthi/category', [
            'this_cate' => $this_cate,
            'items' => $ExamModel,
            'sub_cates' => $sub_cate_,
            'categories' => \App\Bcore\Services\CategoryService::get_baseCategories('hoctap', 'exam')
        ]);
    }

    // TRẮC NGHIỆM TRỰC TUYẾN

    public function get_tracnghiemtructuyen() {
        $Categories = \App\Bcore\Services\CategoryService::get_baseCategories('hoctap', 'exam');
        SeoService::seo_title('Phòng thi online');

        $ExamModel = DB::table('m1_exam')
                ->join('users', 'users.id', '=', 'm1_exam.id_user')
                ->where([
                    ['users.type', 'professor'],
                    //['m1_exam.id_user','<>', \App\Bcore\Services\UserService::id()],
                    ['m1_exam.deleted', null],
                    ['m1_exam.approved_by', '>', 0],
                    ['m1_exam.state', \App\Modules\OnlineCourse\Components\ExamState::trac_nghiem_online()]
                ])
                ->select([
                    'users.google_avatar', 'users.facebook_avatar',
                    'users.fullname', 'm1_exam.name', 'm1_exam.name_meta', 'm1_exam.id_category', 'm1_exam.description',
                    'm1_exam.time', 'm1_exam.price', 'm1_exam.seo_description', 'm1_exam.created_at'
                ])
                ->orderBy('m1_exam.id', 'DESC')
                ->paginate(10);
        foreach ($ExamModel as $k => $v) {
            $v->avatar = $v->google_avatar != null ? $v->google_avatar : $v->facebook_avatar;
            $tmp = new Carbon($v->created_at);
            $v->created_at = $tmp->format('d/m/Y');
        }

        return view('client/phongthi/tracnghiemtructuyen', [
            'items' => $ExamModel,
            'categories_hoctap' => $Categories
        ]);
    }

    public function get_tracnghiemtructuyen_danhmuc($name_meta) {
        $ArrayId = [];
        $this_cate = \App\Bcore\Services\CategoryService::find_byNameMeta($name_meta);
        $sub_cate_ = \App\Bcore\Services\CategoryService::get_childCateByIdParent($this_cate->id);
        $ArrayId[] = $this_cate->id;

        if (count($sub_cate_) != 0) {
            foreach ($sub_cate_ as $k => $v) {
                $ArrayId[] = $v->id;
                $items = DB::table('m1_exam')
                                ->join('users', 'users.id', '=', 'm1_exam.id_user')
                                ->where([
                                    ['users.type', 'professor'],
                                    ['m1_exam.deleted', null],
                                    ['m1_exam.approved_by', '>', 0],
                                    ['m1_exam.state', \App\Modules\OnlineCourse\Components\ExamState::trac_nghiem_online()]
                                ])->whereIn('m1_exam.id_category', [$v->id])
                                ->select([
                                    'users.google_avatar', 'users.facebook_avatar',
                                    'users.fullname', 'm1_exam.name', 'm1_exam.name_meta', 'm1_exam.id_category', 'm1_exam.description',
                                    'm1_exam.time', 'm1_exam.price', 'm1_exam.seo_description', 'm1_exam.created_at'
                                ])->orderBy('m1_exam.id', 'DESC')->paginate(4);
                foreach ($items as $k1 => $v1) {
                    $v1->avatar = $v1->google_avatar != null ? $v1->google_avatar : $v1->facebook_avatar;
                    $tmp = new Carbon($v1->created_at);
                    $v1->created_at = $tmp->format('d/m/Y');
                }
                $v->html_list_items = view('client/phongthi/components/list_exam', [
                    'items' => @$items
                        ])->render();
            }
        }

        $ExamModel = DB::table('m1_exam')
                ->join('users', 'users.id', '=', 'm1_exam.id_user')
                ->where([
                    ['users.type', 'professor'],
                    ['m1_exam.deleted', null],
                    ['m1_exam.approved_by', '>', 0],
                    ['m1_exam.state', \App\Modules\OnlineCourse\Components\ExamState::trac_nghiem_online()]
                ])
                ->whereIn('m1_exam.id_category', $ArrayId)
                ->select([
                    'users.google_avatar', 'users.facebook_avatar',
                    'users.fullname', 'm1_exam.name', 'm1_exam.name_meta', 'm1_exam.id_category', 'm1_exam.description',
                    'm1_exam.time', 'm1_exam.price', 'm1_exam.seo_description', 'm1_exam.created_at'
                ])
                ->orderBy('m1_exam.id', 'DESC')
                ->paginate(10);
        foreach ($ExamModel as $k => $v) {
            $v->avatar = $v->google_avatar != null ? $v->google_avatar : $v->facebook_avatar;
            $tmp = new Carbon($v->created_at);
            $v->created_at = $tmp->format('d/m/Y');
        }


        SeoService::seo_title('Phòng thi online | ' . $this_cate->name);

        return view('client/phongthi/category_tracnghiem', [
            'this_cate' => $this_cate,
            'items' => $ExamModel,
            'sub_cates' => $sub_cate_
        ]);
    }

    // Kiểm tra điều kiện nếu thỏa redirect trang thi
    public function get_exam_phongthi_redirect($pExamMeta, Request $request) {
        $RESULT = (object) [
                    'state' => false,
                    'status' => false,
                    'paid' => false,
                    'error_type' => '',
                    'title' => 'Thông báo',
                    'message' => null,
                    'user_data' => null,
                    'exam_data' => null
        ];
        // Thông tin user
        $AuthService = new AuthService();
        $UserModel = $AuthService->user_info();
        if (!$UserModel) {
            $RESULT->error_type = 'chuadangnhap';
            $RESULT->message = "Vui lòng đăng nhập trước khi thực hiện thao tác";
            goto resultArea;
        }
        // Thông tin bài thi
        $ExamModel = ExamModel::where([['name_meta', '=', $pExamMeta]])->get();

        // ===== KIỂM TRA BÀI VIẾT =====================================================================================
        if (count($ExamModel) == 0) {
            $RESULT->message = "Bài thi không tồn tại, vui lòng kiểm tra lại hoặc liên hệ quản trị để biết thêm thông tin!";
            goto resultArea;
        } else if (count($ExamModel) > 1) {
            $RESULT->message = "Có lỗi xảy ra trong quá trình thao tác, vui lòng liên hệ quản trị để được hỗ trợ!";
            goto resultArea;
        } else if (count($ExamModel) == 1) {
            $ExamModel = $ExamModel[0];
            // Bài viết tồn tại => next step
        } else {
            $RESULT->message = "Lỗi không xác định!";
            goto resultArea;
        }

        // ===== KIỂM TRA XÁC THỰC BÀI THI =============================================================================
        if ($ExamModel->approved_by == null) {
            $RESULT->message = "Bài thi chưa được xác thực, vui lòng quay lại sau";
            goto resultArea;
        } else if ($ExamModel->approved_by == -1) {
            $RESULT->message = "Bài thi này đã bị tạm khóa, vui lòng liên hệ quản trị để được hỗ trợ.";
            goto resultArea;
        } else if ($ExamModel->approved_by > 0) {
            // Bài viết đã được xác thực => next step
        }

        // ===== KIỂM TRA COIN USER ====================================================================================
        if ($UserModel->coin < $ExamModel->price) {
            $RESULT->error_type = 'naptien';
            $RESULT->message = "Số tiền trong tài khoản còn " . $UserModel->coin . ", số tiền cần thanh toán là " . $ExamModel->price . " Vui lòng nạp thêm tiền để thực hiện thao tác này.";
            goto resultArea;
        } else {
            $RESULT->state = true;
            $RESULT->error_type = 'success';
            $RESULT->message = "Đang khởi tạo bài thi...";
            $RESULT->user_data = $UserModel;
            $RESULT->exam_data = $ExamModel;
        }

        $a = \App\Modules\OnlineCourse\Models\ExamUserModel::where([
                    ['id_user', $UserModel->id],
                    ['id_exam', $ExamModel->id]
                ])->first();
        if ($a != null) {

//            if ($a->time_in != null && $a->time_out != null) {
//                $RESULT->state = false;
//                $RESULT->message = "Bạn đã tham gia bài thi này, không thể tham gia nữa!";
//                goto resultArea;
//            }

            if ($a->time_in == null && $a->time_out != null) {
                $RESULT->state = false;
                $RESULT->message = "Bạn đã bỏ lỡ trong quá trình làm bài thi, vui lòng liên hệ giáo viên để được thi lại.";
                goto resultArea;
            }

            $RESULT->state = true;
            $RESULT->paid = true;
        }

        // TOKEN
        $_TOKEN_DATE = Carbon::now();
        $_TOKEN_1 = $_TOKEN_DATE->timestamp . str_random(30) . $UserModel->id;
        $_TOKEN_SESSION = md5($_TOKEN_1);
        session::flash('_TOKEN_EXAM', [
            'id_user' => $UserModel->id,
            'id_exam' => $ExamModel->id,
            'token' => $_TOKEN_SESSION
        ]);

        resultArea:
        return view('client/phongthi/redirect', [
            'redirect' => @$RESULT,
            'id_exam' => @$ExamModel->id,
            'exam' => @$ExamModel
        ]);
    }

    public function post_exam_phongthi_redirect(Request $request) {
        // TOKEN
        $_TOKEN_DATE = Carbon::now();
        $_TOKEN_1 = $_TOKEN_DATE->timestamp . str_random(30) . \App\Bcore\Services\UserService::id();
        $_TOKEN_SESSION = md5($_TOKEN_1);
        session::flash('_TOKEN_EXAM', [
            'id_user' => \App\Bcore\Services\UserService::id(),
            'id_exam' => $request->input('id_exam'),
            'token' => $_TOKEN_SESSION
        ]);
        return redirect()->route('client_exam_thionline_');
    }

    public function get_exam_thionline_token() {
        session::keep('_TOKEN_EXAM');
        if (!session::has('_TOKEN_EXAM')) {
            //return redirect()->route('client_exam_phongthi');
        }
        $DATA_TOKEN = (object) session('_TOKEN_EXAM');
        $ExamModel = ExamModel::find($DATA_TOKEN->id_exam);
        //$ExamModel = ExamModel::find(36);
        $UserModel = UserModel::find(session('user')['id']);
        // $ExamModel = ExamModel::find(22);
        try {
            if ($ExamModel->seo_keywords != null) {
                $ExamModel->seo_keywords = explode(',', $ExamModel->seo_keywords);
            }
        } catch (\Exception $ex) {
            
        }



        return view('client/thitracnghiem/tracnghiem_detail', [
            'item' => $ExamModel,
            'user_data' => $UserModel
        ]);
    }

    // THI TRẮC NGHIỆM

    public function get_exam_thionline_detail($pNameMeta) {
        $ExamModel = ExamModel::where('name_meta', '=', trim($pNameMeta))
                ->orderBy('id', 'DESC')
                ->get();
        if (count($ExamModel) == 0) {
            return "Bài thi không tồn tại.";
        } else if (count($ExamModel) > 1) {
            return "Có lỗi xảy ra trong quá trình xác thực";
        } else {
            $ExamModel = $ExamModel[0];
            $ExamModel->seo_keywords = explode(',', $ExamModel->seo_keywords);
        }

        return view('client/thitracnghiem/tracnghiem_detail', [
            'item' => $ExamModel
        ]);
    }

    //


    public function get_exam_thitracnghiem() {
        return view('client/thitracnghiem/thitracnghiem', [
        ]);
    }

    public function get_exam_thitracnghiem_detail() {

        return view('client/thitracnghiem/tracnghiem_detail', [
        ]);
    }

    public function ajax(Request $request) {
        $act = $request->input('act');
        switch ($act) {
            case 'paying':
                return $this->paying($request);
        }
    }

    private function paying($request) {
        $ExamId = $request->input('id_exam');
        $ExamModel = ExamModel::find($ExamId);
        $state = false;

        if ($ExamModel == null) {
            $msg = 'Dữ liệu không có thực!';
            goto responseArea;
        }

        $UserInfo = \App\Bcore\Services\UserService::db_info();
        if ($UserInfo == null) {
            $msg = 'Có lỗi xảy ra trong quá trình xác thực tài khoản!';
            goto responseArea;
        }

        if ($UserInfo->coin < $ExamModel->price) {
            $msg = 'Tài khoản không đủ để thực hiện thanh toán, vui lòng nạp thêm!';
            goto responseArea;
        }

        $a = \App\Modules\OnlineCourse\Models\ExamUserModel::where([
                    ['id_user', $UserInfo->id],
                    ['id_exam', $ExamId]
                ])->first();
        if ($a != null) {
            $msg = 'Tài khoản đã đăng ký và đã thanh toán, không thể thanh toán lần 2!';
            goto responseArea;
        }

        $UserInfo->coin -= $ExamModel->price;
        $r = $UserInfo->save();

        if ($r) {
            \App\Modules\OnlineCourse\Models\ExamUserModel::registerUser($UserInfo->id, $ExamId);
            $state = true;
            $msg = 'Thanh toán thành công!';
        } else {
            $msg = 'Có lỗi xảy ra trong quá trình thanh toán, vui lòng thử lại sau!';
        }


        responseArea:
        return response()->json([
                    'state' => @$state,
                    'message' => @$msg
        ]);
    }

    public function _ajax(Request $request) {
        $execute_time = Carbon::now();
        $execute_time_tmp = $execute_time;
        $response = (object) [
                    'data' => null,
                    'exam' => null,
                    'exam_code' => null,
                    'exam_detail' => null,
                    'status' => false,
                    'error_message' => null
        ];
        if (!$request->has('action')) {
            $response->error_message = "Có lỗi xảy ra trong quá trình thao tác!";
            goto responseArea;
        }
        if (!session::has('user')) {
            $response->error_message = "Có lỗi xảy ra trong quá trình xác thực tài khoản!";
            goto responseArea;
        }
        switch ($request->input('action')) {
            case 'exam_start':
                $Model = ExamModel::find($request->input('id'));
                if ($Model != null) {

                    // ----- Load Exam detail --------------------------------------------------------------------------
                    $ModelDetail = $Model->db_rela_detail;
                    $response->exam = $Model;
                    $response->exam_detail = $ModelDetail;

                    // ----- Load File PDF -----------------------------------------------------------------------------
                    $FileModel = new FileModel();
                    $FileService = new FileService();
                    $item_pdf = $FileModel->get_file($Model->id, 'm1_exam', 'document');
                    $Model->file_pdf = route('document', $item_pdf->url_encode);

                    // ----- Đăng ký thông tin cho user ----------------------------------------------------------------
                    $ExamUserModel = \App\Modules\OnlineCourse\Models\ExamUserModel::where([
                                ['id_user', \App\Bcore\Services\UserService::id()],
                                ['id_exam', $Model->id]
                            ])->first();
                    $ExamUserModel->code = md5(str_random(6) . $execute_time . session('user')['id']);
                    $ExamUserModel->id_user = session('user')['id'];
                    $ExamUserModel->id_exam = $request->input('id');
                    $ExamUserModel->time_in = $execute_time;
                    $r = $ExamUserModel->save();
                    if ($r) {
                        $response->status = true;
                        $response->exam_code = $ExamUserModel->code;
                    } else {
                        // Khởi tạo người thi thất bại
                        $response->status = false;
                    }
                } else {
                    $response->status = false;
                }
                break;
            case 'exam_end':
                // ----- Kiểm tra kết quả gửi lên ----------------------------------------------------------------------
                if (!$request->has('exam_code')) {
                    $response->error_message = "Có lỗi xảy ra trong quá trình xác thực bài thi.";
                    goto responseArea;
                }
                if (!$request->has('time')) {
                    $response->error_message = "Phát hiện nghi vấn hack.";
                    goto responseArea;
                }
                if (!$request->has('data')) {
                    $response->error_message = "Dữ liệu gửi lên thất bại.";
                    goto responseArea;
                }
                // ----- Gán dữ liệu

                $INPUT_ExamCode = $request->input('exam_code');
                $INPUT_Time = $request->input('time');
                $INPUT_Data = $request->input('data');

                // ----- Kiểm tra time_out -----------------------------------------------------------------------------
                $ExamUserModel = ExamUserModel::where('code', '=', $INPUT_ExamCode)->first();

                if ($ExamUserModel == null) {
                    $response->error_message = "Có gì đó sai sai trong quá trình chấm bài thi!";
                    goto responseArea;
                }

                if ($ExamUserModel->time_in == null) {
                    $response->error_message = "Có lỗi xảy ra trong quá trình thao tác.";
                    goto responseArea;
                }
                $ExamModel = ExamModel::find($ExamUserModel->id_exam);
                if ($ExamModel == null) {
                    $response->error_message = "Xác thực bài thi thất bại, bài thi đã bị khóa!";
                    goto responseArea;
                }

                $TimeIn = new Carbon($ExamUserModel->time_in);
                $TimeIn->addSecond($ExamModel->time);

                $TimeDiff = $execute_time->diffInSeconds($TimeIn);
                // ----- Kiểm tra tính hợp lệ
                if ($TimeDiff < 0) {
                    // Lỗi ngày giờ hệ thống
                    $response->error_message = "Lỗi không xác định!";
                    goto responseArea;
                }

                // User nộp bài do hết thời gian
                if ($INPUT_Time == 0) {
                    checkTimeDiff:
                    // Kiểm tra độ trễ của user, nếu time_in & time_out cách nhau hơn 10s => HACK hoặc máy lag
                    // Cấp TOKEN Thi lại & không hoàn tiền
                    if ($TimeDiff > 10) {
                        $response->error_message = "Xác thực thời gian không hợp lệ, vui lòng thử lại.";
                        if (session::has('_TOKEN_EXAM')) {
                            session::keep('_TOKEN_EXAM');
                        } else {
                            $response->error_message = "Phiên làm việc hết hạn!";
                        }
                        goto responseArea;
                    }
                } else {
                    // User nộp bài sớm hơn dự định
                    $execute_time->addSecond((int) $INPUT_Time);
                    $TimeDiff = $execute_time->diffInSeconds($TimeIn);
                    goto checkTimeDiff;
                }

                // ----- Lưu phiếu trắc nghiệm của user ----------------------------------------------------------------
                // Nếu phiếu trả lời == 0 cho ngay 0 điểm khỏi suy nghĩ :))
                if (count($INPUT_Data) == 0) {
                    $ExamUserModel->score = 0;
                }

                $user_result = [];
                foreach ($INPUT_Data as $v) {
                    $user_result[$v[0]] = $v[1];
                }
                $user_result_ = json_encode($user_result);
                $ExamUserModel->data = $user_result_;

                // ----- Chấm thi --------------------------------------------------------------------------------------
                $ExamDetailModel = $ExamModel->db_rela_detail;
                $QC = count($ExamDetailModel);
                if ($QC == 0) {
                    $response->error_message = "Có lỗi xảy ra trong quá trình chấm thi! vui lòng liên hệ giáo viên để thi lại";
                    goto responseArea;
                }
                $score = 10 / $QC;
                $user_score = 0;
                $_pass = 0;
                foreach ($ExamDetailModel as $k => $v) {
                    if (isset($user_result[$k + 1])) {
                        if ((int) trim($v->result) == (int) trim($user_result[$k + 1])) {
                            $user_score += $score;
                            $_pass ++;
                        } else {
                            
                        }
                    }
                }
                $RESULT_PAN = (object) [
                            'socaudung' => $_pass,
                            'socausai' => $QC - $_pass,
                            'tongsocau' => $QC,
                            'score' => $user_score,
                            'tongthoigianlambai' => $ExamModel->time - $INPUT_Time,
                            'urlketqua' => route('client_exam_ketquathi', $ExamUserModel->code)
                ];
                $ExamUserModel->score = $user_score;
//                $response->data = [
//                    'data' => $INPUT_Data,
//                    'user_result' => $user_result,
//                    'exam_detail_model' => $ExamDetailModel,
//                ];
                $ExamUserModel->time_end = $INPUT_Time;
                $ExamUserModel->time_out = $execute_time_tmp;
                $ExamUserModel->type = $ExamModel->state;

                $r = $ExamUserModel->save();
                if ($r) {
                    // Lưu tg nộp bài thành công!
                    $response->status = true;
                    $response->data = $RESULT_PAN;
                } else {
                    if (session::has('_TOKEN_EXAM')) {
                        session::keep('_TOKEN_EXAM');
                    } else {
                        $response->error_message = "Phiên làm việc hết hạn!";
                    }
                    goto responseArea;
                    $response->error_message = "Có lỗi xảy ra trong quá trình thao tác";
                }



                break;
        }
        responseArea:
        return response()->json($response);
    }

}
