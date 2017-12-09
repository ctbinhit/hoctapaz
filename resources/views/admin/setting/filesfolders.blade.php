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
                <a href="{{route('admin_setting_ff')}}" class="btn btn-app"><i class="fa fa-refresh"></i> {{ __('label.tailai')}}</a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>{{ __('label.dinhdang')}} <small> Các định dạng cho phép</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form action="" class="form form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"> {{ __('label.tailieu')}}</label> 
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" class="form-control jquery-input-tag" name="type_document" value="{{$item->type_document}}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"> {{ __('label.hinhanh')}}</label> 
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" class="form-control jquery-input-tag" name="type_photo" value="{{$item->type_photo}}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"> {{ __('label.anhnen')}}</label> 
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" class="form-control jquery-input-tag" name="type_background" value="{{$item->type_background}}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"> {{ __('label.teptinkhac')}}</label> 
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" class="form-control jquery-input-tag" name="type_file" value="{{$item->type_file}}"/>
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
    <div class="col-md-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>{{ __('label.gioihan')}} <small> {{ __('label.gioihandungluong')}}</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form action="" class="form form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"> {{ __('label.tailieu')}}</label> 
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="number" class="form-control" name="limit_file" value="{{$item->limit_file}}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"> {{ __('label.hinhanh')}}</label> 
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="number" class="form-control" name="limit_photo" value="{{$item->limit_photo}}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"> {{ __('label.anhnen')}}</label> 
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="number" class="form-control" name="limit_background" value="{{$item->limit_background}}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"> {{ __('label.teptinkhac')}}</label> 
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="number" class="form-control" name="limit_document" value="{{$item->limit_document}}"/>
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