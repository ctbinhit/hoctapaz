
@extends('pi.layouts.master')

@push('stylesheet')
<style>
    table th,td{
        text-align: center;
    }
    table img{
        margin: 0 auto;
    }
</style>
@endpush

@section('content')
<div class="">


    <div class="page-title">
        <div class="title_left">
            <h3>Quản lý khóa học</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    
    <ol class="breadcrumb">
        <li><a href="{{route('pi_index_index')}}">Trang chủ</a></li>
        <li><a href="{{route('mdle_oc_index')}}">Khóa học</a></li>
    </ol>
    
    <div class="x_panel">
        <div class="x_content">
            <a href="{{route('mdle_oc_add')}}" class="btn btn-app"><i class="fa fa-graduation-cap"></i> Tạo khóa học</a>
            <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>
        </div>
    </div>

    <div class="x_panel">
        <div class="x_title">
            <h2>Lọc <small></small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <form class="form form-horizontal" action="" method="GET">
                
                <div class="form-group">
                    <label class="control-label col-md-2 hidden-xs">Tìm kiếm</label>
                    <div class="col-md-8 col-xs-9 input-group">
                        <input type="text" name="keywords" class="form-control" placeholder="Từ khóa..."/>
                        <span class="input-group-btn">
                            <button class="btn btn-default"><i class="fa fa-search"></i></button>
                            @if(Request::has('keywords'))
                            <a href="javascript:void(0)" class="btn btn-danger"><i class="fa fa-remove"></i></a>
                            @endif
                        </span>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div class="x_panel">
        <div class="x_title">
            <h2>Quản lý khóa học <small>
                </small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <div class="row">
                <div class="col-md-12">
                    @include('OnlineCourse::Pi.parts.datatable')
                </div>
            </div>

        </div>
    </div>
    <div class="clearfix"></div>
</div>
@endsection

@push('stylesheet')
<!-- iCheck -->
<link href="{!! asset('public/admin_assets/vendors/iCheck/skins/flat/green.css')!!}" rel="stylesheet">

<!-- Select2 -->
<link href="{!! asset('public/admin_assets/vendors/select2/dist/css/select2.min.css')!!}" rel="stylesheet">

@endpush

@push('scripts')
<script>
    /**
     * Number.prototype.format(n, x)
     * 
     * @param integer n: length of decimal
     * @param integer x: length of sections
     */
    Number.prototype.format = function (n, x) {
        var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
        return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
    };

    $(document).ready(function () {
        $('.jquery-icheck-all').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });

        $('.jquery-icheck-all').on('ifChecked', function (event) {
            var items = $('.' + $(this).data('items'));
            $(items).iCheck('check');
        }).on('ifUnchecked', function (event) {
            var items = $('.' + $(this).data('items'));
            $(items).iCheck('uncheck');
        });
    });
</script>

<!-- bootstrap-progressbar -->
<script src="{!! asset('public/admin_assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')!!}"></script>
<!-- iCheck -->
<script src="{!! asset('public/admin_assets/vendors/iCheck/icheck.min.js')!!}"></script>

<!--<script src="public/admin_assets/vendors/jquery.hotkeys/jquery.hotkeys.js"></script>-->
<!-- jQuery Tags Input -->
<script src="{!! asset('public/admin_assets/vendors/jquery.tagsinput/src/jquery.tagsinput.js')!!}"></script>
<!-- Switchery -->
<script src="{!! asset('public/admin_assets/vendors/switchery/dist/switchery.min.js')!!}"></script>
<!-- Select2 -->
<!--<script src="public/admin_assets/vendors/select2/dist/js/select2.full.min.js"></script>-->
<!-- Parsley -->
<!--<script src="public/admin_assets/vendors/parsleyjs/dist/parsley.min.js"></script>-->
<!-- Autosize -->
<!--<script src="public/admin_assets/vendors/autosize/dist/autosize.min.js"></script>-->
<!-- jQuery autocomplete -->
<!--<script src="public/admin_assets/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>-->
<!-- starrr -->
<!--<script src="public/admin_assets/vendors/starrr/dist/starrr.js"></script>-->

<!-- Cropper -->
<script src="{!! asset('public/admin_assets/js/cropperjs/dist/cropper.min.js') !!}"></script>

@endpush


