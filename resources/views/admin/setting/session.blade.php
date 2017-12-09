@extends('admin.layouts.master')
@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>{{__('label.caidat') }}</h3>
        </div>

    </div>
    <div class="clearfix"></div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <a href="{{route('admin_setting_index')}}" class="btn btn-app"><i class="fa fa-gear"></i> {{ __('label.caidatchung')}}</a>
                <a href="{{route('admin_setting_session')}}" class="btn btn-app"><i class="fa fa-refresh"></i> {{ __('label.tailai')}}</a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>{{ __('label.phienlamviec')}} <small> {{ __('label.lifetimesession')}}</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form action="" class="form form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"> {{ __('label.lifetimecache')}}</label> 
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="number" class="form-control" name="cache_lifetime" value="{{@$item->cache_lifetime}}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"> {{ __('label.phienlamviecuser')}}</label> 
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="number" class="form-control" name="session_user" value="{{@$item->session_user}}"/>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success">{{__('label.capnhat')}}</button>
                        </div>
                    </div>
                </form>
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