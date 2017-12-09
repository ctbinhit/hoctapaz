<?php

namespace App\Bcore;

use Illuminate\Support\Facades\Crypt;

class FileService Extends StorageService {

    function __construct() {
        
    }

    public function convertModelToURL($pModel) {
        if ($pModel == null) {
            return -1;
        }
        $URLENCODE_ = $pModel->dir_name . '|' . $pModel->sub_dir . '|' . $pModel->url;
        $URLENCODE = Crypt::encryptString($URLENCODE_);
        return route('doc',$URLENCODE);
    }

}
