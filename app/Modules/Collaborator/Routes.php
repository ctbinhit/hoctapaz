<?php

$module_prefix = 'mdle_';
$module_name = 'Collaborator';
$post = '_';

$namespace = "App\Modules\\$module_name\\Controllers";
$module_name = 'Collaborator';

Route::group(['module' => $module_name, 'middleware' => 'web', 'namespace' => $namespace], function() use ($module_name, $module_prefix, $post) {


    /* =================================================================================================================
     *                                                  ADMIN AREA
     * =================================================================================================================
     */

    Route::group(['prefix' => \App\Bcore\System\RouteArea::admin_area(), 'middleware' => ['AdminMiddleware']], function() use ($module_name, $module_prefix, $post) {
            
        Route::get('/dt', ['uses' => 'Admin\ExchangeController@get_index'])
                ->name($module_prefix . 'admin_collaborator_exchange_index');
        
        Route::post('/yeu-cau-nap-rut/ajax', ['uses' => 'Admin\ExchangeController@ajax'])
                ->name($post . $module_prefix . 'admin_collaborator_ajax');
        
    });

    Route::group(['prefix' => \App\Bcore\System\RouteArea::collaborator(), 'middleware' => ['PiMiddleware']], function() use ($module_name, $module_prefix, $post) {
        Route::get('/dt', ['uses' => 'Collaborator\ExchangeController@get_index'])
                ->name($module_prefix . 'pi_collaborator_exchange_index');

        Route::get('/lich-su-nap-rut', ['uses' => 'Collaborator\ExchangeController@get_transactions'])
                ->name($module_prefix . 'pi_collaborator_transactions');

        Route::get('/yeu-cau-nap-rut', ['uses' => 'Collaborator\ExchangeController@get_rf'])
                ->name($module_prefix . 'pi_collaborator_rf');

        Route::post('/yeu-cau-nap-rut', ['uses' => 'Collaborator\ExchangeController@post_rf'])
                ->name($post . $module_prefix . 'pi_collaborator_rf');
        
        Route::post('/yeu-cau-nap-rut/ajax', ['uses' => 'Collaborator\ExchangeController@ajax'])
                ->name($post . $module_prefix . 'pi_collaborator_ajax');
    });

    Route::group(['prefix' => \App\Bcore\System\RouteArea::client_area(), 'middleware' => ['PiMiddleware']], function() use ($module_name, $module_prefix, $post) {
        
    });
});
