<?php

namespace App\Http\Controllers\pi;

use Illuminate\Http\Request;
use App\Http\Controllers\ProfessorController;
use View,
    Config;
use App\Bcore\StorageService;

class CourseController extends ProfessorController {

    public $storage_folder = 'courses';
    public $ControllerName = 'Course';
    public $StorageGoogle = null;

    use \App\Functions\AdminFunction;

    public function __construct() {
        parent::__construct($this->ControllerName);

        $this->sendDataToView(array(
            'route_ajax' => 'pi_index_ajax'
        ));
        // ----- Lấy nơi lưu trữ trên google ---------------------------------------------------------------------------
        $this->StorageGoogle = config::get('Bcore.storage_service.google_drive.GOOGLE_DRIVE_FOLDER_COURSE');
        View::share('_ControllerName', $this->ControllerName);
    }

    public function controller_require($pType = null) {
        if ($pType == null) {
            return redirect()->route('pi_index_index');
        }
    }

    public function get_index($pType = null) {
        $this->controller_require($pType);

    //    dump('a');

        return view($this->_RV . 'course/index', [
            'items' => null,
            'type' => $pType,
        ]);
    }

    public function get_edit() {
        
    }

    public function get_add() {
        
    }

    public function post_save() {
        
    }

    public function _ajax() {
        
    }

}
