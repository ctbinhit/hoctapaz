<?php

/* ======================================== STORAGE SERVICE LIBRARY ====================================================
  | Created by Bình Cao | Functions Google Drive API V3 For Laravel 5.4
  | Phone: (+84) 964 247 742 | Website: http://toannang.com.vn
  | Email: ctbinhit@gmail.com or binhcao.toannang.com
  | Modified date: 02-09-2017 12:13:00 AM
  | --------------------------------------------------------------------------------------------------------------------
  |                                         Developed by ToanNangGroup
  |                                                ------^------
  | ====================================================================================================================
 */

namespace App\Bcore;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Input;

class StorageService extends UserPermission {

    public $storageName = 'public';
    private $dir_name = null;
    private $dir_autocreate = false;
    // 1.3
    private $path_name = null;
    // 1.3

    private $file_name = null;
    private $file_raw = null;
    private $inserted_id = null;
    private $google_inserted_id = null;
    private $google_dirPath = null;
    private $google_file_path = null;
    private $parent_folder = null;
    // Options =========================================================================================================
    private $toObject = true;
    private $recursive = false;
    // Result meta
    private $metadata = null;
    private $file_count = 0;
    private $dir_count = 0;
    private $oth_count = 0;
    // LOG
    private $log = [
            //['code' => null, 'message' => null]
    ];
    private $err = false;
    
    static function version(){
        return 1.3;
    }

    function __construct() {
        
    }

    public function reset() {
        $this->storageName = 'public';
        $this->recursive = false;
        $this->dir_name = null;
        $this->dir_autocreate = false;
        $this->file_name = null;
        $this->file_raw = null;
        $this->inserted_id = null;
        $this->google_inserted_id = null;
        $this->toObject = true;
        $this->google_file_path = null;
        $this->parent_folder = null;
    }

    // ===== LOG =======================================================================================================

    public function showLog() {
        return $this->log;
    }

    // =================================================================================================================

    public function toObject($pArray = null) {
        // ----- Meta data ---------------------------------------------------------------------------------------------
        if ($pArray == null) {
            if ($this->metadata == null) {
                return null;
            } else {
                $pArray = $this->metadata;
            }
        } else {
            $this->metadata = $pArray;
        }
        if (is_array($this->metadata)) {
            return (object) $this->metadata;
        } else {
            return null;
        }
    }

    public function inserted_id() {
        return $this->inserted_id;
// ----- Storage disk ------------------------------------------------------------------------------------------
//        if ($pDisk == null) {
//            if ($this->storageName == null) {
//                return null;
//            } else {
//                $pDisk = $this->storageName;
//            }
//        } else {
//            $this->storageName = $pDisk;
//        }
//        switch ($pDisk) {
//            case 'google':
//                return $this->google_inserted_id;
//                break;
//            case 'public':
//                return $this->inserted_id;
//                break;
//            default:
//                return null;
//        }
    }

    public function fileCount() {
        return $this->file_count;
    }

    public function dirCount() {
        return $this->dir_count;
    }

    public function othCount() {
        return $this->oth_count;
    }

    public function dirInfo() {
        return $this->google_dirPath;
    }

    public function filePath() {
        return $this->google_file_path;
    }

    public function setDisk($pDisk) {
        $this->storageName = $pDisk;
    }

    public function setStorage($pName) {
        $this->storageName = $pName;
    }

    public function removeParentFolder() {
        $this->parent_folder = null;
    }

    public function setParentFolder($pIdParent = null) {
        if ($pIdParent == null) {
            return null;
        }
        $this->parent_folder = $pIdParent;
    }

