<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\ClientController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TestController extends ClientController {

    //

    public function index() {
        return view($this->RV . 'test/index');
    }
    
    // Cookie
    public function setCookie(){
        $response = new Response();
        // Set cookie [author] với giá trị là 0.1 tương đương 10s
        $response->withCookie('author','BÌNHCAO',0.1);
        echo "Đã set cookie <a href='getcookie'>Xem ngay</a>";
        // Return kết quả
        return $response;
    }
    
    public function getCookie(Request $request){
        echo $request->cookie('author');
    }

    public function uploadsimplefile() {
        return view($this->RV . 'test/uploadsimplefile');
    }

    public function post_uploadsimplefile(Request $request) {
        if ($request->has('hoten')) {
            echo "Hi " . $request->input('hoten');
        } else {
            echo "Tham số họ tên chưa được thiết lập!";
            echo "<pre>";
            var_dump($request->all());
            echo "</pre>";
        }
    }

}
