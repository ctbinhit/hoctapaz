<?php

$module_prefix = 'mdle_';
$module_name = 'OnlineCourse';
$cn = 'OC';
$post = '_';

$namespace = "App\Modules\\$module_name\\Controllers";

Route::group(['module' => $module_name, 'middleware' => 'web', 'namespace' => $namespace], function() use ($module_prefix, $post, $cn) {

    /* =================================================================================================================
     *                                                  PROFESSOR AREA
     * =================================================================================================================
     */

    Route::group(['prefix' => 'professor'], function() use ($module_prefix, $post, $cn) {

        // ===== EXAM AREA =============================================================================================

        Route::group(['prefix' => 'exam'], function() use ($module_prefix, $post, $cn) {
            // Danh sách app đang trong trạng thái free
            Route::get('/', ['uses' => 'Pi\ExamController@get_index'])
                    ->name($module_prefix . 'oc_pi_exam_index');

            Route::get('/phong-thi', ['uses' => 'Pi\ExamController@get_app_phongthi'])
                    ->name($module_prefix . 'oc_pi_exam_app_phongthi');
            
            Route::get('/trac-nghiem-online', ['uses' => 'Pi\ExamController@get_app_tracnghiem'])
                    ->name($module_prefix . 'oc_pi_exam_app_tracnghiem');
            Route::get('/de-thi-thu', ['uses' => 'Pi\ExamController@get_app_dethithu'])
                    ->name($module_prefix . 'oc_pi_exam_dethithu');
            

            Route::get('/reject', ['uses' => 'Pi\ExamController@get_reject'])
                    ->name($module_prefix . 'oc_pi_exam_reject');

            Route::post('/save', ['uses' => 'Pi\ExamController@post_index'])
                    ->name($post . $module_prefix . 'oc_pi_exam_index');

            Route::get('/add', ['uses' => 'Pi\ExamController@get_add'])
                    ->name($module_prefix . 'oc_pi_exam_add');

            Route::get('/users/{examId}', ['uses' => 'Pi\ExamController@get_user'])
                    ->name($module_prefix . 'oc_pi_exam_user');

            Route::get('/edit/{id}', ['uses' => 'Pi\ExamController@get_edit'])
                    ->name($module_prefix . 'oc_pi_exam_edit');

            Route::get('/recycle', ['uses' => 'Pi\ExamController@get_recycle'])
                    ->name($module_prefix . 'oc_pi_exam_recycle');

            Route::post('/recycle', ['uses' => 'Pi\ExamController@post_recycle'])
                    ->name($post . $module_prefix . 'oc_pi_exam_recycle');

            Route::post('/exam/save', ['uses' => 'Pi\ExamController@post_save'])
                    ->name($post . $module_prefix . 'oc_pi_exam_save');

            Route::post('ajax_', ['uses' => 'Pi\ExamController@ajax_'])
                    ->name($post . $module_prefix . 'oc_pi_exam_ajax');

            Route::post('/exam/ajax.html', ['uses' => 'Pi\ExamController@ajax'])
                    ->name($post . $module_prefix . 'oc_pi_exam_ajax');
        });

        // =============================================================================================================

        Route::get('/oc/setup', ['uses' => 'Pi\\' . $cn . 'Controller@get_init'])
                ->name($module_prefix . 'oc_init');

        Route::get('/ocourse/', ['uses' => 'Pi\\' . $cn . 'Controller@get_index'])
                ->name($module_prefix . 'oc_index');

        Route::post('/ocourse/', ['uses' => 'Pi\\' . $cn . 'Controller@post_index'])
                ->name($post . $module_prefix . 'oc_index');

        Route::post('/ocourse/save', ['uses' => 'Pi\\' . $cn . 'Controller@post_save'])
                ->name($post . $module_prefix . 'oc_save');

        Route::get('/ocourse/add', ['uses' => 'Pi\\' . $cn . 'Controller@get_add'])
                ->name($module_prefix . 'oc_add');

        Route::get('/ocourse/edit/{id}', ['uses' => 'Pi\\' . $cn . 'Controller@get_edit'])
                ->name($module_prefix . 'oc_edit');

        Route::post('/course/ajax', ['uses' => 'Pi\\' . $cn . 'Controller@ajax'])
                ->name($post . $module_prefix . 'oc_ajax');

        // ===== CHAPTER AREA ==========================================================================================

        Route::get('/course/{id}/chapters', ['uses' => 'Pi\\' . $cn . 'Controller@get_chapter_index'])
                ->name($module_prefix . 'oc_chapter_index');

        Route::get('/course/{id}/chapters/add', ['uses' => 'Pi\\' . $cn . 'Controller@get_chapter_add'])
                ->name($module_prefix . 'oc_chapter_add');

        Route::get('/course/{id_course}/chapters/edit/{id_chapter}', ['uses' => 'Pi\\' . $cn . 'Controller@get_chapter_edit'])
                ->name($module_prefix . 'oc_chapter_edit');

        Route::post('/course/{id}/chapters/save', ['uses' => 'Pi\\' . $cn . 'Controller@post_chapter_save'])
                ->name($post . $module_prefix . 'oc_chapter_save');

        // ===== LESSION AREA ==========================================================================================

        Route::get('/course/{id}/chapter/{id_chapter}/lessons', ['uses' => 'Pi\\' . $cn . 'Controller@get_lesson_index'])
                ->name($module_prefix . 'oc_lesson_index');

        Route::get('/course/{id}/chapter/{id_chapter}/lessons/add', ['uses' => 'Pi\\' . $cn . 'Controller@get_lesson_add'])
                ->name($module_prefix . 'oc_lesson_add');

        Route::get('/course/{id}/chapter/{id_chapter}/lessons/edit/{id_lesson}', ['uses' => 'Pi\\' . $cn . 'Controller@get_lesson_edit'])
                ->name($module_prefix . 'oc_lesson_edit');

        Route::post('/course/{id}/chapter/{id_chapter}/lessons/save', ['uses' => 'Pi\\' . $cn . 'Controller@post_lesson_save'])
                ->name($post . $module_prefix . 'oc_lesson_save');
    });
});
