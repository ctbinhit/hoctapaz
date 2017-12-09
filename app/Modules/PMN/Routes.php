<?php

$module_prefix = 'mdle_';
$module_name = 'PMN';
$cn = 'PMN';
$post = '_';

$namespace = "App\Modules\\$module_name\\Controllers";

Route::group(['module' => $module_name, 'middleware' => 'web', 'namespace' => $namespace], function() use ($module_prefix, $post, $cn) {

    /* =================================================================================================================
     *                                                  PROFESSOR AREA
     * 
     * =================================================================================================================
     */

    Route::group(['prefix' => 'admin', 'middleware' => ['AdminMiddleware']], function() use ($module_prefix, $post, $cn) {

        Route::get('/pmn/{type}', ['uses' => 'Admin\\' . $cn . 'Controller@get_index'])
                ->name($module_prefix . 'pmn_index');

        Route::post('/pmn/{type}', ['uses' => 'Admin\\' . $cn . 'Controller@post_index'])
                ->name($post . $module_prefix . 'pmn_index');
    });
});
