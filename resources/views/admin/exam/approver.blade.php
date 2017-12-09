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
                    <a href="{{route('admin_examman_approver')}}" class="btn btn-app"><i class="fa fa-refresh"></i> {{__('label.tailai')}}</a>
                    <a href="javascript:void(0)" onclick="PNotify.removeAll();" class="btn btn-app"><i class="fa fa-bell"></i> {{__('label.xoathongbao')}}</a>
                    <a href="javascript:void(0)" class="btn btn-app"><i class="fa fa-check"></i> Bài đã xác thực</a>
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
                    @include('admin.exam.parts.datatable')
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


