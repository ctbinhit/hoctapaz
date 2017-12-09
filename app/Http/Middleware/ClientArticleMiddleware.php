<?php

namespace App\Http\Middleware;

use Closure;

class ClientArticleMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        switch ($request->route()->uri) {
            case 'tuyen-dung.html':
                $request->page_type = 'tuyendung';
                break;
        }
        return $next($request);
    }

}
