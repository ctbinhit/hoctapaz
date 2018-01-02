<?php

namespace App\Modules\Cart\Controllers\Admin;

use App\Models\UserModel;
use Illuminate\Http\Request;
use App\Bcore\PackageServiceAD;
use Illuminate\Support\Facades\DB;
use App\Modules\Cart\Models\UserCartModel;
use App\Modules\Cart\Services\CartService;
use App\Bcore\Services\NotificationService;
use App\Modules\Cart\Models\UserCartStateModel;

class CartController extends PackageServiceAD {

    public function __construct() {
        parent::__construct();
    }

    public function get_index(Request $request) {
        $CartModels = DB::table('users_carts')
                        ->join('users', 'users.id', '=', 'users_carts.id_user')
                        ->leftJoin('users_carts_detail', 'users_carts.id', '=', 'users_carts_detail.id_cart')
                        ->select([
                            'users_carts.id', 'users_carts.id_user', 'users_carts.name',
                            'users_carts.phone', 'users_carts.seen', 'users_carts.created_at', 'users_carts.state',
                            'users.email', DB::raw('COUNT(tbl_users_carts_detail.id) as total_items'),
                            DB::raw('SUM(tbl_users_carts_detail.product_price * tbl_users_carts_detail.count) as total_amount')
                        ])->groupBy('users_carts.id');

        $CartModels->orderBy('id', 'DESC');

        if ($request->has('keywords')) {
            $CartModels->where('users.email', 'LIKE', '%' . $request->input('keywords') . '%');
        }

        $CartList = $CartModels->paginate(5);

        return view('Cart::Admin/Cart/index', [
            'items' => $CartList,
            'stateList' => UserCartStateModel::where('type', 'cart')->get()
        ]);
    }

    public function get_cart_detail($id, Request $request) {
        $UCM = UserCartModel::find($id);

        if ($UCM->seen == 0) {
            $UCM->seen = 1;
            $UCM->save();
        }

        $UI = \App\Models\UserModel::find($UCM->id_user);

        $UCDM = \App\Modules\Cart\Models\UserCartDetailModel::where('id_cart', $id)->get();

        $LIST_STATE = \App\Modules\Cart\Models\UserCartStateModel::where('type', 'cart')->get();

        if ($UCM == null || $UI == null || $UCDM == null) {
            return 'Có lỗi xảy ra';
        }



        return view('Cart::Admin/Cart/cart_detail', [
            'user_info' => $UI,
            'cart_info' => $UCM,
            'cart_dtail' => $UCDM,
            'list_state' => $LIST_STATE
        ]);
    }

    public function post_cart_detail_cart_save($id, Request $request) {
        $CartModel = UserCartModel::find($id);
        if ($CartModel == null) {
            NotificationService::alertRight('Dữ liệu không có thực.', 'danger');
            goto redirectArea;
        }
        $CartModel->name = $request->input('name');
        $CartModel->phone = $request->input('phone');
        $CartModel->phone2 = $request->input('phone2');
        $CartModel->method = $request->input('method');
        $CartModel->address = $request->input('address');
        $CartModel->note = $request->input('note');
        $CartModel->state = $request->input('state');
        $r = $CartModel->save();
        if ($r) {
            NotificationService::alertRight('Cập nhật thông tin giỏ hàng thành công.', 'success');
        } else {
            NotificationService::alertRight('Có lỗi xảy ra trong qus trình cập nhật.', 'warning');
        }
        redirectArea:
        return redirect()->route('mdle_admin_cart_detail', $id);
    }

    public function ajax(Request $request) {
        $data = [];
        $act = $request->input('act');
        switch ($act) {
            case 'cs':
                $r = $this->pri_change_state($request->input('id'), $request->input('state'));
                $data = ['state' => $r[0], 'message' => $r[1], 'type' => $r[2]];
                break;
        }
        return response()->json($data);
    }

    // ===== Private function ==========================================================================================

    private function pri_change_state($id_cart, $state) {
        $CartModel = UserCartModel::find($id_cart);
        if ($CartModel == null) {
            return [false, 'Đơn hàng không tồn tại', 'danger'];
        }
        $CartModel->state = $state;
        return $CartModel->save() ? [true, 'Cập nhật thành công', 'success'] : [false, 'Có lỗi xảy ra, vui lòng thử lại sau', 'warning'];
    }

}
