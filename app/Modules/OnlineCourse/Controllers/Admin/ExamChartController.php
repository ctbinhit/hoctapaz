<?php

namespace App\Modules\OnlineCourse\Controllers\Admin;

use App\Bcore\PackageServiceAD;
use Illuminate\Http\Request;
use App\Bcore\Services\UserServiceV2;
use App\Bcore\System\UserType;
use App\Modules\OnlineCourse\Models\ExamUserModel;
use DB,
    View;

class ExamChartController extends PackageServiceAD {

    public $module_name = 'OnlineCourse';
    public $ControllerName = 'ExamChart';

    function __construct() {
        parent::__construct();
    }

    public function get_index($type, Request $request) {
        $ExamUserModel = DB::table('m1_exam_user')
                ->join('users', 'users.id', '=', 'm1_exam_user.id_user')
                ->join('m1_exam', 'm1_exam.id', '=', 'm1_exam_user.id_exam')
                ->where([
                    ['m1_exam_user.type', $type]
                ])
                ->orderBy('m1_exam_user.created_at', 'DESC')
                ->select([
            'm1_exam_user.id', 'm1_exam_user.code', 'm1_exam_user.score', 'm1_exam_user.time_in', 'm1_exam_user.time_end',
            'm1_exam_user.time_out', 'm1_exam_user.type', 'm1_exam_user.created_at',
            'm1_exam.name', 'm1_exam.name_meta', 'm1_exam_user.id_user', 'm1_exam.id as id_exam', 'm1_exam.time as exam_time',
            'users.fullname', 'users.id as id_user', 'users.email'
        ]);

        return view('OnlineCourse::Admin/ExamChart/index', [
            'items' => $ExamUserModel->paginate(5)
        ]);
    }

    public function get_analytics() {
        
    }

    public function ajax() {
        
    }

}
