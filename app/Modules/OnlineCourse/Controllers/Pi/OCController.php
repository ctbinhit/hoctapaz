<?php

namespace App\Modules\OnlineCourse\Controllers\Pi;

use Illuminate\Http\Request;
use App\Bcore\PackageServiceAD;
use PhotoModel;
use SessionService;
use App\Modules\OnlineCourse\Models\CourseModel;
use ImageService;
use Session,
    Storage,
    Carbon\Carbon;

class OCController extends PackageServiceAD {

    public $module_name = 'OnlineCourse';
    public $dir = 'Pi';
    private $storage_folder = 'course';
    private $display_count = [
        'header' => [
            '5' => 5,
            '10' => 10,
            '25' => 25,
            'Tất cả' => -1
        ]
    ];
    private $MODE_FASTBOOT = true;

    function __construct() {
        parent::__construct();
    }

    public function get_index() {

        $DanhMuc = new \App\Bcore\Services\CategoryService();
        $LSTDanhMuc = $DanhMuc->set_type('hoctap')->set_lang(1)->get_categoriesByLv(0);


        // ----- View count --------------------------------------------------------------------------------------------
        $VIEWCOUNT = $this->get_viewcount('khoahoc');
        if (!isset($VIEWCOUNT)) {
            $VIEWCOUNT = 5;
        }

        $Models = CourseModel::where([
                    ['type', '=', 'khoahoc'],
                    ['deleted_at', '=', null],
                    ['id_user', '=', session('user')['id']]
                ])
                ->orderBy('ordinal_number', 'ASC')
                ->paginate($VIEWCOUNT);
        if (count($Models) != 0) {
            foreach ($Models as $k => $Model) {
                $tmp = new Carbon($Model->created_at);
                $Model->created_at_human = $tmp->diffForHumans(Carbon::now());
                $tmp2 = new Carbon($Model->updated_at);
                $Model->updated_at_human = $tmp2->diffForHumans(Carbon::now());
            }
        }
        return view('OnlineCourse::Pi/index', [
            'items' => $Models,
            'categories' => $LSTDanhMuc->data()
        ]);
    }

    public function post_index(Request $request) {
        if ($request->has('display_count')) {
            $SS = new SessionService();
            $SS->set_displayCount(__CLASS__, (int) $request->input('display_count'), 'khoahoc');
            return redirect()->route('mdle_oc_index');
        }
    }

    public function get_add() {
        $DanhMuc = new \App\Bcore\Services\CategoryService();
        $LSTDanhMuc = $DanhMuc->set_type('hoctap')->set_lang(1)->get_categoriesByLv(0);
        
        return view('OnlineCourse::Pi/add',[
             'categories' => $LSTDanhMuc->data()
        ]);
    }

    public function get_edit($pId) {
        $Model = CourseModel::find($pId);
        if ($Model == null) {
            session::flash('info_callback', (object) [
                        'message_title' => 'Thông báo',
                        'message_type' => 'warning',
                        'message' => 'Dữ liệu không có thực, vui lòng thử lại sau!'
            ]);
            return redirect()->route('mdle_oc_index');
        }

        // ----- Chống hack url ----------------------------------------------------------------------------------------
        if ($Model->id_user != session('user')['id']) {
            return redirect()->route('mdle_oc_index');
        }
        // -------------------------------------------------------------------------------------------------------------

        return view('OnlineCourse::Pi/add', [
            'item' => $Model
        ]);
    }

