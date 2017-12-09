
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
            <h3>Quản lý hành động</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="x_panel">
        <div class="x_title">
            <h2>Sửa khóa</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <form class="form form-horizontal" method="POST" action="{{route('mdle_userpermission_save')}}">
                {{csrf_field()}}
                <input type='hidden' class='form-control' name='am_path' value="{{@$item->am_path}}"/>
                
                <div class="form-group">
                    <label class="control-label col-md-2 col-xs-12">Tên hiển thị:</label>
                    <div class="col-md-10 col-xs-12">
                        <input type="text" class="form-control" name="name" value="{{@$item->name}}"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2 col-xs-12">Quyền mặc định:</label>
                    <div class="col-md-10 col-xs-12">
                        <select name="permission_default" class="form-control">
                            <option selected="" value="1">Cho phép truy cập</option>
                            <option {{$item->permission_default==0?'selected':''}} value="0">Từ chối truy cập</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2 col-xs-12">Action</label>
                    <div class="col-md-10 col-xs-12">
                        <input type="text" class="form-control" name="action" value="{{@$item->action}}"/>
                    </div>
                </div>

                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-10 col-xs-12 col-md-offset-2">
                        <a href="{{route('mdle_userpermission_index')}}" class="btn btn-default">Quay lại</a>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Lưu</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection