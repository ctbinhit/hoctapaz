<?php

/* =============================================== TOANNANG Co., Ltd ===================================================
  | Version: 1.0 - TOANNANG FRAMEWORK - http://toannang.com.vn
  | Developed by ToanNang Group
  | Author: BinhCao | Phone: (+84) 964 247 742 | Email: info@binhcao.com or binhcao.toannang@gmail.com
  |---------------------------------------------------------------------------------------------------------------------
  |                                                    WEB ROUTES
  |---------------------------------------------------------------------------------------------------------------------
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
  | --------------------------------------------------------------------------------------------------------------------
 */

//Route::resource('notification', 'NotificationController');


Route::get('/binhcao.html', function() {
    dd(session()->all());
});

Route::get('/md5/{string}', function($string) {
    echo md5($string);
});



Route::group(['middleware' => 'web'], function() {

    /* =================================================================================================================
      | =============================================== CLIENT AREA ====================================================
      | ================================================================================================================
     */

    //Route::get('/qtk-vcb.html', ['uses' => 'client\IndexController@get_qtk_vcb'])->name('client_quet_vcb');
    //Route::post('/qtk-vcb/post.html', ['uses' => 'client\IndexController@post_qtk_vcb'])->name('_client_quet_vcb');
    // CKEDITOR CONFIG

    Route::post('/ckeditor/upload', function(Illuminate\Http\Request $request) {

        $url = Storage::disk('public')->put('ckeditor', $request->file('upload'));
        $url = Storage::disk('public')->url('/app/public/' . $url);
        $res = '<script>';
        $res .= "window.parent.CKEDITOR.tools.callFunction(" . $request->input('CKEditorFuncNum') . ",'" . $url . "')";
        $res .= '</script>';
        return $res;
    })->name('client_ckeditor_upload_image');

    Route::group(['prefix' => 'ajax'], function() {

        Route::group(['prefix' => 'order'], function() {
            Route::post('/', ['uses' => 'client\AjaxController@post_index'])->name('client_ajax_order');
        });
    });

    Route::get('/', ['uses' => 'client\IndexController@index'])->name('client_index');

    Route::get('/tro-thanh-doi-tac' . config('bcore.PageExtension'), ['uses' => 'client\IndexController@get_partner'])
            ->name('client_partner_index');
    Route::post('/tro-thanh-doi-tac' . config('bcore.PageExtension'), ['uses' => 'client\IndexController@post_partner'])
            ->name('_client_partner_index');



    Route::get('/bai-viet/{name_meta}' . config('bcore.PageExtension'), ['uses' => 'client\IndexController@get_articleo'])
            ->name('client_index_articleo');

    Route::get('/tuyen-dung.html', ['uses' => 'client\ArticleController@get_index'])
            ->name('client_tuyendung')->middleware('ClientArticleMiddleware');

    /* =================================================================================================================
     * NEWS AREA
     * =================================================================================================================
     */

    Route::get('/tin-tuc/{name_meta}.html', ['uses' => 'client\ArticleController@get_news_detail'])
            ->name('client_news_detail')->middleware('ClientArticleMiddleware');
    Route::get('/tin-tuc.html', ['uses' => 'client\ArticleController@get_news'])
            ->name('client_news')->middleware('ClientArticleMiddleware');
    Route::get('/tin-noi-bat.html', ['uses' => 'client\ArticleController@get_news_highlight'])
            ->name('client_news_highlight')->middleware('ClientArticleMiddleware');

    /* =================================================================================================================
     * PRODUCT AREA
     * =================================================================================================================
     */

    Route::get('/san-pham-moi' . config('bcore.PageExtension'), ['uses' => 'client\ProductController@get_index'])
            ->name('client_product_new');

    Route::get('/san-pham-noi-bat' . config('bcore.PageExtension'), ['uses' => 'client\ProductController@get_spnb'])
            ->name('client_product_highlight');

    Route::group(['prefix' => '/san-pham'], function() {

        Route::get('/{name_meta}' . config('bcore.PageExtension'), ['uses' => 'client\ProductController@get_detail'])
                ->name('client_product_detail');
    });

    /* =================================================================================================================
     * USER AREA
     * =================================================================================================================
     */

    Route::group(['prefix' => 'user'], function() {

        Route::get('/info' . config('bcore.PageExtension'), ['uses' => 'client\UserController@get_info'])
                ->name('client_user_info')->middleware('ClientMiddleware');

        Route::get('/friends' . config('bcore.PageExtension'), ['uses' => 'client\UserController@get_friends'])
                ->name('client_user_friends')->middleware('ClientMiddleware');

        Route::get('/ket-qua-thi' . config('bcore.PageExtension'), ['uses' => 'client\UserController@get_exam'])
                ->name('client_user_ketquathi')->middleware('ClientMiddleware');

        Route::get('/tai-lieu-da-mua' . config('bcore.PageExtension'), ['uses' => 'client\UserController@get_tldm'])
                ->name('client_user_tailieudamua')->middleware('ClientMiddleware');

        Route::get('/tai-lieu-da-mua/download/{url_encode}' . config('bcore.PageExtension'), ['uses' => 'client\UserController@get_tldm_download'])
                ->name('client_user_tailieudamua_download')->middleware('ClientMiddleware');

        Route::get('/lich-su-giao-dich' . config('bcore.PageExtension'), ['uses' => 'client\UserController@get_lsgd'])
                ->name('client_user_lichsugiaodich')->middleware('ClientMiddleware');

        Route::get('/nang-cap-vip' . config('bcore.PageExtension'), ['uses' => 'client\UserController@get_upgradeVIP'])
                ->name('client_user_upgradevip')->middleware('ClientMiddleware');

        Route::get('/donate' . config('bcore.PageExtension'), ['uses' => 'client\UserController@get_donate'])
                ->name('client_user_donate')->middleware('ClientMiddleware');
        Route::post('/donate' . config('bcore.PageExtension'), ['uses' => 'client\UserController@post_donate'])
                ->name('_client_user_donate')->middleware('ClientMiddleware');

        Route::get('/profile-picture' . config('bcore.PageExtension'), ['uses' => 'client\UserController@get_update_profilepicture'])
                ->name('client_user_profilepicture')->middleware('ClientMiddleware');

        Route::get('/cai-dat' . config('bcore.PageExtension'), ['uses' => 'client\UserController@get_caidat'])
                ->name('client_user_caidat')->middleware('ClientMiddleware');
        Route::post('/cai-dat' . config('bcore.PageExtension'), ['uses' => 'client\UserController@post_caidat'])
                ->name('_client_user_caidat')->middleware('ClientMiddleware');

        Route::post('/ajax' . config('bcore.PageExtension'), ['uses' => 'client\UserController@ajax'])
                ->name('client_user_ajax')->middleware('ClientMiddleware');
    });

    /* =================================================================================================================
     *                                                  TÀI LIỆU AREA
     * =================================================================================================================
     */


//    Route::get('/tai-lieu-hoc' . config('bcore.PageExtension'), ['uses' => 'client\ExamController@get_exam_ketquathi'])
//            ->name('client_exam_ketquathi');

    Route::get('/ket-qua-thi/{code}' . config('bcore.PageExtension'), ['uses' => 'client\ExamController@get_exam_ketquathi'])
            ->name('client_exam_ketquathi');

    Route::get('/phong-thi' . config('bcore.PageExtension'), ['uses' => 'client\ExamController@get_exam_phongthi'])
            ->name('client_exam_phongthi');

    Route::get('/phong-thi/{name_meta}' . config('bcore.PageExtension'), ['uses' => 'client\ExamController@get_exam_phongthi_danhmuc'])
            ->name('client_exam_phongthi_danhmuc');

    Route::get('/phong-thi/chi-tiet/{examMeta}' . config('bcore.PageExtension'), ['uses' => 'client\ExamController@get_exam_phongthi_redirect'])
            ->name('client_exam_phongthi_redirect');

    Route::post('/phong-thi/chi-tiet/{examMeta}' . config('bcore.PageExtension'), ['uses' => 'client\ExamController@post_exam_phongthi_redirect'])
            ->name('_client_exam_phongthi_redirect');

    Route::get('/thi-online/app' . config('bcore.PageExtension'), ['uses' => 'client\ExamController@get_exam_thionline_token'])
            ->name('client_exam_thionline_');

    Route::post('/thi-online/_ajax' . config('bcore.PageExtension'), ['uses' => 'client\ExamController@_ajax'])
            ->name('client_exam_ajax');

    Route::post('/thi-online/ajax' . config('bcore.PageExtension'), ['uses' => 'client\ExamController@ajax'])
            ->name('client_exam_ajaxV2');

    Route::get('/trac-nghiem-truc-tuyen' . config('bcore.PageExtension'), ['uses' => 'client\ExamController@get_tracnghiemtructuyen'])
            ->name('client_exam_tracnghiemtructuyen');

    Route::get('/trac-nghiem-truc-tuyen/{name_meta}' . config('bcore.PageExtension'), ['uses' => 'client\ExamController@get_tracnghiemtructuyen_danhmuc'])
            ->name('client_exam_tracnghiemtructuyen_danhmuc');

    /* =================================================================================================================
      |                                                 SIGNIN & SIGNUP
      | ================================================================================================================
     */

    Route::get('/dang-nhap' . config('bcore.PageExtension'), ['uses' => 'client\LoginController@get_index'])
            ->name('client_login_index');

    Route::post('/dang-nhap' . config('bcore.PageExtension'), ['uses' => 'client\LoginController@post_index'])
            ->name('_client_login_index');

    Route::get('/dang-ky' . config('bcore.PageExtension'), ['uses' => 'client\LoginController@get_signup'])
            ->name('client_login_signup');

    Route::post('/dang-ky' . config('bcore.PageExtension'), ['uses' => 'client\LoginController@post_signup'])
            ->name('_client_login_signup');

    Route::get('/dang-xuat' . config('bcore.PageExtension'), ['uses' => 'client\LoginController@access_signout'])
            ->name('client_login_signout');

    Route::get('/kich-hoat' . config('bcore.PageExtension'), ['uses' => 'client\LoginController@get_active'])
            ->name('client_login_active');
    Route::get('/kich-hoat/{code}' . config('bcore.PageExtension'), ['uses' => 'client\LoginController@get_active_o'])
            ->name('client_login_active_o');

    Route::group(['prefix' => 'login'], function() {

        Route::get('/auth/{driver}', ['uses' => 'client\LoginController@access_authenticate_redirect'])
                ->name('client_login_with');

        Route::get('/{driver}/callback', ['uses' => 'client\LoginController@access_authenticate_callback'])
                ->name('client_login_scb');

        Route::get('/destroy', ['uses' => 'client\LoginController@access_destroy'])
                ->name('client_login_destroy');
    });

    /* =================================================================================================================
     * 
     * =================================================================================================================
     */

    Route::get('/files/{url_encode}', ['uses' => 'FileController@file_request'])->name('document');

    Route::get('/u/files/{id}/{url_encode}', ['uses' => 'FileController@file_private'])->name('file_private');

    Route::group(['prefix' => 'api'], function() {
        Route::get('/licensetext', function() {
            return "<center><h1>TOANNANG Co., Ltd</h1>Invalid license error | Hotline: 08 38911719 - 08 38911720</center>";
        });
    });

    //==================================================================================================================
    //================================================== ADMIN AREA ====================================================
    //==================================================================================================================

    Route::group(['prefix' => 'err'], function() {
        Route::get('/{name}' . config('bcore.PageExtension'), function($name) {
            return view('admin/error/' . $name);
        })->name('admin_page_error');
    });

    Route::group(['prefix' => 'admin', 'middleware' => ['AdminMiddleware']], function() {

        Route::get('/', ['uses' => 'admin\IndexController@index'])->name('admin_index');

        // SUMMERNOTE PLUGINS
        Route::post('/summernote/upload', ['uses' => 'admin\SummerNoteController@post_upload'])->name('_admin_summernote_upload');

        // END SUMMERNOTE

        Route::get('logout', function() {
            return redirect()->route('admin_login_index');
        })->name('admin_logout');

        // ===== Login form ============================================================================================

        Route::get('/login', ['uses' => 'admin\LoginController@index'])->name('admin_login_index');
        Route::get('/admin/login/fb/accountkit_callback', ['uses' => 'admin\LoginController@index'])->name('admin_login_fb_autokit_callback');
        Route::post('/login', ['uses' => 'admin\LoginController@signin'])->name('admin_login_signin');

        // ===== NEWSLETTER ============================================================================================
        Route::group(['prefix' => 'newsletter'], function() {

            Route::get('/{type}' . config('bcore.PageExtension'), ['uses' => 'admin\NewsletterController@get_index'])
                    ->name('admin_newsleeter_index');
        });

        // ===== SYSTEMS ===============================================================================================

        Route::group(['prefix' => 'system'], function() {

            Route::get('/' . config('bcore.PageExtension'), ['uses' => 'admin\SystemController@get_index'])
                    ->name('admin_system_index');

            Route::get('/services' . config('bcore.PageExtension'), ['uses' => 'admin\SystemController@get_service'])
                    ->name('admin_system_service');

            Route::get('/services/add' . config('bcore.PageExtension'), ['uses' => 'admin\SystemController@get_service_add'])
                    ->name('admin_system_service_add');

            Route::post('/services/save' . config('bcore.PageExtension'), ['uses' => 'admin\SystemController@post_service_save'])
                    ->name('admin_system_service_save');
        });

        // ===== INBOX =================================================================================================
        Route::group(['prefix' => 'inbox'], function() {

            Route::get('/{type}' . config('bcore.PageExtension'), ['uses' => 'admin\InboxController@get_index'])
                    ->name('client_inbox_index')->middleware('ClientMiddleware');
        });

        // ===== USER ==================================================================================================

        Route::group(['prefix' => 'me'], function() {
            Route::get('info', ['uses' => 'admin\UserController@get_info'])
                    ->name('admin_me_info')->middleware('UserMiddleware');

            Route::post('info', ['uses' => 'admin\UserController@post_info'])
                    ->name('_admin_me_info')->middleware('UserMiddleware');

            Route::post('info_upw', ['uses' => 'admin\UserController@updatePassword'])
                    ->name('_admin_update_pw')->middleware('UserMiddleware');
        });

        // ===== CACHE =================================================================================================

        Route::group(['prefix' => 'cache'], function() {
            Route::get('clearSync', ['uses' => 'admin\CacheController@clearSync'])->name('admin_cache_clearSync');

            Route::get('clearSetting/{route?}', ['uses' => 'admin\CacheController@clearSetting'])->name('admin_cache_clearSetting');

            Route::get('clearCategory/{tbl?}/{type?}', ['uses' => 'admin\CacheController@clearCategory'])->name('admin_cache_clearCategory');

            Route::get('clear/{cate}/{url}', ['uses' => 'admin\CacheController@clear'])->name('admin_cache_clear');
        });

        // ===== Setting page ==========================================================================================

        Route::group(['prefix' => 'setting'], function() {

            Route::get('/thong-tin-chung', ['uses' => 'admin\SettingController@get_info'])->name('admin_setting_info');
            Route::post('/thong-tin-chung/save', ['uses' => 'admin\SettingController@post_info'])->name('_admin_setting_info');

            Route::get('/mang-xa-hoi', ['uses' => 'admin\SettingController@get_social'])->name('admin_setting_social');
            Route::post('/mang-xa-hoi/save', ['uses' => 'admin\SettingController@post_social'])->name('_admin_setting_social');


            Route::post('setlangdefault', ['uses' => 'admin\SettingController@post_setlangdefault'])
                    ->name('admin_setting_langdefault');

            Route::get('', ['uses' => 'admin\SettingController@get_index'])->name('admin_setting_index');
            Route::post('', ['uses' => 'admin\SettingController@post_index'])->name('_admin_setting_index');

            Route::post('save', ['uses' => 'admin\SettingController@post_save'])->name('admin_setting_save');

            Route::get('datetime', ['uses' => 'admin\SettingController@get_datetime'])->name('admin_setting_timezone');
            Route::post('datetime', ['uses' => 'admin\SettingController@post_datetime'])->name('_admin_setting_timezone');

            Route::group(['prefix' => 'account'], function() {
                Route::get('/', ['uses' => 'admin\SettingController@get_account'])->name('admin_setting_account');

                Route::get('/facebook-api', ['uses' => 'admin\SettingController@get_account_facebook'])
                        ->name('admin_setting_account_facebook');

                Route::post('/facebook-api', ['uses' => 'admin\SettingController@post_account_facebook'])
                        ->name('_admin_setting_account_facebook');

                Route::get('/google-drive', ['uses' => 'admin\SettingController@get_account_googledrive'])
                        ->name('admin_setting_account_googledrive');
                Route::post('/google-drive', ['uses' => 'admin\SettingController@post_account_googledrive'])
                        ->name('_admin_setting_account_googledrive');
                Route::get('/google-drive/clearcache', ['uses' => 'admin\SettingController@get_account_googledrive_clearcache'])
                        ->name('admin_setting_account_googledrive_clearcache');

                Route::get('/google-drive/storage', ['uses' => 'admin\SettingController@get_account_googledrive_path'])
                        ->name('admin_setting_account_googledrive_path');
                Route::post('/google-drive/storage', ['uses' => 'admin\SettingController@post_account_googledrive_path'])
                        ->name('_admin_setting_account_googledrive_path');
            });

            // ----- SESSION -------------------------------------------------------------------------------------------

            Route::get('session', ['uses' => 'admin\SettingController@get_session'])->name('admin_setting_session');
            Route::post('session', ['uses' => 'admin\SettingController@post_session'])->name('_admin_setting_session');

            // ----- FILES AND FOLDER ----------------------------------------------------------------------------------
            Route::get('ff', ['uses' => 'admin\SettingController@get_ff'])->name('admin_setting_ff');
            Route::post('ff', ['uses' => 'admin\SettingController@post_ff'])->name('_admin_setting_ff');

            Route::get('mail', ['uses' => 'admin\SettingController@get_mail'])->name('admin_setting_mail');
            Route::post('mail', ['uses' => 'admin\SettingController@post_mail'])->name('_admin_setting_mail');

            Route::group(['prefix' => 'language'], function() {
                Route::get('/', ['uses' => 'admin\SettingController@get_language'])
                        ->name('admin_setting_language');
                Route::get('/add', ['uses' => 'admin\SettingController@get_language_add'])
                        ->name('admin_setting_language_add');

                Route::post('save', ['uses' => 'admin\SettingController@post_language_save']);

                Route::get('save', function() {
                            return redirect()->route('admin_setting_language');
                        })
                        ->name('admin_setting_language_save');
            });
        });

        // ----- USER PAGE ---------------------------------------------------------------------------------------------

        Route::group(['prefix' => 'users'], function() {

            Route::get('/{type}', ['uses' => 'admin\UserController@get_index'])
                    ->name('admin_user_index');

            Route::get('/{type}/add', ['uses' => 'admin\UserController@get_add'])->name('admin_user_add');

            Route::get('/{type}/edit/{id}', ['uses' => 'admin\UserController@get_edit'])
                    ->name('admin_user_edit');

            Route::post('/{type}/save', ['uses' => 'admin\UserController@post_save'])
                    ->name('_admin_user_save');
            Route::get('/{type}/lock/{id}', ['uses' => 'admin\UserController@get_lock'])
                    ->name('admin_user_lock');
            Route::post('/{type}/lock/save', ['uses' => 'admin\UserController@post_lock'])
                    ->name('_admin_user_lock_save');

            Route::get('/{type}/vip/{id}', ['uses' => 'admin\UserController@get_user_vip'])
                    ->name('admin_user_vip');

            Route::post('/{type}/vip/{id}/save', ['uses' => 'admin\UserController@post_user_vip_save'])
                    ->name('_admin_user_vip_save');
        });

        // ===== Product page ==========================================================================================

        Route::group(['prefix' => 'product', 'middleware' => 'ProductMiddleware'], function() {
            Route::get('/', function() {
                return redirect()->route('admin_index');
            });

            Route::get('/{type}', ['uses' => 'admin\ProductController@get_index'])->name('admin_product_index');

            Route::get('/{type}/add', ['uses' => 'admin\ProductController@get_add'])->name('admin_product_add');

            Route::get('/{type}/edit/{id?}', ['uses' => 'admin\ProductController@get_edit'])->name('admin_product_edit');

            Route::post('/ajax', ['uses' => 'admin\ProductController@ajax'])
                    ->name('_admin_product_ajax');

            Route::post('/save', ['uses' => 'admin\ProductController@post_save'])
                    ->name('admin_product_save_post');
        });

        // ===== Category page =========================================================================================

        Route::group(['prefix' => 'category'], function() {
            Route::get('/', function() {
                return redirect()->route('admin_index');
            });
            // QUẢN LÝ DANH MỤC
            Route::get('/{table}/{type}', ['uses' => 'admin\CategoryController@get_index'])
                    ->name('admin_category_index')->middleware(['AdminMiddleware', 'CategoryMiddleware']);

            Route::post('/{table}/{type}', ['uses' => 'admin\CategoryController@post_index'])
                    ->name('_admin_category_index')->middleware(['AdminMiddleware', 'CategoryMiddleware']);
            // THÊM DANH MỤC
            Route::get('/{table}/{type}/add', ['uses' => 'admin\CategoryController@get_add'])
                    ->name('admin_category_add')->middleware(['AdminMiddleware', 'CategoryMiddleware']);
            // SỬA DANH MỤC
            Route::get('/{table}/{type}/edit/{id?}', ['uses' => 'admin\CategoryController@get_edit'])
                    ->name('admin_category_edit')->middleware('CategoryMiddleware');
            // LƯU DANH MỤC
            Route::post('save', ['uses' => 'admin\CategoryController@post_save'])->name('admin_category_save_post');
            // AJAX
            Route::post('ajax_', ['uses' => 'admin\CategoryController@ajax_'])->name('admin_category_ajax');
        });

        // ===== Article page ==========================================================================================

        Route::group(['prefix' => 'article', 'middleware' => 'ArticleMiddleware'], function() {
            Route::get('/', function() {
                return redirect()->route('admin_index');
            });

            Route::get('/{type}', ['uses' => 'admin\ArticleController@get_index'])
                    ->name('admin_article_index');

            Route::get('/{type}/recycle', ['uses' => 'admin\ArticleController@get_recycle'])
                    ->name('admin_article_recycle');

            Route::get('/{type}/add', ['uses' => 'admin\ArticleController@get_add'])
                    ->name('admin_article_add');

            Route::get('/{type}/edit/{id?}', ['uses' => 'admin\ArticleController@get_edit'])
                    ->name('admin_article_edit');

            Route::get('/{type}/sync', ['uses' => 'admin\ArticleController@get_sync']);

            Route::post('save', ['uses' => 'admin\ArticleController@post_save'])
                    ->name('admin_article_save_post');

            Route::post('ajax_', ['uses' => 'admin\ArticleController@ajax_'])->name('admin_article_ajax');
            Route::post('ajax', ['uses' => 'admin\ArticleController@ajax'])->name('_admin_article_ajax');
        });

        // ===== Article 1 Page ========================================================================================

        Route::group(['prefix' => 'mot-bai-viet'], function() {

            Route::get('/{type}', ['uses' => 'admin\ArticleOController@get_index'])
                    ->name('admin_articleo_index');

            Route::post('/{type}', ['uses' => 'admin\ArticleOController@post_index'])
                    ->name('_admin_articleo_index');

            Route::get('/{type}/creating', ['uses' => 'admin\ArticleOController@get_creating'])
                    ->name('admin_articleo_creating');
        });

        // ===== APPROVER ==============================================================================================

        Route::group(['prefix' => 'exam'], function() {
            Route::get('/approver', ['uses' => 'admin\ExamManController@get_approver'])
                    ->name('admin_examman_approver');

            Route::post('/approver', ['uses' => 'admin\ExamManController@post_approver'])
                    ->name('_admin_examman_approver');
            
            Route::get('/registered-app', ['uses' => 'admin\ExamManController@get_app_registered'])
                    ->name('admin_examman_registered');

            Route::get('/approver/reject/{id}', ['uses' => 'admin\ExamManController@get_approver_reject'])
                    ->name('admin_examman_approver_reject');

            Route::get('/approver/view/{id}', ['uses' => 'admin\ExamManController@get_approver_detail'])
                    ->name('admin_examman_approver_detail');

            Route::post('/approver/view/{id}', ['uses' => 'admin\ExamManController@post_approver_detail'])
                    ->name('_admin_examman_approver_detail');
        });

        // ===== SET LANG ==============================================================================================

        Route::group(['prefix' => 'set'], function() {
            Route::get('lang/{locale}', function($locale) {
                App::setLocale($locale);
                return redirect()->route('admin_index');
            });
        });

        // ===== AJAX REQUEST ==========================================================================================

        Route::group(['prefix' => 'ajax'], function() {

            Route::post('/ajax_updateDisplay', 'admin\AjaxController@ajax_updateDisplay')
                    ->name('ajax_updateDisplay');

            Route::post('/ajax_bcoreAction', 'admin\AjaxController@ajax_jqueryBcoreButton')
                    ->name('ajax_bcore_action');

            Route::post('/ajax_center', 'admin\AjaxController@ajax_center')
                    ->name('_admin_ajax');

            Route::post('/fd557e6e8c681809568b90909e79120b', 'admin\AjaxController@ajax_request')
                    ->name('_admin_ajax_request');
        });
    });

    //==================================================================================================================
    //================================================== PI AREA =======================================================
    //==================================================================================================================

    Route::group(['prefix' => App\Bcore\System\RouteArea::collaborator()], function() {

        Route::get('/', 'pi\IndexController@get_index')->name('pi_index_index')->middleware('PiMiddleware');

        // ===== AJAX REQUEST ==========================================================================================

        Route::group(['prefix' => 'ajax'], function() {

            Route::post('/fd557e6e8c681809568b90909e79120b', 'pi\AjaxController@ajax_request')
                    ->name('_pi_ajax_request');
        });

        // ----- USER INFO ---------------------------------------------------------------------------------------------

        Route::group(['prefix' => 'me', 'middleware' => ['PiMiddleware']], function() {

            Route::get('/info', ['uses' => 'pi\UserController@get_index'])->name('pi_me_info');
            Route::get('/detail', ['uses' => 'pi\UserController@get_me_detail'])->name('pi_me_detail');
            Route::post('/detail', ['uses' => 'pi\UserController@post_me_detail_save'])->name('_pi_me_detail_save');

            Route::get('/friends', ['uses' => 'pi\UserController@get_me_friends'])->name('pi_me_friends');
            Route::get('/transaction', ['uses' => 'pi\UserController@get_me_transaction'])->name('pi_me_transaction');
            Route::get('/security', ['uses' => 'pi\UserController@get_me_security'])->name('pi_me_security');
            Route::get('/setting', ['uses' => 'pi\UserController@get_me_setting'])->name('pi_me_setting');
        });

        // ----- LOGIN FORM --------------------------------------------------------------------------------------------

        Route::get('login', ['uses' => 'pi\LoginController@get_index'])->name('pi_login_index');
        Route::post('login', ['uses' => 'pi\LoginController@post_index'])->name('pi_login_signin');

        Route::get('logout', function() {
            App\Bcore\Services\UserServiceV2::drop_currentSession(App\Bcore\SystemComponents\User\UserType::professor());
            return redirect()->route('pi_index_index');
        })->name('pi_logout');

        // ----- INFO USER ---------------------------------------------------------------------------------------------
//        Route::group(['prefix' => 'exam'], function() {
//
//            Route::get('/', ['uses' => 'pi\ExamController@get_index'])->name('pi_exam_index')
//                    ->middleware(['UserMiddleware']);
//
//            Route::post('/', ['uses' => 'pi\ExamController@post_index'])->name('_pi_exam_index')
//                    ->middleware(['UserMiddleware']);
//
//            Route::get('/add', ['uses' => 'pi\ExamController@get_add'])->name('pi_exam_add')
//                    ->middleware(['UserMiddleware']);
//            // View users in this exam
//            Route::get('/users/{examId}', ['uses' => 'pi\ExamController@get_user'])->name('pi_exam_user')
//                    ->middleware(['UserMiddleware']);
//
//            Route::get('/edit/{id}', ['uses' => 'pi\ExamController@get_edit'])->name('pi_exam_edit')
//                    ->middleware(['UserMiddleware']);
//
//            Route::get('/recycle', ['uses' => 'pi\ExamController@get_recycle'])->name('pi_exam_recycle')
//                    ->middleware(['UserMiddleware']);
//
//            Route::post('/recycle', ['uses' => 'pi\ExamController@post_recycle'])->name('_pi_exam_recycle')
//                    ->middleware(['UserMiddleware']);
//
//            Route::post('/save', ['uses' => 'pi\ExamController@post_save'])->name('pi_exam_save_post')
//                    ->middleware(['UserMiddleware']);
//
//            Route::post('ajax_', ['uses' => 'pi\ExamController@ajax_'])->name('pi_exam_ajax')
//                    ->middleware(['UserMiddleware']);
//            
//        });
        // ----- COURSE ------------------------------------------------------------------------------------------------

        Route::group(['prefix' => 'course'], function() {
            Route::get('/{type}', 'pi\CourseController@get_index')->name('pi_course_index')->middleware('UserMiddleware');
        });
    });

    Route::get('/thi-online.html', function() {
        return view("client/thionline/thionline");
    });
    Route::get('/tai-lieu-trac-nghiem.html', function() {
        return view("client/tailieutracnghiem/tailieutracnghiem");
    });
    Route::get('/tai-lieu-tu-luan.html', function() {
        return view("client/tailieutuluan/tailieutuluan");
    });
    Route::get('/thi-trac-nghiem.html', function() {
        return view("client/thitracnghiem/thitracnghiem");
    });
    Route::get('/chi-tiet.html', function() {
        return view("client/thitracnghiem/tracnghiem_detail");
    });
    Route::get('/he-co-so-du-lieu.html', function() {
        return view("client/thitracnghiem/tracnghiem_detail");
    });
    Route::get('/chi-tiet-khoa-hoc.html', function() {
        return view("client/tailieutuluan/chitietkhoahoc");
    });
    Route::get('/hoc-online.html', function() {
        return view("client/hoconline/hoconline");
    });


    /* =================================================================================================================
     * SYSTEM
     * =================================================================================================================
     */
    Route::get('/sys-ch-da-vi-co', function() {
        
    });
});

