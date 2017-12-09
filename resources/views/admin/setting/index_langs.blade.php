@extends('admin.layouts.master')
@section('content')

<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-gear faa-spin animated"></i> {{__('label.caidat') }}</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-edit"></i> Thông tin chung</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <a href="{{route('admin_index')}}" class="btn btn-app"><i class="fa fa-dashboard"></i> Dashboard</a>
                <a href="{{route('admin_setting_info')}}" class="btn btn-app"><i class="fa fa-edit"></i> Thông tin</a>
                <a href="{{route('admin_setting_social')}}" class="btn btn-app"><i class="fa fa-share-alt"></i> Mạng xã hội</a>
                <a href="{{route('mdle_admin_map')}}" class="btn btn-app"><i class="fa fa-map-marker faa-float animated"></i> Vị trí & bản đồ</a>
            </div>
        </div>
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-gear"></i> Hệ thống</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <a href="{{route('admin_setting_language')}}" class="btn btn-app"><i class="fa fa-language"></i> {{ __('label.ngonngu')}}</a>
                <a href="{{route('admin_setting_timezone')}}" class="btn btn-app"><i class="fa fa-clock-o"></i> {{ __('label.ngaygio')}}</a>
                <a href="{{route('admin_setting_account')}}" class="btn btn-app"><i class="fa fa-puzzle-piece"></i> {{ __('label.taikhoan')}}</a>
                <a href="{{route('admin_setting_mail')}}" class="btn btn-app"><i class="fa fa-envelope"></i> {{ __('label.cauhinhmail')}}</a>
                <a href="{{route('admin_setting_ff')}}" class="btn btn-app"><i class="fa fa-file"></i> {{ __('label.file&folder')}}</a>
                <a href="{{route('admin_setting_session')}}" class="btn btn-app"><i class="fa fa-gamepad"></i> {{ __('label.phienlamviec')}}</a>
                <a href="{{route('admin_cache_clearSetting')}}" class="btn btn-app"><i class="fa fa-remove"></i> {{ __('label.xoacache')}}</a>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
@endsection


@section('header_css')
<!-- Select2 -->
<link href="{!! asset('public/admin_assets/vendors/select2/dist/css/select2.min.css ')!!}" rel="stylesheet">
@endsection

@section('footer_js')
<!-- bootstrap-progressbar -->
<script src="{!! asset('public/admin_assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')!!}"></script>

<!-- jQuery Tags Input -->
<script src="{!! asset('public/admin_assets/vendors/jquery.tagsinput/src/jquery.tagsinput.js')!!}"></script>
<!-- Select2 -->
<script src="{!! asset('public/admin_assets/vendors/select2/dist/js/select2.full.min.js')!!}"></script>
@endsection