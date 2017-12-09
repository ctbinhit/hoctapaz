<?php

$module_prefix = 'mdle_';
$module_name = 'UserVIP';
$post = '_';

$namespace = "App\Modules\\$module_name\\Controllers";

Route::group(['module' => $module_name, 'middleware' => 'web', 'namespace' => $namespace], function() use ($module_name, $module_prefix, $post) {

    Route::group(['prefix' => 'admin', 'middleware' => ['AdminMiddleware']], function() use ($module_name, $module_prefix, $post) {

        Route::get('/user-vip', ['uses' => 'Admin\\' . $module_name . 'Controller@get_index'])
                ->name($module_prefix . 'uservip_index');

        Route::get('/user-vip/add', ['uses' => 'Admin\\' . $module_name . 'Controller@get_add'])
                ->name($module_prefix . 'uservip_add');

        Route::get('/user-vip/edit/{id}', ['uses' => 'Admin\\' . $module_name . 'Controller@get_edit'])
                ->name($module_prefix . 'uservip_edit');

        Route::post('/user-vip/save', ['uses' => 'Admin\\' . $module_name . 'Controller@post_save'])
                ->name($post . $module_prefix . 'uservip_save');
    });
});
