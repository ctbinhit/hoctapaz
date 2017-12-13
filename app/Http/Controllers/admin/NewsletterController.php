<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use Cache,
    Route;
use App\Models\NewsletterModel;
use App\Bcore\Services\UserServiceV2;
use App\Bcore\System\UserType;

class NewsletterController extends AdminController {

    public function __construct() {
        parent::__construct();
    }

    public function get_index($type, Request $request) {
        $NewsletterModels = NewsletterModel::where([
                    ['type', $type]
                ])
                ->orderBy('id', 'DESC');


        if ($request->has('keyword')) {
            $NewsletterModels->where('name', 'LIKE', '%' . $request->input('keyword') . '%');
        }



        return view('admin/newsletter/index', [
            'items' => $NewsletterModels->paginate(10)
        ]);
    }

}
