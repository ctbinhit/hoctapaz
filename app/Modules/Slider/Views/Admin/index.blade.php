
@extends('admin.layouts.master')

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
            <h3><i class="fa fa-image"></i> Slide</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="x_panel">
        <div class="x_content">
            <a href="{{route('mdle_slider_add',$type)}}" class="btn btn-app"><i class="fa fa-plus"></i> Thêm</a>
            <a href="{{url()->current()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>
        </div>
    </div>
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-image"></i> Quản lý slides <small>
                  @if(count($items)!=0)
                  Tổng records {{$items->total()}}
                  @endif
                </small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <div class="row">
                <div class="col-md-12">
                  @include('Slider::Admin.parts.datatable')
                </div>
            </div>

        </div>
    </div>
    <div class="clearfix"></div>
</div>
@endsection

@push('stylesheet')
<!-- iCheck -->
<link href="{!! asset('public/admin/bower_components/iCheck/skins/flat/green.css')!!}" rel="stylesheet">
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

<!-- iCheck -->
<script src="{!! asset('public/admin/bower_components/iCheck/icheck.min.js')!!}"></script>
<!-- Switchery -->
<script src="{!! asset('public/admin/bower_components/switchery/dist/switchery.min.js')!!}"></script>

@endpush


