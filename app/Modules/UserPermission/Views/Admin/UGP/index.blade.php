
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
            <h3><i class="fa fa-users"></i> User Groups</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="x_panel">
        <div class="x_content">
            <a href="{{route('admin_index')}}" class="btn btn-app"><i class="fa fa-dashboard"></i> Dashboard</a>
            <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>
        </div>
    </div>
    
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-list"></i> Danh sách nhóm user</h2><div class="clearfix"></div>
        </div>
        <div class="x_content">
            <table class="table table-bordered" >
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th><i class="fa fa-user"></i></th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($items as $k=>$v)
                    <tr>
                        <td>{{$k+1}}</td>
                        <td>{{$v->name}}</td>
                        <td></td>
                        <td></td>
                        <td>
                            <a href="{{route('mdle_ugp_pers',$v->id)}}" class="btn btn-default btn-xs"><i class="fa fa-edit"></i> Permissions</a>
                            <a href="#" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> Remove</a>
                        </td>
                    </tr>
                    @endforeach
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
