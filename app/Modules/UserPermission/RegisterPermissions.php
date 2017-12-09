<?php

namespace App\Modules\UserPermission;

trait RegisterPermissions {

    function load_classes() {
        return [
            'Quản lý hệ thống' => \App\Http\Controllers\admin\SettingController::class,
            'Quản lý bài viết' => \App\Http\Controllers\admin\ArticleController::class,
                // 'Quản lý bài viết (Đơn) ' => \App\Models\ArticleOController::class,
                //  'Quản lý sản phẩm' => \App\Modules\Product\Controllers\ProductController::class,
                //  'Quản lý đơn hàng' => \App\Modules\Cart\Controllers\Admin\CartController::class
        ];
    }

}
