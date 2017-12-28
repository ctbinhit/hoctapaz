<?php

namespace App\Modules\OnlineCourse\App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Bcore\Services\ImageService;
use App\Models\FileModel;
use App\Bcore\Services\UserServiceV2;
use App\Bcore\Services\UserServiceV3;
use App\Bcore\SystemComponents\User\UserType;
use App\Modules\OnlineCourse\Models\ExamModel;
use App\Modules\OnlineCourse\Models\ExamUserModel;
use App\Modules\OnlineCourse\Components\ExamState;
use App\Modules\OnlineCourse\Models\ExamRegisteredModel;

class ExamHelper {

    private $_examRegisteredModels = null;
    private $_examRegisteredModel = null;
    private $_request = null;
    private $_options = [
        'paginate' => 5,
        'operator' => ['=', '>', '<', '<>', '>=', '<='],
        'withUserPhoto' => true,
        'withFileUrl' => false,
        'select' => [
            'm1_exam_registered.id', 'm1_exam_registered.name', 'm1_exam_registered.name_meta', 'm1_exam_registered.description',
            'm1_exam_registered.time', 'm1_exam_registered.price', 'm1_exam_registered.price2', 'm1_exam_registered.created_at',
            'm1_exam_registered.id_category', 'm1_exam_registered.id_user', 'm1_exam_registered.start_date', 'm1_exam_registered.expiry_date',
            'm1_exam_registered.seo_title', 'm1_exam_registered.seo_description', 'm1_exam_registered.seo_keywords',
            'm1_exam_registered.id_exam', 'm1_exam_registered.app_type',
            'm1_exam_registered.version', 'm1_exam_registered.code', 'm1_exam_registered.state',
            'users.fullname as user_fullname', 'users.avatar as user_photo',
            'categories_lang.name as cate_name'
        ]
    ];

    public function __construct() {
        
    }

    // REGISTER

    public function register_appData($user_model, $erm_model = null) {
        if ($erm_model != null) {
            $this->_examRegisteredModel = $erm_model;
        }
        $EUM = (new ExamUserModel());
        $EUM->erm_code = $this->_examRegisteredModel->code;
        $EUM->erm_id = $this->_examRegisteredModel->id;
        $EUM->erm_price = $this->_examRegisteredModel->price;
        $EUM->erm_price2 = $this->_examRegisteredModel->price2;
        $EUM->code = (new \Carbon\Carbon)->now()->timestamp;
        $EUM->id_user = $user_model->id;
        $EUM->id_exam = $this->_examRegisteredModel->id_exam;
        $EUM->type = $this->_examRegisteredModel->app_type;
        return $EUM->save();
    }

    public function set_request($request) {
        $this->_request = $request;
        return $this;
    }

    public function load_modelByMetaName($meta_name) {
        $this->_examRegisteredModel = DB::table('m1_exam_registered')
                ->join('users', "users.id", '=', "m1_exam_registered.id_user")
                ->join('categories', "categories.id", '=', "m1_exam_registered.id_category")
                ->join('categories_lang', "categories_lang.id_category", '=', "categories.id")
                ->where('m1_exam_registered.name_meta', $meta_name)
                ->select($this->_options['select']);
        return $this;
    }

    // Copy
    public function load_ermByMetaName($meta_name) {
        $this->_examRegisteredModel = DB::table('m1_exam_registered')
                ->join('users', "users.id", '=', "m1_exam_registered.id_user")
                ->join('categories', "categories.id", '=', "m1_exam_registered.id_category")
                ->join('categories_lang', "categories_lang.id_category", '=', "categories.id")
                ->where('m1_exam_registered.name_meta', $meta_name)
                ->select($this->_options['select']);
        return $this;
    }

    public function load_ermById($id) {
        $this->_examRegisteredModel = DB::table('m1_exam_registered')
                ->join('users', "users.id", '=', "m1_exam_registered.id_user")
                ->join('categories', "categories.id", '=', "m1_exam_registered.id_category")
                ->join('categories_lang', "categories_lang.id_category", '=', "categories.id")
                ->where('m1_exam_registered.id', $id)
                ->select($this->_options['select']);
        return $this;
    }

    public function load_models() {
        $a = 'm1_exam_registered';
        $u = 'users';
        $c = 'categories';
        $cl = 'categories_lang';
        $this->_examRegisteredModels = DB::table('m1_exam_registered')
                ->join($u, "$u.id", '=', "m1_exam_registered.id_user")
                ->join($c, "$c.id", '=', "$a.id_category")
                ->join($cl, "$cl.id_category", '=', "$c.id")
                ->where('categories_lang.id_lang', 1)
                ->select($this->_options['select']);
        return $this;
    }

    public function filter($fields) {
        $request = $this->_request;
        if ($request->has('keywords')) {
            if ($request->has('filterBy')) {
                switch ($request->input('filterBy')) {
                    case 'username':
                        $this->_examRegisteredModels->where('users.fullname', 'LIKE', '%' . $request->input('keywords') . '%');
                        break;
                    default:
                        goto defaultFilterArea;
                }
            } else {
                defaultFilterArea:
                $this->_examRegisteredModels->where('m1_exam_registered.seo_keywords', 'LIKE', '%' . $request->input('keywords') . '%');
            }
        }
        return $this;
    }

    public function set_where($field, $val, $op = '=') {
        if (in_array($op, $this->_options['operator'])) {
            $this->_examRegisteredModels->where($field, $op, $val);
        } return $this;
    }

    public function set_options($options) {
        $this->_options = array_merge($this->_options, $options);
        return $this;
    }

    public function set_userType($user_type) {
        $this->_examRegisteredModels->where('users.type', $user_type);
        return $this;
    }

    public function set_approvedField() {
        $this->_examRegisteredModels->where('m1_exam_registered.approved_by', 1);
        return $this;
    }

    public function set_modesState($state = 1, $op = '=') {
        if (in_array($op, $this->_options['operator'])) {
            $this->_examRegisteredModels->where('m1_exam_registered.state', $op, (int) $state);
        } return $this;
    }

    public function set_orderBy() {
        $this->orderBy('m1_exam_registered.id', 'DESC');
        return $this;
    }

    public function get_models() {
        $models = $this->_examRegisteredModels->paginate($this->_options['paginate']);
        if ($this->_options['withUserPhoto']) {
            $models = $this->pri_addUserPhoto($models);
        }
        return $models;
    }

    public function get_model() {
        $model = $this->_examRegisteredModel->first();
        if ($this->_options['withFileUrl']) {
            if ($this->_examRegisteredModel != null) {
                $FILE = FileModel::where([
                            ['obj_id', $model->id_exam],
                            ['id_user', $model->id_user],
                            ['obj_table', 'm1_exam']
                        ])->orderBy('id', 'DESC')->select(['url'])->first();
                if ($FILE != null) {
                    $model->file_url = Storage::disk('localhost')->url($FILE->url);
                } else {
                    $model->file_url = null;
                }
            }
        }
        return $model;
    }

    public function append_options($opt_name, $value) {
        switch ($opt_name) {
            case 'select':
                $this->_options[$opt_name][] = (string) $value;
                break;
        }
        return $this;
    }

    public function append_fileUrl() {
        $this->_options['withFileUrl'] = true;
        return $this;
    }

    private function pri_addUserPhoto($models) {
        foreach ($models as $v) {
            if (Storage::disk('localhost')->exists($v->user_photo)) {
                $v->user_photo_url = Storage::disk('localhost')->url($v->user_photo);
            } else {
                $v->user_photo_url = ImageService::no_userPhoto();
            }
        }
        return $models;
    }

}
