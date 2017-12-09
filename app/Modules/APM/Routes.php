<?php

$module_prefix = 'mdle_';
$module_name = 'APM';
$post = '_';

$namespace = "App\Modules\\$module_name\\Controllers";

Route::group(['module' => $module_name, 'middleware' => 'web', 'namespace' => $namespace], function() use ($module_name, $module_prefix, $post) {

    Route::group(['prefix' => 'admin', 'middleware' => ['AdminMiddleware']], function() use ($module_name, $module_prefix, $post) {

        Route::get('/apm', ['uses' => 'Admin\\' . $module_name . 'Controller@get_index'])
                ->name($module_prefix . 'admin_apm_index');

        Route::post('/apm/save', ['uses' => 'Admin\\' . $module_name . 'Controller@save'])
                ->name($module_prefix . 'admin_apm_save');
    });
});
