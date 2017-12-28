<?php

namespace App\Modules\Collaborator\Controllers\Admin;

use Illuminate\Http\Request;
use App\Bcore\PackageServiceAD;
use Illuminate\Support\Facades\DB;
use App\Models\UserTransactionModel;
use Illuminate\Support\Facades\Session;

class ExchangeController extends PackageServiceAD {

    private $filter_data = [
        'strict' => [
            'filterSortBy' => ['created_at', 'id', 'amount', 'updated_at']
        ],
        'request' => [
            'filterType' => null,
            'filterState' => null,
            'filterSortBy' => null,
            'filterSortVal' => null
        ],
        'filterType' => ['Tất cả' => -1, 'Yêu cầu rút' => 'ycr', 'Yêu cầu nạp' => 'ycn'],
        'filterState' => ['Tất cả' => -1, 'Success' => 1, 'Pending' => 0],
        'filterSortBy' => ['Ngày đăng' => 'created_at'],
        'filterSortVal' => ['Mới nhất | Giảm dần (desc)' => 'desc', 'Cũ nhất | tăng dần (asc)' => 'asc']
    ];

    function __construct() {
        parent::__construct();
    }

    public function get_index(Request $request) {
        $this->set_request($request);
        $UT = DB::table('users_transactions')
                ->join('users', 'users_transactions.id_user', '=', 'users.id')
                ->where([
                    ['users_transactions.type', '=', 'ycr'], ['users_transactions.deleted_at', null]
                ])
                ->select([
            'users_transactions.amount', 'users_transactions.created_at', 'users_transactions.id',
            'users_transactions.state', 'users_transactions.note',
            'users.fullname as user_fullname', 'users.email as user_email'
        ]);
        if ($request->has('filterType') && $request->input('filterType') != -1) {
            $UT->where('users_transactions.type', $request->input('filterType'));
        }
        if ($request->has('filterState') && $request->input('filterState') != -1) {
            $UT->where('users_transactions.state', $request->input('filterState'));
        }
        if ($request->has('filterSortVal') && $request->input('filterSortVal') != 'all') {
            $sortBy = $request->has('filterSortBy') ? $request->input('filterSortBy') : 'id';
            if (!in_array($sortBy, $this->filter_data['strict']['filterSortBy']))
                $sortBy = 'id';
            $UT->orderBy($sortBy, $request->input('filterSortVal'));
        }

        $items = $UT->paginate(10);
        return view('Collaborator::Admin/Exchange/index', [
            'items' => $items,
            'items_links' => $items->appends($this->filter_data['request'])->links(),
            'stateList' => $this->get_stateList(),
            'filter_data' => $this->filter_data
        ]);
    }

    public function ajax(Request $request) {
        $act = $request->input('act');
        switch ($act) {
            case 'cs': //Change state
                $r = $this->change_state($request->input('id'), $request->input('state'));
                $data = ['state' => $r[0], 'message' => $r[1], 'type' => $r[2]];
                break;
        }
        return response()->json($data);
    }

    private function change_state($id, $state) {
        $UT = UserTransactionModel::find((int) $id);
        $UT->updated_by = $this->current_admin->id;
        $UT->state = (int) $state;
        return $UT->save() ? [true, 'Thay đổi trạng thái thành công', 'success'] : [false, 'Thay đổi trạng thái không thành công, vui lòng thử lại sau.', 'danger'];
    }

    private function get_stateList() {
        return [
            ['Chờ duyệt', 0], ['Đã chuyển tiền', 1], ['Thiếu thông tin', 2]
        ];
    }

    // Search

    private function    set_request($request) {
        $this->filter_data['request']['filterType'] = $request->input('filterType');
        $this->filter_data['request']['filterState'] = $request->input('filterState');
        $this->filter_data['request']['filterSortBy'] = $request->input('filterSortBy');
        $this->filter_data['request']['filterSortVal'] = $request->input('filterSortVal');
    }

}
