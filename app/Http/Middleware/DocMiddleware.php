<?php

namespace App\Http\Middleware;

use Closure;
use App\Bcore\Services\UserServiceV2;
use App\Bcore\Services\ErrorService;
use Illuminate\Support\Facades\Request;

class DocMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
//        $url_allow = ['de-thi-thu', 'tai-lieu-hoc'];
//        foreach ($url_allow as $k => $v) {
//            if ($request->is($v . '*')) {
//                Request::merge([
//                    'doc_type' => $v
//                ]);
//                goto nextStep;
//            }
//        }
//        return redirect()->route('client_index');
        nextStep:
        return $next($request);
    }

}
