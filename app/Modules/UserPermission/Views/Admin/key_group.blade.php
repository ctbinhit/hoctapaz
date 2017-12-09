
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
            <h3>Quản lý nhóm keys</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="x_panel">
        <div class="x_content">
            <a href="{{route('mdle_userpermission_index')}}" class="btn btn-app"><i class="fa fa-arrow-left"></i> Quay lại</a>
        </div>
    </div>

    <div class="x_panel">
        <div class="x_title">
            <h2>Keys <small class="text-danger">Việc sửa đổi các khóa này có thể làm website bị lỗi, nên để mặc định của nhà cung cấp dịch vụ, mọi thắc mắc vui lòng liên hệ <strong>kythuat.toannang@gmail.com.vn</strong> để được hỗ trợ.</small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <table class="table table-striped">

                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên Controller</th>
                        <th>Tên hiển thị</th>
                        <th>Hành động</th>
                        <th>Quyền mặc định user</th>
                        <th>Tham số</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($items as $k=>$v)
                    <tr>
                        <td>{{$k+1}}</td>
                        <td>{{$v->controller_name}}</td>
                        <td>{{$v->name}}</td>
                        <td></td>
                        <td></td>
                        <td>
                            <a href="" class="btn btn-default"><i class="fa fa-edit"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>
</div>
@endsection