    public function post_save(Request $request) {

        $RESPONSE = (object) [
                    'action' => null,
                    'msg' => (object) [
                        'type' => 'success',
                        'text' => null,
                        'title' => 'Thông báo'
                    ]
        ];

        if ($request->has('id')) {
            $RESPONSE->action = 'cập nhật';
            $Model = CourseModel::find($request->input('id'));

            if ($Model == null) {
                $RESPONSE->msg->text = 'Dữ liệu không có thực!';
                $RESPONSE->msg->type = 'danger';
                goto responseArea;
            }

            // ----- Chống hack url ------------------------------------------------------------------------------------
            if ($Model->id_user != session('user')['id']) {
                return redirect()->route('mdle_oc_index');
            }
            // ---------------------------------------------------------------------------------------------------------
        } else {
            $RESPONSE->action = 'khởi tạo';
            $Model = new CourseModel();
            $Model->id_user = session('user')['id'];
            $Model->professor_name = session('user')['fullname'];
            $Model->name_meta = '#';
            $Model->views = 0;
            $Model->type = 'khoahoc';
        }

        $Model->name = $request->input('name');
        $Model->description = $request->input('description');
        $Model->distributor_price = $request->input('distributor_price');
        $Model->introduction_text = $request->input('introduction_text');
        $Model->promotion_text = $request->input('promotion_text');
        $Model->promotion_percent = $request->input('promotion_percent');
        $Model->content = $request->input('content');
        $Model->highlight = $request->input('highlight') == 'on' ? true : false;
        $Model->display = $request->input('display') == 'on' ? true : false;
        if ($Model->save()) {
            $RESPONSE->msg->text = "Khóa học $RESPONSE->action thành công!";
            $RESPONSE->msg->type = 'success';
        } else {
            $RESPONSE->msg->text = "$RESPONSE->action khóa học thất bại, vui lòng thử lại sau!";
            $RESPONSE->msg->type = 'warning';
        }

        responseArea:
        session::flash('info_callback', (object) [
                    'message_title' => $RESPONSE->msg->title,
                    'message_type' => $RESPONSE->msg->type,
                    'message' => $RESPONSE->msg->text,
        ]);
        return redirect()->route('mdle_oc_index');
    }

    public function get_chapter_index($id_course) {
        $RESPONSE = (object) [
                    'action' => null,
                    'redirect' => null,
                    'msg' => (object) [
                        'type' => 'success',
                        'text' => null,
                        'title' => 'Thông báo'
                    ]
        ];

        $CourseModel = CourseModel::find($id_course);

        if ($CourseModel == null) {
            session::flash('info_callback', (object) [
                        'message_title' => 'Thông báo',
                        'message_type' => 'warning',
                        'message' => 'Dữ liệu không có thực, vui lòng thử lại sau!'
            ]);
            return redirect()->route('mdle_oc_index');
        }

        // ----- Chống hack url ----------------------------------------------------------------------------------------
        if ($CourseModel->id_user != session('user')['id']) {
            return redirect()->route('mdle_oc_index');
        }
        // -------------------------------------------------------------------------------------------------------------

        $Models = \App\Modules\OnlineCourse\Models\ChapterModel::
                where([
                    ['id_course', '=', $id_course],
                    ['deleted_at', '=', null]
                ])
                ->paginate(5);

        ResponseArea:
        if ($RESPONSE->redirect != null) {
            if (Route::has($RESPONSE->redirect))
                return redirect()->route($RESPONSE->redirect);
        }
        return view('OnlineCourse::Pi/chapter_index', [
            'id_course' => $id_course,
            'course_info' => $CourseModel,
            'items' => $Models
        ]);
    }

    public function get_chapter_add($id_course) {

        $CourseModel = CourseModel::find($id_course);
        if ($CourseModel == null) {
            session::flash('info_callback', (object) [
                        'message_title' => 'Thông báo', 'message_type' => 'warning',
                        'message' => 'Dữ liệu không có thực, vui lòng thử lại sau!'
            ]);
            return redirect()->route('mdle_oc_index');
        }

        return view('OnlineCourse::Pi/chapter_add', [
            'course_info' => $CourseModel,
        ]);
    }

    public function get_chapter_edit($id_course, $id_chapter) {

        $CourseModel = CourseModel::find($id_course);

        $Model = \App\Modules\OnlineCourse\Models\ChapterModel::find($id_chapter);

        if ($CourseModel == null || $Model == null) {
            session::flash('info_callback', (object) [
                        'message_title' => 'Thông báo', 'message_type' => 'warning',
                        'message' => 'Dữ liệu không có thực, vui lòng thử lại sau!'
            ]);
            return redirect()->route('mdle_oc_chapter_index', $id_course);
        }

        // ----- Chống hack url ----------------------------------------------------------------------------------------
        if ($CourseModel->id_user != session('user')['id']) {
            return redirect()->route('mdle_oc_chapter_index', $id_course);
        }
        // -------------------------------------------------------------------------------------------------------------

        return view('OnlineCourse::Pi/chapter_add', [
            'course_info' => $CourseModel,
            'item' => $Model
        ]);
    }

