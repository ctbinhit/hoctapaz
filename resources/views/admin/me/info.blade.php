@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-edit"></i> {{__('label.thongtincanhan')}} <small>{{__('label.quanlythongtincanhan')}} </small></h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-8">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-user"></i> {{__('label.thongtinchung')}}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <!-- content starts here -->
                    <form action="{{route('_admin_me_info')}}" method="POST" class="form-horizontal form-label-left" novalidate="">
                        {{ csrf_field() }}
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">{{__('label.hovaten')}} <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" required="required" name="fullname" value="{{@$item->fullname}}" placeholder="{{__('placeholder.nhap',['name'=>  __('label.hovaten')])}}" class="form-control col-md-7 col-xs-12">
                                <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">{{__('label.email')}}</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input required="required" class="form-control col-md-7 col-xs-12" name="email" value="{{@$item->email}}" type="email" placeholder="{{__('placeholder.nhap',['name'=>  __('label.email')])}}">
                                <span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label for="phone" class="control-label col-md-3 col-sm-3 col-xs-12">{{__('label.dienthoai')}}</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input required="required" class="form-control col-md-7 col-xs-12" name="phone" value="{{@$item->phone}}" type="phone" placeholder="{{__('placeholder.nhap',['name'=>  __('label.dienthoai')])}}">
                                <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">{{__('label.ngaysinh')}} <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="input-group date dtpicker_dateonly">
                                    <input type='text' class="form-control" name="date_of_birth" value="{{@$item->date_of_birth}}"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-9 col-sm-12 col-xs-12 col-md-offset-3">
                                <button type="submit" class="btn btn-success">{{__('label.capnhat')}}</button>
                            </div>
                        </div>
                    </form>
                    <!-- content ends here -->
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('label.thongtin')}} <small> </small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <!-- content starts here -->
                    <p>Fullname: {{@$item->fullname}}</p>
                    <p>Coin: {{@$item->coin}} <i class="fa fa-money"></i></p>
                    <p>VIP: <font color="gold">{{@$item->id_vip}}</font></p>
                    <p>Email: {{@$item->email}}</p>
                    <p>IP: {{$_SERVER['SERVER_ADDR']}}</p>
                    <!-- content ends here -->
                </div>
            </div>
        </div>
       
    </div>
</div>
@endsection


@push('stylesheet')

@endpush

@push('scripts')
<script src="https://sdk.accountkit.com/en_US/sdk.js"></script>
<script>
    // initialize Account Kit with CSRF protection
    AccountKit_OnInteractive = function () {
        AccountKit.init(
                {
                    appId: "552682171742827",
                    state: "{{csrf_token()}}",
                    version: "v1.1",
                    fbAppEventsEnabled: true,
                    redirect: "https://hoctapaz.dev/admin/info/accountkit_callback"
                }
        );
    };
</script>


<!-- validator -->
<script src="{!!asset('public/admin_assets/vendors/validator/validator.js')!!}"></script>
<script>
    $(document).ready(function () {
        $('.dtpicker_dateonly').datetimepicker({
            format: 'YYYY-MM-DD'
        });
    });
</script>
@endpush

@include('admin.me.jsc.JSUserController_index')