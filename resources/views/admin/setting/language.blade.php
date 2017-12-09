@extends('admin.layouts.master')

@section('content')

<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>{{ __('default.caidat')}} | {{ __('default.ngonngu')}}</h3>
        </div>

        <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="{{ __('default.timkiem')}}...">
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
                <a href="{{route('admin_setting_language')}}" class="btn btn-app"><i class="fa fa-refresh"></i> {{ __('label.tailai')}}</a>
            </div>
        </div>
    </div>


    <div class="col-md-12">
        @if(Session::has('message'))
        <div class="alert {{Session::get('message_type','alert-info')}} alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Thông báo: </strong>  {{@Session::get('message')}}
        </div>
        @endif
    </div>

    <div class="col-md-8 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>{{ __('label.danhsachgoingonngu')}} {{@$title}}</small></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <p class="text-muted font-13 m-b-30">

                </p>
                <table id="main_form" class="table table-striped table-bordered bulk_action">
                    <thead>
                        <tr>
                            <th>{{ __('label.ten') }}</th>
                            <th>{{ __('label.quocgia') }}</th>
                            <th>{{ __('label.donvitiente') }}</th>
                            <th>{{ __('label.maquocgia') }}</th>
                            <th>{{ __('label.ngaytao') }}</th>
                            <th>{{ __('label.anien') }}</th>
                            <th>{{ __('label.thaotac') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $k => $v)
                        <tr>
                            <td>{{@$v->name}}</td>
                            <td></td>
                            <td class="text-center">{{@$v->currency_unit}}</td>
                            <td class="text-center">{{@$v->country_sortname}}</td>
                            <td>{{@$v->created_at}}</td>
                            <td>
                                @php
                                $visibility = $v->display==1?'checked':'';
                                $disabled = $v->id_user==-1?'disabled':'';
                                @endphp
                                <input type="checkbox" data-table="{{@$v->tbl }}" 
                                       data-id="{{@$v->id}}" data-field="display" class="js-switch js-switch-ajax" 
                                       {{$visibility}} {{$disabled}}/>
                            </td>
                            <td>
                                @if($v->id_user!=-1)

                                @else 
                                {{ __('default.macdinh') }}
                                @endif
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>{{ __('label.thongtin')}} {{@$title}}</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <p>Mọi thông tin về nâng cấp ngôn ngữ vui lòng liên hệ <b>(+84) 028 389 11719</b> để được hỗ trợ</p>
            </div>
        </div>
    </div>


    <div class="clearfix"></div>
</div>
@endsection

@section('header_css')
<!-- Datatables -->
<link href="public/admin_assets//vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="public/admin_assets//vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="public/admin_assets//vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="public/admin_assets//vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="public/admin_assets//vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<!-- iCheck -->
<link href="public/admin_assets//vendors/iCheck/skins/flat/green.css" rel="stylesheet">
<!-- Datatables -->
<link href="public/admin_assets//vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="public/admin_assets//vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="public/admin_assets//vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="public/admin_assets//vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="public/admin_assets//vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">


@endsection

@section('footer_js')
<!-- FastClick -->
<script src="public/admin_assets//vendors/fastclick/lib/fastclick.js"></script>
<!-- iCheck -->
<script src="public/admin_assets//vendors/iCheck/icheck.min.js"></script>
<!-- Datatables -->
<script src="public/admin_assets//vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="public/admin_assets//vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="public/admin_assets//vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="public/admin_assets//vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="public/admin_assets//vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="public/admin_assets//vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="public/admin_assets//vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="public/admin_assets//vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="public/admin_assets//vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="public/admin_assets//vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="public/admin_assets//vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="public/admin_assets//vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
<script src="public/admin_assets//vendors/jszip/dist/jszip.min.js"></script>
<script src="public/admin_assets//vendors/pdfmake/build/pdfmake.min.js"></script>
<script src="public/admin_assets//vendors/pdfmake/build/vfs_fonts.js"></script>
@endsection