<?php

namespace App\Http\Middleware;

use Closure;
use App\Bcore\Services\UserServiceV2;
use App\Bcore\Services\ErrorService;

class AdminMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if ($request->path() == 'admin/login') {
            goto nextStep;
        }
        if (!UserServiceV2::isLoggedIn(\App\Bcore\System\UserType::admin())) {
            return redirect()->route('admin_page_error', '404');
        }
        if (!UserServiceV2::isAdmin()) {
            return redirect()->route('admin_page_error', 'permission');
        }
        nextStep:
        return $next($request);
    }

}
