<?php

$module_prefix = 'mdle_';
$module_name = 'Document';
$post = '_';

$namespace = "App\Modules\\$module_name\\Controllers";

$module_name = 'doc';

use Illuminate\Support\Facades\Config;

Route::group(['module' => $module_name, 'middleware' => 'web', 'namespace' => $namespace], function() use ($module_name, $module_prefix, $post) {

    /* =================================================================================================================
     *                                                  CLIENT AREA
     * =================================================================================================================
     */

    // ----- TÀI LIỆU HỌC ----------------------------------------------------------------------------------------------

    Route::get('/doc/{type}' . config('bcore.PageExtension'), ['uses' => 'Client\DocController@get_index'])
            ->name($module_prefix . 'client_doc_index')
            ->middleware('DocMiddleware');
    
    Route::get('/doc/{type}/{mime_type}' . config('bcore.PageExtension'), ['uses' => 'Client\DocController@get_index'])
            ->name($module_prefix . 'client_doc_type')
            ->middleware('DocMiddleware');

    Route::get('/doc/{type}/danh-muc/{name_meta_category}' . config('bcore.PageExtension'), ['uses' => 'Client\DocController@get_category'])
            ->name($module_prefix . 'client_doc_category');
    
    Route::get('/doc/{type}/danh-muc/{name_meta_category}/{mime_type}' . config('bcore.PageExtension'), ['uses' => 'Client\DocController@get_category'])
            ->name($module_prefix . 'client_doc_category_mime');

    Route::post('/module/document/ajax' . config('bcore.PageExtension'), ['uses' => 'Client\DocController@ajax'])
            ->name($post . $module_prefix . 'client_doc_ajax');

    // ----- ĐỀ THI THỬ ------------------------------------------------------------------------------------------------

    Route::get('/de-thi-thu' . config('bcore.PageExtension'), ['uses' => 'Client\DocController@get_index'])
            ->name($module_prefix . 'client_doc_dethithu')
            ->middleware('DocMiddleware');

    Route::get('/de-thi-thu/tai-lieu-{type}' . config('bcore.PageExtension'), ['uses' => 'Client\DocController@get_index'])
            ->name($module_prefix . 'client_doc_dethithu')
            ->middleware('DocMiddleware');

    /* =================================================================================================================
     *                                                  ADMIN AREA
     * =================================================================================================================
     */

    Route::group(['prefix' => 'admin', 'middleware' => ['AdminMiddleware']], function() use ($module_name, $module_prefix, $post) {

        Route::get('/doc/{type}', ['uses' => 'Admin\DocController@get_index'])
                ->name($module_prefix . 'admin_doc_index');

        Route::get('/doc/{type}/tai-lieu-dang-ban', ['uses' => 'Admin\DocController@get_tailieudangban'])
                ->name($module_prefix . 'admin_doc_tailieudangban');

        Route::get('/doc/{type}/tai-lieu-da-huy', ['uses' => 'Admin\DocController@get_tailieudahuy'])
                ->name($module_prefix . 'admin_doc_tailieudahuy');

        Route::post('/doc/{type}/ajax', ['uses' => 'Admin\DocController@ajax'])
                ->name($post . $module_prefix . 'admin_doc_ajax');
    });

    Route::group(['prefix' => 'pi', 'middleware' => ['PiMiddleware']], function() use ($module_name, $module_prefix, $post) {

        Route::get('/doc/{type}', ['uses' => 'Pi\DocController@get_index'])
                ->name($module_prefix . 'pi_doc_index');

        Route::get('/doc/{type}/add', ['uses' => 'Pi\DocController@get_add'])
                ->name($module_prefix . 'pi_doc_add');

        Route::get('/doc/{type}/edit/{id}', ['uses' => 'Pi\DocController@get_edit'])
                ->name($module_prefix . 'pi_doc_edit');

        Route::post('/doc/{type}/save', ['uses' => 'Pi\DocController@post_save'])
                ->name($post . $module_prefix . 'pi_post_save');

        // ----- TÀI LIỆU ĐANG BÁN -------------------------------------------------------------------------------------
        Route::get('/doc/{type}/tai-lieu-dang-ban/', ['uses' => 'Pi\DocController@get_index_approved'])
                ->name($module_prefix . 'pi_doc_approved');

        Route::post('/doc/{type}/ajax', ['uses' => 'Pi\DocController@ajax'])
                ->name($post . $module_prefix . 'pi_doc_ajax');
    });
});
