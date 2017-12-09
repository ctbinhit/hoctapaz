<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class ClientMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
//        if (!Session::has('user')) {
//            session::flash('info_callback', (object) [
//                        'message' => 'Vui lòng đăng nhập!',
//                        'url_redirect' => 'client_user_info'
//            ]);
//            return redirect()->route('client_login_index');
//        }
        return $next($request);
    }

}
