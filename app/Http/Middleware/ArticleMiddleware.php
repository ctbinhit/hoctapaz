<?php

namespace App\Http\Middleware;

use Closure;

class ArticleMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
//        $r;
//        switch ($request->route('type')) {
//            case 'tintuc':
//                $r = array(
//                    'title' => 'label.tintuc',
//                    'columns' => array(
//                        'ordinal_number' => array(
//                            'visible' => true,
//                            'title' => 'label.stt',
//                            'width' => '3%',
//                            'className' => 'dt-body-center'
//                        ),
//                        'views' => array(
//                            'title' => 'label.luotxem',
//                            'visible' => true,
//                        ),
//                        'name' => array(
//                            'visible' => true,
//                            'title' => 'label.ten',
//                            'note' => ''
//                        ),
//                        'highlight' => array(
//                            'visible' => true,
//                            'title' => 'label.noibat',
//                        ),
//                        'display' => array(
//                            'visible' => true,
//                        ),
//                        'photo' => array(
//                            'visible' => true
//                        )
//                    )
//                );
//                break;
//            case 'tuyendung':
//                $r = array(
//                    'title' => 'Tuyển dụng',
//                );
//                break;
//            default:
//                return redirect()->route('admin_index');
//        }
//        $request->viewdata = $r;
        return $next($request);
    }

}
