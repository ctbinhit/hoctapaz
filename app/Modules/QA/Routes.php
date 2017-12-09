<?php

$module_prefix = 'mdle_';
$module_name = 'QA';
$post = '_';

$namespace = "App\Modules\\$module_name\\Controllers";

Route::group(['module' => $module_name, 'middleware' => 'web', 'namespace' => $namespace], function() use ($module_name, $module_prefix, $post) {

    Route::get('/hoi-dap' . config('bcore.PageExtension'), ['uses' => 'Client\\' . $module_name . 'Controller@get_index'])
            ->name($module_prefix . 'client_qa_index');

    Route::get('/hoi-dap/danh-muc/{category}' . config('bcore.PageExtension'), ['uses' => 'Client\\' . $module_name . 'Controller@get_index'])
            ->name($module_prefix . 'client_qa_category');

    Route::get('/hoi-dap/tao-cau-hoi' . config('bcore.PageExtension'), ['uses' => 'Client\\' . $module_name . 'Controller@get_add'])
            ->name($module_prefix . 'client_qa_add');

    Route::post('/hoi-dap/tao-cau-hoi/save' . config('bcore.PageExtension'), ['uses' => 'Client\\' . $module_name . 'Controller@post_save'])
            ->name($post . $module_prefix . 'client_qa_save');

    Route::get('/hoi-dap/cau-hoi/{id}' . config('bcore.PageExtension'), ['uses' => 'Client\\' . $module_name . 'Controller@get_qa_detail'])
            ->name($module_prefix . 'client_qa_detail');

    Route::post('/hoi-dap/cau-hoi/{id}/save' . config('bcore.PageExtension'), ['uses' => 'Client\\' . $module_name . 'Controller@post_qa_detail_save'])
            ->name($post . $module_prefix . 'client_qa_detail_save');

    Route::post('/hoi-dap/ajax' . config('bcore.PageExtension'), ['uses' => 'Client\\' . $module_name . 'Controller@ajax'])
            ->name($post . $module_prefix . 'client_qa_ajax');
});
