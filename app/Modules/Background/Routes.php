<?php

$module_prefix = 'mdle_';
$module_name = 'Background';
$post = '_';

$namespace = "App\Modules\\$module_name\\Controllers";

Route::group(['module' => $module_name, 'middleware' => 'web', 'namespace' => $namespace], function() use ($module_name, $module_prefix, $post) {

    Route::group(['prefix' => 'admin', 'middleware' => ['AdminMiddleware']], function() use ($module_name, $module_prefix, $post) {

        Route::get('/background/{type}', ['uses' => 'Admin\\' . $module_name . 'Controller@get_index'])
                ->name($module_prefix . 'background_index');

        Route::post('/background', ['uses' => 'Admin\\' . $module_name . 'Controller@post_index'])
                ->name($post . $module_prefix . 'background_index');
    });

    /* =============================================================
     * BACKGROUND IMAGE
     * =============================================================
     */

    Route::group(['prefix' => 'bg'], function() {

        Route::get('/{key}', function( $key) {
            $PathDecode = \Illuminate\Support\Facades\Crypt::decryptString($key);

            if (Storage::disk('public')->exists($PathDecode)) {
                $mimetype = Storage::mimeType('public/' . $PathDecode);
                $raw = (Storage::disk('public')->get($PathDecode));
                header('Content-Type:' . $mimetype . ';Content-Disposition: attachment;');
                echo $raw;
            } else {
                
            }
        })->name('background_url');
    });
});
