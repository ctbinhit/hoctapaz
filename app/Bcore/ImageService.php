<?php

namespace App\Bcore;

use Intervention\Image\Image;
use Config,
    Crypt;
use Session;
use PhotoModel;

class ImageService extends Bcore {

    function __construct() {
        
    }

    /* ============================== get_photoByModel =================================================================
      | Input: 1 Model (đơn)
      | Output: 1 Model + field photo
      | ------------------------------------------ EX ------------------------------------------------------------------
      | Input: Input: Article [ name => 'Bình Cao', email => 'ctbinhit']
      | Output: Article [ name => 'Bình Cao', email => 'ctbinhit', photo => image(object)]
      | ----------------------------------------------------------------------------------------------------------------
     */

    public function get_photoByModel($Model) {
        if (!is_object((object) $Model)) {
            return null;
        }
        if (!isset($Model->id) && !isset($Model->tbl)) {
            return null;
        }
        $Photo = PhotoModel::where([
                    ['obj_table', '=', $Model->tbl],
                    ['obj_type', '=', 'photo'],
                    ['obj_id', '=', $Model->id],
                    ['deleted', '=', null]
                ])
                ->orderBy('id', 'DESC')
                ->first();
        if (count($Photo) == 0) {
            $Model->photo = null;
        } else {
            $Model->photo = $Photo;
        }
        return $Model;
    }

    /* ============================== get_photoByModels =================================================================
      | Input: Model(s)
      | Output: Model(s) + field photo
      | ------------------------------------------ EX ------------------------------------------------------------------
      | Input:
      | Output:
      | ----------------------------------------------------------------------------------------------------------------
     */

    public function get_photoByModels($Models) {
        if (!is_object((object) $Models)) {
            return null;
        }
        if (count($Models) == 0) {
            return null;
        }
        $ListId = $this->get_ArrayFieldByModels('id', $Models);
        $Photos = PhotoModel::where([
                    ['obj_table', '=', $Models[0]->tbl],
                    ['obj_type', '=', 'photo'],
                    ['deleted', '=', null]
                ])
                ->whereIn('obj_id', $ListId)
                ->orderBy('id', 'DESC')
                ->get();
     
        $Photos_ = $this->group_fieldFromModels('obj_id', (object) $Photos);
        foreach ($Models as $v) {
            if (isset($Photos_[$v->id])) {
                $v->photo = $Photos_[$v->id];
            } else {
                $v->photo = null;
            }
        }
        return $Models;
    }

    /* ============================== convertUrlImageFromModels ========================================================
      | Input: Model(s)
      | Output: Model(s) + field photo
      | ------------------------------------------ EX ------------------------------------------------------------------
      | Input: danh sách bài viết đã có trường image (object)
      | Output: Object hình ảnh => URL
      | ----------------------------------------------------------------------------------------------------------------
     */

    public function convertUrlImageFromModels($pImageType, $pModels, $x = 50, $y = 50) {
        if ($pImageType == '') {
            return null;
        }
        if (!is_object($pModels)) {
            return null;
        }
        if (count($pModels) == 0) {
            return null;
        }
        foreach ($pModels as $k => $v) {
            // Chỉ có 1 object
            if (is_object($v->{$pImageType})) {
                if (isset($v->{$pImageType})) {
                    if ($v->{$pImageType} == null) {
                        $v->{$pImageType} = route('thumb', [404, 404, $x != null ? $x : 40, $y != null ? $y : 40]);
                    } else {
                        //$v->{$pImageType} = route('thumb', [$v->{$pImageType}->dir_name, $pImageType, $v->{$pImageType}->url, $x != null ? $x : 40, $y != null ? $y : 40]);
                        $v->{$pImageType} = route('thumbnail', [Crypt::encryptString($v->{$pImageType}->dir_name . '/' . $pImageType . '/' . $v->{$pImageType}->url), 40, 40]);
                    }
                }
            } elseif (is_array($v->{$pImageType})) {
                
            } elseif ($v->{$pImageType} == null) {
                $v->{$pImageType} = route('thumb', [404, 404, $x != null ? $x : 40, $y != null ? $y : 40]);
            }
        }
        return $pModels;
    }

    public function convertUrlImageFromModel($pImageType, $pModel, $x = null, $y = null) {
        if ($pImageType == '') {
            return null;
        }
        if (!is_object($pModel)) {
            return null;
        }
        if (!isset($pModel->{$pImageType})) {
            return null;
        }
        if ($pModel->{$pImageType} == null) {
            $pModel->{$pImageType} = route('thumb', [404, 404, $x != null ? $x : 40, $y != null ? $y : 40]);
        } else {
            $pModel->{$pImageType} = route('thumbnail', [Crypt::encryptString($pModel->{$pImageType}->dir_name . '/' . $pImageType .
                        '/' . $pModel->{$pImageType}->url), $x != null ? $x : 40, $y != null ? $y : 40]);
        }
        return $pModel;
    }

//    public function convertUrlImageFromModel($pArray, $x = null, $y = null) {
//        if (!is_array($pArray)) {
//            return -1;
//        }
//        if (count($pArray) <= 0) {
//            return -1;
//        }
//        $r = [];
//        foreach ($pArray as $k => $v) {
//            if ($v == null) {
//                $r[$k] = route('thumb', [404, 404, $x != null ? $x : 40, $y != null ? $y : 40]);
//            } else {
//                $r[$k] = route('thumb', [$v->dir_name, $v->url, $x != null ? $x : 40, $y != null ? $y : 40]);
//            }
//        }
//        return $r;
//    }

    /* =================================================================================================================
      | Input: Array Pic, ArrayId, with, heigh
      | Output: Array photo
      | array [
      |         id_exam: Model photo,
      |
      |       ]
      | ================================================================================================================
     */

    public function convertModelsToURL($pArray, $pArrayIdDb = null, $x = null, $y = null) {
        if (!is_array($pArray)) {
            return -1;
        }
        if (count($pArray) <= 0) {
            return -1;
        }
        $r = [];
        foreach ($pArray as $k => $v) {
            if ($v == null) {
                $r[$k] = route('thumb', [404, 404, $x != null ? $x : 40, $y != null ? $y : 40]);
            } else {
                $r[$k] = route('thumb', [$v->dir_name, $v->url, $x != null ? $x : 40, $y != null ? $y : 40]);
            }
        }
        foreach ($pArrayIdDb as $k => $v) {
            if (!isset($r[$v])) {
                $r[$v] = route('thumb', [404, 404, $x != null ? $x : 40, $y != null ? $y : 40]);
            }
        }
        return $r;
    }

    public function convertModelToURL($pModel, $x = null, $y = null) {
        if ($pModel == null) {
            return route('thumb', [404, 404, $x != null ? $x : 40, $y != null ? $y : 40]);
        }
        return route('thumb', [$pModel->dir_name, $pModel->url, $x != null ? $x : 40, $y != null ? $y : 40]);
    }

    public function EncryptURL($pPath) {
        return \Illuminate\Support\Facades\Crypt::encryptString($pPath);
    }

}
