<?php

namespace App\Modules\UserVIP\Controllers\Admin;

use App\Bcore\PackageServiceAD;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;

class UserVIPController extends PackageServiceAD {

    public function get_index(Request $request) {

        $UserVIPModels = \App\Modules\UserVIP\Models\UserVIPModel::paginate(10);

        return view('UserVIP::Admin/index', [
            'items' => @$UserVIPModels
        ]);
    }

    public function get_add(Request $request) {


        return view('UserVIP::Admin\add');
    }

    public function get_edit($id, Request $request) {

        $Model = \App\Modules\UserVIP\Models\UserVIPModel::find($id);
        if ($Model == null) {
            alertRight('Dữ liệu không có thực, vui lòng thử lại.', 'danger');
            return redirect()->route('mdle_uservip_index');
        }
        return view('UserVIP::Admin\add', [
            'item' => $Model
        ]);
    }

    public function post_save(Request $request) {

        if ($request->has('id')) {
            $UserVipModel = \App\Modules\UserVIP\Models\UserVIPModel::
                    find($request->input('id'));
            if ($UserVipModel == null) {
                
            }
        } else {
            $UserVipModel = new \App\Modules\UserVIP\Models\UserVIPModel();
        }
        $UserVipModel->name = $request->input('name');
        $UserVipModel->discount = $request->input('discount');
        $UserVipModel->sum = $request->input('sum');
        $UserVipModel->note = $request->input('note');
        $r = $UserVipModel->save();
        if ($r) {
            \App\Bcore\Services\NotificationService::
            alertRight('Lưu thành công.', 'success');
        } else {
            \App\Bcore\Services\NotificationService::
            alertRight('Lưu không thành công, vui lòng thử lại.', 'warning');
        }
        return redirect()->route('mdle_uservip_index');
    }

}
