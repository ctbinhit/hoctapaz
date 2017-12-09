<?php

namespace App\Modules\OnlineCourse\Models;

use Illuminate\Database\Eloquent\Model;

class ExamUserModel extends Model {

    protected $table = 'm1_exam_user';
    public $timestamps = true;
    protected $guarded = ['id', 'id_user', 'id_exam', 'tbl', 'time_in', 'created_at'];
// ===== OPTIONS ===================================================================================================
    private $_select = null;
    private $_orderBy = null;
    private $_keyword = null;
    private $_type = null;
    private $_lang = 1;
    private $_deleted = null;
    private $_perPage = 10;
    private $_where = null;
// ===== RESULT VARIABLES =========================================================================================
    private $_result = null;
    private $_log = null;

    public static function registerUser($id_user, $id_exam) {
        $model = new ExamUserModel();
        $model->code = null;
        $model->id_user = $id_user;
        $model->id_exam = $id_exam;
        return $model->save();
    }

}
