<?php

namespace App\Modules\BKPayment\Controllers\Client;

use Illuminate\Http\Request;
use App\Bcore\PackageService;
use PhotoModel;
use SessionService;
use ImageService;
use Session,
    Storage,
    Carbon\Carbon;
use App\Bcore\Services\SeoService;

class BKPaymentController extends PackageService {

    public function __construct() {
        parent::__construct();
    }

    public function get_index() {
        
        SeoService::seo_title('Nạp thẻ | Học Tập AZ');
        
        return view('BKPayment::Client/index');
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

        switch ($R->status_code) {
            case 200:
                $User->coin = $User->coin + $R->card_value;
                if ($User->save()) {
                    session::flash('card_success', [
                        'user' => $User,
                        'card' => $R->card_value
                    ]);
                    return 'Nạp tiền thành công ' . $User->coin;
                } else {
                    \App\Bcore\Services\NotificationService::popup_default('Thao tác thất bại, có lỗi xảy ra!');
                }
                break;
            case 202: //Giao dịch chưa xác định được trạng thái thành công hay không! TimeOut
                \App\Bcore\Services\NotificationService::popup_default('Không có phản hồi, thao tác thất bại.');
                break;
            case 450:
                \App\Bcore\Services\NotificationService::popup_default('Lỗi hệ thống!');
                break;
            case 460:
                \App\Bcore\Services\NotificationService::popup_default($R->msg);
                break;
        }
        return redirect()->route('mdle_bkp_napthe');
    }

}
