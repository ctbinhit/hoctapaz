<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use PayService;
use Illuminate\Support\Facades\DB;
use View;

class IndexController extends AdminController {

    public function index() {
        $this->load_chartMobileCard();
        return view($this->_RV . 'index/index', [
            'today_count_naprut' => $this->today_count_naprut()
        ]);
    }

    private function today_count_naprut() {
        return DB::table('users_transactions')
                        ->whereIn('type', ['ycr', 'ycn'])
                        ->whereDate('created_at', DB::raw('CURDATE()'))
                        ->count();
    }

    private function load_chartMobileCard() {
        $Chart_Users = DB::table('users')
                        ->where('type', 'user')
                        ->select(DB::raw('MONTH(created_at) as thang,COUNT(id) as soluong'))
                        ->groupBy(DB::raw('MONTH(created_at)'))->get();

        $CHART_USER_TRANSACTIONS = [];
        $CHART_USER_TRANSACTIONS_SUCCESS = [];
        $CHART_USER_TRANSACTIONS_FAIL = [];
        for ($i = 1; $i <= 12; $i++) {
            $CHART_USER_TRANSACTIONS[$i] = DB::table('users_transactions')
                    ->where('type', 'the-cao')
                    ->whereMonth('created_at', $i)
                    ->count();

            $CHART_USER_TRANSACTIONS_SUCCESS[$i] = DB::table('users_transactions')
                    ->where('type', 'the-cao')
                    ->where('state', 'success')
                    ->whereMonth('created_at', $i)
                    ->count();

            $CHART_USER_TRANSACTIONS_FAIL[$i] = DB::table('users_transactions')
                    ->where('type', 'the-cao')
                    ->where('state', 'error')
                    ->whereMonth('created_at', $i)
                    ->count();
        }
        View::share('CHART_USERCOUNT', $Chart_Users);
        View::share('CHART_TRANSACTIONS', $CHART_USER_TRANSACTIONS);
        View::share('CHART_TRANSACTIONS_SUCCESS', $CHART_USER_TRANSACTIONS_SUCCESS);
        View::share('CHART_TRANSACTIONS_ERROR', $CHART_USER_TRANSACTIONS_FAIL);
    }

}
