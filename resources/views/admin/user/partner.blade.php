@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>{{@$title}} <small></small></h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <a href="{{route('admin_user_add')}}" class="btn btn-app"><i class="fa fa-plus"></i> {{__('label.them')}}</a>
                    <a href="{{route('admin_user_partner')}}" class="btn btn-app"><i class="fa fa-refresh"></i> {{__('label.tailai')}}</a>
                    <a href="javascript:void(0)" onclick="PNotify.removeAll();" class="btn btn-app"><i class="fa fa-bell"></i> {{__('label.xoathongbao')}}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <form class="form form-horizontal" action="" method="get">
                        <div class="form-group">
                            <label class="control-label col-md-2">Tìm kiếm</label>
                            <div class="col-md-8">
                                <input type="text" name="keyword" placeholder="Tìm kiếm họ tên | sđt | email..."  
                                       value="{{Request::has('keyword')?Request::get('keyword'):''}}" class="form-control"/>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Tìm kiếm</button>
                                @if(Request::has('keyword'))
                                <a href="{{route('admin_user_partner')}}"  class="btn btn-danger"><i class="fa fa-remove"></i></a>
                                @endif
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('label.danhsach')}} đối tác</small></h2>
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
                    @include('admin.user.parts.datatable_partner')
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')

@endpush
