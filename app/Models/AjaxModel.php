<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AjaxModel extends Model {

    public function db_update_display($pTable, $pId, $pField, $pVal) {
//        $r = LanguageModel::find(1)->update([$pField=>$pVal]);
        $r = DB::table($pTable)
                ->where('id', $pId)
                ->update([
            $pField => $pVal
        ]);
        return $r;
    }

    public function db_update_field($pTable, $pId, $pField, $pVal = null) {
        if ($pVal != null) {
            $Model = DB::table($pTable)->find($pId);
            if ($Model->{$pField} == $pVal) {
                return true;
            }
            $r = DB::table($pTable)
                    ->where('id', $pId)
                    ->update([
                $pField => $pVal
            ]);
        } else {
            return false;
        }
        return $r;
    }

    public function db_update_boolean($pTable, $pId, $pField, $pVal = null) {
        if ($pVal != null) {
            $r = DB::table($pTable)
                    ->where('id', $pId)
                    ->update([
                $pField => $pVal
            ]);
        } else {
            $item = DB::table($pTable)->where('id', $pId)->first();
            if ($item != null) {
                $r = DB::table($pTable)
                        ->where('id', $pId)
                        ->update([
                    $pField => !$item->$pField
                ]);
            } else {
                $r = $item;
            }
        }
        return $r;
    }

}
