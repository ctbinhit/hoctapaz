@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>{{__('label.caidat') }}</h3>
        </div>
        <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Go!</button>
                    </span>
                </div>
            </div>
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
    <div class="col-md-8 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>{{ __('label.timezone')}} <small>ToanNang Co., Ltd</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#"><i class="fa fa-save"></i> {{ __('default.luu')}}</a>
                            </li>
                            <li><a href="#"><i class="fa fa-recycle"></i> Khôi phục cài đặt gốc</a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i>                                                                                                                                                                 </a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form class="form form-horizontal" method="post" action="">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label col-md-2">Timezone</label>
                        <div class="col-md-10">
                            @if(isset($lst_timezone))
                            <select class="form-control" name="timezone">
                                @foreach($lst_timezone as $k=>$v)
                                @if(trim($current_timezone)==$v)
                                <option selected="" value="{{$v}}">{{$k}}</option>
                                @else
                                <option value="{{$v}}">{{$k}}</option>
                                @endif
                                @endforeach
                            </select>
                            @endif
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success">Cập nhật</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>{{ __('label.dinhdangngaygio')}} </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#"><i class="fa fa-save"></i> {{ __('default.luu')}}</a>
                            </li>
                            <li><a href="#"><i class="fa fa-recycle"></i> Khôi phục cài đặt gốc</a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i>                                                                                                                                                                 </a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                Chức năng đang cập nhật...
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
