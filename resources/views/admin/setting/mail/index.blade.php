@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-envelope"></i> Mail</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <a href="{{route('admin_setting_index')}}" class="btn btn-app"><i class="fa fa-arrow-left"></i> {{ __('label.caidatchung')}}</a>
                <a href="{{route('admin_cache_clear',['SETTING','admin_setting_index'])}}" class="btn btn-app"><i class="fa fa-remove"></i> {{ __('label.xoacache')}}</a>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-envelope-o"></i> {{ __('label.cauhinhmail')}} <small>Cập nhật lần cuối {{diffInNow(@$mail_info->updated_at)}}</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form class="form form-horizontal" method="post" action="">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-4 col-xs-12">Driver</label>
                        <div class="col-md-10 col-sm-8 col-xs-12">
                            <input class="form-control" type="text" name="driver" value="{{$mail_info->driver}}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-4 col-xs-12">Host</label>
                        <div class="col-md-10 col-sm-8 col-xs-12">
                            <input class="form-control" type="text" name="ip_host" value="{{$mail_info->ip_host}}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-4 col-xs-12">Username</label>
                        <div class="col-md-10 col-sm-8 col-xs-12">
                            <input class="form-control" type="text" name="username" value="{{$mail_info->username}}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-4 col-xs-12">Password</label>
                        <div class="col-md-10 col-sm-8 col-xs-12">
                            <input class="form-control" type="text" name="password" value="{{$mail_info->password}}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-4 col-xs-12">Port</label>
                        <div class="col-md-10 col-sm-8 col-xs-12">
                            <input class="form-control" type="text" name="port" value="{{$mail_info->port}}" />
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-10 col-sm-9 col-xs-12 col-md-offset-2">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Cập nhật</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
@endsection

@push('stylesheet')
<!-- Select2 -->
<link href="public/admin_assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
@endpush

@push('scripts')
<!-- bootstrap-progressbar -->
<script src="public/admin_assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
<!-- ICheck -->
<script src="public/admin_assets/vendors/iCheck/icheck.min.js"></script>
<!-- jQuery Tags Input -->
<script src="public/admin_assets/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
<!-- Select2 -->
<script src="public/admin_assets/vendors/select2/dist/js/select2.full.min.js"></script>
@endpush
