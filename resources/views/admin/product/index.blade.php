@extends('admin.layouts.master')

@section('content')

<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-shopping-bag"></i> Quản lý sản phẩm</h3>
        </div>
        <div class="title_right">

        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <a href="{{route('admin_product_add',$type)}}" class="btn btn-app"><i class="fa fa-plus"></i> {{__('label.them')}}</a>
                    <a href="{{route('admin_product_index',$type)}}" class="btn btn-app"><i class="fa fa-refresh"></i> {{__('label.tailai')}}</a>
                    <a href="#" class="btn btn-app"><i class="fa fa-remove"></i> {{__('label.xoacache')}}</a>
                    <a href="javascript:void(0)" onclick="PNotify.removeAll();" class="btn btn-app"><i class="fa fa-bell"></i> {{__('label.xoathongbao')}}</a>
                    <a href="javascript:void(0)" class="btn btn-app"><i class="fa fa-cloud-upload"></i> {{__('label.dongbo')}}</a>
                    <a href="{{route('admin_category_index',['products',$type])}}" class="btn btn-app"><i class="fa fa-list"></i> {{__('label.quanlydanhmuc')}}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-search"></i> {{__('label.timkiem')}} {{@$title}}</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form class="form form-horizontal" method="GET" action="" role="search">
                        <div class="form-group">
                            <label class="control-label col-md-1 col-sm-2 col-xs-12">{{__('label.timkiem')}}</label>
                            <div class="col-md-5 col-sm-10 col-xs-12">
                                <div class="input-group">
                                    <input class="form-control" name="keyword" type="search" placeholder="" value="{{@Request::input('keyword')}}" />
                                    <span class = "input-group-btn">
                                        <button class="btn btn-default"><i class="fa fa-search"></i></button>
                                        @if(Request::has('keyword'))
                                        <a href="{{route('admin_product_index',[$type])}}" class="btn btn-warning"><i class="fa fa-remove"></i></a>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row hide">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-1">
                            <label>Danh mục</label>
                        </div>
                        <div class="col-md-11">
                            <div class="row">
                                <div class="col-md-4">
                                    <select class="form-control">
                                        <option>-- Danh mục cấp 1 --</option>
                                    </select>
                                </div>
<!--                                <div class="col-md-4">
                                    <select class="form-control">
                                        <option>-- Danh mục cấp 2 --</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control">
                                        <option>-- Danh mục cấp 3 --</option>
                                    </select>
                                </div>-->
                            </div>
                        </div>
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
                    <p class="text-muted font-13 m-b-30">

                    </p>
                    @include('admin.product.parts.table')
                </div>
            </div>
        </div>
    </div>
</div>

@endsection




