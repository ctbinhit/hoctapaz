<?php

namespace App\Bcore\Services;

use Illuminate\Support\Facades\Storage;

class StorageServiceV2 {

    private $_storage = 'app/public/';
    private $_log = null;
    protected $_FILE = null;
    protected $_DISK = null;
    protected $_FOLDER = null;
    protected $_FILENAME = null;
    // =================================================================================================================
    protected $_FILE_UPLOADED = null;
    protected $_FILE_UPLOADED_FULLPATH = null;

    public function file_uploaded() {
        return $this->_FILE_UPLOADED;
    }

    public function file_uploaded_path() {
        return $this->_FILE_UPLOADED_FULLPATH;
    }

    public function file_uploaded_url() {
        return Storage::disk($this->_DISK)->url($this->_FILE_UPLOADED_FULLPATH);
    }

    public function get_rawFileUploaded() {
        $arrContextOptions = stream_context_create([
            "ssl" => array(
                //'cafile' => Storage::disk('localhost')->url('system/cacert.pem'),
                //'default_cert_dir_env' => 'Z:/www/Ampps/apache/conf/ssl_crt',
                'verify_peer' => false,
                'verify_peer_name' => false,
            )
        ]);

        return file_get_contents($this->file_uploaded_url(), false, $arrContextOptions);
    }

    public function __construct($file = null) {
        if ($file != null) {
            $this->_FILE = $file;
        }
    }

    public static function version() {
        return 2.0;
    }

    public function set_file($file) {
        if ($file != null) {
            $this->_FILE = $file;
        }
        return $this;
    }

    public function as_name($file_name) {
        $this->_FILENAME = $file_name;
        return $this;
    }

    public function disk($disk_name) {
        $this->_DISK = $disk_name;
        return $this;
    }

    public function folder($folder_path) {
        $this->_FOLDER = $folder_path;
        return $this;
    }

    public function upload() {
        if ($this->_DISK == null) {
            return false;
        }

        if ($this->_FILENAME != null) {
            $r = Storage::disk($this->_DISK)->putFileAs($this->_FOLDER, $this->_FILE, $this->_FILENAME);
            $this->_FILE_UPLOADED = $this->_FILENAME;
            $this->_FILE_UPLOADED_FULLPATH = $this->_FOLDER . '/' . $this->_FILENAME;
        } else {
            $r = Storage::disk($this->_DISK)->putFile($this->_FOLDER, $this->_FILE);

            $this->_FILE_UPLOADED_FULLPATH = $r;
        }
        if ($r != null) {
            $this->_FILE_UPLOADED = array_last(explode('/', $r));
            return $this;
        } else {
            $this->_FILE_UPLOADED = null;
            $this->_FILE_UPLOADED_FULLPATH = null;
            return null;
        }
    }

    private function set_log() {
        
    }

    public function sync_google($parent_id) {

        if ($this->_FILE_UPLOADED == null) {
            return false;
        }

        if (!class_exists(GoogleStorageServiceV2::class)) {
            return false;
        }

        $GoogleStorageService = new GoogleStorageServiceV2($this->get_rawFileUploaded());
        $FileGoogle = $GoogleStorageService
                ->as_name($this->_FILE_UPLOADED)
                ->folder($parent_id . '/')
                ->upload();
        return $FileGoogle;
    }

    public function sync_dropbox() {
        return "Chưa hỗ trợ upload file lên dropbox";
    }

}
