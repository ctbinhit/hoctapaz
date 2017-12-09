@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Users <small></small></h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('label.danhsach')}} {{@$title}}</small></h2>
                  
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <a href="{{route('admin_index')}}" class="btn btn-app"><i class="fa fa-dashboard"></i> Dashborard</a>
                    <a href="{{route('admin_user_add',$type)}}" class="btn btn-app"><i class="fa fa-plus"></i> {{__('label.them')}}</a>
                    <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> {{__('label.tailai')}}</a>
<!--                    <a href="#" class="btn btn-app"><i class="fa fa-remove"></i> {{__('label.xoacache')}}</a>-->
                    <a href="javascript:void(0)" onclick="PNotify.removeAll();" class="btn btn-app"><i class="fa fa-bell"></i> {{__('label.xoathongbao')}}</a>
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
                    @include('admin.user.parts.datatable')
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
@include('admin.user.jsc.JSUserController_index')
@endpush
