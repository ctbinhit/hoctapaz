<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use AjaxModel,
    CategoryModel;
use Illuminate\Support\Facades\DB;
use App\Bcore\System\AjaxResponse;

class AjaxController extends AdminController {

    public function ajax_updateDisplay(Request $request) {
        if ($request->isMethod('post')) {
            $AjaxModel = new AjaxModel();
            return response()->json([
                        'status' => true,
                        'result' => $AjaxModel->db_update_display($request->input('table'), $request->input('id'), $request->input('field'), $request->input('value') == 'true' ? 1 : 0),
            ]);
        }
        // Nếu phương thức không đúng sẽ trở về trang chủ admin
        return redirect()->route('admin_index');
    }

    // ajax_jqueryBcoreButton ==========================================================================================
    // @Param Request

    public function ajax_jqueryBcoreButton(Request $request) {
        if ($request->isMethod('post')) {
            $object['table'] = trim($request->input('tbl'));
            $object['action'] = trim($request->input('action'));
            $object['id'] = trim($request->input('id'));
            $AjaxModel = new AjaxModel();
            $r = false;
            switch ($object['action']) {
                // Update boolean - Cập nhật hiển thị, nổi bật, khuyến mãi...
                case 'ub':
                    if ($request->input('field') != null) {
                        $r = $AjaxModel->db_update_boolean($object['table'], $object['id'], $request->input('field'));
                    } else {
                        $r = false;
                    }
                    break;
                // Update field - Cập nhật field ordinal_number...
                case 'uf':
                    if ($request->input('field') != null) {
                        $r = $AjaxModel->db_update_field($object['table'], $object['id'], $request->input('field'), $request->input('field_val'));
                    } else {
                        $r = false;
                    }
                    break;
                case 'rs':
                    $object['items'] = $request->input('items');
                    if ($request->has('items')) {
                        $res = true;
                        foreach ($object['items'] as $k => $v) {
                            $r[] = DB::table($object['table'])->where('id', '=', trim($v))->update(['deleted' => \Carbon\Carbon::now()->toDateTimeString()]);
                            if (!$r) {
                                $res = false;
                            }
                        }
                        $r = $res;
                    } else {
                        $r = false;
                    }
                    break;
                case 'recs':
                    $object['items'] = $request->input('items');
                    if ($request->has('items')) {
                        $res = true;
                        foreach ($object['items'] as $k => $v) {
                            $r[] = DB::table($object['table'])->where('id', '=', trim($v))->update(['deleted' => null]);
                            if (!$r) {
                                $res = false;
                            }
                        }
                        $r = $res;
                    } else {
                        $r = false;
                    }
                    break;
                case 'reca':
                    $r = DB::table($object['table'])->where('id', '=', $object['id'])->update(['deleted' => null]);
                    break;
                case 'remove':
                    $r = DB::table($object['table'])->where('id', '=', $object['id'])->update(['deleted' => \Carbon\Carbon::now()->toDateTimeString()]);
                    break;
                default:
            }

            return response()->json([
                        'status' => true,
                        'result' => $r
            ]);
        }
        // Nếu phương thức không đúng sẽ trở về trang chủ admin
        //return redirect()->route('admin_index');
    }

    public function ajax_checkNameMeta(Request $request) {

        $RESPONSE = (object) [
                    'status' => true,
                    'result' => null,
                    'message' => null
        ];
        $REQUEST_DATA = $request->input('data');
        $table = $REQUEST_DATA['tbl'];
        $name_meta = $REQUEST_DATA['val'];
        if ($name_meta == null) {
            $RESPONSE->status = false;
            $RESPONSE->message = 'name meta không được để trống!';
            goto responseArea;
        }
        $r = DB::table($table)->where([
                    ['name_meta', '=', $name_meta]
                ])->first();
        if ($r == null) {
            $RESPONSE->status = true;
            $RESPONSE->result = true;
        } else {
            $RESPONSE->status = true;
            $RESPONSE->result = false;
        }

        responseArea:
        return response()->json($RESPONSE);
    }

    public function ajax_loadCategoriesByParentId(Request $request) {
        $RESPONSE = (object) [
                    'status' => true,
                    'result' => null,
                    'data' => null
        ];

        $REQUEST_DATA = $request->input('data');

        $type = $REQUEST_DATA['type'];
        $lang = $REQUEST_DATA['lang'];
        $id = $REQUEST_DATA['id'];
        if ($type == null || $lang == null || $id == null) {
            $RESPONSE->status = false;
            goto responseArea;
        }
        try {
            $DanhMuc = new \App\Bcore\Services\CategoryService();
            $LSTDanhMuc = $DanhMuc->set_type($type)->set_lang($lang)->get_categoriesByParentId($id);
            $RESPONSE->data = $LSTDanhMuc;
            $RESPONSE->status = true;
        } catch (\Exception $ex) {
            $RESPONSE->status = false;
        }
        responseArea:
        return response()->json($RESPONSE);
    }

    public function ajax_loadCategoryByCateLevel(Request $request) {
        $RESPONSE = (object) [
                    'status' => true,
                    'result' => null,
                    'data' => null
        ];
        if (!is_integer($pLevel)) {
            $RESPONSE->status = false;
            goto resultArea;
        }
        try {
            $type = $request->input('type');
            $lang = $request->input('lang');
            $level = $request->input('level');
            $DanhMuc = new \App\Bcore\Services\CategoryService();
            $LSTDanhMuc = $DanhMuc->set_type($type)->set_lang($lang)->get_categoriesByLv($level);
            $RESPONSE->data = $LSTDanhMuc;
        } catch (\Exception $ex) {
            $RESPONSE->status = false;
        }
        resultArea:
        return response()->json($RESPONSE);
    }

    public function ajax_center(Request $request) {

        $RESPONSE = (object) [
                    'status' => true,
                    'message' => null,
                    'type' => 'warning'
        ];

        if (!$request->has('method')) {
            $RESPONSE->status = false;
        }

        $method_name = trim($request->input('method'));

        if (method_exists(__CLASS__, $method_name)) {
            return $this->{$method_name}($request);
        } else {
            $RESPONSE->message = 'Method ' . $method_name . ' không tồn tại!';
            $RESPONSE->status = false;
        }
        resultArea:
        return response()->json($RESPONSE);
    }

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
