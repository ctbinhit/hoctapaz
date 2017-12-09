<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use SettingModel,
    UserModel,
    SettingAccountModel,
    App\Models\SettingLangModel,
    LanguageModel,
    CountryModel;
use Cache;
use Illuminate\Support\Facades\Config;
use App\Bcore\Services\NotificationService;

class SettingController extends AdminController {

    use \App\Bcore\Permissions\SettingPermission;

    public function update_setting() {
        Cache::forget('_SETTING');
        Cache::forget('_SETTING_LANG');
    }

    // ===== GENERAL SETTING ===========================================================================================
    public function get_index() {

        return $this->render_view('setting/index', array(
        ));
    }

    public function post_index(Request $request) {
        $SettingMode = SettingModel::find('info');
        $checked = false;
        if ($request->has('mode_fastboot')) {
            if ($request->input('mode_fastboot') == true) {
                $checked = true;
            } else {
                $checked = false;
            }
        }
        if ($SettingMode->mode_fastboot != $checked) {
            $SettingMode->mode_fastboot = $checked;
        }
        if ($SettingMode->save()) {
            $request->session()->flash('message', __('message.capnhatthanhcong'));
        } else {
            $request->session()->flash('message_type', 'warning');
            $request->session()->flash('message', __('message.capnhatkhongthanhcong'));
        }
        $this->remove_cache_setting();
        return redirect()->route('admin_setting_index');
    }

    public function post_setlangdefault(Request $request) {
        if ($request->has('lang')) {
            $ModelUser = UserModel::find(session('user')['id']);
            if ($ModelUser != null) {
                $ModelUser->lang = $request->input('lang');
                $r = $ModelUser->save();
                if ($r == true) {
                    session()->put('user.lang', $ModelUser->lang);
                    $request->session()->flash('message', __('message.capnhatthanhcong'));
                } else {
                    $request->session()->flash('message_type', 'warning');
                    $request->session()->flash('message', __('message.capnhatkhongthanhcong'));
                }
            } else {
                $request->session()->flash('message', __('message.coloixayratrongquatrinhxuly'));
            }
        } else {
            $request->session()->flash('message_type', 'warning');
            $request->session()->flash('message', __('message.coloixayratrongquatrinhxuly'));
        }
        $this->remove_cache_setting();
        return redirect()->route('admin_setting_index');
    }

    // ===== INFO ======================================================================================================

    public function get_info() {
        $arrayIdLang = [];
        foreach ($this->_LISTLANG as $k => $v) {
            $arrayIdLang[] = $v->id;
        }
        $website_data = SettingLangModel::whereIn('id_lang', $arrayIdLang)
                ->get();
        foreach ($this->_LISTLANG as $k => $v) {
            $wd[$v->id] = $website_data->where('id_lang', $v->id)->first();
        }
        return view($this->_RV . 'setting/info/index', [
            'wd' => $wd,
        ]);
    }

    public function post_info(Request $request) {
        $form_data = $request->input('form_data');
        $r = true;
        foreach ($this->_LISTLANG as $k => $v) {
            $SLModel = SettingLangModel::where([
                        ['id_lang', $v->id]
                    ])->first();
            if ($SLModel == null) {
                $SLModel = new SettingLangModel();
            }
            $SLModel->title = @$form_data[$v->id]['title'];
            $SLModel->hotline = @$form_data[$v->id]['hotline'];
            $SLModel->address = @$form_data[$v->id]['address'];
            $SLModel->email = @$form_data[$v->id]['email'];
            $SLModel->website_url = @$form_data[$v->id]['website_url'];
            $SLModel->copyright = @$form_data[$v->id]['copyright'];

            $SLModel->seo_title = @$form_data[$v->id]['seo_title'];
            $SLModel->seo_description = @$form_data[$v->id]['seo_description'];
            $SLModel->seo_keywords = @$form_data[$v->id]['seo_keywords'];
            $SLModel->save();
        }
        if ($r) {
            NotificationService::alertRight('Cập nhật thành công.', 'success', 'Thông tin website');
        } else {
            NotificationService::alertRight('Có lỗi xảy ra, vui lòng thử lại sau', 'warning', 'Thông tin website');
        }
        redirectArea:
        return redirect()->route('admin_setting_info');
    }

