<?php

namespace App\Modules\OnlineCourse\App;

use App\Bcore\Services\UserServiceV2;
use App\Bcore\Services\UserServiceV3;
use App\Bcore\SystemComponents\User\UserType;
use App\Modules\OnlineCourse\Models\ExamModel;
use App\Modules\OnlineCourse\Components\ExamState;
use App\Modules\OnlineCourse\Models\ExamRegisteredModel;

class ExamBuilder {

    private $_act = null;
    private $_node = [];
    private $_type = null;
    private $_date = null;
    private $_examModel = null;
    private $_examVirtual = null;
    // LOG(S)
    private $_log = null;
    private $_logs = [];

    function __construct() {
        $this->_date = \Carbon\Carbon::now();
    }

    public function do_insert() {
        $this->_act = __FUNCTION__;
        $this->_examModel = new ExamModel();
        $this->_examModel->id_user = UserServiceV2::current_userId(UserType::professor());
        $this->_examModel->views = 0;
        return $this;
    }

    public function do_update($id_exam) {
        $this->_act = __FUNCTION__;
        $this->_examModel = ExamModel::find($id_exam);
        return $this;
    }

    public function load_app($id_exam) {
        $this->_act = __FUNCTION__;
        $this->_examModel = ExamModel::find($id_exam);
        return $this;
    }

    public function register_app() {
        if ($this->_examModel == null || $this->_act == null)
            return false;
        $ERM = (new ExamRegisteredModel());
        $ERM->version = \Carbon\Carbon::now()->timestamp;
        $ERM->code = md5(\Carbon\Carbon::now());
        $ERM->name = $this->_examModel->name;
        $ERM->name_meta = $this->_examModel->name_meta;
        $ERM->description = $this->_examModel->description;
        $ERM->app_data = $this->_examModel->app_data;
        $ERM->app_type = $this->_examModel->app_type;
        $ERM->app_role = 1;
        $ERM->id_exam = $this->_examModel->id;
        $ERM->id_user = $this->_examModel->id_user;
        $ERM->id_category = $this->_examModel->id_category;
        $ERM->time = $this->_examModel->time;
        $ERM->price = $this->_examModel->price;
        $ERM->price2 = $this->_examModel->price2;
        $ERM->exam_data = json_encode($this->_examModel);
        $ERM->user_data = (new UserServiceV3())->professor()->current()
                        ->set_options(['select' => \App\Models\UserModel::data_fields()])->loadFromDatabase()->get_jsonModel();
        $ERM->start_date = $this->_examModel->start_date;
        $ERM->expiry_date = $this->_examModel->expiry_date;
        $ERM->seo_title = $this->_examModel->seo_title;
        $ERM->seo_keywords = $this->_examModel->seo_keywords;
        $ERM->seo_description = $this->_examModel->seo_description;
        return $ERM->save();
    }

    public function set_modelByRequest($request) {
        if ($this->_examModel == null || $this->_act == null)
            return false;
        $ExamModel = $this->_examModel;
        $ExamModel->id_category = $request->input('id_category');
        $ExamModel->name = $request->input('name');
        $ExamModel->time = (int) ($request->input('time_h') * 60 * 60) + (int) ($request->input('time_m') * 60) + (int) $request->input('time_s');
        $ExamModel->price = $request->input('price');
        $ExamModel->price2 = $request->input('price2');
        $ExamModel->start_date = $request->input('time_start');
        $ExamModel->expiry_date = $request->input('time_end');
        $ExamModel->name_meta = str_slug($request->input('name'), '-');
        $ExamModel->description = $request->input('description');
        $ExamModel->state = ExamState::free();
        // ----- APP ---------------------------------------------------------------------------------------------------
        $ExamModel->app_data = $this->convert_questionsToJsonData($request->questions);
        // ----- SEO ---------------------------------------------------------------------------------------------------
        $ExamModel->seo_title = $request->input('seo_title');
        $ExamModel->seo_description = $request->input('seo_description');
        $ExamModel->seo_keywords = $request->input('seo_keywords');
        $this->_examModel = $ExamModel;
        return $this;
    }

    public function get_examModel() {
        return $this->_examModel;
    }

    public function save() {
        return $this->_examModel->save();
    }

    private function convert_questionsToJsonData($questions) {
        foreach ($questions as $k => $v) {
            $Node = [
                'ordinal_number' => $k + 1,
                'type' => 'normal',
                'label' => ['A', 'B', 'C', 'D'],
                'answer_type' => 'boolean',
                'answer' => $v
            ];
            $this->_node[] = $Node;
        }
        return json_encode([
            'build_at' => $this->_date,
            'type' => $this->_type,
            'data' => $this->_node
        ]);
    }

}