//Route::get('/thumb_p/{filename}/{x?}x{y?}', function($filename, $w = null, $h = null) {
//    try {
//        reloadThumb:
//        $thumbnail_url = 'thumbnails/' . $w . '_' . $h . '/' . $filename . '.png';
//        if (Storage::disk('localhost')->exists($thumbnail_url)) {
//            $mimetype = Storage::disk('localhost')->mimeType($thumbnail_url);
//            header('Content-Type:' . $mimetype . ';Content-Disposition: attachment; filename="' . $filename . '"');
//            $raw = Storage::disk('localhost')->get($thumbnail_url);
//            echo $raw;
//        } else {
//            $a = PhotoModel::where([
//                        ['url_encode', '=', $filename]
//                    ])->first();
//            $thumb_url = 'public/thumbnails/' . $w . '_' . $h . '/';
//
//            if (!Storage::disk('localhost')->exists($thumb_url)) {
//                Storage::makeDirectory($thumb_url);
//            }
//            $url = Storage::disk('localhost')->url($a->url);
//            if (!Storage::disk('localhost')->exists($thumbnail_url)) {
//                $thumb = Image::make($url);
//                $thumb->fit($w, $h);
//                $thumb->save('storage/app/' . $thumb_url . $filename . '.png');
//            }
//            goto reloadThumb;
//        }
//    } catch (\Exception $ex) {
//        return null;
//    }
//})->name('thumb_product');

    /* =================================================================================================================
      |                                                 TEST AREA
      | ================================================================================================================
     */

