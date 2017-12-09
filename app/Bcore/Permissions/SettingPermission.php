<?php

namespace App\Bcore\Permissions;

use App\Modules\UserPermission\Services\UPService;
use App\Http\Controllers\admin\SettingController;

trait SettingPermission {

    public function register_permissions() {
        return (new UPService(__CLASS__))
                        ->register_permission('get_index', 'Xem tổng quan cài đặt hệ thống')
                        ->rp('post_index', 'Lưu tổng quan')
                        ->rp('get_info', 'Xem tin website')
                        ->rp('post_info', 'Cập nhật thông tin website')
                        ->rp('get_social', 'Xem thông tin URL mạng xã hội')
                        ->rp('post_social', 'Cập nhật thông tin URL mạng xã hội')
                        ->rp('get_session', 'Xem thông tin phiên làm việc hệ thống (Session)')
                        ->rp('post_session', 'Cập nhật thông tin phiên làm việc hệ thống (Session)')
                        ->rp('get_account', 'Xem thông tin danh sách các tài khoản hệ thống')
                        ->rp('get_account_facebook', 'Xem thông tin danh sách tài khoản Facebook (Bao gồm API)')
                        ->rp('post_account_facebook', 'Cập nhật thông tin tài khoản facebook')
                        ->rp('get_account_googledrive', 'Xem thông tin danh sách các tài khoản google (Bao gồm API)')
                        ->rp('get_account_googledrive_path', 'Xem thông tin cấu hình Storage Path của (Google Drive)')
                        ->rp('post_account_googledrive_path', 'Cập nhật thông tin cấu hính Storage Path (Google Drive)')
                        ->rp('get_mail', 'Xem thông tin cấu hình mail (System)')
                        ->run();
    }

}
