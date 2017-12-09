<?php

namespace App\Http\Controllers\pi;

use Illuminate\Http\Request;
use App\Http\Controllers\ProfessorController;
use AjaxModel,
    CategoryModel;
use Illuminate\Support\Facades\DB;
use App\Bcore\System\AjaxResponse;

class AjaxController extends ProfessorController {

    public function ajax_request(Request $request) {
        $act = $request->input('act');

        switch ($act) {
            case 'uf':
                return $this->uf($request);
            case 'us':
                return $this->us($request);
            default:
                return response()->json(AjaxResponse::actionUndefined());
        }
    }

    public function us($request) {
        $JsonResponse = AjaxResponse::actionUndefined();
        try {
            $table = $request->input('tbl');
            $id = $request->input('id');
            $fieldName = $request->input('fieldName');
            $fieldVal = $request->input('fieldVal');
            $updated = DB::table($table)
                    ->where('id', $id)
                    ->update([
                "$fieldName" => $fieldVal == 'true' ? true : false
            ]);
            if ($updated) {
                $JsonResponse = AjaxResponse::success();
            } else {
                $JsonResponse = AjaxResponse::fail($request->all());
            }
        } catch (\Exception $ex) {
            // Write log
            $JsonResponse = AjaxResponse::has_error($ex, $request->all());
        }
        responseArea:
        return response()->json($JsonResponse);
    }

    public function uf($request) {
        $JsonResponse = AjaxResponse::actionUndefined();
        try {
            $table = $request->input('tbl');
            $id = $request->input('id');
            $fieldName = $request->input('fieldName');
            $fieldVal = $request->input('fieldVal');
            $updated = DB::table($table)
                    ->where('id', $id)
                    ->update([
                "$fieldName" => $this->parseDataType($fieldName, $fieldVal)
            ]);
            if ($updated) {
                $JsonResponse = AjaxResponse::success();
            } else {
                $JsonResponse = AjaxResponse::fail($request->all());
            }
        } catch (\Exception $ex) {
            // Write log
            $JsonResponse = AjaxResponse::has_error($ex, $request->all());
        }
        responseArea:
        return response()->json($JsonResponse);
    }

    private function parseDataType($field_name, $field_val) {
        try {
            switch ($field_name) {
                case 'ordinal_number': return (int) $field_val;
                case 'display' : return (boolean) $field_val;
                case 'highlight' : return (boolean) $field_val;
                default: return (string) $field_val;
            }
        } catch (\Exception $ex) {
            // Không thể parse
            return $field_val;
        }
    }

}
