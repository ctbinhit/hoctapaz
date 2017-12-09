<?php

namespace App\Modules\Cart\Services;

use Carbon\Carbon;

class CartService {

    function __construct() {
        
    }

    public static function cartTotal($id_cart) {
        $UCDM = \App\Modules\Cart\Models\UserCartDetailModel::where('id_cart', $id_cart)->get();
        $total = 0;
        foreach ($UCDM as $k => $v) {
            $total += $v->count * $v->product_net_price;
        }

        return $total;
        return \App\Modules\Cart\Models\UserCartDetailModel::
                where([
                    ['id_cart', $id_cart],
                    ['deleted_at', null]
                ])->sum('product_net_price');
    }

    public static function addColumnTotalByCartModels($cart_models) {
        foreach ($cart_models as $k => $v) {
            $v->total = CartService::cartTotal($v->id);
        }
        return $cart_models;
    }

    public static function addColumnDiffInNowByCartModels($cart_models) {
        foreach ($cart_models as $k => $v) {
            $v->diffInNow = CartService::diffInNow($v->created_at);
        }
        return $cart_models;
    }

    public static function diffInNow($created_at) {
        $now = Carbon::now();
        $time = new Carbon($created_at);
        return $time->diffForHumans($now);
    }

}
