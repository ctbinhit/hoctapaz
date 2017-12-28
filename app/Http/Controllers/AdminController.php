<?php

namespace App\Http\Controllers;

use App\Bcore\ControllerService;
use View;
use App\Helper\BView;
use LanguageModel;
use App\Functions\ClsAdmin;
use Illuminate\Support\Facades\Redirect;
use App\Bcore\UserInterface;
use App\Models\SettingAccountModel;
use Cache,
    SettingModel;
use App\Bcore\Services\UserServiceV2;
use App\Bcore\Services\UserServiceV3;
use App\Bcore\SystemComponents\User\UserType;

class AdminController extends ControllerService {

    public $_RV = 'admin/';
    public $_FKEY = null;
    public $_ML = '';
    public $_LISTLANG = null;
    public $_FORMPREFIX = null;
    public $_SETTING = null;
    protected $guarded_variables = [
        '_RV', '_FKEY', '_ML', '_LISTLANG', '_FORMPREFIX'
    ];
    public $current_admin = null;

    public function __construct() {
        parent::__construct();
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
//        $this->_FKEY = env('APP_FORM_KEY');
//        View::share('_FKEY', $this->_FKEY);

        $this->middleware(function ($request, $next) {
//            $user_info = UserServiceV2::get_currentSessionData(UserType::admin());
//            $this->current_admin = $user_info;
//            View::share('current_admin', (object) $user_info);
            $this->load_userSession();
            return $next($request);
        });
    }

    public function load_userSession() {
        $this->current_admin = (object) json_decode(json_encode((new UserServiceV3)->admin()->load_session()->get_session()));
        View::share('current_admin', (object) $this->current_admin);
        return $this->current_admin;
    }

    public function __call($method, $parameters) {
        switch ($method) {
            case 'out':
                Redirect::to('admin')->send();
                break;
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
