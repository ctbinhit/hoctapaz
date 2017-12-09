<?php

namespace App\Modules\APM\Controllers\Admin;

use Illuminate\Http\Request;
use App\Bcore\PackageServiceAD;
use App\Modules\APM\Models\APMModel;
use SessionService;
use ImageService;
use Session,
    Storage,
    Carbon\Carbon;
use App\Bcore\Services\NotificationService;

class APMController extends PackageServiceAD {

    public $asset_type = ['css', 'javascript', 'image'];

    public function __construct() {
        parent::__construct();
    }

    public function get_index() {
        $CSSModel = APMModel::find('css');
        if ($CSSModel == null) {
            $r = $this->init('css');
        }
        $JAVAModel = APMModel::find('javascript');
        if ($JAVAModel == null) {
            $r = $this->init('javascript');
        }
        return view('APM::Admin/APM/index', [
            'css' => @$CSSModel,
            'javascript' => @$JAVAModel
        ]);
    }

    public function save(Request $request) {
        try {
            $CSSModel = APMModel::find('css');
            $CSSModel->version = $request->input('version_css');
            $CSSModel->cache = $request->input('cache_css') == 'on' ? true : false;
            $CSSModel->save();
            $JAVAModel = APMModel::find('javascript');
            $JAVAModel->version = $request->input('version_javascript');
            $JAVAModel->cache = $request->input('cache_javascript') == 'on' ? true : false;
            $JAVAModel->save();
            NotificationService::alertRight('Cập nhật thành công!', 'success');
        } catch (\Exception $ex) {
            NotificationService::alertRight('Cập nhật không thành công!', 'warning');
        }
        return redirect()->route('mdle_admin_apm_index');
    }

    private function init($id) {
        $APMModel = new APMModel();
        $APMModel->id = $id;
        $APMModel->name = $id;
        $APMModel->version = 1;
        $APMModel->cache = true;
        $r = $APMModel->save();
        if ($r) {
            return $APMModel;
        } else {
            return false;
        }
    }

}
