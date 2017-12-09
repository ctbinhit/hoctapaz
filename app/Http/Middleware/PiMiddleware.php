<?php

namespace App\Http\Middleware;

use Closure;
use App\Bcore\Services\UserServiceV2;
use App\Bcore\Services\ErrorService;

class PiMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if ($request->path() == 'professor/login') {
            goto nextStep;
        }
        if (!UserServiceV2::isLoggedIn(\App\Bcore\System\UserType::professor())) {
            return redirect()->route('client_index', '404');
        }
        nextStep:
        return $next($request);
    }

}
