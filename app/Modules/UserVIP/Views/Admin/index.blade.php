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
            <h3>Quản lý User VIP</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="x_panel">
        <div class="x_content">
            <a href="{{route('admin_index')}}" class="btn btn-app"><i class="fa fa-dashboard"></i> Dashboard</a>
            <a href="{{route('mdle_uservip_add')}}" class="btn btn-app"><i class="fa fa-plus"></i> Thêm VIP</a>
            <a href="{{route('mdle_uservip_index')}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>

        </div>
    </div>

    <div class="x_panel">
        <div class="x_title"><h2>Danh sách VIP</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="alert alert-info">
                <p><strong>Lưu ý:</strong> Chỉ có thể xóa vip khi đã chuyển hết user từ vip muốn xóa sang vip khác.</p>
            </div>
            <table class="table table-bordered" >

                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Chiết khấu</th>
                        <th>Điều kiện</th>
                        <th><i class="fa fa-users"></i></th>
                        <th>Ngày tạo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>

                <tbody>
                    @if(count($items)!=0)

                    @foreach($items as $k=>$v)
                    <tr>
                        <td>{{$k+1}}</td>
                        <td>{{$v->name}}</td>
                        <td>{{$v->discount}}%</td>
                        <td>nạp > {{number_format($v->sum,0)}} VNĐ</td>
                        <td>0</td>
                        <td>{{$v->created_at}}</td>
                        <td>
                            <a href="{{route('mdle_uservip_edit',$v->id)}}" class="btn btn-default"><i class="fa fa-edit"></i></a>
                        </td>
                    </tr>
                    @endforeach

                    @endif
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="99">

                        </td>
                    </tr>
                </tfoot>

            </table>

        </div>
    </div>

</div>
@endsection