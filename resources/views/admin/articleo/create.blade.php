
@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="clearfix"></div>
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-primary">
            <div class="panel-heading">Khởi tạo dữ liệu.</div>
            <div class="panel-body">
                <p><i class="fa fa-spinner faa-spin animated"></i> Đang khởi tạo dữ liệu...</p>
            </div>
            <div class="panel-footer text-center">
                <p class="text-info">ToanNang Co., Ltd</p>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
@endsection

@push('stylesheet')
<meta http-equiv="refresh" content="5;url={{route('admin_articleo_index',$type)}}" />
@endpush

@push('scripts')

@endpush


