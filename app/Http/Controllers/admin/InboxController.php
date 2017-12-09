<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use PayService;

class InboxController extends AdminController {

    public function get_index() {


        return view($this->_RV . 'inbox/index', [
        ]);
    }

    public static function register_permissions() {
        return (object) [
                    'admin' => (object) [
                        'per_require' => (object) [
                            'per_man_mail' => (object) [
                                'name' => 'Xem & quản lý mail',
                                'default' => false
                            ],
                            'per_add_mail' => (object) [
                                'name' => 'Tạo mail & gửi đi',
                                'default' => false
                            ],
                            'per_remove_mail' => (object) [
                                'name' => 'Xóa mail',
                                'default' => false
                            ],
                        ],
                        'signin_require' => true,
                        'classes_require' => (object) [
                            'App\Bcore\StorageService',
                            'App\Models\ArticleOModel',
                            'Illuminate\Support\Facades\Lang'
                        ]
                    ],
                    'client' => (object) [
                        'signin_require' => false,
                    ]
        ];
    }

}
