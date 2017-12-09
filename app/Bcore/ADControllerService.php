<?php

namespace App\Bcore;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use SettingModel,
    SettingLangModel,
    SettingAccountModel;
use MenuModel,
    UserModel,
    UserPermissionModel;
use App\Functions\ClsAdmin;
use LanguageModel;
use LanguageService;
use Config,
    Session,
    Cache,
    View;

class ADControllerService extends BaseController {

    public $_SETTING = null;
    public $_SETTING_LANG = null;
    public $_SETTING_ACCOUNT;

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    function __construct() {
        // ===== MULTIPLE LANGUAGES ====================================================================================
        $LanguageModel = new LanguageModel();
        if (env('APP_MULTIPLE_LANG') == true) {
            $this->_ML = '_langs';
            // Share cho tất cả các controller
            $this->_LISTLANG = $LanguageModel->db_getListLangAvailible();
        } else {
            $this->_LISTLANG = $LanguageModel->db_getLangDefault();
        }
        // Share list lang cho tất cả các view
        View::share('_LISTLANG', $this->_LISTLANG);
        // ===== DECLARE FORM KEY ======================================================================================
        $this->_FKEY = env('APP_FORM_KEY');
        View::share('_FKEY', $this->_FKEY);
        // ----- NAVBAR ------------------------------------------------------------------------------------------------
        $this->middleware(function ($request, $next) {
            $navbar = new \App\Bcore\ActionView();
            View::share('navbar', $navbar);
            $this->_NAVBAR = $navbar;

            $nav = new ClsAdmin();
            View::share('nav', $nav);
            $this->_NAV = $nav;
            return $next($request);
        });


        // -------------------------------------------------------------------------------------------------------------
        $Model = Cache::remember('SETTING_SYNC_GOOGLEDRIVE', 3600, function() {
                    return SettingAccountModel::find('google-drive');
                });
        // -------------------------------------------------------------------------------------------------------------
        if ($Model != null) {
            config(['bcore.Sync.Google.Active' => $Model->active]);
            config(['bcore.Sync.Google.AutoSync' => $Model->auto_sync]);
            if ($Model->active) {
                config(['Bcore.storage_service.google_drive.GOOGLE_DRIVE_CLIENT_ID' => $Model->client_id]);
                config(['Bcore.storage_service.google_drive.GOOGLE_DRIVE_CLIENT_SECRET' => $Model->app_key]);
                config(['Bcore.storage_service.google_drive.GOOGLE_DRIVE_REFRESH_TOKEN' => $Model->token]);
                config(['Bcore.storage_service.google_drive.GOOGLE_DRIVE_FOLDER_ID' => $Model->storage_parent]);
                // SUB PARENT ID
                // ----- ARTICLE ---------------------------------------------------------------------------------------
                config(['Bcore.storage_service.google_drive.GOOGLE_DRIVE_FOLDER_ARTICLE' => $Model->storage_article]);
                // ----- PRODUCT ---------------------------------------------------------------------------------------
                config(['Bcore.storage_service.google_drive.GOOGLE_DRIVE_FOLDER_PRODUCT' => $Model->storage_article]);
                // ----- CATEGORY --------------------------------------------------------------------------------------
                config(['Bcore.storage_service.google_drive.GOOGLE_DRIVE_FOLDER_CATEGORY' => $Model->storage_article]);
                // ----- GOOGLE_DRIVE_FOLDER_EXAM ----------------------------------------------------------------------
                config(['Bcore.storage_service.google_drive.GOOGLE_DRIVE_FOLDER_EXAM' => $Model->storage_exam]);
            } else {
                
            }
        }

        // LOAD SESSION | CACHE LIFETIME
        $LifeTime = (object) [
                    'CACHE_SETTING' => 3600,
                    'CACHE_SETTING_LANG' => 3600,
                    'CACHE_SETTING_ACCOUNT' => 3600,
        ];

        $this->_SETTING = Cache::remember('CACHE_SETTING', $LifeTime->CACHE_SETTING, function() {
                    return $this->get_setting(false);
                });
        $this->_SETTING_LANG = Cache::remember('CACHE_SETTING_LANG', $LifeTime->CACHE_SETTING_LANG, function() {
                    return $this->get_setting_lang(false);
                });
        $this->_SETTING_ACCOUNT = Cache::remember('CACHE_SETTING_ACCOUNT', $LifeTime->CACHE_SETTING_ACCOUNT, function() {
                    return $this->get_setting_account(false);
                });

        View::share('SETTING', $this->_SETTING);
    }

