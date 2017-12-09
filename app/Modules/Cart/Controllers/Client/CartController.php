<?php

namespace App\Modules\Cart\Controllers\Client;

use App\Bcore\PackageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends PackageService {

    public function __construct() {
        parent::__construct();
    }

    public function get_index() {
        return view('Cart::Client/Cart/index');
    }

    public function get_payment() {
        if (\App\Bcore\Services\OrderService::cart() == null) {
            return redirect()->route('mdle_cart_index');
        }


        $UserInfo = \App\Models\UserModel::find(\App\Bcore\Services\UserService::id());

        if ($UserInfo == null) {
            \App\Bcore\Services\UserService::logout();
        }

        if (\App\Bcore\Services\OrderService::cartCount() == 0) {
            return redirect()->route('mdle_cart_index');
        }

        $CartInfo = \App\Bcore\Services\OrderService::cartAnalyze();

        return view('Cart::Client/Cart/payment', [
            'ui' => $UserInfo,
            'ci' => $CartInfo
        ]);
    }

    public function post_payment(Request $request) {

        if (!\App\Bcore\Services\UserService::isLoggedIn()) {
            return redirect()->route('mdle_cart_payment');
        }

        if (!$request->has('httt')) {


            return back()->withInput();
        }

        if (!$request->has('email') || !$request->has('address')) {

            return back()->withInput();
        }

        $CartInfo = \App\Bcore\Services\OrderService::cartAnalyze();

        switch ($request->input('httt')) {
            case 'thanh-toan-tien-mat':

                break;
            case 'thanh-toan-vi-az':
                $UserInfo = \App\Bcore\Services\UserService::db_info();
                $user_coin = $UserInfo->coin;
                $cart_sum = (int) $CartInfo['sum'];
                if ($user_coin < $cart_sum) {
                    // User không đủ tiền mua đồ T.T

                    return back()->withInput();
                }
                $UserInfo->coin -= $cart_sum;
                $r = $UserInfo->save();
                if (!$r) {
                    // Có lỗi xảy ra trong quá trình trừ tiền user & không thực hiện bất kì thao tác nào ( Chưa trừ tiền là chưa mua )
                    return back()->withInput();
                }
                break;
            default:
                return back()->withInput();
        }
    }

    public function get_payment_success($id_cart) {
        $OrderModel = \App\Modules\Cart\Models\UserCartModel::find($id_cart);

        if ($OrderModel == null) {
            return redirect()->route('client_index');
        }

        if ($OrderModel->id_user != \App\Bcore\Services\UserService::id()) {
            return redirect()->route('client_index');
        }

        return view('Cart::Client/Cart/message', [
            'cart_info' => $OrderModel
        ]);
    }

    public function ajax(Request $request) {
        $act = $request->input('act');
        switch ($act) {
            case '34ec78fcc91ffb1e54cd85e4a0924332': // add
                return $this->addToCart($request);
            case '0f6969d7052da9261e31ddb6e88c136e': // remove
                return $this->remove($request);
            case '6e9d25362c485bc3c90c818dfac5dc49': // drop cart
                return $this->drop($request);
            case '03b62516184fb6ef591f45bd4974b753': // refresh
                return $this->refresh();
            case 'update':
                return $this->updateCart($request);
            case 'html_cart':
                return $this->parseObjectCartToHTML();
            case 'update_quanlity':
                return $this->updateQuanlity($request);
            case '312af04ac0d72c5df7796032f508d3dc': // Paying...
                return $this->paying($request);
        }
        return response()->json([
                    'state' => false, 'message' => 'Lỗi không xác định.']);
    }

    // ===== PRIVATE FUNCTION ==========================================================================================

    private function paying($request) {
        $state = false;
        $message = '';
        $form_data = $this->parseFormSerializeArray($request->input('data'));

        if (!\App\Bcore\Services\UserService::isLoggedIn()) {
            $state = false;
            $message = 'Có lỗi xảy ra, phiên đăng nhập hết hạn';
            goto responseArea;
        }

        if (\App\Bcore\Services\UserService::isLocked()) {
            $state = false;
            $message = 'Tài khoản đang bị khóa, không thể thực hiện giao dịch.';
            goto responseArea;
        }

        $UserInfo = \App\Bcore\Services\UserService::db_info();
        if ($UserInfo == null) {
            $state = false;
            $message = 'Lỗi xử lý dữ liệu người dùng, thao tác thất bại.';
            goto responseArea;
        }

        $cart_sum = \App\Bcore\Services\OrderService::cartSum();
        $PAID = false;

        switch ($form_data['httt']) {
            case '993da28babb425eca88aca91184c752e': // Thanh toán sau khi nhận hàng
                $PAID = true;
                break;
            case '07d5b024ba9a8a78210f3df6f07db0fe': // Thanh toán bằng ví
                if (\App\Bcore\Services\UserService::pay($cart_sum)) {
                    // Event notification
                    $PAID = true;
                } else {
                    $state = false;
                    $message = 'Không thể thanh toán, số tiền trong ví không đủ để thực hiện giao dịch.';
                    goto responseArea;
                }
                break;
            case '97b01ce40e54ca5bc2c9da5e2ad58e75': // Thanh toán bằng thẻ ngân hàng

                break;
            default: // Hình thức thanh toán không được hỗ trợ
        }

        if (!$PAID) {
            $state = false;
            $message = 'Thanh toán thất bại, có lỗi xảy ra!';
            goto responseArea;
        }

        $CartModel = new \App\Modules\Cart\Models\UserCartModel();
        $CartModel->id_user = \App\Bcore\Services\UserService::id();
        $CartModel->name = $form_data['txt_hovaten'];
        $CartModel->method = $form_data['httt'];
        $CartModel->address = $form_data['txt_diachi'];
        $CartModel->note = $form_data['txt_note'];
        $CartModel->state = 'pending';
        $r = $CartModel->save();
        $ID_CART = $CartModel->id;
        if ($r) {

            $data = \App\Bcore\Services\OrderService::generate_cartDetailModels($ID_CART);
            $r1 = DB::table('users_carts_detail')->insert($data);
            if (!$r1) {
                // Xóa đơn hàng & trả lại tiền
                $r->delete();
                \App\Bcore\Services\UserService::returnMoneyBack($cart_sum);
                $state = false;
                $message = 'Lỗi hệ thống, thao tác thất bại!';
                goto responseArea;
            }
        }
        $state = true;
        $message = 'Đặt hàng thành công!';
        $url = route('mdle_cart_payment_success', $ID_CART);
        \App\Bcore\Services\OrderService::dropCart();
        responseArea:
        return response()->json([
                    'state' => $state,
                    'data' => null,
                    'message' => $message,
                    'request' => $form_data,
                    'redirect' => @$url,
                    'redirect_delay' => 1 * 3000
        ]);
    }

    private function parseFormSerializeArray($json) {
        $r = [];
        foreach ($json as $k => $v) {
            $r[$v['name']] = $v['value'];
        }
        return $r;
    }

    private function parseObjectCartToHTML() {
        $Cart = \App\Bcore\Services\OrderService::cartAnalyze();
        $Cart_Count = \App\Bcore\Services\OrderService::cartCount();
        return response()->json([
                    'state' => true,
                    'isEmpty' => $Cart_Count == 0 ? true : false,
                    'count' => $Cart_Count,
                    'sum' => $Cart['sum'],
                    'sum_text' => number_format((int) $Cart['sum'], 0) . ' VNĐ',
                    'data' => \App\Bcore\Services\OrderService::cart(),
                    'html' => view('Cart::Client/Cart/parts/cart', ['items' => $Cart])->render(),
                    'message' => ''
        ]);
    }

    private function updateQuanlity($request) {
        try {
            $form_data = $request->input('data');
            foreach ($form_data as $k => $v) {
                if ((int) $v['q'] == 0) {
                    \App\Bcore\Services\OrderService::removeItem($v['c']);
                } else {
                    \App\Bcore\Services\OrderService::updateQuality($v['c'], $v['q']);
                }
            }
            $Cart = \App\Bcore\Services\OrderService::cartAnalyze();
            $Cart_Count = \App\Bcore\Services\OrderService::cartCount();
            return response()->json([
                        'state' => true,
                        'isEmpty' => $Cart_Count == 0 ? true : false,
                        'count' => $Cart_Count,
                        'sum' => $Cart['sum'],
                        'sum_text' => number_format((int) $Cart['sum'], 0) . ' VNĐ',
                        'data' => \App\Bcore\Services\OrderService::cart(),
                        'html' => view('Cart::Client/Cart/parts/cart', ['items' => $Cart])->render(),
                        'message' => ''
            ]);
        } catch (\Exception $ex) {
            return response()->json(['state' => false, 'message' => $ex->getMessage()]);
        }
    }

    private function updateCart($request) {
        // Updating...
    }

    private function addToCart($request) {
        $id_product = $request->input('id_product');
        $count = $request->input('count');
        $color = $request->input('color');
        $size = $request->input('size');
        return response()->json([
                    'state' => \App\Bcore\Services\OrderService:: addToCart($id_product, $count, $color, $size),
                    'count' => \App\Bcore\Services\OrderService::cartCount(),
                    'data' => \App\Bcore\Services\OrderService::cart(),
                    'message' => ''
        ]);
    }

    private function remove($request) {
        $id_code = $request->input('code');
        return response()->json([
                    'state' => \App\Bcore\Services\OrderService::removeItem($id_code),
                    'count' => \App\Bcore\Services\OrderService::cartCount(),
                    'data' => \App\Bcore\Services\OrderService::cart(),
                    'message' => ''
        ]);
    }

    private function drop($request) {
        return response()->json([
                    'state' => \App\Bcore\Services\OrderService::dropCart(),
                    'count' => 0,
                    'data' => null,
                    'message' => null
        ]);
    }

    private function refresh() {
        return response()->json([
                    'state' => true,
                    'count' => \App\Bcore\Services\OrderService::cartCount(),
                    'data' => \App\Bcore\Services\OrderService::cart(),
                    'message' => null
        ]);
    }

}
