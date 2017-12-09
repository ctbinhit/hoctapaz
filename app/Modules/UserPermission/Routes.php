<?php

$module_prefix = 'mdle_';
$module_name = 'UserPermission';
$post = '_';

$namespace = "App\Modules\\$module_name\\Controllers";

Route::group(['module' => $module_name, 'middleware' => 'web', 'namespace' => $namespace], function() use ($module_name, $module_prefix, $post) {

    Route::group(['prefix' => 'admin'], function() use ($module_name, $module_prefix, $post) {
        
        Route::get('/system/', ['uses' => 'Admin\\' . $module_name . 'Controller@get_index'])
                ->name($module_prefix . 'userpermission_index');

        Route::get('/system/key/groups', ['uses' => 'Admin\\' . $module_name . 'Controller@get_key_group_index'])
                ->name($module_prefix . 'userpermission_key_group');

        // ===== USER GROUP ============================================================================================

//        Route::group(['prefix' => 'user-groups'], function() use ($module_name, $module_prefix, $post) {
//
            Route::get('/', ['uses' => 'Admin\\' . $module_name . 'Controller@get_ug_index'])
                    ->name($module_prefix . 'userpermission_ug');
//
//            Route::get('/add', ['uses' => 'Admin\\' . $module_name . 'Controller@get_ug_add'])
//                    ->name($module_prefix . 'userpermission_ug_add');
//
//            Route::post('/save', ['uses' => 'Admin\\' . $module_name . 'Controller@post_ug_save'])
//                    ->name($module_prefix . 'userpermission_ug_save');
//
//            Route::get('/{id}/permissions', ['uses' => 'Admin\\' . $module_name . 'Controller@get_ug_permissions'])
//                    ->name($module_prefix . 'userpermission_ug_permissions');
//
//            Route::post('/{id}/permissions/save', ['uses' => 'Admin\\' . $module_name . 'Controller@post_ug_permissions_save'])
//                    ->name($post . $module_prefix . 'userpermission_ug_permissions_save');
//        });

        // ===== GROUP PERMISSION ======================================================================================

        Route::group(['prefix' => 'user-groups'], function() use ($module_name, $module_prefix, $post) {

            Route::get('/', ['uses' => 'Admin\UGController@get_index'])
                    ->name($module_prefix . 'ug_index');

            Route::get('/groups/{id}/permissions', ['uses' => 'Admin\UGController@get_pers_detail'])
                    ->name($module_prefix . 'ug_pers');

            Route::post('/groups/{id}/permissions/save', ['uses' => 'Admin\UGPController@post_save'])
                    ->name($post . $module_prefix . 'ugp_permissions_save');

            Route::post('/groups/ajax', ['uses' => 'Admin\UGPController@ajax'])
                    ->name($post . $module_prefix . 'ugp_ajax');
        });

        // ===== PACKAGE ===============================================================================================

        Route::get('/system/sc', ['uses' => 'Admin\\SCController@get_index'])
                ->name($module_prefix . 'userpermission_sc_index');

        Route::get('/system/sc/add/{controller_name}', ['uses' => 'Admin\\SCController@get_add'])
                ->name($module_prefix . 'userpermission_sc_add');

        Route::post('/system/sc/save', ['uses' => 'Admin\\SCController@post_save'])
                ->name($post . $module_prefix . 'userpermission_sc_save');

        Route::post('/system/sc/ajax', ['uses' => 'Admin\\SCController@ajax'])
                ->name($post . $module_prefix . 'userpermission_sc_ajax');



        Route::get('/system/packages/update', ['uses' => 'Admin\\' . $module_name . 'Controller@get_package_update'])
                ->name($module_prefix . 'userpermission_package_update');

        Route::get('/system/keys', ['uses' => 'Admin\\' . $module_name . 'Controller@get_key_index'])
                ->name($module_prefix . 'userpermission_key');

        Route::get('/system/keys/edit/{am_path_encode}', ['uses' => 'Admin\\' . $module_name . 'Controller@get_key_edit'])
                ->name($module_prefix . 'userpermission_key_edit');

        Route::post('/system/up_configuration.toannang/save', ['uses' => 'Admin\\' . $module_name . 'Controller@post_save'])
                ->name($post . $module_prefix . 'userpermission_key_save');

        Route::get('/user/{id}/set-permission', ['uses' => 'Admin\\' . $module_name . 'Controller@get_sup_index'])
                ->name($module_prefix . 'sup_index');
    });
});
