@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>{{__('label.caidat') }}</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <a href="{{route('admin_setting_account')}}" class="btn btn-app"><i class="fa fa-arrow-left"></i> {{ __('label.cauhinhtaikhoan')}}</a>
                <a href="{{route('admin_setting_account_googledrive')}}" class="btn btn-app"><i class="fa fa-refresh"></i> {{__('label.tailai')}}</a>
<!--                <a href="{{route('admin_cache_clear',['SETTING','admin_setting_index'])}}" class="btn btn-app"><i class="fa fa-remove"></i> {{ __('label.xoacache')}}</a>-->
            </div>
        </div>
    </div>
    @if($item!=null)
    <div class="col-md-8 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>{{__('label.thongtinchung')}} <small>{{__('message.cauhinhchitiet')}}</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form action="{{route('_admin_setting_account_googledrive')}}" method="post" class="form form-horizontal">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-4 col-xs-12">{{__('label.serectkey')}}</label>
                        <div class="col-md-10 col-sm-8 col-xs-12">
                            <input class="form-control" type="text" name="app_key" placeholder="" value="{{@$item->app_key}}"/>
                            <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                {{__('google.nhapsecretkeycuaungdung')}}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-4 col-xs-12">{{__('label.idungdung')}}</label>
                        <div class="col-md-10 col-sm-8 col-xs-12">
                            <input class="form-control" type="text" name="client_id" placeholder="" value="{{@$item->client_id}}"/>
                            <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                {{__('google.nhapidungdung')}}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-4 col-xs-12">{{__('label.storage')}}</label>
                        <div class="col-md-10 col-sm-8 col-xs-12">
                            <input class="form-control" type="text" name="storage_parent" placeholder="" value="{{@$item->storage_parent}}"/>
                            <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;"><i class="fa fa-folder"></i> Storage name: <b>{{@$item->storage_parent_name}}</b></div>
                            <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                {{__('google.noiluutrutoanbodulieucuawebsite')}}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-4 col-xs-12">Refresh Token</label>
                        <div class="col-md-10 col-sm-8 col-xs-12">
                            <input class="form-control" type="text" name="token" placeholder="" value="{{@$item->token}}"/>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success">{{__('label.capnhat')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>{{ __('label.trangthai')}} </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @php
                if($item->storage_parent_size != null){
                $disk_ussage = number_format($item->storage_parent_size/1024/1024,3);
                $disk_limit = 15360;
                }else{
                $disk_ussage = $disk_limit = null;
                }
                @endphp
                Kích hoạt: <input {!!$item->active==1?'checked':''!!} type="checkbox" data-id="{{@$item->id}}" data-field="active" data-tbl="{{@$item->tbl}}" 
                data-action="ub" class="js-switch" name="active" data-switchery="true" style="display: none;">
                <div class="ln_solid"></div>
                <ul class="list-unstyled" id="drive-status">
                    <li><i class="fa fa-info-circle"></i> {{@$item->status}}</li>
                    @if($disk_ussage!=null)
                    <li><i class="fa fa-user"></i> Google Drive API V3 For Laravel</li>
                    <li><i class="fa fa-hdd-o faa-ring animated"></i> {{$disk_ussage}} mb/{{$disk_limit}}Mb ({{number_format(($disk_ussage/$disk_limit)*100,2)}}%)
                        <div class="progress">
                            <div class="progress-bar progress-bar-info" data-transitiongoal="{{($disk_ussage/$disk_limit)*100}}" aria-valuenow="{{$disk_limit}}" style="width: 0%;"></div>
                        </div>
                    </li>
                    <li><i class="fa fa-file"></i> {{__('google.soluongtep')}}: {!!$item->file_count!=null?$item->file_count:'<i class="fa fa-warning"></i>'!!}</li>
                    <li><i class="fa fa-folder"></i> {{__('google.soluongthumuc')}}: {!!$item->dir_count!=null?$item->dir_count:'<i class="fa fa-warning"></i>'!!}</li>
                    <li><i class="fa fa-warning"></i> {{__('google.teptinloi')}}: <i class="fa fa-refresh faa-spin animated"></i></li>
                    @endif

                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>{{ __('label.chuandoan')}} </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <ul class="list-unstyled user_data">
                    <li><i class="fa fa-upload"></i> Upload: OK</li>
                    <li><i class="fa fa-download"></i> Donwload: OK</li>
                    <li><i class="fa fa-file"></i> Access file & directory: OK</li>
                </ul>
            </div>
        </div>
    </div>
    @else
    <!-- Lỗi cấu hình -->
    <div class="col-md-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>{{ __('message.loicauhinhhethong')}} </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="alert alert-danger" role="alert">
                    <strong>{{__('label.canhbao')}}!</strong> {{__('message.loicauhinhhethong')}}. <br>
                    {{__('message.contacttotoannang')}}
                </div>
            </div>
        </div>
    </div>
    @endif


    <div class="clearfix"></div>
</div>
@endsection

@push('stylesheet')
<!-- Select2 -->
<link href="{!! asset('public/admin_assets/vendors/select2/dist/css/select2.min.css')!!}" rel="stylesheet">
@endpush

@push('scripts')
<!-- bootstrap-progressbar -->
<script src="{!! asset('public/admin_assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')!!}"></script>
<!-- ICheck -->
<script src="{!! asset('public/admin_assets/vendors/iCheck/icheck.min.js')!!}"></script>
<!-- jQuery Tags Input -->
<script src="{!! asset('public/admin_assets/vendors/jquery.tagsinput/src/jquery.tagsinput.js')!!}"></script>
<!-- Select2 -->
<script src="{!! asset('public/admin_assets/vendors/select2/dist/js/select2.full.min.js')!!}"></script>

<script>
$(document).ready(function () {
$('.js-switch').on('change', function () {
var this_tr = $(this).parents('tr');
var isChecked = $(this).prop('checked');
var data = {
action: $(this).data('action'),
        tbl: $(this).data('tbl'),
        id: $(this).data('id'),
        field: $(this).data('field')
        };
$.ajax({
url: '{{route("ajax_bcore_action")}}',
        type: 'POST',
        beforeSend: function () {
        $(this_tr).css('background', '#CFF');
        },
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        data: data,
        success: function (data) {
        update_pan_status(isChecked);
        if (data.result == '1') {
        $(this_tr).css('background', 'none');
        } else {
        $(this_tr).css('background', '#F00');
        }
        }, error: function (data) {
// console.log(data.responseText);
}
});
});
init_page();
});
function init_page() {

var isChecked = $('input[name="active"]').prop('checked');
update_pan_status(isChecked);
}

function update_pan_status(pIsChecked) {
if (pIsChecked) {
$('#drive-status').slideDown();
} else {
$('#drive-status').slideUp();
}
}
</script>
@endpush
