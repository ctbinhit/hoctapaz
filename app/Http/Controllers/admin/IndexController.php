<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use PayService;
use Illuminate\Support\Facades\DB;

class IndexController extends AdminController {

    public function index() {
        
        $PayService = new PayService();
        $Chart_bitcoin = $PayService->get_marketInfo('bitcoin');

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

        return view($this->_RV . 'index/index', [
            'BITCOIN' => $Chart_bitcoin->get_market(),
            'CHART_USERCOUNT' => $Chart_Users,
            'CHART_TRANSACTIONS' => $CHART_USER_TRANSACTIONS,
            'CHART_TRANSACTIONS_SUCCESS' => $CHART_USER_TRANSACTIONS_SUCCESS,
            'CHART_TRANSACTIONS_ERROR' => $CHART_USER_TRANSACTIONS_FAIL
        ]);
    }

    public static function register_permissions() {
        return (object) [
                    'admin' => (object) [
                        'per_require' => (object) [
                            'per_view_chart_1' => (object) [
                                'name' => 'Xem biểu đồ thống kê doanh thu',
                                'default' => false
                            ],
                            'per_view_chart_2' => (object) [
                                'name' => 'Xem biểu đồ thống kê thiết bị truy cập',
                                'default' => false
                            ],
                            'per_view_chart_3' => (object) [
                                'name' => 'Xem biểu đồ thống kê top thi trắc nghiệm',
                                'default' => false
                            ],
                        ],
                        'signin_require' => true,
                        'classes_require' => (object) [
                            'App\Bcore\StorageService',
                            'App\Models\ArticleOModel',
                            'Illuminate\Support\Facades\Lang'
                        ]
                    ],
                    'client' => (object) [
                        'signin_require' => false,
                    ]
        ];
    }

}
