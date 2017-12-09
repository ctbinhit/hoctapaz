<?php

namespace App\Http\Controllers;

use App\Bcore\ControllerService;
use App\Functions\ClsAdmin;
use App\Bcore\UserInterface;
use App\Models\SettingModel;
use View,
    Config;
use Illuminate\Support\Facades\Cache;
use App\Bcore\Services\UserServiceV2;
use App\Bcore\System\UserType;

class ProfessorController extends ControllerService {

    public $_RV = 'pi/';
    public $current_user = null;
    protected $guarded_variables = [
        '_RV', '_FKEY', '_ML', '_LISTLANG', '_FORMPREFIX'
    ];

    public function eloquent_merge($pObj1, $pObj2) {
        $res;
        foreach ($pObj1 as $k => $v) {
            if (!isset($res[$k])) {
                $res[$k] = $v;
            }
        }
        foreach ($pObj2 as $k => $v) {
            if (!isset($res[$k])) {
                $res[$k] = $v;
            }
        }
        return $res;
    }

    public function __construct() {
        parent::__construct();

        // ----- NAVBAR ------------------------------------------------------------------------------------------------
        $this->middleware(function ($request, $next) {
            $navbar = new \App\Bcore\ActionView();
            View::share('navbar', $navbar);
            $this->_NAVBAR = $navbar;

            $user_info = UserServiceV2::get_currentSessionData(UserType::professor());
            $this->current_user = $user_info;
            View::share('current_user', (object) $user_info);
            View::share('user_info', (object) $user_info);

            return $next($request);
        });
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

}