    // ===== SOCIAL ====================================================================================================

    public function get_social() {
        $allow_fields = ['setting_lang.id_lang', 'setting_lang.google', 'setting_lang.twitter', 'setting_lang.zalo', 'setting_lang.viber',
            'setting_lang.fb_fanpage', 'setting_lang.skype', 'setting_lang.youtube'];
        $arrayIdLang = [];
        foreach ($this->_LISTLANG as $k => $v) {
            $arrayIdLang[] = $v->id;
        }
        $website_data = SettingLangModel::whereIn('id_lang', $arrayIdLang)
                ->select($allow_fields)
                ->get();
        foreach ($this->_LISTLANG as $k => $v) {
            $wd[$v->id] = $website_data->where('id_lang', $v->id)->first();
        }
        return view($this->_RV . 'setting/info/social', [
            'wd' => $wd,
        ]);
    }

    public function post_social(Request $request) {
        $form_data = $request->input('form_data');
        $r = true;
        foreach ($this->_LISTLANG as $k => $v) {
            $SLModel = SettingLangModel::where([
                        ['id_lang', $v->id]
                    ])->first();
            if ($SLModel == null) {
                $SLModel = new SettingLangModel();
            }
            $SLModel->fb_fanpage = @$form_data[$v->id]['fb_fanpage'];
            $SLModel->google = @$form_data[$v->id]['google'];
            $SLModel->youtube = @$form_data[$v->id]['youtube'];
            $SLModel->skype = @$form_data[$v->id]['skype'];
            $SLModel->zalo = @$form_data[$v->id]['zalo'];
            $SLModel->twitter = @$form_data[$v->id]['twitter'];
            $SLModel->save();
        }
        if ($r) {
            NotificationService::alertRight('Cập nhật thành công.', 'success', 'Thông tin website');
        } else {
            NotificationService::alertRight('Có lỗi xảy ra, vui lòng thử lại sau', 'warning', 'Thông tin website');
        }
        redirectArea:
        return redirect()->route('admin_setting_social');
    }

    // ===== SESSION ===================================================================================================

    public function get_session(Request $request) {
        $SettingModel = $this->get_setting();
        if ($SettingModel->session_user == null) {
            $session_user = -1;
        } else {
            $session_user = $SettingModel->session_user;
        }
        if ($SettingModel->cache_lifetime == null) {
            $cache_lifetime = -1;
        } else {
            $cache_lifetime = $SettingModel->cache_lifetime;
        }

        return view($this->_RV . 'setting/session', array(
            'item' => (object) [
                'session_user' => $session_user,
                'cache_lifetime' => $cache_lifetime
            ],
        ));
    }

    public function post_session(Request $request) {
        if (!$request->has('cache_lifetime') || !$request->has('session_user')) {
            $request->session()->flash('message_type', 'warning');
            $request->session()->flash('message', __('message.coloixayratrongquatrinhxuly'));
            goto resultArea;
        }
        $SettingModel = $this->get_setting(false);
        $SettingModel->session_user = $request->input('session_user');
        $SettingModel->cache_lifetime = $request->input('cache_lifetime');
        if ($SettingModel->save()) {
            $request->session()->flash('message', __('message.capnhatthanhcong'));
        } else {
            $request->session()->flash('message_type', 'warning');
            $request->session()->flash('message', __('message.coloixayratrongquatrinhxuly'));
        }
        resultArea:
        $this->remove_cache_setting();
        return redirect()->route('admin_setting_session');
    }

    // ===== FILE & FOLDERS ============================================================================================

    public function get_ff() {
        $Fields = 'limit_file,limit_document,limit_photo,limit_background,type_file,type_photo,type_background,type_document';
        $item = $this->get_setting();
        return view($this->_RV . 'setting/filesfolders', array(
            'item' => $item
        ));
    }

