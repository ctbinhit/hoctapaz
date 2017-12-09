<?php

namespace App\Bcore\Permissions;

use App\Modules\UserPermission\Services\UPService;
use \App\Http\Controllers\admin\ArticleController;

trait ArticlePermission {

    public function register_permissions() {
        return (new UPService(__CLASS__))
                        ->set_header('Bài viết', '30-11-2017 22:29:00 PM')
                        ->register_permission('get_index', 'Xem danh sách các bài viết')
                        ->rp('get_add', 'Thêm một bài viết')
                        ->rp('get_add', 'Cập nhật bài viết')
                        ->register_type('tintuc', 'Tin tức', [
                            'default' => false,
                            'columns' => [
                                ['id_category' => $this->strict_category()]
                            ]
                        ])
                        ->rt('tuyen-dung', 'Tuyển dụng')
                        ->run();
    }

    public function strict_category() {
        return (new \App\Models\CategoryModel())
                        ->set_type('tintuc')
                        ->set_table('articles')
                        ->set_lang(1)
                        ->execute()
                        ->load_data();
    }

}