//    Route::group(['prefix' => 'test'], function() {
//
//        Route::get('/carbon', function() {
//            $a = new Carbon\Carbon('2017-09-22 03:38:42');
//            $b = Carbon\Carbon::now();
//
//            echo $b->diffInSeconds($a, false);
//        });
//        // Socialite
//        Route::group(['prefix' => 'login'], function() {
//
//
//            Route::get('/google', ['uses' => 'admin\TestController@get_login_google'])
//                    ->name('test_login_google');
//
//            Route::get('/google/callback', ['uses' => 'admin\TestController@get_login_google_callback'])
//                    ->name('test_login_google_callback');
//
//            Route::get('/fb', ['uses' => 'admin\TestController@get_login_fb'])
//                    ->name('test_login_fb');
//
//            Route::get('/fb/callback', ['uses' => 'admin\TestController@get_login_fb_callback'])
//                    ->name('test_login_fb_callback');
//        });
//
//        Route::get('/thi-online', ['uses' => 'admin\TestController@get_thionline'])
//                ->name('test_thionline');
//
//        Route::get('/thi-online/{id}', ['uses' => 'admin\TestController@get_exam'])
//                ->name('test_thionline_exam');
//
//        Route::post('/ajax', ['uses' => 'admin\TestController@_ajax'])
//                ->name('test_ajax');
//    });


