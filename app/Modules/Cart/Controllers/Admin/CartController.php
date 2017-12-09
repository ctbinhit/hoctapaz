<?php

namespace App\Modules\Cart\Controllers\Admin;

use App\Bcore\PackageServiceAD;
use Illuminate\Http\Request;
use App\Modules\Cart\Models\UserCartModel;
use App\Modules\Cart\Services\CartService;

class CartController extends PackageServiceAD {

    public function __construct() {
        parent::__construct();
    }

    public function get_index(Request $request) {



        if ($request->ajax()) {
            $CartModels = UserCartModel::
                    orderBy('id', 'DESC');

            if ($request->has('keywords')) {
                $CartModels->where('phone', 'LIKE', "%" . trim($request->input('keywords')) . "%");

                $CartModels->orWhere('name', 'LIKE', "%" . trim($request->input('keywords')) . "%");
            }

            $LIST_STATE = \App\Modules\Cart\Models\UserCartStateModel::where('type', 'cart')->get();


            $CartModels = $CartModels->paginate(5);
            $CartModels = CartService::addColumnTotalByCartModels($CartModels);
            $CartModels = CartService::addColumnDiffInNowByCartModels($CartModels);
            return response()->json([
                        'state' => true,
                        'html' => view('Cart::/Admin/Cart/parts/component_carts', ['items' => $CartModels, 'list_state' => $LIST_STATE])->render(),
            ]);
        }

        return view('Cart::Admin/Cart/index');
    }

    public function get_cart_detail($id, Request $request) {
        $UCM = UserCartModel::find($id);
        
        if($UCM->seen==0){
            $UCM->seen=1;
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
            \App\Bcore\Services\NotificationService::alertRight('Dữ liệu không có thực.', 'danger');
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
            \App\Bcore\Services\NotificationService::alertRight('Cập nhật thông tin giỏ hàng thành công.', 'success');
        } else {
            \App\Bcore\Services\NotificationService::alertRight('Có lỗi xảy ra trong qus trình cập nhật.', 'warning');
        }
        redirectArea:
        return redirect()->route('mdle_admin_cart_detail', $id);
    }

    public function ajax(Request $request) {
        $act = $request->input('act');
        switch ($act) {
            case 'loadHtml':
                return $this->loadHtml($request);
        }
    }

    // ===== Private function ==========================================================================================

    private function loadHtml($request) {

        return response()->json([
                    'state' => true,
                    'html' => view('Cart::/Admin/Cart/parts/components_carts', ['items' => ''])->render()
        ]);
    }

    private function update_cartState() {
        
    }

}
