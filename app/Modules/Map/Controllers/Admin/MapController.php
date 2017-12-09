<?php

namespace App\Modules\Map\Controllers\Admin;

use App\Bcore\PackageServiceAD;
use Illuminate\Http\Request;
use DB;
use App\Modules\Map\Models\MapModel;
// SYSTEM SERVICE
use App\Bcore\Services\NotificationService;
// SYSTEM MODEL
use App\Models\SettingModel;

class MapController extends PackageServiceAD {

    function __construct() {
        parent::__construct();
    }

    public function get_map(Request $request) {
        $MapModel = MapModel::where([
                    ['main_position', 1]
                ])->first();

        if ($MapModel == null) {
            return "Lỗi dữ liệu.";
        }

        return view('Map::Admin/map/index', [
            'map_info' => $MapModel
        ]);
    }

    public function post_map(Request $request) {
        $MapModel = MapModel::find($request->input('id'));

        if ($MapModel == null) {
            NotificationService::alertRight('Dữ liệu không tồn tại.', 'danger');
            goto redirectArea;
        }
        $MapModel->infowindow_title = $request->input('title');
        $MapModel->infowindow_description = $request->input('description');
        $MapModel->latitude = $request->input('pos_latitude');
        $MapModel->longitude = $request->input('pos_longitude');
        $MapModel->address_formated = $request->input('address');

        if ($MapModel->save()) {
            NotificationService::alertRight('Cập nhật thành công.', 'success');
        } else {
            NotificationService::alertRight('Cập nhật không thành công, vui lòng thử lại sau.', 'warning');
        }
        
        redirectArea:
        return redirect()->route('mdle_admin_map');
    }

}
