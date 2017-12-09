<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamDetailModel1 extends Model {

    protected $table = 'm1_exam_detail';
    public $timestamps = false;
    protected $guarded = ['id', 'id_exam', 'tbl'];
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

}