//    Route::get('/file/{key}', function($key) {
//        try {
//            $PathDecode = \Illuminate\Support\Facades\Crypt::decryptString($key);
//            if (Storage::disk('public')->exists($PathDecode)) {
//                $mimetype = Storage::mimeType('public/' . $PathDecode);
//                $raw = (Storage::disk('public')->get($PathDecode));
//                header('Content-Type:' . $mimetype . ';Content-Disposition: attachment;');
//                echo $raw;
//            } else {
//                return "ERROR 404!";
//            }
//        } catch (\Exception $ex) {
//            return 'ERROR!';
//        }
//    })->name('file');
//
//    Route::get('/file/{folder?}/{filename?}', function($folder = null, $filename = null) {
//        if (Storage::disk('public')->exists($folder . '/' . $filename)) {
//            $mimetype = Storage::mimeType('public/' . $folder . '/' . $filename);
//            $raw = (Storage::disk('public')->get($folder . '/' . $filename));
//            header('Content-Type:' . $mimetype . ';Content-Disposition: attachment; filename="' . $filename . '"');
//            echo $raw;
//        } else {
//            return "ERROR 404";
//        }
//    })->name('storage');
// Route::get('/files/clo/gg/{id?}', function($id = null) {
//        if ($id != null) {
//            // $path = @Crypt::decryptString($id);
//            $path = $id;
//            $StorageService = new \App\Bcore\StorageService();
//            $res = $StorageService->getFile($path, 'google');
//
//            if ($res != null) {
//                header('Content-Type:' . $res['mimetype'] . ';Content-Disposition: attachment; filename="' . $path . '"');
//                echo $res['raw'];
//            } else {
//                echo "<center>ERROR 404!</center>";
//            }
//        }
//    })->name('storage_google');