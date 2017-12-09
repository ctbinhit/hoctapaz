<?php

namespace App\Bcore\Services\UserServices;

use SettingModel,
    SettingAccountModel;
use Session,
    Cache;
use App\Bcore\Services\UserService;

trait Tr_Payment {

    public static function pay($money) {
        try {
            $UserInfo = UserService::db_info();
            if ((int) $UserInfo->coin < (int) $money) {
                return false;
            }
            $UserInfo->coin -= $money;
            return $UserInfo->save();
        } catch (\Exception $ex) {
            return false;
        }
    }

    public static function coin() {
        try {
            return UserService::db_info()->coin();
        } catch (\Exception $ex) {
            return false;
        }
    }

    public static function returnMoneyBack($money) {
        try {
            $UserInfo = UserService::db_info();
            $UserInfo->coin += $money;
            return $UserInfo->save();
        } catch (\Exception $ex) {
            return false;
        }
    }

}