    public function post_chapter_save(Request $request) {
        $RESPONSE = (object) [
                    'action' => null,
                    'msg' => (object) [
                        'type' => 'success',
                        'text' => null,
                        'title' => 'Thông báo'
                    ]
        ];

        if ($request->has('id')) {
            $RESPONSE->action = 'cập nhật';
            $Model = \App\Modules\OnlineCourse\Models\ChapterModel::find($request->input('id'));
            if ($Model == null) {
                $RESPONSE->msg->text = 'Dữ liệu không có thực!';
                $RESPONSE->msg->type = 'danger';
                goto responseArea;
            }

            $CourseModel = CourseModel::find($Model->id_course);
            if ($CourseModel == null) {
                $RESPONSE->msg->text = 'Dữ liệu không có thực!';
                $RESPONSE->msg->type = 'danger';
                goto responseArea;
            }
            // ----- Chống hack url ------------------------------------------------------------------------------------
            if ($CourseModel->id_user != session('user')['id']) {
                return redirect()->route('mdle_oc_chapter_index', $id_course);
            }
            // ---------------------------------------------------------------------------------------------------------
        } else {
            $RESPONSE->action = 'khởi tạo';
            $Model = new \App\Modules\OnlineCourse\Models\ChapterModel();
            $Model->id_course = $request->input('id_course');
        }
        $Model->ordinal_number = $request->input('ordinal_number') != null ? $request->input('ordinal_number') : 1;
        $Model->name = $request->input('name');
        $Model->description = $request->input('description');
        $Model->price = $request->input('price');
        $Model->promotion_price = $request->input('promotion_price');
        if ($Model->save()) {
            $RESPONSE->msg->text = "Chương $RESPONSE->action thành công!";
            $RESPONSE->msg->type = 'success';
        } else {
            $RESPONSE->msg->text = "$RESPONSE->action chương thất bại, vui lòng thử lại sau!";
            $RESPONSE->msg->type = 'warning';
        }

        responseArea:
        session::flash('info_callback', (object) [
                    'message_title' => $RESPONSE->msg->title,
                    'message_type' => $RESPONSE->msg->type,
                    'message' => $RESPONSE->msg->text,
        ]);
        return redirect()->route('mdle_oc_chapter_index', $request->input('id_course'));
    }

    public function get_lesson_index($id_course, $id_chapter) {

        $CourseModel = CourseModel::find($id_course);

        $ChapterModel = \App\Modules\OnlineCourse\Models\ChapterModel::find($id_chapter);

        if ($CourseModel == null || $ChapterModel == null) {
            // Dữ liệu không có thực.
        }

        $Models = \App\Modules\OnlineCourse\Models\LessonModel::where([
                    ['id_chapter', '=', $id_chapter],
                    ['deleted_at', '=', null]
                ])
                ->orderBy('ordinal_number', 'ASC')
                ->paginate(5);

        return view('OnlineCourse::Pi/lesson_index', [
            'id_course' => $id_course,
            'id_chapter' => $id_chapter,
            'course_info' => $CourseModel,
            'chapter_info' => $ChapterModel,
            'items' => $Models
        ]);
    }

    public function get_lesson_add($id_course, $id_chapter) {
        $CourseModel = CourseModel::find($id_course);

        $ChapterModel = \App\Modules\OnlineCourse\Models\ChapterModel::find($id_chapter);

        if ($CourseModel == null || $ChapterModel == null) {
            // Dữ liệu không có thực.
        }

        return view('OnlineCourse::Pi/lesson_add', [
            'course_info' => $CourseModel,
            'chapter_info' => $ChapterModel
        ]);
    }

    public function get_lesson_edit($id_course, $id_chapter, $id_lesson) {

        $CourseModel = CourseModel::find($id_course);

        $ChapterModel = \App\Modules\OnlineCourse\Models\ChapterModel::find($id_chapter);

        $LessonModel = \App\Modules\OnlineCourse\Models\LessonModel::find($id_lesson);

        if ($CourseModel == null || $ChapterModel == null || $LessonModel == null) {
            // Dữ liệu không có thực.
        }

        return view('OnlineCourse::Pi/lesson_add', [
            'course_info' => $CourseModel,
            'chapter_info' => $ChapterModel,
            'item' => $LessonModel
        ]);
    }

