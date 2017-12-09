
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
            <h3>Quản lý services</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="x_panel">
        <div class="x_content">
            <a href="{{route('admin_system_index')}}" class="btn btn-app"><i class="fa fa-arrow-left"></i> Quay lại</a>
            <a href="{{route('admin_system_service_add')}}" class="btn btn-app"><i class="fa fa-puzzle-piece"></i> Tạo mới</a>
        </div>
    </div>

    <div class="x_panel">
        <div class="x_content">
            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên service</th>
                        <th>Path</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($items as $k=>$v)
                    <tr>
                        <td>{{$k+1}}</td>
                        <td>{{$v->service_name}}</td>
                        <td>{{$v->service_path}}</td>
                        <td>
                            @if($v->active)
                            <p class="text-success">Đã kích hoạt</p>
                            @else
                            <p class="text-danger">Chưa kích hoạt</p>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>


@endsection