    public function post_ff(Request $request) {
        $Model = SettingModel::find('info');
        if ($request->has('limit_file')) {
            $Model->limit_file = $request->input('limit_file');
            $Model->limit_photo = $request->input('limit_photo');
            $Model->limit_background = $request->input('limit_background');
            $Model->limit_document = $request->input('limit_document');
        }

        if ($request->has('type_file')) {
            $Model->type_file = $request->input('type_file');
            $Model->type_photo = $request->input('type_photo');
            $Model->type_background = $request->input('type_background');
            $Model->type_document = $request->input('type_document');
        }

        $r = $Model->save();
        if ($r) {
            $request->session()->flash('message', __('message.capnhatthanhcong'));
        } else {
            $request->session()->flash('message_type', 'warning');
            $request->session()->flash('message', __('message.capnhatkhongthanhcong'));
        }
        $this->remove_cache_setting();
        return redirect()->route('admin_setting_ff');
    }

    // ===== LANGUAGE SETTING ==========================================================================================
    public function get_language() {
        $LanguageModel = new LanguageModel();
        $lst_lang = $LanguageModel->db_getListLang();

        return view($this->_RV . 'setting/language', array(
            'items' => $lst_lang
        ));
    }

    public function get_language_add() {
        $lst_country_code = CountryModel::select(['id', 'name', 'sortname'])->get();
        return view($this->_RV . 'setting/language_add', [
            'lst_country_code' => $lst_country_code
        ]);
    }

    // ===== ACCOUNTS SETTING ==========================================================================================

    public function get_account() {
        return view($this->_RV . 'setting/account/index', [
        ]);
    }

    public function get_account_facebook() {
        $Model = \App\Models\SettingAccountModel::find('facebook-api');
        if ($Model == null) {
            return "Lỗi hệ thống, vui lòng kiểm tra lại dữ liệu API";
        }
        return view($this->_RV . 'setting/account/facebook/setting', [
            'item' => $Model
        ]);
    }

    public function post_account_facebook(Request $request) {
        try {
            $Model = \App\Models\SettingAccountModel::find('facebook-api');
            $Model->app_id = $request->input('app_id');
            $Model->app_version = $request->input('app_version');
            $Model->app_key = $request->input('app_key');
            if ($Model->save()) {
                \App\Bcore\Services\NotificationService::alertRight('Cập nhật thành công', 'success');
            } else {
                \App\Bcore\Services\NotificationService::alertRight('Cập nhật không thành công', 'warning');
            }
        } catch (\Exception $ex) {
            \App\Bcore\Services\NotificationService::alertRight('Có lỗi hệ thống!', 'danger');
        }
        return redirect()->route('admin_setting_account_facebook');
    }

    public function get_account_googledrive() {
        $Model = SettingAccountModel::find('google-drive');
        if ($Model != null) {
            $StorageServide = new \App\Bcore\StorageService();
            $StorageServide->setDisk('google');
            if ($this->_SETTING->mode_fastboot) {
                goto SaveArea;
            }
            $ParentFolderInfo = $StorageServide->checkConnectionRoot($Model->storage_parent);
            if ($ParentFolderInfo['code'] == -1) {
                $Model->status = __($ParentFolderInfo['message']);
            } else {

                // Kết nối thành công --------------------------------------------------------------------------------------
                $Model->status = __(@$ParentFolderInfo['message']);
                $ParentFolderSize = $StorageServide->getDiskUssage();
                $Model->file_count = @$StorageServide->fileCount();
                $Model->dir_count = @$StorageServide->dirCount();
                $Model->oth_count = @$StorageServide->othCount();
                $Model->storage_parent_name = @$ParentFolderInfo['data']['filename'];
                $Model->storage_parent_size = $ParentFolderSize;
            }
        } else {
            $Model = null;
        }
        SaveArea:
        return view($this->_RV . 'setting/account/google_drive', [
            'item' => $Model
        ]);
    }

