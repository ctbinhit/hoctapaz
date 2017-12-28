@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-microchip"></i> Tài khoản</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <a href="{{route('admin_setting_index')}}" class="btn btn-app"><i class="fa fa-arrow-left"></i> {{ __('label.caidatchung')}}</a>
                <a href="{{route('admin_index')}}" class="btn btn-app"><i class="fa fa-dashboard"></i> Dashboard</a>
                <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh faa-spin animated-hover"></i> Tải lại</a>
                <a href="{{route('admin_cache_clearSync')}}" class="btn btn-app"><i class="fa fa-remove"></i> {{ __('label.xoacache')}}</a>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-google"></i> Google<small> Google services - API.</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <a href="{{route('admin_setting_account_googledrive')}}" class="btn btn-app"><i class="fa fa-google"></i> Google Drive</a>
                <a href="{{route('admin_setting_account_googledrive_path')}}" class="btn btn-app"><i class="fa fa-hdd-o"></i> Path</a>
                <a href="#" class="btn btn-app"><i class="fa fa-map-o"></i> Map API</a>
                <a href="#" class="btn btn-app"><i class="fa fa-user"></i> Authenticate</a>
                <a href="#" class="btn btn-app" title="Đăng nhập ứng dụng bằng tin nhắn SMS"><i class="fa fa-mobile-phone"></i> Account Kit</a>
                <a href="{{route('mdle_admin_seo_analytics')}}" class="btn btn-app" title="Google analytics"><i class="fa fa-bar-chart-o"></i> Analytics</a>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-facebook-official"></i> Facebook API<small></small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <a href="{{route('admin_setting_account_facebook')}}" class="btn btn-app" title="Thiết lập cấu hình facebook API"><i class="fa fa-facebook-square"></i> Cấu hình</a>
                <a href="#" class="btn btn-app" title="Đăng nhập ứng dụng bằng tin nhắn SMS"><i class="fa fa-mobile-phone"></i> Account Kit</a>
                <a href="#" class="btn btn-app" title="Đăng nhập bằng tài khoản facebook"><i class="fa fa-user"></i> Đăng nhập</a>
                <a href="#" class="btn btn-app" title="Facebook analytics"><i class="fa fa-bar-chart-o"></i> Analytics</a>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-share"></i> Add this<small></small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <a href="#" class="btn btn-app" title="Tùy chỉnh nút chia sẻ trên trang web"><i class="fa fa-share"></i> Share buttons</a>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
@endsection

@push('stylesheet')
@endpush

@push('scripts')
@endpush
