@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                {{__('label.thongtincanhan')}} <small>{{__('label.quanlythongtincanhan')}} </small>
            </h3>
        </div>

        <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-8">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('label.thongtinchung')}} <small> </small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Settings 1</a></li>
                                <li><a href="#">Settings 2</a></li>
                            </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
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

        <div class="col-md-4">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('label.anhdaidien')}} <small> </small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <!-- content starts here -->
                    <div style="width:100%;text-align: center;margin: 10px 0px;">
                        @if(isset($data_photos['photo'][0]['url']))
                        <img alt="100%x1280" data-src="holder.js/100%x180" id="photo_preview" class="thumbnail" style="height: 220px; width: 250px; display: block;margin: 0 auto;" 
                             src="{{route('storage_google',[$data_photos['photo'][0]['url']])}}" data-holder-rendered="true">
                        @endif
                    </div>
                    <form action="{{route('_admin_me_info')}}" enctype="multipart/form-data" method="POST" class="form-horizontal form-label-left" novalidate="">
                        {{ csrf_field() }}
                        <a href="javascript:void(0)" class="btn btn-default jquery-input-file" data-input="photo">Chọn file...</a>
                        <a disabled="" href="javascript:void(0)" class="jquery-input-file-remove btn btn-warning" data-input="photo">Xóa hình</a>
                        <input class="hidden" id="photo" type="file" name="photo" placeholder="Chọn file"/>
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

        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('label.caidatnangcao')}} <small> </small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <!-- content starts here -->
                    <div class="col-xs-3 col-md-2">
                        <!-- required for floating -->
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs tabs-left">
                            <li class="active"><a href="#home" data-toggle="tab">{{__('label.dangnhap')}}</a></li>
                            <li><a href="#profile" data-toggle="tab">{{__('label.canhanhoa')}}</a></li>
                            <li><a href="#security" data-toggle="tab"><i class="fa fa-shield"></i> Bảo mật 2 lớp</a></li>
                            <li><a href="#messages" data-toggle="tab">{{__('label.thongbao')}}</a></li>
                            <li><a href="#settings" data-toggle="tab">{{__('label.tuychon')}}</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-9 col-md-10">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="home">@include('admin.me.parts.form_account',['enable_form_tag'=>true])</div>
                            <div class="tab-pane" id="profile"> @include('admin.me.parts.form_personalize')</div>
                            <div class="tab-pane" id="security">
                                <h3>Bảo mật 2 lớp</h3>
                                <form action="https://www.accountkit.com/v1.0/basic/dialog/sms_login/" method="post" class="form form-horizontal">
                                    <input type="hidden" name="app_id" value="552682171742827">
                                    <input type="hidden" name="debug" value="1">
                                    <input type="hidden" name="redirect" value="https://hoctapaz.dev/admin/info/fb/accountkit_callback">
                                    <input type="hidden" name="state" value="{{csrf_token()}}">
                                    <input type="hidden" name="fbAppEventsEnabled" value=true>
                                    <div class="form-group">
                                        <label for="phone_number" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Số điện thoại:</label>
                                        <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                            <input type="text" name="phone_number" id="phone_number" 
                                                   class="form-control" placeholder="Số điện thoại của bạn..." />
                                        </div>
                                    </div>  

                                    <div class="form-group">
                                        <label for="country_code" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Mã quốc gia:</label>
                                        <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                            <select name="country_code" id="country_code" class="form-control">
                                                <optgroup label="Mã quốc gia"></optgroup>
                                                <option value="84">(+84) Việt Nam</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 col-md-offset-2">
                                            <button type="submit" class="btn btn-primary">Xác thực</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="tab-pane" id="messages"> @include('admin.me.parts.form_notification')</div>
                            <div class="tab-pane" id="settings"> {{ __('message.dangcapnhat') }}</div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
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