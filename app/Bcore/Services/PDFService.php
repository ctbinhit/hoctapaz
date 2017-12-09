<?php

namespace App\Bcore\Services;

use Session;
use App\Bcore\StorageService;
use Illuminate\Support\Facades\Storage;

class PDFService {

    public static function getGooglePath() {
        return '0B76IYXdgtJXfY3RTSWctWUdYcW8';
    }

    public static function getFileFromModel($file_model) {
        header('Content-Type:' . $file_model->mimetype . ';Content-Disposition: attachment; filename="' . @$filename . '"');
        $DISK_LOCAL = Storage::disk('localhost');
        $FILE_LOCAL = $file_model->url;
        // Kiểm tra file trên localhost
        if ($DISK_LOCAL->exists($FILE_LOCAL)) {
            echo $DISK_LOCAL->get($FILE_LOCAL);
        } else {
            if ($file_model->sync_google != null) {
                $google_file = GoogleStorageServiceV2::get_fileByJsonText(json_decode($file_model->sync_google));
                
                echo response($google_file);
            }
        }
    }

}
