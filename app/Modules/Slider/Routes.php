<?php

$module_prefix = 'mdle_';
$module_name = 'Slider';
$post = '_';

$namespace = "App\Modules\\$module_name\\Controllers";

Route::group(['module' => $module_name, 'middleware' => 'web', 'namespace' => $namespace], function() use ($module_name, $module_prefix, $post) {

    Route::group(['prefix' => 'admin', 'middleware' => ['AdminMiddleware']], function() use ($module_name, $module_prefix, $post) {

        Route::get('/slider/{type}', ['uses' => 'Admin\\' . $module_name . 'Controller@get_index'])
                ->name($module_prefix . 'slider_index');

        Route::post('/slider/{type}', ['uses' => 'Admin\\' . $module_name . 'Controller@post_index'])
                ->name($post . $module_prefix . 'slider_index');

        Route::get('/slider/{type}/add', ['uses' => 'Admin\\' . $module_name . 'Controller@get_add'])
                ->name($module_prefix . 'slider_add');

        Route::get('/slider/{type}/edit/{id}', ['uses' => 'Admin\\' . $module_name . 'Controller@get_edit'])
                ->name($module_prefix . 'admin_slider_edit');

        Route::post('/slider', ['uses' => 'Admin\\' . $module_name . 'Controller@post_save'])
                ->name($post . $module_prefix . 'slider_save');

        Route::post('/ajax', ['uses' => 'Admin\\' . $module_name . 'Controller@ajax'])
                ->name($post . $module_prefix . 'admin_slider_ajax');
    });
});