    public function get_sync_state($pConfigFromController) {
        foreach ($pConfigFromController as $k => $v) {
            if ($v['state'] == null) {
                if (isset($this->_SETTING_ACCOUNT[$k])) {
                    $pConfigFromController[$k]['state'] = $this->_SETTING_ACCOUNT[$k]->active;
                    $pConfigFromController[$k]['data'] = $this->_SETTING_ACCOUNT[$k];
                } else {
                    $pConfigFromController[$k]['state'] = false;
                }
            }
        }
        return $pConfigFromController;
    }

    public function remove_cache() {
        $this->remove_cache_setting;
    }

    public function remove_cache_setting() {
        Cache::forget('CACHE_SETTING');
        Cache::forget('CACHE_SETTING_LANG');
        Cache::forget('CACHE_SETTING_ACCOUNT');
    }

    public function get_setting($return_cache = true) {
        if ($return_cache) {
            return Cache::get('CACHE_SETTING', function() {
                        return $this->get_setting(false);
                    });
        }
        return SettingModel::find('info');
    }

    static public function get_setting_lang($return_cache = true) {
        if ($return_cache) {
            return Cache::get('CACHE_SETTING_LANG', function() {
                        return $this->get_setting_lang(false);
                    });
        }
        return SettingModel::find('info')->db_rela_settingLang;
    }

    public function get_setting_account($return_cache = true) {
        if ($return_cache) {
            return Cache::get('CACHE_SETTING_LANG', function() {
                        return $this->get_setting_account(false);
                    });
        }
        return $this->array_convertSettingAccoutn(SettingAccountModel::all());
    }

    private function array_convertSettingAccoutn($pArray) {
        if ($pArray == null) {
            return null;
        }
        if (count($pArray) <= 0) {
            return null;
        }
        $r = [];
        foreach ($pArray as $k => $v) {
            $r[$v->id] = $v;
        }
        return $r;
    }

    // SUPPORT METHOD

    public function groupModelsById($pModels) {
        if (!is_object($pModels)) {
            return -1;
        }
        if (count($pModels) == 0) {
            return -1;
        }
        $r = [];
        foreach ($pModels as $k => $v) {
            $r[$v->id] = $v;
        }
        return $r;
    }

    // Update 1.3
    public function groupFieldByModels($pFieldName, $pModel) {
        if (count($pModel) == 0) {
            return null;
        }
        $r = [];
        foreach ($pModel as $v) {
            if (isset($v->{$pFieldName})) {
                $r[$v->{$pFieldName}] = $v;
            }
        }
        return $r;
    }

    // Removed from 1.3 ------------------------------------------------------------------------------------------------
    public function get_arrayIdFromField($pFieldName, $pModel) {
        if (count($pModel) == 0) {
            return null;
        }
        $r = [];
        foreach ($pModel as $v) {
            if (isset($v->{$pFieldName})) {
                $r[] = $v->{$pFieldName};
            }
        }
        return $r;
    }

    // xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

    public function get_arrayIdFromModel($pObject) {
        if (!is_object($pObject)) {
            return -1;
        }
        if (count($pObject) <= 0) {
            return -1;
        }
        $r = [];
        foreach ($pObject as $k => $v) {
            $r[] = $v->id;
        }
        return $r;
    }

    public function get_arrayIdLangs() {
        $Models = $this->get_listLangs();
        if (count($Models) != 0) {
            return $this->get_arrayIdFromModel($Models);
        } else {
            return null;
        }
    }

    // ===== Lấy danh sách tất cả các ngôn ngữ hiện tại

    public function get_listLangs() {
        $LS = new LanguageService();
        return $LS->get_listLangs();
    }

    // ===== SET ALERT ============================

    public function setAlert($pObject, $pType = 'html') {
        session::flash("noti_$pType", (object) [
                    'type' => isset($pObject->type) ? $pObject->type : 'info',
                    'title' => isset($pObject->title) ? $pObject->title : 'Thông báo',
                    'msg' => isset($pObject->msg) ? $pObject->msg : 'Không xác định!',
                    'button' => [
                        'home', 'signup', 'signin'
                    ]
        ]);
        if (isset($pObject->redirect)) {
            return redirect()->route($pObject->redirect);
        }
    }
    
    
    
     // ===== registerDVC (Register data view controller) ===============================================================
    // Đăng ký 1 biến VDC cho view hiện tại để quản lý các thành phần bên trong đó
    // Các tham số gồm IdController & Type để phân biệt giữa các UI khác
    // -----------------------------------------------------------------------------------------------------------------
    // @Param $pControllerName: Article,Product...
    // @Param $pType: tintuc, 
    // -----------------------------------------------------------------------------------------------------------------
    // =================================================================================================================

