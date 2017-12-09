<?php

/* Created By Bình Cao - Developed by ToanNangCo., Ltd >= 1.3
 * 
 */

namespace App\Modules\UserPermission\Services;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Modules\UserPermission\Models\SystemControllersModel;
use App\Modules\UserPermission\Models\SystemControllersDetailModel;

class UPService {

    public $THIS = null;
    public $DATA_HEADER = null;
    public $DATA_PERMISSIONS = [];
    public $DATA_TYPE = [];

    public function __construct($class) {
        $this->THIS = $class;
    }

    // INFO ------------------------------------------------------------------------------------------------------------

    function set_header($name, $build_date) {
        $this->DATA_HEADER = [
            'class' => $name,
            'name' => $build_date
        ];
        return $this;
    }

    // REGISTER PERMISSION ---------------------------------------------------------------------------------------------

    function rp($per_name, $title) {
        return $this->register_permission($per_name, $title);
    }

    public function register_permission($per_name, $title) {
        $this->DATA_PERMISSIONS[] = [$per_name => $title];
        return $this;
    }

    // REGISTER TYPE ---------------------------------------------------------------------------------------------------

    public function rt($type, $title, $data = null) {
        return $this->register_type($type, $title, $data);
    }

    public function register_type($type, $title, $data = null) {
        $this->DATA_TYPE[] = [$type => [
                'name' => $title,
                'name_meta' => $type,
                'default' => isset($data['default']) ? $data['default'] : false,
                'columns' => $data['columns']
        ]];
        return $this;
    }

    // RUN CODE --------------------------------------------------------------------------------------------------------

    public function run() {
        return $this->executePermissionData();
    }

    public function done() {
        return $this->executePermissionData();
    }

    // PRIVATE FUNCTION ------------------------------------------------------------------------------------------------

    private function executePermissionData() {
        return [
            'path' => $this->THIS,
            'header' => $this->DATA_HEADER != null ? $this->DATA_HEADER : $this->set_header($this->THIS, 'unknown!')->DATA_HEADER,
            'permissions' => $this->DATA_PERMISSIONS,
            'strict_type' => $this->DATA_TYPE
        ];
    }

    // DEFAULT VALUE ---------------------------------------------------------------------------------------------------
}
