<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Bcore\Services\GoogleStorageServiceV2;
use App\Models\FileModel;
use DB;

class FileController {

    function __construct() {
        
    }

    public function file_private($id_file, $url_encode) {
        $UserDataModel = \App\Models\UserDataModel::find($id_file);
        $UserDataModel->do = json_decode($UserDataModel->data_object);
        
        if ($UserDataModel->id_user != \App\Bcore\Services\UserService::id()) {
            return "File không tồn tại!";
        }
        header('Content-Type:' . $UserDataModel->do->mimetype . ';Content-Disposition: attachment; filename="' . $UserDataModel->do->name . '"');
        $DISK_LOCAL = Storage::disk('localhost');
        $FILE_LOCAL = $UserDataModel->do->url;
        if ($DISK_LOCAL->exists($FILE_LOCAL)) {
            echo $DISK_LOCAL->get($FILE_LOCAL);
        } else {
            abort(404);
        }
    }

    public function file_request($url_encode) {
        $FILEMODEL = \App\Models\FileModel::where('url_encode', $url_encode)->first();
        header('Content-Type:' . $FILEMODEL->mimetype . ';Content-Disposition: attachment; filename="' . $FILEMODEL->name . '"');
        $DISK_LOCAL = Storage::disk('localhost');
        $FILE_LOCAL = $FILEMODEL->url;
        // Kiểm tra file trên localhost
        if ($DISK_LOCAL->exists($FILE_LOCAL)) {
            echo $DISK_LOCAL->get($FILE_LOCAL);
        } else {
            if ($FILEMODEL->sync_google != null) {
                $google_file = GoogleStorageServiceV2::get_fileByJsonText(json_decode($FILEMODEL->sync_google));
                echo response($google_file);
            }
        }
    }

}
