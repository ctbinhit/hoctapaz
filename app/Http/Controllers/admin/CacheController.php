<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use Cache,
    Route;

class CacheController extends AdminController {

    private $Cache = [
        'Sync' => [
            'SETTING_SYNC_GOOGLEDRIVE'
        ],
        'Setting' => [
            'SETTING',
            '_SETTING'
        ],
        'Article' => [
            // Prefix_Table_Type
            'ARTICLE_exam_hoctap',
        ]
    ];

    public function clear($cate, $url = 'admin_index', Request $request) {
        if (Cache::has($cate)) {
            Cache::forget($cate);
            $request->session()->flash('message', __('message.cachedaduocxoa'));
        } else {
            $request->session()->flash('message', __('message.cachedaduocxoa'));
        }
        if ($request->has('type')) {
            return redirect()->route($url, $request->input('type'));
        } else {
            return redirect()->route($url);
        }
    }

    public function clearSync(Request $request) {
        foreach ($this->Cache['Sync'] as $k => $v) {
            if (Cache::has($v)) {
                Cache::forget($v);
            }
        }
        $request->session()->flash('message', __('message.cachedaduocxoa'));
        return redirect()->route('admin_setting_account');
    }

    public function clearCategory($pTable = null, $pType = null, Request $request) {
        if ($pTable == null && $pTable == null) {
            foreach ($this->Cache['Setting'] as $k => $v) {
                if (Cache::has($v)) {
                    Cache::forget($v);
                }
            }
        } else {
            $CacheName = "ARTICLE_$pTable" . "_$pType";
            if (Cache::has($CacheName)) {
                Cache::forget($CacheName);
            }
        }
        $request->session()->flash('message', __('message.cachedaduocxoa'));
        return redirect()->route('admin_category_index', [$pTable, $pType]);
    }

    public function clearSetting($pRoute = null, Request $request) {
        $this->remove_cache_setting();
         refirectArea:
            return redirect()->route('admin_setting_index');
    }

}