    public function get_account_googledrive_path() {
        $list_storage = ['exam_documents', 'file_doc'];
        $GSM = \App\Models\GoogleStorageModel::whereIn('id', $list_storage)->get();
        return view($this->_RV . 'setting/account/google/storage_path', [
            'gg_paths' => $GSM
        ]);
    }

    public function post_account_googledrive_path(Request $request) {
        $has_error = false;
        $storage_data = $request->input('storage');
        foreach ($storage_data as $k => $v) {
            $GSM = \App\Models\GoogleStorageModel::find($k);
            if ($GSM != null) {
                $GSM->id_google = $v;
                $GSM->save();
            } else {
                $has_error = true;
            }
        }
        if ($has_error) {
            NotificationService::alertRight('Có lỗi xảy ra trong quá trình cập nhật.', 'warning');
        } else {
            NotificationService::alertRight('Cập nhật thành công!', 'success');
        }
        return redirect()->route('admin_setting_account_googledrive_path');
    }

    public function post_account_googledrive(Request $request) {
        $Model = SettingAccountModel::find('google-drive');
        if ($Model == null) {
            $request->session()->flash('message_type', 'warning');
            $request->session()->flash('message', Lang::get('message.coloixayratrongquatrinhxuly'));
            goto redirectArea;
        }
        $Model->client_id = $request->input('client_id');
        $Model->app_key = $request->input('app_key');
        $Model->token = $request->input('token');
        $Model->storage_parent = $request->input('storage_parent');
        $r = $Model->save();
        if ($r) {
            $request->session()->flash('message', __('message.capnhatthanhcong'));
        } else {
            $request->session()->flash('message_type', 'warning');
            $request->session()->flash('message', __('message.capnhatkhongthanhcong'));
        }
        redirectArea:
        return redirect()->route('admin_setting_account_googledrive');
    }

    // ===== TIMEZONE SETTING ==========================================================================================

    public function get_datetime() {
        $Model = SettingModel::find('info');
        $CurrentTimeZone = $Model->timezone;
        $LstTimeZone = config('Libraries.timezone');
        return view($this->_RV . 'setting/datetime', [
            'lst_timezone' => $LstTimeZone,
            'current_timezone' => $CurrentTimeZone
        ]);
    }

    public function post_datetime(Request $request) {
        if ($request->has('timezone')) {
            $Model = SettingModel::find('info');
            $Model->timezone = $request->input('timezone');
            $r = $Model->save();
            if ($r) {
                $request->session()->flash('message', 'Cập nhật thành công!');
            } else {
                $request->session()->flash('message_type', 'error');
                $request->session()->flash('message', 'Cập nhật không thành công!');
            }
        } else {
            $request->session()->flash('message_type', 'error');
            $request->session()->flash('message', __('message.coloixayra'));
        }
        return redirect()->route('admin_setting_timezone');
    }

    // ===== MAIL ======================================================================================================

    public function get_mail() {
        $Model = SettingAccountModel::select([
                    'driver', 'ip_host', 'username', 'password', 'port', 'updated_at'
                ])->find('mail');
        return view($this->_RV . 'setting/mail/index', [
            'mail_info' => $Model
        ]);
    }

    public function post_mail(Request $request) {

        $Model = SettingAccountModel::find('mail');
        if ($request->has('driver')) {
            $Model->driver = $request->input('driver');
        }
        if ($request->has('ip_host')) {
            $Model->ip_host = $request->input('ip_host');
        }
        if ($request->has('username')) {
            $Model->username = $request->input('username');
        }
        if ($request->has('password')) {
            $Model->password = $request->input('password');
        }
        if ($request->has('port')) {
            $Model->port = $request->input('port');
        }
        $r = $Model->save();
        if ($r) {
            $request->session()->flash('message', 'Cập nhật thành công!');
        } else {
            $request->session()->flash('message_type', 'error');
            $request->session()->flash('message', 'Cập nhật không thành công!');
        }
        return redirect()->route('admin_setting_mail');
    }

    // ===== SAVE LANGUAGE =============================================================================================

