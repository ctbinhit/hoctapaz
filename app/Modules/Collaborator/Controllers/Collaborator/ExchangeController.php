<?php

namespace App\Modules\Collaborator\Controllers\Collaborator;

use Illuminate\Http\Request;
use App\Bcore\PackageServicePI;
use Illuminate\Support\Facades\DB;
use App\Models\UserTransactionModel;
use Illuminate\Support\Facades\Session;
use App\Modules\OnlineCourse\Models\ExamUserModel;
use App\Modules\OnlineCourse\Models\ExamRegisteredModel;

class ExchangeController extends PackageServicePI {

    function __construct() {
        parent::__construct();
    }

    public function get_index() {
        $EUMS = $this->get_eum();

        return view('Collaborator::Collaborator/Exchange/index', [
            'items' => $EUMS->paginate(5),
            'eum_total' => $this->sum_price($EUMS)
        ]);
    }

    public function get_transactions() {
        $UserTransactions = DB::table('users_transactions')->where([
                    ['id_user', $this->current_user->id], ['deleted_at', null]
                ])
                ->whereIn('type', ['ycn', 'ycr'])
                ->orderBy('created_at', 'DESC');



        return view('Collaborator::Collaborator/Transactions/transactions', [
            'items' => $UserTransactions->paginate(5),
        ]);
    }

    public function get_rf() {
        $TotalAmount = $this->sum_amount();


        return view('Collaborator::Collaborator/Transactions/form_request', [
            'sodukhadung' => $this->sum_price($this->get_eum()) - $TotalAmount
        ]);
    }

    public function post_rf(Request $request) {
        $SoDuKhaDung = $this->sum_price($this->get_eum()) - $this->sum_amount();
        if ($request->input('amount') > $SoDuKhaDung) {
            Session::flash('html_callback', [
                'type' => 'warning',
                'message' => 'Số lượng rút cao hơn hạn mức cho phép!, số lượng tối đa có thể rút là ' . number_format($SoDuKhaDung, 0) . ' VNĐ'
            ]);
            return back()->withInput();
        }

        $UT = (new UserTransactionModel());
        $UT->type = $request->input('request_type');
        $UT->state = 0;
        $UT->amount = $request->input('amount');
        $UT->note = $request->input('note');
        $UT->id_user = $this->current_user->id;
        $UT->save();
        Session::flash('html_callback', [
            'type' => 'success',
            'message' => 'Đơn yêu cầu của bạn đã được gửi đi thành công, chúng tôi sẽ xử lý trong thời gian sớm nhất. Thân!'
        ]);
        redirectArea:
        return redirect()->route('mdle_pi_collaborator_rf');
    }

    public function ajax(Request $request) {
        $data = [];
        $act = $request->input('act');
        switch ($act) {
            case 'delete':
                $r = $this->delete_rf($request->input('id'));
                $data = ['state' => $r[0], 'message' => $r[1], 'type' => $r[2]];
                break;
        }
        return response()->json($data);
    }

    private function delete_rf($id) {
        $UT = UserTransactionModel::find((int) $id);
        if ($UT->state == 1)
            return [false, 'Đơn yêu cầu này đã được duyệt, không thể xóa.', 'warning'];
        if ($UT == null)
            return [false, 'Đơn yêu cầu không tồn tại, không thể xóa.', 'warning'];
        $UT->deleted_at = \Carbon\Carbon::now();
        return $UT->save() ? [true, 'Xóa đơn thành công', 'success'] : [false, 'Xóa không thành công, vui lòng thử lại sau.', 'danger'];
    }

    // PRIVATE FUNCTIONS
    private function sum_amount() {
        $Total = DB::table('users_transactions')->where([
                    ['id_user', $this->current_user->id], ['type', 'ycr'], ['deleted_at', null]
                ])->select(DB::raw('SUM(amount) as total'))->first();
        return $Total != null ? $Total->total : 0;
    }

    private function get_eum() {
        return DB::table('m1_exam_user')
                        ->join('users', 'm1_exam_user.id_user', '=', 'users.id')
                        ->join('m1_exam_registered', 'm1_exam_user.erm_id', '=', 'm1_exam_registered.id')
                        ->where([
                            ['m1_exam_registered.id_user', $this->current_user->id]
                        ])
                        ->select([
                            'm1_exam_user.id', 'm1_exam_user.time_in', 'm1_exam_user.time_out', 'm1_exam_user.score',
                            'm1_exam_user.erm_price', 'm1_exam_user.created_at', 'm1_exam_user.code',
                            'm1_exam_user.time_end',
                            'm1_exam_registered.time',
                            'users.fullname as user_fullname', 'users.email as user_email'
                        ])
                        ->groupBy('m1_exam_user.id')
                        ->orderBy('m1_exam_user.id', 'DESC');
    }

    private function sum_price($Models) {
        $TMP_MODELS = $Models;
        if (count($TMP_MODELS->get()) == 0) {
            return 0;
        }
        $SUM = 0;
        foreach ($TMP_MODELS->get() as $v) {
            $SUM += $v->erm_price;
        }
        return $SUM;
    }

}
