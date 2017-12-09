<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Functions;

trait AdminFunction {

    // =================================================================================================================
    // ===== merge_object =====
    // Created By Bình Cao
    // 21-08-2017 15:17:00 PM
    public function bcore_merge_object($pObject1, $pObject2) {
        if (!is_object($pObject1) && !is_object($pObject2))
            return null;
        // Duyệt tất cả các [Column] của object 1 gán cho object 2
        foreach ($pObject2->toArray() as $k => $v) {
            $pObject1->{$k} = $v;
        }
        return $pObject1;
    }

    // =================================================================================================================
    // ===== bcore_ListPhotoGroupByType =====
    // Created By Bình Cao
    // 25-08-2017 08:28:00 AM
    // Input: List photo from database
    // Output: List photo with key group by obj_type
    public function bcore_ListPhotoGroupByType($pArray) {
        if (is_array($pArray) && $pArray != null)
            return null;
        $res = [];
        foreach ($pArray as $k => $v) {
            if (isset($v->obj_type)) {
                $res[$v->obj_type][] = $v;
            }
        }
        return $res;
    }

    public function bcore_ListPhotosGroupByType() {
        if (is_array($pArray) && $pArray != null)
            return null;
        $res = [];
        foreach ($pArray as $k => $v) {
            if (isset($v->obj_type)) {
                $res[$v->obj_type][$v->obj_id][] = $v;
            }
        }
        return $res;
    }

    // ===== bcore_ListPhotoGroupByObjectId ============================================================================
    // Created By Bình Cao
    // 01-09-2017 08:28:00 AM
    // Input: List photo from database
    // Output: List photo with key group by obj_id

    public function bcore_ListPhotoGroupByObjectId($pArray) {
        if (is_array($pArray) && $pArray != null)
            return null;
        $res = [];
        foreach ($pArray as $k => $v) {
            if (isset($v->obj_id) && isset($v->obj_type)) {
                $res[$v->obj_type][$v->obj_type][] = $v;
            }
        }
        return $res;
    }

    // =================================================================================================================
}
