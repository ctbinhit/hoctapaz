<?php

namespace App\Modules\Seo\Controllers\Admin;

use App\Bcore\PackageServiceAD;
use Illuminate\Http\Request;
use DB;
// SYSTEM SERVICE
use App\Bcore\Services\NotificationService;
// SYSTEM MODEL
use App\Models\SettingModel;

class SeoController extends PackageServiceAD {

    function __construct() {
        
    }

    public function get_google_analytics(Request $request) {
        $SettingModel = DB::table('setting')
                ->select([
                    'setting.google_analytics', 'setting.google_analytics_structure'
                ])
                ->first();

        if ($SettingModel == null) {
            return 'Không tìm thấy dữ liệu hệ thống';
        }

        responseArea:
        return view('Seo::Admin/Seo/google_analytics/index', [
            'item' => $SettingModel
        ]);
    }

    public function post_google_analytics(Request $request) {
        $setting_id = 'info';
        $SettingModel = \App\Models\SettingModel::find($setting_id);
        $SettingModel->google_analytics = $request->input('google_analytics');
        if ($SettingModel->save()) {
            NotificationService::alertRight('Cập nhật thành công', 'success');
        } else {
            NotificationService::alertRight('Cập nhật thành công', 'success');
        }
        return redirect()->route('mdle_admin_seo_analytics');
    }

}
