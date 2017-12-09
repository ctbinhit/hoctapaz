<?php

$module_prefix = 'mdle_';
$module_name = 'Cart';
$post = '_';

$namespace = "App\Modules\\$module_name\\Controllers";

Route::group(['module' => $module_name, 'middleware' => 'web', 'namespace' => $namespace], function() use ($module_name, $module_prefix, $post) {

    Route::group(['prefix' => 'admin', 'middleware' => ['AdminMiddleware']], function() use ($module_name, $module_prefix, $post) {

        Route::get('/cart', ['uses' => 'Admin\\' . $module_name . 'Controller@get_index'])
                ->name($module_prefix . 'admin_cart_index');

        Route::get('/cart/{id}', ['uses' => 'Admin\\' . $module_name . 'Controller@get_cart_detail'])
                ->name($module_prefix . 'admin_cart_detail');

        Route::post('/cart/{id}', ['uses' => 'Admin\\' . $module_name . 'Controller@post_cart_detail_cart_save'])
                ->name($post . $module_prefix . 'admin_cart_detail_cart_saved');

        Route::post('/cart/ajax', ['uses' => 'Admin\\' . $module_name . 'Controller@ajax'])
                ->name($post . $module_prefix . 'admin_cart_ajax');
    });

    Route::group(['prefix' => 'gio-hang'], function() use ($module_name, $module_prefix, $post) {

        Route::get('/', ['uses' => 'Client\\' . $module_name . 'Controller@get_index'])
                ->name($module_prefix . 'cart_index');

        Route::get('/thanh-toan', ['uses' => 'Client\\' . $module_name . 'Controller@get_payment'])
                ->name($module_prefix . 'cart_payment');

        Route::get('/don-hang/{id}', ['uses' => 'Client\\' . $module_name . 'Controller@get_payment_success'])
                ->name($module_prefix . 'cart_payment_success');


        Route::post('/ajax', ['uses' => 'Client\\' . $module_name . 'Controller@ajax'])
                ->name($module_prefix . 'client_order_ajax');
    });
});