    public function registerDVC($pControllerName, $pType = null, $pViewDataName = 'UI') {
        $pOptions = array(
            'ControllerName' => $pControllerName,
            'Type' => @$pType
        );
        View::share($pViewDataName, new UserInterface((object) $pOptions));
        return $pOptions;
    }

    // =================================================================================================================
    // @Param Controller name
    // @Param Options
    // @Param View data name
    // -----------------------------------------------------------------------------------------------------------------

    public function setViewData($pOptions, $pViewDataName = '_VIEWDATA') {
        $pOptions['ControllerName'] = $this->ControllerName;
        View::share($pViewDataName, (object) $pOptions);
        View::share('BVIEW', new BView($this->ControllerName, (object) $pOptions));
        return $pOptions;
    }

    // =================================================================================================================
    // @Param $pParam (Array)
    // Ex: Array(
    //          'Title' =>  'News',
    //          'Description'   =>  'Your description'
    // -----------------------------------------------------------------------------------------------------------------

    public function sendDataToView($pParam = null) {
        if ($pParam === null || !is_array($pParam)) {
            return;
        }
        foreach ($pParam as $k => $v) {
            if (!in_array($k, $this->guarded_variables)) {
                View::share($k, $v);
            }
        }
    }

    // =================================================================================================================
    // @Param View name
    // @Param Data
    // @Param Multiple languages
    // -----------------------------------------------------------------------------------------------------------------

    public function render_view($pViewName, $pData = array(), $pML = true) {
        $tmp = explode('/', trim($pViewName));
        if ($tmp[0] == 'system') {
            $pML = false;
        }
        $tmp_view = $this->_RV . $pViewName . ($pML == true ? $this->_ML : '');
        return view($tmp_view, $pData);
    }

    // =================================================================================================================    
    // @Param Request (Request of the current page)
    // @Param AppenData (Append data to the result data)
    // @Param Is Object ( = true => return object | return array)
    // Hàm chuyển đổi tất cả cái fields name trong giao diện thành 1 mảng theo id lang
    // -----------------------------------------------------------------------------------------------------------------

    public function form_field_generator($pRequest, $pAppenData = null, $pIsObject = false) {
        try {
            $tmp_model = [];
            foreach ($pRequest as $k => $v) {
                if ($this->_FKEY == '') {
                    return null;
                }
                // [1a] Tách KEY APP  => field name & id_language
                $tmp_dataField = explode($this->_FKEY, $k);
                // [1b] Nếu rỗng trả về null
                if (empty($tmp_dataField)) {
                    return null;
                }
                // [2a] Bẫy lỗi nếu không tồn tại index[1] => filed không hợp lệ => Next step
                if (isset($tmp_dataField[1])) {
                    // Nếu tồn tại khóa => id ngôn ngữ đã tồn tại
                    if (key_exists($tmp_dataField[1], $tmp_model)) {
                        $tmp_model[$tmp_dataField[1]][$tmp_dataField[0]] = $v;
                    } else {
                        // Tạo mới field trong mảng và gán giá trị từ input form
                        $tmp_model[$tmp_dataField[1]][$tmp_dataField[0]] = $v;
                        // Set id ngôn ngữ cho ArticleLanguage Object
                        $tmp_model[$tmp_dataField[1]]['id_lang'] = $tmp_dataField[1];
                        if ($pAppenData !== null) {
                            if (is_array($pAppenData)) {
                                foreach ($pAppenData as $kad => $vad) {
                                    $tmp_model[$tmp_dataField[1]][$kad] = $vad;
                                }
                            }
                        }
                    }
                }
                // End [2a] ============================================================================================
            }
            // End foreach =============================================================================================
            $tmp_model2 = [];
            foreach ($tmp_model as $v) {
                if ($pIsObject) {
                    $tmp_model2[] = (object) $v;
                } else {
                    $tmp_model2[] = $v;
                }
            }
            return $tmp_model2;
        } catch (Exception $ex) {
            return null;
        }
    }

    public function convert_objToListLang($pObj, $isEmptyLanguage = true, $pModel, $pIsObject = false) {
        $r = [];
        if ($pObj == null) {
            return;
        }
        foreach ($pObj as $v) {
            $r[$v->id_lang] = $v;
        }
        if ($isEmptyLanguage === true) {
            foreach ($this->_LISTLANG as $v) {
                if (!key_exists($v->id, $r)) {
                    $r[$v->id] = new $pModel();
                }
            }
        }
        if ($pIsObject)
            return (object) $r;
        return $r;
    }

}
