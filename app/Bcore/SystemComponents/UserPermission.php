<?php

namespace App\Bcore\SystemComponents;

class UserPermission {

    public static function view() {
        return UserPermission::select();
    }

    public static function write() {
        return UserPermission::insert();
    }

    public static function edit() {
        return UserPermission::update();
    }

    public static function remove() {
        return UserPermission::delete();
    }

    public static function select() {
        return __FUNCTION__;
    }

    public static function insert() {
        return __FUNCTION__;
    }

    public static function update() {
        return __FUNCTION__;
    }

    public static function delete() {
        return __FUNCTION__;
    }

    public static function publish() {
        return __FUNCTION__;
    }

    public static function sync() {
        return UserPermission::synchronize();
    }

    public static function synchronize() {
        return __FUNCTION__;
    }

    public static function approve() {
        return __FUNCTION__;
    }

    public static function reject() {
        return __FUNCTION__;
    }

}
