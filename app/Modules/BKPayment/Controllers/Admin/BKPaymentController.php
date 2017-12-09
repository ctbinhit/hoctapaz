<?php

namespace App\Modules\BKPayment\Controllers\Admin;

use Illuminate\Http\Request;
use App\Bcore\PackageServiceAD;
use PhotoModel;
use SessionService;
use ImageService;
use Session,
    Storage,
    Carbon\Carbon;

class BKPaymentController extends PackageServiceAD {

    public function __construct() {
        parent::__construct();
    }

    public function get_index() {

        return view('BKPayment::Admin/index');
    }

    public function post_index(Request $request) {

        $User = \App\Models\UserModel::find(session('user')['id']);

        if ($User == null) {
            return "User không hợp lệ!";
        }
        $card_seri = $request->input('txtseri');
        $card_pin = $request->input('txtpin');
        $mang = $request->input('chonmang');

        $BGTC = new \App\Modules\BKPayment\Services\BKTCService();
        $BGTC->set_card($mang, $card_seri, $card_pin);

        $R = (object) $BGTC->payment();

        if ($R->status) {
            $User->coin = $User->coin + $R->card_value;
            if ($User->save()) {
                return 'Nạp tiền thành công ' . $User->coin;
            } else {
                return 'Nạp tiền không thành công ';
            }
        } else {
            dd($R);
        }
        dd($R);
    }

    /*
     *  User payment history
     */

    public function get_uph(Request $request) {

        $Models = new \App\Models\UserTransactionModel();
        $items = $Models->set_keywords($request->input('keywords'))
                ->set_orderBy(['created_at', 'DESC'])
                ->set_where([
                    ['amount', '=', $request->input('amount')],
                    ['card_type', '=', $request->input('card_type')],
                    ['state', '=', $request->input('state')]
                ])
                ->set_perPage(5)
                ->execute();
        
        return view('BKPayment::Admin/ugh', [
            'items' => $items->data(),
            'items_link' => $items->data()->appends([
                'amount' => $request->input('amount'),
                'card_type' => $request->input('card_type'),
                'state' => $request->input('state'),
                'keywords' => $request->input('keywords'),
            ]),
            'total' => $items->get_total('amount'),
            'trans_success_count' => $items->get_trans_success_count(),
            'trans_error_count' => $items->get_trans_error_count(),
            'chart_card_type' => $items->get_listCardTypeWithCount()
        ]);
    }

}
