@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-book"></i> <small> Bài viết</small></h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <a href="{{route('admin_article_add',$type)}}" class="btn btn-app"><i class="fa fa-plus"></i> {{__('label.them')}}</a>
                    <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> {{__('label.tailai')}}</a>
<!--                    <a href="{{route('admin_article_recycle',[$type])}}" class="btn btn-app"><i class="fa fa-recycle"></i> {{__('label.khoiphuc')}}</a>-->
                    <a href="{{route('admin_cache_clear',['article','admin_article_index'])}}?type={{$type}}" class="btn btn-app"><i class="fa fa-remove"></i> {{__('label.xoacache')}}</a>
                    <a href="javascript:void(0)" onclick="PNotify.removeAll();" class="btn btn-app"><i class="fa fa-bell"></i> {{__('label.xoathongbao')}}</a>
                    <a href="{{route('admin_category_index',['bai-viet',$type])}}" class="btn btn-app"><i class="fa fa-list"></i> {{__('label.quanlydanhmuc')}}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-search"></i></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form class="form form-horizontal" action="" method="get">

                        <div class="form-group">
                            <label for="nameOfTheInput" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Từ khóa:</label>
                            <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12 input-group">
                                <input type="text" name="keyword" class="form-control" placeholder="Từ khóa..." />
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </span>
                                @if(Request::has('keyword'))
                                <span class="input-group-btn">
                                    <a href="{{route('admin_article_index',$type)}}" class="btn btn-danger"><i class="fa fa-remove"></i></a>
                                </span>
                                @endif
                            </div>

                        </div>

                    </form>
                </div>
            </div>
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('label.danhsach')}} {{@$title}}</small></h2>
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


