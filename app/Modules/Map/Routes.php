<?php

$module_prefix = 'mdle_';
$module_name = 'Map';
$post = '_';

$namespace = "App\Modules\\$module_name\\Controllers";

Route::group(['module' => $module_name, 'middleware' => 'web', 'namespace' => $namespace], function() use ($module_name, $module_prefix, $post) {

    Route::group(['prefix' => 'admin', 'middleware' => ['AdminMiddleware']], function() use ($module_name, $module_prefix, $post) {

        Route::get('/ban-do', ['uses' => 'Admin\\' . $module_name . 'Controller@get_map'])
                ->name($module_prefix . 'admin_map');

        Route::post('/ban-do', ['uses' => 'Admin\\' . $module_name . 'Controller@post_map'])
                ->name($post . $module_prefix . 'admin_map');
    });
});
