
@extends('admin.layouts.master')
@push('stylesheet')
<style>
    table th,td {
        text-align: center;
    }
</style>
@endpush
@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Set quyền user</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="x_panel">
        <div class="x_content">
            <ul>
                <li>Họ và tên: {{$user_info->fullname}}</li>
                <li>Ngày tạo: {{$user_info->created_at}}</li>
                <li>Role level:
                    @if($user_info->role==9999)
                    <i class="text-success">Super Admin</i>
                    @else
                    <i class="text-info">User</i>
                    @endif
                </li>
                <li>Email: {{$user_info->email}}</li>
                <li>SĐT: {{$user_info->phone}}</li>
                <li>Số dư TK: {{number_format($user_info->coin,0)}} VNĐ</li>
            </ul>
        </div>
    </div>
    <div class="x_panel">
        <div class="x_content">
            <form class="form form-horizontal" action="" method="POST">
                <div class="form-group">
                    <label class="control-label col-md-2">Quyền hiện tại</label>
                    <div class="col-md-10">

                    </div>
                </div>
            </form>

        </div>
    </div>
    <div class="x_panel">
        <div class="x_content">
            <form class="form form-horizontal" action="" method="POST">
                <div class="form-group">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên quyền</th>
                                    <th>Xem</th>
                                    <th>Thêm</th>
                                    <th>Xóa</th>
                                    <th>Sửa</th>
                                    <th>Sửa trạng thái</th>
                                    <th>Khôi phục</th>
                                    <th>Sync</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($lst_permission as $k=>$v)
                                <tr>
                                    <td>{{$k+1}}</td>
                                    <td>{{$v->name}}</td>
                                    <td>
                                        <input type="checkbox" name="per_view" class="jquery-icheck" checked/>
                                    </td>
                                    <td>
                                        <input type="checkbox" name="per_add" class="jquery-icheck"/>
                                    </td>
                                    <td>
                                        <input type="checkbox" name="per_del" class="jquery-icheck"/>
                                    </td>
                                    <td>
                                        <input type="checkbox" name="per_edit" class="jquery-icheck"/>
                                    </td>
                                    <td>
                                        <input type="checkbox" name="per_edit_status" class="jquery-icheck"/>
                                    </td>
                                    <td>
                                        <input type="checkbox" name="per_edit_recycle" class="jquery-icheck"/>
                                    </td>
                                    <td>
                                        <input type="checkbox" name="per_edit_sync" class="jquery-icheck"/>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
