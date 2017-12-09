<?php

namespace App\Modules\PMN\Controllers\Admin;

use App\Bcore\PackageServiceAD;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;

class PMNController extends PackageServiceAD {

    function __construct() {
        parent::__construct();
    }

    public function get_index($pType, Request $request) {

        // ================================== CHECK PERMISSION =========================================================
        if (class_exists(\App\Modules\UserPermission\Services\UPService::class)) {
            $CP = \App\Modules\UserPermission\Services\UPService::check_permission('per_edit', __CLASS__, $request);
      
            
            if (!$CP->status) {
                return $CP->view;
            }
        }
        // ================================== CHECK PERMISSION =========================================================

        if (!Schema::hasTable('m_pmn')) {
            $this->get_init($pType);
        }

        if ($pType == null) {
            return redirect()->route('admin_index');
        }

        $PMNModel = \App\Modules\PMN\Models\PMNModel::where([
                    ['type', '=', $pType]
                ])->first();
        if ($PMNModel == null) {
            echo "Đang khởi tạo...";
            $this->create($pType);
        }


        return view('PMN::Admin/index', [
            'type' => $pType,
            'item' => $PMNModel,
        ]);
    }

    public function post_index(Request $request) {
        if (!$request->has('type')) {
            return redirect()->route('client_index');
        }
        $PMNModel = \App\Modules\PMN\Models\PMNModel::where([
                    ['type', '=', $request->input('type')]
                ])->first();
        if ($PMNModel == null) {
            return redirect()->route('client_index');
        }

        $PMNModel->content = $request->input('content');
//        $PMNModel->time_from = $request->input('name');
//        $PMNModel->time_to = $request->input('name');
        $PMNModel->display = $request->input('display') == 'on' ? true : false;
        $PMNModel->updated_by = session('user')['id'];
        $PMNModel->scrollamount = $request->input('scrollamount');
        $PMNModel->save();

        return redirect()->route('mdle_pmn_index', $request->input('type'));
    }

    private function create($pType) {
        $PMNModel = new \App\Modules\PMN\Models\PMNModel();
        $PMNModel->type = $pType;
        $PMNModel->content = 'Nội dung thông báo...';
        if ($PMNModel->save()) {
            return redirect()->route('mdle_pmn_index', $pType);
        } else {
            return redirect()->route('admin_index');
        }
    }

    private function get_init($pType) {
        Schema::create('m_pmn', function($table) {
            $table->string('type', 255)->primary()->nullable();
            $table->dateTime('time_from')->nullable();
            $table->dateTime('time_to')->nullable();
            $table->string('content', 255)->default('Thông báo: nội dung thông báo!')->nullable();
            $table->timestamps();
        });
        return redirect()->route('mdle_pmn_index', $pType);
    }

    public static function register_strict() {
        return (object) [
                    'type' => [
                        'header' => (object) [
                            'name' => 'Thông báo top',
                            'default' => true,
                        ],
                    ]
        ];
    }

    public static function register_permissions() {
        return (object) [
                    'admin' => (object) [
                        'per_require' => (object) [
                            'per_edit' => (object) [
                                'name' => 'Cập nhật nội dung thông báo',
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
