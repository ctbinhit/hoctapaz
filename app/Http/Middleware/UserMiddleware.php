<?php

namespace App\Http\Middleware;

use Closure;
use App\Functions\ClsAdmin;

class UserMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (!session()->has('user')) {
            switch ($request->route()->uri) {
                case 'professor':
                    return redirect()->route('pi_login_index');
                case 'admin':
                    return redirect()->route('admin_login_index');
                default:
                    return redirect()->route('client_index');
            }
        }




        return $next($request);
    }

}
