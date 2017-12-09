<?php

namespace App\Bcore\Services;

use Illuminate\Support\Facades\Storage;

class ImageService {

    function __construct() {
        
    }

    public static function no_imageURL() {
        return Storage::disk('localhost')->url('default/no-image.png');
    }

    public static function no_userPhoto() {
        return Storage::disk('localhost')->url('default/no-user.png');
    }

}
