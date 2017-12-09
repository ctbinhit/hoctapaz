<?php

namespace App\Bcore\Services;

use Session;

class OrderService {

    public function __construct() {
        
    }

    public static function cartAnalyze() {
        $shopping_bag = OrderService::cart();
        if (count($shopping_bag) == 0) {
            return false;
        }
        $lang = 1;
        $res_html = [];
        $sum = 0;
        foreach ($shopping_bag as $code => $item) {
            $ProductModel = \App\Models\ProductModel::find($item['id_product']);
            $ProductLang = \App\Models\ProductLangModel::where([
                        ['id_product', $ProductModel->id],
                        ['id_lang', $lang]
                    ])->first();

            $real_price = $ProductModel->promotion_price == 0 ? $ProductModel->price : $ProductModel->promotion_price;

            $res_html[] = (object) [
                        'product_code' => $code,
                        'product_name' => $ProductLang->name,
                        'product_count' => $item['count'],
                        'product_real_price' => $real_price,
                        'product_price' => $ProductModel->price,
                        'product_promotion_price' => $ProductModel->promotion_price,
                        'color' => $item['color'],
                        'size' => $item['size'],
                        'total_normal' => $ProductModel->price * $item['count'],
                        'total' => $real_price * $item['count']
            ];
            $sum += $real_price * $item['count'];
        }
        $res_html['sum'] = $sum;
        return $res_html;
    }

    public static function getArrayIdFromCart() {
        try {
            $ArrayId = [];
            $shopping_bag = OrderService::cart();
            foreach ($shopping_bag as $k => $v) {
                $ArrayId[] = $v['id_product'];
            }
            return $ArrayId;
        } catch (\Exception $ex) {
            return null;
        }
    }

    public static function getProductModelsByCart() {
        $ProductModels = \App\Models\ProductModel::whereIn('id', OrderService::getArrayIdFromCart())->get();
        return $ProductModels;
    }

    public static function getProductLangModelsByCart($id_lang = null) {
        if ($id_lang == null) {
            $id_lang = 1;
        }
        $ProductLangModels = \App\Models\ProductLangModel::where('id_lang', $id_lang)
                        ->whereIn('id_product', OrderService::getArrayIdFromCart())->get();
        return $ProductLangModels;
    }

    public static function checkCart() {
        $ArrayId = OrderService::getArrayIdFromCart();
        $ProductModels = \App\Models\ProductModel::where('deleted_at', null)->whereIn('id', $ArrayId)->get();
        $r = true;
        foreach ($ArrayId as $id_product) {
            $item = $ProductModels->find($id_product);
            if ($item == null) {
                $r = false;
            }
        }
        return $r;
    }

    public static function generate_cartDetailModels($id_cart) {
        $shopping_bag = OrderService::cart();

        if (!OrderService::checkCart()) {
            return null;
        }

        $ProductModels = OrderService::getProductModelsByCart();
        $ProductLangModels = OrderService::getProductLangModelsByCart();

        $models = [];
        foreach ($shopping_bag as $item_code => $item) {

            $product = $ProductModels->find($item['id_product']);
            $product_lang = $ProductLangModels->where('id_product', $item['id_product'])->first();

            $models[] = [
                'id_product' => $item['id_product'],
                'size' => $item['size'],
                'color' => $item['color'],
                'count' => $item['count'],
                'product_price' => $product->price,
                'product_promotion_price' => $product->promotion_price,
                'product_net_price' => $product->promotion_price != 0 ? $product->promotion_price : $product->price,
                'product_pp_price' => $product->promotion_price != 0 ? $product->promotion_price : $product->price,
                'product_name' => $product_lang->name,
                'product_description' => $product_lang->description,
                'product_updated_at' => $product_lang->updated_at,
                'product_json' => json_encode($product),
                'lang_json' => json_encode($product_lang),
                'id_cart' => $id_cart
            ];
        }
        return $models;
    }

    public static function cartSum() {
        $shopping_bag = OrderService::cart();
        $sum = 0;
        foreach ($shopping_bag as $code => $item) {
            $ProductModel = \App\Models\ProductModel::find($item['id_product']);
            $real_price = $ProductModel->promotion_price == 0 ? $ProductModel->price : $ProductModel->promotion_price;
            $sum += $real_price * $item['count'];
        }
        return $sum;
    }

    public function encryptCart() {
        
    }

    public function encryptItem() {
        
    }

    public static function updateQuality($code, $quanlity) {
        if (OrderService::hasItem($code)) {
            session::put("TMP_CART.$code.count", $quanlity);
            return true;
        } else {
            return false;
        }
    }

    public static function addToCart($id_product, $count, $color, $size) {
        try {
            $response = (object) [
                        'state' => false,
                        'message' => null
            ];
            if (!UserService::isLoggedIn()) {
                $response->message = 'Chưa đăng nhập!';
                $response->state = false;
            }

            $item_code = md5($id_product . $color . $size);

            if (session::has('TMP_CART')) {
                if (OrderService::hasItem($item_code)) {
                    $itemCount = OrderService::getItemCount($item_code) + $count;
                    session::put("TMP_CART.$item_code.count", $itemCount);
                } else {
                    session::put("TMP_CART.$item_code", [
                        'code' => $item_code,
                        'id_product' => $id_product,
                        'count' => $count,
                        'color' => $color,
                        'size' => $size
                    ]);
                }
            } else {
                session::put('TMP_CART', [
                    $item_code => [
                        'code' => $item_code,
                        'id_product' => $id_product,
                        'count' => $count,
                        'color' => $color,
                        'size' => $size
                    ]
                ]);
            }
            return true;
        } catch (\Exception $ex) {
            OrderService::removeCart();
            return false;
        }
    }

    public static function getItemCount($code) {
        try {
            return session('TMP_CART')[$code]['count'];
        } catch (\Exception $ex) {
            return false;
        }
    }

    public static function hasItem($code) {
        try {
            $items = session('TMP_CART');
            if ($items == null || count($items) == 0) {
                return false;
            }
            foreach ($items as $k => $item) {
                if ($item['code'] == $code) {
                    return true;
                }
            }
            return false;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public static function removeItem($code) {
        session::forget("TMP_CART.$code");
        return !OrderService::hasItem($code);
    }

    public static function dropCart() {
        session::forget('TMP_CART');
    }

    public static function cart() {
        try {
            return session('TMP_CART');
        } catch (\Exception $ex) {
            OrderService::removeCart();
            return null;
        }
    }

    public static function cartCount() {
        try {
            return count(session('TMP_CART'));
        } catch (\Exception $ex) {
            return 0;
        }
    }

    // ===== INFO ======================================================================================================

    public static function cache($model_name) {
        
    }

    public static function info() {
        return (object) [
                    'version' => 2.0,
                    'method' => (object) [
                        '34ec78fcc91ffb1e54cd85e4a0924332' => 'add',
                        '0f6969d7052da9261e31ddb6e88c136e' => 'remove',
                        '6e9d25362c485bc3c90c818dfac5dc49' => 'drop',
                        '03b62516184fb6ef591f45bd4974b753' => 'refresh'
                    ],
                    'name' => 'AO For Laravel 5.4'
        ];
    }

}
