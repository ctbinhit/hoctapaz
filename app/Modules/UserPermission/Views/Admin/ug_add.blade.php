
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
            <h3>Quản lý packages</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <form class="form form-horizontal" action="{{route('mdle_userpermission_ug_save')}}" method="POST" >
        {{csrf_field()}}
        <input type="hidden" name="id" value="{{@$item->id}}" />
        <div class="x_panel">
            <div class="x_content">
                <a href="{{route('mdle_userpermission_ug')}}" class="btn btn-app"><i class="fa fa-arrow-left"></i> Quay lại</a>
                <button type="submit" class="btn btn-app"><i class="fa fa-save"></i> Lưu</button>
            </div>
        </div>

        <div class="x_panel">
            <div class="x_content">

                <div class="form-group">
                    <label for="name" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Tên group:</label>
                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                        <input type="text" name="name" class="form-control" placeholder="Tên group..." />
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Tên group:</label>
                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                        <textarea rows="5" class="form-control" name="description" placeholder="Mô tả..."></textarea>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

@endsection