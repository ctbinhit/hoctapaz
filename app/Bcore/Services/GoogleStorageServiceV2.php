<?php

/* ============================================================
 * 
 */

namespace App\Bcore\Services;

use Illuminate\Support\Facades\Storage;

class GoogleStorageServiceV2 {

    public $_STORAGENAME = 'google';
    protected $_FILE = null;
    protected $_DISK = null;
    protected $_FOLDER = null;
    protected $_FILENAME = null;

    public function __construct($file = null) {
        if ($file != null) {
            $this->_FILE = $file;
        }
    }

    public static function info() {
        return (object) [
                    'version' => $this->version(),
                    'author' => $this->author(),
                    'website' => 'http://binhcao.com',
                    'phone' => ['0964247742'],
                    'email' => [
                        'ctbinhit@gmail.com', 'binhcao.toannang@gmail.com', 'binh77.toannang@gmail.com'
                    ],
                    'license' => $this->license()
        ];
    }

    public static function license() {
        return (object) [
                    'key' => null,
                    'copyright' => null
        ];
    }

    public static function author() {
        return "Bình Cao";
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

    public static function version() {
        return 2.0;
    }

    public function create_folder() {
        
    }

    public static function check_directoryInDirectoryByName($dir_name, $id_parent = '/') {
        $content = collect(Storage::disk('google')
                        ->listContents($id_parent, false
        ));
        return $content
                        ->where('type', '=', 'dir')
                        ->where('filename', '=', trim($dir_name, '/'))
                        ->first();
    }

    public static function check_directoryInDirectoriesByName($dir_name, $id_parent = '/') {
        $content = collect(Storage::disk('google')
                        ->listContents($id_parent, true
        ));
        return $content
                        ->where('type', '=', 'dir')
                        ->where('filename', '=', trim($dir_name, '/'))
                        ->first();
    }

    public function get_fileInDirectoriesByName($filename, $id_parent = '/') {
        $content = collect(Storage::disk('google')
                        ->listContents($id_parent, true
        ));

        $file = explode('.', $filename);

        $r = $content
                ->where('type', '=', 'file')
                ->where('filename', '=', $file[0])
                ->where('extension', '=', $file[1]);
        return $r->first();
    }

    public function check_directoryInDirectoryById($id_dir) {
        
    }

    public function check_directoryInDirectoriesById($id_dir) {
        
    }

    /* =================================================================================================================
     *                                          convert_directoriesByStringPath
     * -----------------------------------------------------------------------------------------------------------------
     * Input: articles/photo
     * Output: /0B76IYXdgtJXfenc5d2tpQl9GWUE/0B76IYXdgtJXfX0lmaVFXR25CdkE (Google drive )
     * =================================================================================================================
     */

    public static function convert_directoriesByStringPath($pPath, $auto_create = false) {
        try {

            $tmp = explode('/', trim($pPath, '/'));
            $path = [];
            foreach ($tmp as $dir) {
                if (count($path) == 0) {
                    $a = GoogleStorageServiceV2::check_directoryInDirectoryByName($dir);
                    if ($a != null) {
                        $path[] = $a['basename'];
                    } else {
                        if ($auto_create == false) {
                            return "Directory " . $dir . " not found!";
                        } else {
                            // Create new directory
                            $cd = GoogleStorageServiceV2::create_directory($dir);
                            $path[] = $cd['basename'];
                        }
                    }
                } else {
                    $b = GoogleStorageServiceV2::check_directoryInDirectoryByName($dir, '/' . end($path) . '/');
                    if ($b != null) {
                        $path[] = $b['basename'];
                    } else {
                        if ($auto_create == false) {
                            return "Directory " . $dir . " not found!";
                        } else {
                            // Create new directory
                            $cd1 = GoogleStorageServiceV2::create_directory(GoogleStorageServiceV2::convertArrayToURL($path, $dir));
                            $path[] = $cd1['basename'];
                        }
                    }
                }
            }
            return GoogleStorageServiceV2::convertArrayToURL($path);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    public static function convertArrayToURL($pArray, $dir = null) {
        $URL = '';
        foreach ($pArray as $k => $v) {
            $URL .= $v . '/';
        }
        return $URL . $dir;
    }

    public function dir_inDirectory($dir_name) {
        $content = collect(Storage::disk('google')
                        ->listContents('/', false
        ));
        $dir = $content
                ->where('type', '=', 'dir')
                ->where('filename', '=', trim($dir_name, '/'))
                ->first();
        if ($dir == null) {
            return false;
        }
        return $dir;
    }

    public static function create_directory($path) {
        Storage::disk('google')->makeDirectory($path);
        $a = GoogleStorageServiceV2::check_directoryInDirectoryByName($path);
        if ($a != null) {
            return $a;
        } else {
            return false;
        }
    }

    public function upload() {
        //$url = $this->convert_directoriesByStringPath($this->_FOLDER, true);
        if (Storage::disk('google')->put('/' . $this->_FOLDER . $this->_FILENAME, $this->_FILE)) {
            return $this->get_fileInDirectoriesByName($this->_FILENAME);
        } else {
            return null;
        }
    }

    public static function get_fileByJsonText($json_data) {
        return Storage::disk('google')->get($json_data->path);
    }

}
