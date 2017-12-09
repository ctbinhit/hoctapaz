<?php

namespace App\Http\Controllers\client;

use Illuminate\Http\Request;
use App\Http\Controllers\ClientController;
use ArticleModel,
    PhotoModel;

class AjaxController extends ClientController {

//    public static function info() {
//        return (object) [
//                    'version' => 2.0,
//                    'method' => (object) [
//                        '34ec78fcc91ffb1e54cd85e4a0924332' => 'add',
//                        '0f6969d7052da9261e31ddb6e88c136e' => 'remove',
//                        '6e9d25362c485bc3c90c818dfac5dc49' => 'drop',
//                        '03b62516184fb6ef591f45bd4974b753' => 'refresh'
//                    ],
//                    'name' => 'AO For Laravel 5.4'
//        ];
//    }
//
//    public function post_index(Request $request) {
//        $act = $request->input('act');
//        switch ($act) {
//            case '34ec78fcc91ffb1e54cd85e4a0924332': // add
//                return $this->addToCart($request);
//            case '0f6969d7052da9261e31ddb6e88c136e': // remove
//                return $this->remove($request);
//            case '6e9d25362c485bc3c90c818dfac5dc49': // drop cart
//                return $this->drop($request);
//            case '03b62516184fb6ef591f45bd4974b753': // refresh
//                return $this->refresh($request);
//        }
//        return response()->json([
//                    'state' => false, 'message' => 'Lỗi không xác định.']);
//    }
//
//    private function addToCart($request) {
//        $id_product = $request->input('id_product');
//        $count = $request->input('count');
//        $color = $request->input('color');
//        $size = $request->input('size');
//        return response()->json([
//                    'state' => \App\Bcore\Services\OrderService:: addToCart($id_product, $count, $color, $size),
//                    'count' => \App\Bcore\Services\OrderService::cartCount(),
//                    'data' => \App\Bcore\Services\OrderService::cart(),
//                    'message' => ''
//        ]);
//    }
//
//    private function remove($request) {
//        
//    }
//
//    private function drop($request) {
//        
//    }
//
//    private function refresh($request) {
//        
//    }

}
