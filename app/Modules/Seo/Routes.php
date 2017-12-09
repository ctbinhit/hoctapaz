<?php

$module_prefix = 'mdle_';
$module_name = 'Seo';
$post = '_';

$namespace = "App\Modules\\$module_name\\Controllers";

Route::group(['module' => $module_name, 'middleware' => 'web', 'namespace' => $namespace], function() use ($module_name, $module_prefix, $post) {

    Route::group(['prefix' => 'admin', 'middleware' => ['AdminMiddleware']], function() use ($module_name, $module_prefix, $post) {

        Route::get('/seo/google-analytics', ['uses' => 'Admin\\' . $module_name . 'Controller@get_google_analytics'])
                ->name($module_prefix . 'admin_seo_analytics');

        Route::post('/seo/google-analytics', ['uses' => 'Admin\\' . $module_name . 'Controller@post_google_analytics'])
                ->name($post . $module_prefix . 'admin_seo_analytics');
    });
});