    public function setOptions($pOptions) {
        foreach ($pOptions as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }

    public function getFolderLocation($pStorageName = null, $pParentName = null) {
        if ($pParentName == null || $pStorageName == null) {
            return null;
        }
        return config::get('Bcore.storage_service.' . $pStorageName . '.' . $pParentName);
    }

    public function find($pId, $pDisk = null) {
        // ----- Storage disk ------------------------------------------------------------------------------------------
        if ($pDisk == null) {
            if ($this->storageName == null) {
                return null;
            } else {
                $pDisk = $this->storageName;
            }
        } else {
            $this->storageName = $pDisk;
        }
        $r = null;
        switch ($this->storageName) {
            case 'google':
                $r = $this->getMetadata($pId, $pDisk);
                break;
        }
        return $r;
    }

    public function findName($pName, $pDisk = null) {
        if ($pName == null || $pName == '') {
            return null;
        }
// ----- Storage disk ------------------------------------------------------------------------------------------
        if ($pDisk == null) {
            if ($this->storageName == null) {
                return null;
            } else {
                $pDisk = $this->storageName;
            }
        } else {
            $this->storageName = $pDisk;
        }
        $r = null;
        switch ($this->storageName) {
            case 'google':

                break;
        }
        return $r;
    }

    public function getTimeStamp($pPath, $pDisk = null) {
// ----- Storage disk ------------------------------------------------------------------------------------------
        if ($pDisk == null) {
            if ($this->storageName == null) {
                return null;
            } else {
                $pDisk = $this->storageName;
            }
        } else {
            $this->storageName = $pDisk;
        }
        $r = null;
        switch ($this->storageName) {
            case 'google':
                Storage::disk($pDisk)->getTimestamp($pPath);
                break;
        }
        return $r;
    }

    public function checkConnectionRoot($pRoot, $pDisk = null) {
        if ($this->err) {
            return $this->showLog();
        }
// ----- Storage disk ------------------------------------------------------------------------------------------
        if ($pDisk == null) {
            if ($this->storageName == null) {
                return null;
            } else {
                $pDisk = $this->storageName;
            }
        } else {
            $this->storageName = $pDisk;
        }
        $r = null;
        switch ($this->storageName) {
            case 'google':
                try {
                    $r = [
                        'code' => 1,
                        'message' => 'google.daketnoi',
                        'data' => Storage::disk('google')->getMetadata($pRoot)
                    ];
                } catch (\Exception $ex) {
                    $log = $this->log[] = [
                        'code' => -1,
                        'message' => 'google.khongtheketnoidenserver'
                    ];
                    $this->err = true;
                    $r = [
                        'code' => -1,
                        'message' => 'google.khongtheketnoidenserver',
                        'data' => null
                    ];
                }
                break;
        }
        return $r;
    }

    public function getMetadata($pPath, $pDisk = null) {
        if ($this->err) {
            return $this->log();
        }
// ----- Storage disk ------------------------------------------------------------------------------------------
        if ($pDisk == null) {
            if ($this->storageName == null) {
                return null;
            } else {
                $pDisk = $this->storageName;
            }
        } else {
            $this->storageName = $pDisk;
        }
        $r = null;
        switch ($this->storageName) {
            case 'google':
                try {
                    $r = Storage::disk('google')->getMetadata($pPath);
                } catch (\Exception $ex) {
                    $this->log[] = [
                        'code' => -1,
                        'message' => 'google.khongtheketnoidenserver'
                    ];
                    $r = -1;
                }
                break;
        }
        return $r;
    }

    /* ===== getSize ===================================================================================================
      | @Param Id (String)
      | @Return array | false
      | ================================================================================================================
     */

    public function getSize($pId, $pDisk = null) {
// ----- Storage disk ------------------------------------------------------------------------------------------
        if ($pDisk == null) {
            if ($this->storageName == null) {
                return null;
            } else {
                $pDisk = $this->storageName;
            }
        } else {
            $this->storageName = $pDisk;
        }
        $r = null;
        switch ($this->storageName) {
            case 'google':
                $r = Storage::disk($this->storageName)->getSize($pId);
                break;
        }
        return $r;
    }

    public function hasDir($pPath) {
        return Storage::disk('google')->hasDir($pPath);
    }

// ===== SEARCH ==============================================
// Search file
    public function searchFile($pKeyword, $pRecusive = null, $pDisk = null) {
// Storage disk ------------------------------------------------------------------------------------------------
        if ($pDisk == null) {
            if ($this->storageName == null) {
                return null;
            } else {
                $pDisk = $this->storageName;
            }
        } else {
            $this->storageName = $pDisk;
        }
// Recusive  ------------------------------------------------------------------------------------------------
        if ($pRecusive == null) {
            if ($this->recursive == null) {
                $this->recursive = false;
            } else {
                $pRecusive = $this->recursive;
            }
        } else {
            $this->recursive = $pRecusive;
        }
        $r = null;
        switch ($this->storageName) {
            case 'google':
                $lst = $this->getListContent('/', $this->recursive, $this->storageName);
                $r = $lst
                        ->where('type', '=', 'file')
                        ->where('filename', '=', $this->getFileNameFormFile($pKeyword))
                        ->where('extension', '=', $this->getFileExtensionByFile($pKeyword));
                break;
        }
        return $r;
    }

// Search thư mục
    public function searchDir($pKeyword, $pRecusive = null, $pDisk = null) {
// Storage disk ------------------------------------------------------------------------------------------------
        if ($pDisk == null) {
            if ($this->storageName == null) {
                return null;
            } else {
                $pDisk = $this->storageName;
            }
        } else {
            $this->storageName = $pDisk;
        }
// Recusive  ------------------------------------------------------------------------------------------------
        if ($pRecusive == null) {
            if ($this->recursive == null) {
                $this->recursive = $pRecusive = false;
            } else {
                $pRecusive = $this->recursive;
            }
        } else {
            $this->recursive = $pRecusive;
        }
        $r = null;
        switch ($this->storageName) {
            case 'google':
                $lst = $this->getListContent('/', $this->recursive, $this->storageName);
                $r = $lst
                        ->where('type', '=', 'dir')
                        ->where('filename', '=', $pKeyword);
                break;
        }
        return $r;
    }

// Seach file & thư mục
    public function search($pKeyword, $pRecusive = null, $pDisk = null) {
// Storage disk ------------------------------------------------------------------------------------------------
        if ($pDisk == null) {
            if ($this->storageName == null) {
                return null;
            } else {
                $pDisk = $this->storageName;
            }
        } else {
            $this->storageName = $pDisk;
        }
// Recusive  ------------------------------------------------------------------------------------------------
        if ($pRecusive == null) {
            if ($this->recursive == null) {
                $this->recursive = false;
            } else {
                $pRecusive = $this->recursive;
            }
        } else {
            $this->recursive = $pRecusive;
        }
        $r = null;
        switch ($this->storageName) {
            case 'google':
                $lst = $this->getListContent('/', $this->recursive, $this->storageName);
                $r = $lst
                        ->where('filename', '=', $this->getFileNameFormFile($pKeyword));
                break;
        }
        return $r;
    }

    public function getDiskUssage($pDisk = null) {
// Storage disk ------------------------------------------------------------------------------------------------
        if ($pDisk == null) {
            if ($this->storageName == null) {
                return null;
            } else {
                $pDisk = $this->storageName;
            }
        } else {
            $this->storageName = $pDisk;
        }
        $size = 0;
        $dir_count = 0;
        $file_count = 0;
        $other_count = 0;
        $items = $this->getListContent('/', true);
        if (count($items) != 0) {
            foreach ($items as $v) {
                if (isset($v['type'])) {
                    switch ($v['type']) {
                        case 'dir':
                            $dir_count++;
                            break;
                        case 'file':
                            $file_count++;
                            break;
                        default:
                            $other_count++;
                            break;
                    }
                }
                $size += (int) $v['size'];
            }
        }
        $this->file_count = $file_count;
        $this->dir_count = $dir_count;
        $this->oth_count = $other_count;
        return $size;
    }

// ===============================================================
// Lấy danh sách tất cả các file và thư mục nằm trong 1 dir
// @Param $pRecusive true | false ( true: lấy sub thư mục con, false chỉ lấy tại thư mục cha)

    public function getListContent($pDir = '/', $pRecusive = null, $pDisk = null) {
// Storage disk ------------------------------------------------------------------------------------------------
        if ($pDisk == null) {
            if ($this->storageName == null) {
                return null;
            } else {
                $pDisk = $this->storageName;
            }
        } else {
            $this->storageName = $pDisk;
        }
// Recusive  ------------------------------------------------------------------------------------------------
        if ($pRecusive == null) {
            if ($this->recursive == null) {
                $this->recursive = false;
            } else {
                $pRecusive = $this->recursive;
            }
        } else {
            $this->recursive = $pRecusive;
        }
        $r = null;
        switch ($this->storageName) {
            case 'google':
                $r = collect(Storage::disk('google')->listContents('/', $this->recursive));
                break;
        }
        return $r;
    }

    public function getFileByName($pFileName = null, $pDisk = null) {
// Storage disk ------------------------------------------------------------------------------------------------
        if ($pDisk == null) {
            if ($this->storageName == null) {
                return null;
            } else {
                $pDisk = $this->storageName;
            }
        } else {
            $this->storageName = $pDisk;
        }
// File name ---------------------------------------------------------------------------------------------------
        if ($pFileName == null) {
            if ($this->file_name == null) {
                return null;
            } else {
                $pFileName = $this->file_name;
            }
        }
        $r = null;
        switch ($this->storageName) {
            case 'google':
                $lst_content = $this->getListContent('/', true);
                $file = $lst_content
                        ->where('type', '=', 'file')
                        ->where('filename', '=', $this->getFileNameFormFile($pFileName))
                        ->where('extension', '=', $this->getFileExtensionByFile($pFileName));
                if (count($file) == 1) {
// Có 1 file duy nhất
                    return $file[1];
                } elseif (count($file) == 0) {
                    return $file;
                } else {
                    return $file;
                }
                break;
        }
        return $r;
    }

// =================================================================================================================
// Chỉ hỗ trợ google
    public function getFile($pFileName = null, $pDisk = null) {
        $res = [];
        // Storage disk ------------------------------------------------------------------------------------------------
        if ($pDisk == null) {
            if ($this->storageName == null) {
                return null;
            } else {
                $pDisk = $this->storageName;
            }
        } else {
            $this->storageName = $pDisk;
        }
        // File name ---------------------------------------------------------------------------------------------------
        if ($pFileName == null) {
            if ($this->file_name == null) {
                return null;
            } else {
                $pFileName = $this->file_name;
            }
        }
        $file = $this->checkFileExists($pFileName, $pDisk);
        if ($file != null) {
            $raw = Storage::disk($pDisk)->get($file['basename']);
            $res['raw'] = $raw;
            $res['mimetype'] = $file['mimetype'];
            return $res;
        } else {
            return null;
        }

//        return response($raw, 200)
//                        ->header('Content-Type', $file['mimetype'])
//                        ->header('Content-Disposition', "attachment; filename='$pFileName'");
    }

    public function checkFileExists($pFileName = null, $pDisk = null) {
// ----- Storage disk ------------------------------------------------------------------------------------------
        if ($pDisk == null) {
            if ($this->storageName == null) {
                return null;
            } else {
                $pDisk = $this->storageName;
            }
        } else {
            $this->storageName = $pDisk;
        }
// ----- File name ---------------------------------------------------------------------------------------------
        if ($pFileName == null) {
            if ($this->file_name == null) {
                return null;
            } else {
                $pFileName = $this->file_name;
            }
        } else {
            $this->file_name = $pFileName;
        }
        switch ($this->storageName) {
            case 'google':
                $PARENT_FOLDER = '';
                if ($this->parent_folder != null) {
                    $PARENT_FOLDER = $this->parent_folder . '/';
                }
                $content = collect(Storage::disk('google')->listContents('/' . $PARENT_FOLDER, true));
                $file = $content
                        ->where('type', '=', 'file')
                        ->where('filename', '=', $this->getFileNameFormFile($this->file_name))
                        ->where('extension', '=', $this->getFileExtensionByFile($this->file_name))
                        ->first();
                $this->google_file_path = $file['path'];
                return $file;
            case 'public':
                return Storage::disk('public')->exists($pFileName);
            default :
                return null;
        }
    }

    // ===== Kiểm tra tệp có tồn tại theo object file google =========================

    public function checkFileExistsByObject($pObject = null, $pDisk = null) {
        // ----- Storage disk ------------------------------------------------------------------------------------------
        if ($pDisk == null) {
            if ($this->storageName == null) {
                return null;
            } else {
                $pDisk = $this->storageName;
            }
        } else {
            $this->storageName = $pDisk;
        }
        if ($pObject == null) {
            return null;
        }
        $content = collect(Storage::disk('google')->listContents('/', true));
        $file = $content
                ->where('type', '=', 'file')
                ->where('filename', '=', $pObject->filename)
                ->where('extension', '=', $pObject->extension)
                ->where('size', '=', $pObject->size)
                ->first();
        return $file;
    }

    public function createFolderIfNotExitst($pDisk, $pDirName) {
        $tmp = $this->checkFolderExists($pDisk, $pDirName, true);
        return @$tmp->path;
    }

    // ===== checkFolderExists =========================================================================================

    public function checkFolderExists($pDisk = null, $pDirName = null, $pAutoCreate = null, $pRecursive = false) {
        // Storage disk ------------------------------------------------------------------------------------------------
        if ($pDisk == null) {
            if ($this->storageName == null) {
                return null;
            } else {
                $pDisk = $this->storageName;
            }
        }
        // Directory name ----------------------------------------------------------------------------------------------
        if ($pDirName == null) {
            if ($this->dir_name == null) {
                return null;
            } else {
                $pDirName = $this->dir_name;
            }
        }
        // Auto create -------------------------------------------------------------------------------------------------
        if ($pAutoCreate == null) {
            if ($this->dir_autocreate == null) {
                $pAutoCreate = false;
                $this->dir_autocreate = false;
            } else {
                $pAutoCreate = $this->dir_autocreate;
            }
        } else {
            $this->dir_autocreate = $pAutoCreate;
        }
        switch ($pDisk) {
            case 'google':
                $content = collect(Storage::disk('google')
                                ->listContents('/', true
                ));
                $dir = $content
                        ->where('type', '=', 'dir')
                        ->where('filename', '=', trim($pDirName, '/'))
                        ->first();
                if ($dir == null) {
                    if ($pAutoCreate == true) {
                        $r = $this->create_directory($pDirName);
                        if ($r) {
                            return $this->checkFolderExists($pDisk, $pDirName);
                        }
                    }
                }
                if ($this->toObject) {
                    $this->google_dirPath = $dir['path'];
                    return (object) $dir;
                } else {
                    return $dir;
                }
                break;
            case 'public':

                break;
        }
    }

    // ===== upload_file ===============================================================================================

    public function upload_file($pDisk = null, $pFileName = null, $pRaw = null, $pDir = null) {
        // Storage disk ------------------------------------------------------------------------------------------------
        if ($pDisk == null) {
            if ($this->storageName == null) {
                return null;
            } else {
                $pDisk = $this->storageName;
            }
        } else {
            $this->storageName = $pDisk;
        }
        // Raw ---------------------------------------------------------------------------------------------------------
        if ($pRaw == null) {
            if ($this->file_raw == null) {
                return null;
            } else {
                $pRaw = $this->file_raw;
            }
        } else {
            $this->file_raw = $pRaw;
        }
        // File name ---------------------------------------------------------------------------------------------------
        if ($pFileName == null) {
            if ($this->file_name == null) {
                return null;
            } else {
                $pFileName = $this->file_name;
            }
        } else {
            $this->file_name = $pFileName;
        }

        if ($pDir == null) {
            if ($this->parent_folder == null) {
                return null;
            } else {
                $pDir = $this->parent_folder;
            }
        } else {
            $this->parent_folder = $pDir;
        }

        if ($this->parent_folder != null) {
            $tmpFileName = $this->parent_folder . '/' . $this->file_name;
        }

        switch ($this->storageName) {
            case 'google':
                if (Storage::cloud()->put($tmpFileName, $pRaw)) {
                    $this->inserted_id = $pFileName;
                    $res = $this->checkFileExists($this->file_name, $pDisk);
                    // Nếu res != null => return dữ liệu file
                    if ($res != null) {
                        $this->google_inserted_id = $this->google_file_path;
                    } else {
                        $res = null;
                    }
                    return $res;
                }
                break;
            case 'public':
                if (Storage::disk('public')->putFileAs($pDir, $pRaw, $pFileName)) {
                    $this->inserted_id = $pFileName;
                    return $pFileName;
                }
                break;
            default:
                return null;
        }
    }

    public function get_file() {
        
    }

    /* ===== DELETE A FILE =============================================================================================
      | @Param: Id | String
      | @Reutrn: Bool
      | ================================================================================================================
     */

    public function delete($pId = null, $pDisk = null) {
// Storage disk ------------------------------------------------------------------------------------------------
        if ($pDisk == null) {
            if ($this->storageName == null) {
                return null;
            } else {
                $pDisk = $this->storageName;
            }
        } else {
            $this->storageName = $pDisk;
        }
        switch ($pDisk) {
            case 'google':
                $r = Storage::disk('google')->delete($pId);
                break;
            default:
                return null;
        }
        return $r;
    }

    /* ===== DELETE DIR ================================================================================================
      | @Param: Id | String
      | @Reutrn: Bool
      | ================================================================================================================
     */

    public function deleteDir($pDisk, $pIdDir) {
// Storage disk ------------------------------------------------------------------------------------------------
        if ($pDisk == null) {
            if ($this->storageName == null) {
                return null;
            } else {
                $pDisk = $this->storageName;
            }
        } else {
            $this->storageName = $pDisk;
        }
        return $this->delete($pDisk, $pIdDir);
    }

// PRIVATE FUNCTION ================================================================================================

    private function getFileNameFormFile($pFileName) {
        $tmp = strpos($pFileName, '.');
        if ($tmp) {
            $tmp = explode('.', $pFileName);
            return $tmp[0];
        }
        return null;
    }

    private function getFileExtensionByFile($pFileName) {
        $tmp = strpos($pFileName, '.');
        if ($tmp) {
            $tmp = explode('.', $pFileName);
            return end($tmp);
        }
        return null;
    }

}
