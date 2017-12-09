<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Storage;

class SummerNoteController extends AdminController {

    private $storage = 'summernote_data';

    function __construct() {
        
    }

    public function post_upload(Request $request) {
        $file = $request->summernote_file;
        $url = Storage::disk('localhost')->putFile($this->storage, $file, 'public');
        return response()->json([
                    'state' => true,
                    'path' => Storage::disk('localhost')->url($url)
        ]);
    }

}