    public function post_language_save(Request $request) {
        $pArray = [];
        $pArray['id_user'] = session('user')['id'];
        foreach ($request->except('id') as $k => $v) {
            if (Schema::hasColumn('languagé', $k)) {
                if ($v !== null)
                    $pArray[$k] = $v;
                else {
                    $pArray[$k] = '';
                }
            }
        }
        $LangModel = new LanguageModel();
        $r = $LangModel->db_save($request->input('id') == null ? null : $request->input('id'), $pArray);
        if ($r === true) {
            $request->session()->flash('message', 'Cập nhật thành công!');
        } else {
            $request->session()->flash('message_type', 'error');
            $request->session()->flash('message', 'Cập nhật không thành công!');
        }
        return redirect()->route('admin_setting_language');
    }

    // ===== SAVE SETTING ==============================================================================================

    public function post_save(Request $request) {
        $form_fields = $this->form_field_generator($request->all());
        if ($form_fields == null) {
            $request->session()->flash('message_type', 'alert-danger');
            $request->session()->flash('message', 'Không nhận được dữ liệu!');
            goto redir;
        }
        foreach ($form_fields as $v) {
            if (!isset($v['id']))
                goto add;
            $SettingLangModel = SettingLangModel::where('id', '=', $v['id'])->first();
            if ($SettingLangModel == null) {
                add:
                $v['id_setting'] = 'info';
                $r = SettingLangModel::insert($v);
            } else {
                $r = $SettingLangModel->update($v);
            }
        }
        if ($r === true) {
            $request->session()->flash('message', 'Cập nhật thành công!');
        } else {
            $request->session()->flash('message_type', 'alert-danger');
            $request->session()->flash('message', 'Cập nhật không thành công!');
        }

        redir:
        return redirect()->route('admin_setting_index');
    }

//
//    public static function register_permissions() {
//        return (object) [
//                    'admin' => (object) [
//                        'per_require' => (object) [
//                            'per_edit_seo' => (object) [
//                                'name' => 'Xem & cập nhật nội dung seo',
//                                'default' => false
//                            ],
//                            'per_edit_seo' => (object) [
//                                'name' => 'Xem & cập nhật nội dung seo',
//                                'default' => false
//                            ],
//                            'per_edit_info' => (object) [
//                                'name' => 'Xem & cập nhật thông tin doanh nghiệp',
//                                'default' => false
//                            ],
//                            'per_edit_social' => (object) [
//                                'name' => 'Xem & cập nhật link mạng xã hội',
//                                'default' => false
//                            ],
//                            'per_edit_mail_info' => (object) [
//                                'name' => 'Thay đổi cấu hình mail',
//                                'default' => false
//                            ],
//                            'per_edit_file_info' => (object) [
//                                'name' => 'Thay đổi cấu hình thư mục & tệp tin',
//                                'default' => false
//                            ],
//                            'per_edit_session_info' => (object) [
//                                'name' => 'Thay đổi cấu hình phiên làm việc',
//                                'default' => false
//                            ],
//                            'per_view_accounts' => (object) [
//                                'name' => 'Xem danh sách tài khoản',
//                                'default' => false
//                            ],
//                            'per_edit_accounts' => (object) [
//                                'name' => 'Thay đổi cấu hình tài khoản',
//                                'default' => false
//                            ],
//                            'per_edit_timezone' => (object) [
//                                'name' => 'Thay đổi cấu hình múi giờ & ngày giờ',
//                                'default' => false
//                            ],
//                            'per_remove_cache' => (object) [
//                                'name' => 'Xóa cache hệ thống',
//                                'default' => false
//                            ],
//                        ],
//                        'signin_require' => true,
//                        'classes_require' => (object) [
//                            'App\Bcore\StorageService',
//                            'App\Models\ArticleOModel',
//                            'Illuminate\Support\Facades\Lang'
//                        ]
//                    ],
//                    'client' => (object) [
//                        'signin_require' => false,
//                    ]
//        ];
//    }
}
