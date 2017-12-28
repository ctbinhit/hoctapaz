<?php

namespace App\Bcore\Services;

use Illuminate\Support\Facades\Storage;
use App\Bcore\Services\StorageServiceV2;
use DB;

class ImageService {

    private $_model = null;
    private $_IdModel = null;
    private $_name = null;
    private $_disk = 'localhost';

    function __construct($disk = null) {

        if ($disk != null) {
            $this->_disk = $disk;
        }
    }

    private function fileExists($url) {
        if (Storage::disk($this->_disk)->exists($url)) {
            return true;
        } else {
            return false;
        }
    }

    public function getImageUrlById($id, $disk = null) {
        if ($disk != null) {
            $this->_disk = $disk;
        }
        $Model = DB::table('photos')->find($id);
        if ($Model == null) {
            return $this->no_imageURL();
        }
        $FileOnDisk = StorageServiceV2::fileExists($Model->url, $this->_disk);
        if ($FileOnDisk) {
            return Storage::disk($this->_disk)->url($Model->url);
        } else {
            return $this->no_imageURL();
        }
    }

    public function set_name($type) {
        $this->_name = $type;
        return $this;
    }

    public function appendImage($type, $model = null) {
        if ($this->_name == null) {
            $this->_name = $type;
        }
        if ($model != null) {
            $this->_model = $model;
        } else {
            if ($this->_model == null) {
                return null;
            }
        }
        $Photo = DB::table('photos')
                ->where([
                    ['obj_table', $this->_model->tbl == 'user' ? 'users' : $this->_model->tbl],
                    ['obj_type', $type],
                    ['deleted_at', null]
                ])
                ->orderBy('id', 'DESC')
                ->first();
        if ($Photo != null) {
            if (Storage::disk($this->_disk)->exists($Photo->url)) {
                $this->_model->{$this->_name} = $Photo;
            }
        } else {
            $this->_model->{$this->_name} = (object) ['url' => $this->no_userPhoto()];
        }
        return $this->_model;
    }

    public static function no_imageURL() {
        return Storage::disk('localhost')->url('default/no-image.png');
    }

    public static function no_userPhoto() {
        return Storage::disk('localhost')->url('default/no-user.png');
    }

}
