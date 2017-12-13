@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-list"></i> Danh mục <small></small></h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <a href="{{route('admin_index')}}" class="btn btn-app"><i class="fa fa-dashboard"></i> Dashboard</a>
                    <a href="{{route('admin_category_add',[$tbl,$type])}}" class="btn btn-app"><i class="fa fa-plus"></i> {{__('label.them')}}</a>
                    <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>
                    <a href="{{route('admin_cache_clearCategory',[$tbl,$type])}}" class="btn btn-app"><i class="fa fa-remove"></i> {{__('label.xoacache')}}</a>
                    <a href="javascript:void(0)" onclick="PNotify.removeAll();" class="btn btn-app"><i class="fa fa-bell"></i> {{__('label.xoathongbao')}}</a>
                    <a href="javascript:void(0)" class="btn btn-app"><i class="fa fa-cloud-upload"></i> {{__('label.dongbo')}}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-search"></i> {{__('label.loc')}}</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-md-12">
                        <form class="form form-horizontal" method="GET" action="" role="search">
                            <div class="form-group">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">{{__('label.timkiem')}}</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="input-group">
                                        <input class="form-control" name="keyword" type="search" placeholder="" value="{{@Request::input('keyword')}}" />
                                        <input type="hidden" name="id_category" value="{{@Request::input('id_category')}}" />
                                        <span class = "input-group-btn">
                                            <button class="btn btn-default"><i class="fa fa-search"></i></button>
                                            @if(Request::has('keyword'))
                                            <a href="{{route('admin_category_index',[$tbl,$type])}}" class="btn btn-warning"><i class="fa fa-remove"></i></a>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @isset($items_cate_data)
                            <div class="form-group">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">{{__('label.nangcao')}}</label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{__('label.danhmuccha')}} <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        @foreach($items_cate_data as $k=>$v)
                                        <li><a href="{{route('admin_category_index',[$tbl,$type])}}?id_category={{$k}}">{{$v->name}}</a></li>
                                        @endforeach
                                    </ul>
                                    @if(Request::has('id_category'))
                                    <a href="{{route('admin_category_index',[$tbl,$type])}}" class="btn btn-warning"><i class="fa fa-remove"></i>
                                        {{$items_cate_data[Request::get('id_category')]->name}}
                                    </a>
                                    @endif
                                </div>
                            </div>
                            @endisset
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('label.danhsach')}} {{@$title}}</small></h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <p class="text-muted font-13 m-b-30"></p>
                    @include('admin.category.parts.table')
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-bar-chart-o"></i> {{__('label.sododanhmuc')}} <small>Sắp xếp bằng cách kéo thả.</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-md-6">
                        @if(isset($items_cate))
                        <p class="text-muted font-13 m-b-30"></p>
                        @include('admin.category.parts.sortable')
                        @else
                        <p>{{__('message.khongcodulieu')}}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
@include('admin.category.jsc.JSCategoryController_index')
@endpush
