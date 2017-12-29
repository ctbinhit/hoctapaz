<?php

namespace App\Http\Controllers\client;

use Session;
use View;
use Illuminate\Http\Request,
    PhotoModel,
    UserModel,
    FileModel;
use Carbon\Carbon;
use App\Bcore\FileService;
use App\Bcore\Services\SeoService;
use Illuminate\Support\Facades\DB;
use App\Bcore\Services\UserServiceV2;
use App\Bcore\Services\UserServiceV3;
use App\Bcore\Services\CategoryService;
use App\Http\Controllers\ClientController;
use App\Modules\OnlineCourse\App\ExamHelper;
use App\Bcore\SystemComponents\User\UserType;
use App\Modules\OnlineCourse\Models\ExamModel;
use App\Modules\OnlineCourse\Models\ExamUserModel;
use App\Modules\OnlineCourse\Models\ExamRegisteredModel;

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
        $Categories = CategoryService::get_baseCategories('hoctap', 'exam');
        SeoService::seo_title('Phòng thi online');

        $ExamHelper = (new ExamHelper())
                ->load_models()
                ->set_request($request)
                ->filter(['keywords', 'username'])
                ->set_where('m1_exam_registered.state', 1)
                ->set_options([
            'paginate' => 5
        ]);

        //dd($ExamHelper->load_models());

        return view('client/phongthi/index', [
            'items' => $ExamHelper->get_models(),
            'categories_hoctap' => $Categories
        ]);
    }

    public function get_exam_phongthi_danhmuc($name_meta, Request $request) {

        $this_cate = \App\Bcore\Services\CategoryService::find_byNameMeta($name_meta);
        $sub_cate_ = \App\Bcore\Services\CategoryService::get_childCateByIdParent($this_cate->id);
        $ArrayId = array_prepend(array_pluck($sub_cate_, 'id'), $this_cate->id);

        $ExamHelper = (new \App\Modules\OnlineCourse\App\ExamHelper())
                ->load_models()
                ->set_request($request)
                ->filter(['keywords', 'username'])
                ->set_where('m1_exam_registered.state', 1)
                ->set_whereIn('m1_exam_registered.id_category', $ArrayId)
                ->set_options([
            'paginate' => 5
        ]);

        if ($request->has('keywords')) {
            if ($request->has('filterBy')) {
                switch ($request->input('filterBy')) {
                    case 'keywords':
                        goto defaultFilterArea;
                        break;
                    case 'username':
                        $ExamHelper->set_where('users.fullname', 'LIKE', '%' . $request->input('keywords') . '%');
                        break;
                    default:
                        goto defaultFilterArea;
                }
            } else {
                defaultFilterArea:
                $ExamHelper->set_where('m1_exam_registered.seo_keywords', 'LIKE', '%' . $request->input('keywords') . '%');
            }
        }


//        if (count($sub_cate_) != 0) {
//            foreach ($sub_cate_ as $k => $v) {
//                $ArrayId[] = $v->id;
//                $items = DB::table('m1_exam')
//                                ->join('users', 'users.id', '=', 'm1_exam.id_user')
//                                ->where([
//                                    ['users.type', 'professor'],
//                                    ['m1_exam.deleted', null],
//                                    ['m1_exam.approved_by', '>', 0],
//                                    ['m1_exam.state', \App\Modules\OnlineCourse\Components\ExamState::de_thi()]
//                                ])->whereIn('m1_exam.id_category', [$v->id])
//                                ->select([
//                                    'users.google_avatar', 'users.facebook_avatar',
//                                    'users.fullname', 'm1_exam.name', 'm1_exam.name_meta', 'm1_exam.id_category', 'm1_exam.description',
//                                    'm1_exam.time', 'm1_exam.price', 'm1_exam.seo_description', 'm1_exam.created_at'
//                                ])->orderBy('m1_exam.id', 'DESC')->paginate(4);
//                foreach ($items as $k1 => $v1) {
//                    $v1->avatar = $v1->google_avatar != null ? $v1->google_avatar : $v1->facebook_avatar;
//                    $tmp = new Carbon($v1->created_at);
//                    $v1->created_at = $tmp->format('d/m/Y');
//                }
//                $v->html_list_items = view('client/phongthi/components/list_exam', [
//                    'items' => @$items
//                        ])->render();
//            }
//        }
//
//        $ExamModel = DB::table('m1_exam')
//                ->join('users', 'users.id', '=', 'm1_exam.id_user')
//                ->where([
//                    ['users.type', 'professor'],
//                    ['m1_exam.deleted', null],
//                    ['m1_exam.approved_by', '>', 0],
//                    ['m1_exam.state', \App\Modules\OnlineCourse\Components\ExamState::de_thi()]
//                ])
//                ->whereIn('m1_exam.id_category', $ArrayId)
//                ->select([
//                    'users.google_avatar', 'users.facebook_avatar',
//                    'users.fullname', 'm1_exam.name', 'm1_exam.name_meta', 'm1_exam.id_category', 'm1_exam.description',
//                    'm1_exam.time', 'm1_exam.price', 'm1_exam.seo_description', 'm1_exam.created_at'
//                ])
//                ->orderBy('m1_exam.id', 'DESC');
//
//        if ($request->has('keywords')) {
//            if ($request->has('filterBy')) {
//                switch ($request->input('filterBy')) {
//                    case 'keywords':
//                        goto defaultFilterArea;
//                        break;
//                    case 'username':
//                        $ExamModel->where('users.fullname', 'LIKE', '%' . $request->input('keywords') . '%');
//                        break;
//                    default:
//                        goto defaultFilterArea;
//                }
//            } else {
//                defaultFilterArea:
//                $ExamModel->where('m1_exam.seo_keywords', 'LIKE', '%' . $request->input('keywords') . '%');
//            }
//        }
//        $ExamModel = $ExamModel->paginate(10);

        $items = $ExamHelper->get_models();
        foreach ($items as $k => $v) {
            $v->avatar = \App\Bcore\Services\ImageService::no_userPhoto();
//            $v->avatar = $v->google_avatar != null ? $v->google_avatar : $v->facebook_avatar;
//            $tmp = new Carbon($v->created_at);
//            $v->created_at = $tmp->format('d/m/Y');
        }


        SeoService::seo_title('Phòng thi online | ' . $this_cate->name);

        return view('client/phongthi/category', [
            'this_cate' => $this_cate,
            'items' => $items,
            'sub_cates' => $sub_cate_,
            'categories' => \App\Bcore\Services\CategoryService::get_baseCategories('hoctap', 'exam')
        ]);
    }

    // TRẮC NGHIỆM TRỰC TUYẾN

    public function get_tracnghiemtructuyen() {
        $Categories = \App\Bcore\Services\CategoryService::get_baseCategories('hoctap', 'exam');
        SeoService::seo_title('Phòng thi online');

        $ExamHelper = (new \App\Modules\OnlineCourse\App\ExamHelper())
                ->load_models()
                ->set_request($request)
                ->filter(['keywords', 'username'])
                ->set_where('m1_exam_registered.state', 1)
                ->set_whereIn('m1_exam_registered.id_category', $ArrayId)
                ->set_options([
            'paginate' => 5
        ]);

//        $ExamModel = DB::table('m1_exam')
//                ->join('users', 'users.id', '=', 'm1_exam.id_user')
//                ->where([
//                    ['users.type', 'professor'],
//                    //['m1_exam.id_user','<>', \App\Bcore\Services\UserService::id()],
//                    ['m1_exam.deleted', null],
//                    ['m1_exam.approved_by', '>', 0],
//                    ['m1_exam.state', \App\Modules\OnlineCourse\Components\ExamState::trac_nghiem_online()]
//                ])
//                ->select([
//                    'users.google_avatar', 'users.facebook_avatar',
//                    'users.fullname', 'm1_exam.name', 'm1_exam.name_meta', 'm1_exam.id_category', 'm1_exam.description',
//                    'm1_exam.time', 'm1_exam.price', 'm1_exam.seo_description', 'm1_exam.created_at'
//                ])
//                ->orderBy('m1_exam.id', 'DESC')
//                ->paginate(10);
//        foreach ($ExamModel as $k => $v) {
//            $v->avatar = $v->google_avatar != null ? $v->google_avatar : $v->facebook_avatar;
//            $tmp = new Carbon($v->created_at);
//            $v->created_at = $tmp->format('d/m/Y');
//        }

        return view('client/phongthi/tracnghiemtructuyen', [
            'items' => [],
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

        if ($this->current_user == null) {
            $RESULT->error_type = 'chuadangnhap';
            $RESULT->message = "Vui lòng đăng nhập trước khi thực hiện thao tác";
            return redirect()->route('client_login_index', [
                        'cwr' => url()->full()
            ]);
        }

        $UserModel = (new UserServiceV3)->user()->current()->loadFromDatabase()->get_userModel();

        if ($UserModel == null) {
            $RESULT->message = "User không tồn tại!";
            goto resultArea;
        }

        // ----- Thông tin bài thi -------------------------------------------------------------------------------------
        $ERM = (new ExamHelper())
                ->load_modelByMetaName($pExamMeta)
                ->get_model();

        if ($ERM == null) {
            $RESULT->message = "Bài thi không tồn tại, vui lòng kiểm tra lại hoặc liên hệ quản trị để biết thêm thông tin!";
            goto resultArea;
        }

        if ($ERM->state == 0) {
            $RESULT->message = "Bài thi chưa được xác thực, vui lòng quay lại sau";
            goto resultArea;
        }
        if ($ERM->state == 2) {
            $RESULT->message = "Bài thi đang bị tạm khóa, vui lòng quay lại sau";
            goto resultArea;
        }

        $ERM_CHECK = ExamUserModel::where([
                    ['id_user', $UserModel->id], ['erm_id', $ERM->id], ['id_exam', $ERM->id_exam]
                ])->first();

        if ($ERM_CHECK != null) {
            if ($ERM_CHECK->time_in != null && $ERM_CHECK->time_out != null) {
                $RESULT->state = false;
                $RESULT->message = "Bạn đã tham gia bài thi này, không thể tham gia nữa!";
                goto resultArea;
            }
            if ($ERM_CHECK->time_in == null && $ERM_CHECK->time_out != null) {
                $RESULT->state = false;
                $RESULT->message = "Bạn đã bỏ lỡ trong quá trình làm bài thi, vui lòng liên hệ giáo viên để được thi lại.";
                goto resultArea;
            }
            $RESULT->state = true;
            $RESULT->paid = true;
        }

        if ($UserModel->coin < $ERM->price) {
            $RESULT->error_type = 'naptien';
            $RESULT->message = "Số tiền trong tài khoản còn " . $UserModel->coin . ", số tiền cần thanh toán là "
                    . $ERM->price . " Vui lòng nạp thêm tiền để thực hiện thao tác này.";
            goto resultArea;
        } else {
            $RESULT->state = true;
            $RESULT->error_type = 'success';
            $RESULT->message = "Đang khởi tạo bài thi...";
            $RESULT->user_data = $UserModel;
            $RESULT->exam_data = $ERM;
        }
        // GENERATE TOKEN
        $_TOKEN_DATE = Carbon::now();
        $_TOKEN_1 = $_TOKEN_DATE->timestamp . str_random(30) . $UserModel->id;
        $_TOKEN_SESSION = md5($_TOKEN_1);
        session::flash('_TOKEN_EXAM', [
            'id_user' => $UserModel->id,
            'id_erm' => $ERM->id,
            'token' => $_TOKEN_SESSION
        ]);

        resultArea:
        return view('client/phongthi/redirect', [
            'redirect' => @$RESULT,
            'erm' => $ERM
        ]);
    }

    public function post_exam_phongthi_redirect(Request $request) {
        // TOKEN
        $_TOKEN_DATE = Carbon::now();
        $_TOKEN_1 = $_TOKEN_DATE->timestamp . str_random(30) . $this->current_user->id;
        $_TOKEN_SESSION = md5($_TOKEN_1);
        session::flash('_TOKEN_EXAM', [
            'id_user' => $this->current_user->id,
            'id_erm' => $request->input('erm_id'),
            'token' => $_TOKEN_SESSION
        ]);
        return redirect()->route('client_exam_thionline_');
    }

    public function get_exam_thionline_token() {
        session::keep('_TOKEN_EXAM');
        session('_TOKEN_EXAM', session::get('_TOKEN_EXAM'));
        if (!session::has('_TOKEN_EXAM')) {
            return redirect()->route('client_exam_phongthi');
        }
        $DATA_TOKEN = (object) session('_TOKEN_EXAM');
        $ERM = (new ExamHelper())
                        ->append_options('select', 'm1_exam_registered.app_data')->load_ermById($DATA_TOKEN->id_erm)->get_model();
        $ERM_DATA = (object) json_decode($ERM->app_data);

//        $ExamModel = DB::table('m1_exam')
//                ->join('m1_exam_detail', 'm1_exam_detail.id_exam', '=', 'm1_exam.id')
//                ->where([
//                    ['m1_exam.id', $DATA_TOKEN->id_erm]
//                ])
//                ->select([
//                    'm1_exam.id', 'm1_exam.name', 'm1_exam.name_meta', 'm1_exam.description', 'm1_exam.time',
//                    'm1_exam.seo_keywords', 'm1_exam.seo_title', 'm1_exam.seo_description', 'm1_exam.created_at',
//                    DB::raw('COUNT(tbl_m1_exam_detail.id) as eqc')
//                ])
//                ->groupBy('m1_exam.id')
//                ->first();
        //$ExamModel = ExamModel::find($DATA_TOKEN->id_exam);


        return view('client/thitracnghiem/tracnghiem_detail', [
            'item' => $ERM,
            'app_data' => $ERM_DATA,
            'chart_top_score' => @$this->get_top_score($ERM->id)
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
            case 'es': // ERM -> START
                return $this->erm_start($request);
            case 'ee':
                return $this->erm_end($request);
        }
    }

    private function paying($request) {
        $ERM_ID = $request->input('id_exam');
        $ERM = ExamRegisteredModel::find($ERM_ID);
        $state = false;

        if ($ERM == null) {
            $msg = 'Dữ liệu không có thực!';
            goto responseArea;
        }

        $UserInfo = (new UserServiceV3())->user()->current()->loadFromDatabase()->get_userModel();

        if ($UserInfo == null) {
            $msg = 'Có lỗi xảy ra trong quá trình xác thực tài khoản!';
            goto responseArea;
        }

        if ($UserInfo->coin < $ERM->price) {
            $msg = 'Tài khoản không đủ để thực hiện thanh toán, vui lòng nạp thêm!';
            goto responseArea;
        }

        $a = \App\Modules\OnlineCourse\Models\ExamUserModel::where([
                    ['id_user', $UserInfo->id],
                    ['id_exam', $ERM_ID]
                ])->first();
        if ($a != null) {
            $msg = 'Tài khoản đã đăng ký và đã thanh toán, không thể thanh toán lần 2!';
            goto responseArea;
        }

        $UserInfo->coin -= $ERM->price;
        $r = $UserInfo->save();

        if ($r) {
            $ExamHelper = (new ExamHelper())->load_ermById($ERM_ID)->register_appData($UserInfo, $ERM);
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

    private function erm_start($request) {
        session::keep('_TOKEN_EXAM');
        $execute_time = Carbon::now();
        $execute_time_tmp = $execute_time;
        $UserModel = (new UserServiceV3)->user()->current()->loadFromDatabase()->get_userModel();
        if ($UserModel == null) {
            
        }


        $input_erm_id = $request->input('id');
        $ERM = (new ExamHelper())->append_options('select', 'm1_exam_registered.app_data')->load_ermById($input_erm_id)->append_fileUrl()->get_model();
        $ERM_APP_DATA = (object) json_decode($ERM->app_data);
        if ($ERM == null) {
            
        }

        $EUM = ExamUserModel::where([
                    ['id_user', $UserModel->id], ['id_exam', $ERM->id_exam], ['erm_id', $ERM->id]
                ])->first();

        if ($EUM == null) {
            
        }
        $EUM->time_in = $execute_time;
        return response()->json([
                    'state' => $EUM->save(),
                    'app_data' => $ERM_APP_DATA->data,
                    'eum_code' => $EUM->code,
                    'erm' => $ERM
        ]);
    }

    private function erm_end($request) {
        session::keep('_TOKEN_EXAM');
        $execute_time = Carbon::now();
        $execute_time_tmp = $execute_time;
        $input_eum_code = $request->input('eum_code');
        $input_time = $request->input('time');
        $input_data = $request->has('data') ? $request->input('data') : [];
        $EUM = ExamUserModel::where('code', '=', $input_eum_code)->first();
        if ($EUM == null) {
            
        }
        $ERM = (new ExamHelper())->append_options('select', 'm1_exam_registered.app_data')->load_ermById($EUM->erm_id)->get_model();


        //$ERM = ExamRegisteredModel::find($EUM->erm_id);
        $TimeIn = new Carbon($EUM->time_in);
        $TimeIn->addSecond($ERM->time);
        $TimeDiff = $execute_time->diffInSeconds($TimeIn);
        if ($TimeDiff < 0) {
            // Lỗi ngày giờ hệ thống
        }
        if ($input_time == 0) {
            checkTimeDiff:
            // Kiểm tra độ trễ của user, nếu time_in & time_out cách nhau hơn 10s => HACK hoặc máy lag
            // Cấp TOKEN Thi lại & không hoàn tiền
            if ($TimeDiff > 10) {
                if (session::has('_TOKEN_EXAM')) {
                    session::keep('_TOKEN_EXAM');
                } else {
                    
                }
                goto responseArea;
            }
        } else {
            // User nộp bài sớm hơn dự định
            $execute_time->addSecond((int) $input_time);
            $TimeDiff = $execute_time->diffInSeconds($TimeIn);
            goto checkTimeDiff;
        }

        // ----- Lưu phiếu trắc nghiệm của user ------------------------------------------------------------------------
        // Nếu phiếu trả lời == 0 cho ngay 0 điểm khỏi suy nghĩ :))
        if (count($input_data) == 0) {
            $EUM->score = 0;
        }

        $user_result = [];
        foreach ($input_data as $v) {
            $user_result[$v[0]] = $v[1];
        }
        $EUM->data = json_encode($user_result);

        // ----- Chấm thi ----------------------------------------------------------------------------------------------
        $ERM_DATA = (object) json_decode($ERM->app_data);
        $ERM_QUESTIONS = $ERM_DATA->data;
        $QC = count($ERM_QUESTIONS);
        $PERC = 10 / $QC;
        $USER_SOCRE = 0;
        $_PASSS = 0;
        foreach ($ERM_QUESTIONS as $k => $v) {
            if (isset($user_result[$k + 1])) {
                if ((int) trim($v->answer) == (int) trim($user_result[$k + 1])) {
                    $USER_SOCRE += $PERC;
                    $_PASSS ++;
                }
            }
        }
        $RESULT_PAN = (object) [
                    'socaudung' => $_PASSS,
                    'socausai' => $QC - $_PASSS,
                    'tongsocau' => $QC,
                    'score' => $USER_SOCRE,
                    'tongthoigianlambai' => $ERM->time - $input_time,
                    'urlketqua' => route('client_exam_ketquathi', $EUM->code)
        ];
        $EUM->score = $USER_SOCRE;
        $EUM->time_end = $input_time;
        $EUM->time_out = $execute_time_tmp;
        $EUM->type = $ERM->app_type;
        $r = $EUM->save();
        if ($r) {
            
        } else {
            if (session::has('_TOKEN_EXAM')) {
                session::keep('_TOKEN_EXAM');
            } else {
                
            }
            goto responseArea;
        }
        responseArea:
        return response()->json([
                    'state' => isset($r) ? $r : false,
                    'data' => @$RESULT_PAN,
                    'erm_code' => $input_eum_code,
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
                                ['id_user', UserServiceV2::current_userId(UserType::user())],
                                ['id_exam', $Model->id]
                            ])->first();
                    $ExamUserModel->code = md5(str_random(6) . $execute_time . UserServiceV2::current_userId(UserType::user()));
                    $ExamUserModel->id_user = UserServiceV2::current_userId(UserType::user());
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
//                if (!$request->has('data')) {
//                    $response->error_message = "Dữ liệu gửi lên thất bại.";
//                    goto responseArea;
//                }
                // ----- Gán dữ liệu

                $INPUT_ExamCode = $request->input('exam_code');
                $INPUT_Time = $request->input('time');
                $INPUT_Data = $request->has('data') ? $request->input('data') : [];

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

    // PRIVATE FUNCTIONS
    private function get_top_score($id_exam, $exam_type = 'de-thi') {
        $ExamModel = DB::table('m1_exam_user')
                ->join('users', 'users.id', '=', 'm1_exam_user.id_user')
                ->join('m1_exam', 'm1_exam.id', '=', 'm1_exam_user.id_exam')
                ->where([
                    ['m1_exam_user.score', '>=', 5],
                    ['m1_exam_user.id_exam', $id_exam],
                    ['m1_exam_user.type', '=', trim($exam_type)]
                ])
                ->select([
            'm1_exam_user.score', 'm1_exam_user.time_end',
            'users.fullname',
            'm1_exam.time'
        ]);
        $ExamModel->orderBy('m1_exam_user.score', 'DESC');
        return $ExamModel->take(5)->get();
    }

}
