
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
            <h3><i class="fa fa-gear"></i> Hệ thống <small>(Dành cho nhà phát triển)</small></h3>
        </div>
    </div>
    <div class="clearfix"></div>
    
    <div class="alert alert-warning">
        <strong>Lưu ý!</strong>
        <p>Đây là trang dành cho nhà phát triển, việc tự ý thay đổi nội dung/dữ liệu trong trang này có thể làm trang web ngưng hoạt động.</p>
    </div>
    
    <div class="x_panel">
        <div class="x_content">
            <a href="{{route('admin_index')}}" class="btn btn-app"><i class="fa fa-dashboard"></i> Dashboard</a>
            <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>
            <a href="{{route('mdle_userpermission_sc_index')}}" class="btn btn-app"><i class="fa fa-puzzle-piece"></i> Controllers</a>
<!--            <a href="{{route('mdle_userpermission_key')}}" class="btn btn-app"><i class="fa fa-key"></i> Quản lý khóa</a>
            <a href="{{route('mdle_userpermission_key_group')}}" class="btn btn-app"><i class="fa fa-bars"></i> Nhóm chức năng</a>-->
            <a href="{{route('mdle_ugp_index')}}" class="btn btn-app"><i class="fa fa-users"></i> User groups</a>
        </div>
    </div>
</div>
@endsection