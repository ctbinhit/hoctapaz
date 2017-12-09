<?php

/* =====================================================================================================================
 *                                              LIST VIEW SERVICE
 * ---------------------------------------------------------------------------------------------------------------------
 * 
 * =====================================================================================================================
 */

namespace App\Bcore\Services;

use App\Bcore\Bcore;
use Illuminate\Support\Facades\Session;

class ListViewService extends Bcore {

    public static function getDataView($request_count = null, $time = 3600) {
        try {
            $ss_name = 'PAGE_' . url()->current() . '_VIEW';
            if ($request_count != null) {
                if ((int) $request_count != (int) Session::get($ss_name)) {
                    Session::put([$ss_name => (int) $request_count]);
                }
            }
            if (Session::has($ss_name)) {
                return (int) Session($ss_name);
            } else {
                return 5;
            }
        } catch (\Exception $ex) {
            return 5;
        }
    }

    public static function setDataView($request_count = null) {
        try {
            $ss_name = 'PAGE_' . url()->current() . '_VIEW';
            Session::put([$ss_name => (int) $request_count]);
            return (int) Session($ss_name);
        } catch (\Exception $ex) {
            return 5;
        }
    }

}