    public function post_lesson_save($id_course, $id_chapter, Request $request) {
        $RESPONSE = (object) [
                    'action' => null,
                    'msg' => (object) [
                        'type' => 'success',
                        'text' => null,
                        'title' => 'Thông báo'
                    ]
        ];

        // Bật tính năng tăng tốc load trang => bỏ qua bước xác thực Khóa học & chương
        $tang_toc_website = true;

        if ($tang_toc_website == false) {
            $CourseModel = CourseModel::find($id_course);
            $ChapterModel = \App\Modules\OnlineCourse\Models\ChapterModel::find($id_chapter);
            if ($CourseModel == null || $ChapterModel == null) {
                return "Dữ liệu không có thực.";
            }
        }

        if ($request->has('id')) {
            $Model = \App\Models\LessonModel::find($request->input('id'));
        } else {
            $Model = new \App\Modules\OnlineCourse\Models\LessonModel();
            $Model->id_chapter = $id_chapter;
        }

        $Model->name = $request->input('name');
        $Model->name_meta = str_slug($Model->name, '-');
        $Model->description = $request->input('description');
        // SEO
        $Model->seo_title = $request->input('seo_title');
        $Model->seo_description = $request->input('seo_description');
        $Model->seo_keywords = $request->input('seo_keywords');

        if ($Model->save()) {
            $RESPONSE->msg->text = "Bài học $RESPONSE->action thành công!";
            $RESPONSE->msg->type = 'success';
        } else {
            $RESPONSE->msg->text = "$RESPONSE->action bài học thất bại, vui lòng thử lại sau!";
            $RESPONSE->msg->type = 'warning';
        }
        responseArea:
        session::flash('info_callback', (object) [
                    'message_title' => $RESPONSE->msg->title,
                    'message_type' => $RESPONSE->msg->type,
                    'message' => $RESPONSE->msg->text,
        ]);
        return redirect()->route('mdle_oc_lesson_index', [
                    $request->input('id_course'),
                    $request->input('id_chapter')
        ]);
    }

    public function ajax(Request $request) {
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
                    $PM = CourseModel::whereIn('id', (array) $request->input('items'));
                    if ($PM->update(['deleted_at' => Carbon::now()])) {
                        $RESPONSE->status = true;
                        $RESPONSE->lst_id = $request->input('items');
                    } else {
                        $RESPONSE->status = false;
                    }
                    break;
                case 'ri':
                    $PM = CourseModel::find(trim($request->input('id')));
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
                case 'uh':
                    $PM = CourseModel::find(trim($request->input('id')));
                    if ($PM != null) {
                        $PM->highlight = !$PM->highlight;
                        if ($PM->save()) {
                            $RESPONSE->status = true;
                        }
                    } else {
                        $RESPONSE->status = false;
                    }
                    break;
                case 'ud':
                    $PM = CourseModel::find(trim($request->input('id')));
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
                    $PM = CourseModel::find(trim($request->input('id')));
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

    // ===== Auto import setting & database ============================================================================

    public function get_init() {
        $RC = (object) [
                    'Bcore' => (object) [
                        'status' => false,
                        'version' => ['>=', 1.3]
                    ],
                    '\App\Bcore\StorageService' => (object) [
                        'status' => false,
                        'version' => ['>=', 1.3]
                    ],
                    'Storage' => (object) [
                        'status' => false,
                        'version' => ['>=', 1.3]
                    ],
                    'App\Bcore\PackageServiceAD' => (object) [
                        'status' => false,
                        'version' => ['>=', 1.3]
                    ],
        ];
        foreach ($RC as $k => $v) {
            if (class_exists($k)) {
                if ($RC->{$k}->version != null) {
                    if (method_exists($k, 'version')) {
                        switch ($RC->{$k}->version[0]) {
                            case '>=':
                                if ($RC->{$k::version() >= $k}->version[1])
                                    $RC->{$k}->status = true;
                                break;
                            case '<=' :
                                if ($RC->{$k::version() <= $k}->version[1])
                                    $RC->{$k}->status = true;
                                break;
                            case '=' :
                                if ($RC->{$k::version() == $k}->version[1])
                                    $RC->{$k}->status = true;
                                break;
                            case '<':
                                if ($RC->{$k::version() < $k}->version[1])
                                    $RC->{$k}->status = true;
                                break;
                        }
                    } else {
                        $RC->{$k}->status = true;
                    }
                }
            }
        }
        dd($RC);

        return view('OnlineCourse::Pi/init');
    }

}
