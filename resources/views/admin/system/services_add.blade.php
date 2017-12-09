
@extends('admin.layouts.master')
@push('stylesheet')
<style>
    table th,td {
        text-align: center;
    }
</style>
@endpush
@section('content')

<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Tạo service</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <form class="form form-horizontal" action="{{route('admin_system_service_save')}}" method="post">
        {{csrf_field()}}
        <div class="x_panel">
            <div class="x_content">
                <a href="{{route('admin_system_service')}}" class="btn btn-app"><i class="fa fa-arrow-left"></i> Quay lại</a>

            </div>
        </div>

        <div class="x_panel">
            <div class="x_content">

                <div class="form-group">
                    <label class="control-label col-md-2 col-xs-12">Path:</label>
                    <div class="col-md-10 col-xs-12">
                        <input type="text" name="service_path" class="form-control" placeholder="Path..." />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2 col-xs-12">Tên:</label>
                    <div class="col-md-10 col-xs-12">
                        <input type="text" name="service_name" class="form-control" placeholder="Tên service..." />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2 col-xs-12">Kích hoạt:</label>
                    <div class="col-md-10 col-xs-12">
                        <input type="checkbox" name="status" class="jquery-icheck" checked=""/>
                    </div>
                </div>

                <div class="ln_solid"></div>

                <div class="form-group">
                    <div class="col-md-10 col-md-offset-2 col-xs-12">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Lưu</button>
                    </div>
                </div>

            </div>
        </div>
    </form>

</div>


@endsection
