<?php

$module_prefix = 'mdle_';
$module_name = 'BKPayment';
$post = '_';

$namespace = "App\Modules\\$module_name\\Controllers";

Route::group(['module' => $module_name, 'middleware' => 'web', 'namespace' => $namespace], function() use ($module_name, $module_prefix, $post) {

    Route::group(['prefix' => 'admin', 'middleware' => ['AdminMiddleware']], function() use ($module_name, $module_prefix, $post) {

        Route::get('/lich-su-giao-dich', ['uses' => 'Admin\\' . $module_name . 'Controller@get_uph'])
                ->name($module_prefix . 'ad_bkp_uph')->middleware('AdminMiddleware');
    });

    Route::get('/nap-the.html', ['uses' => 'Client\\' . $module_name . 'Controller@get_index'])
            ->name($module_prefix . 'bkp_napthe')->middleware('UserMiddleware');

    Route::post('/nap-the.html', ['uses' => 'Client\\' . $module_name . 'Controller@post_index'])
            ->name($post . $module_prefix . 'bkp_index');

    Route::group(['prefix' => 'admin/setting/'], function() use ($module_name, $module_prefix, $post) {

        Route::get('/bao-kim-payment', ['uses' => 'Admin\\' . $module_name . 'Controller@get_index'])
                ->name($post . $module_prefix . 'bkp_index');
    });
});
