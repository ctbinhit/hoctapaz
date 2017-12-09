@extends('admin.layouts.master')
@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>{{__('label.them')}} {{ @$title }}</h3>
        </div>
        <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                    <input type="text" class="form-control"  placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <form class="form-horizontal form-label-left" action="{{route('admin_category_save_post')}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ @$item['id'] }}" />
        <input type="hidden" name="tbl" value="{{ @$tbl }}" />
      
        <div class="col-md-9 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{ __('label.thongtinchung')}} <small>ToanNang Co., Ltd</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#"><i class="fa fa-save"></i> Lưu</a>
                                </li>
                                <li><a href="#"><i class="fa fa-recycle"></i> Khôi phục cài đặt gốc</a>
                                </li>
                            </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    Loading... <i class="fa fa-refresh faa-spin animated"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('label.caidat')}} <small>ToanNang Co., Ltd</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    @if($UI->field('highlight'))
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12">{!!$UI->field_name('highlight')!!}</label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <div class="">
                                <label>
                                    <input type="checkbox" {{@$item->highlight==1?'checked=""':''}} class="js-switch" name="highlight" data-switchery="true" style="display: none;">
                                </label>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($UI->field('display'))
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12">{!!$UI->field_name('display')!!}</label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <div class="">
                                <label>
                                    <input type="checkbox" {{@$item->display==1?'checked=""':''}} class="js-switch" name="display" data-switchery="true" style="display: none;">
                                </label>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-3">
                            <a href="{{route('admin_user_index')}}" class="btn btn-primary">Quay lại</a>
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Lưu</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </form>
    <div class="clearfix"></div>
</div>
@endsection

@push('stylesheet')


@endpush

@push('scripts')

@endpush

