@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>{{@$title}} <small> ToanNang Co., Ltd</small></h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('label.thaotac')}} {{@$title}}</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <a href="{{route('admin_article_index',[$type])}}" class="btn btn-app"><i class="fa fa-arrow-left"></i> {{__('label.trolai')}}</a>
                    <a href="{{route('admin_article_recycle',[$type])}}" class="btn btn-app"><i class="fa fa-refresh"></i> {{__('label.tailai')}}</a>
                    <a href="{{route('admin_article_recycle',[$type])}}" class="btn btn-app"><i class="fa fa-recycle"></i> {{__('label.khoiphuc')}}</a>
                    <a href="{{route('admin_cache_clear',['article','admin_article_index'])}}?type={{$type}}" class="btn btn-app"><i class="fa fa-remove"></i> {{__('label.xoacache')}}</a>
                    <a href="javascript:void(0)" onclick="PNotify.removeAll();" class="btn btn-app"><i class="fa fa-bell"></i> {{__('label.xoathongbao')}}</a>
                    <a href="javascript:void(0)" class="btn btn-app"><i class="fa fa-cloud-upload"></i> {{__('label.dongbo')}}</a>
                    @if(@$UI->ConfigVal('CategoryLevel')!=0)
                    <a href="{{route('admin_category_index',['bai-viet',$type])}}" class="btn btn-app"><i class="fa fa-list"></i> {{__('label.quanlydanhmuc')}}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('label.danhsach')}} {{@$title}}</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="javascript:void(0)" onClick="datatables_refresh()">{{__('label.tailai')}}</a></li>
                        </li>
                    </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <p class="text-muted font-13 m-b-30"></p>
                    @include('admin.article.parts.datatable')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


