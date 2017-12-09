@extends('admin.layouts.master')

@section('content')
<form action="{{route('_admin_setting_account_googledrive_path')}}" method="POST" class="form form-horizontal">
    {{csrf_field()}}
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3><i class="fa fa-hdd-o"></i> Google Storage</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <a href="{{route('admin_setting_account')}}" class="btn btn-app"><i class="fa fa-arrow-left"></i> Cài đặt</a>
                    <a href="{{route('admin_index')}}" class="btn btn-app"><i class="fa fa-dashboard"></i> Dashboard</a>
                    <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh faa-spin animated-hover"></i> Tải lại</a>
                    <button type="submit" class="btn btn-app"><i class="fa fa-save"></i> Lưu</button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="alert alert-warning">
                <p>
                    <strong><i class="fa fa-warning"></i> Lưu ý!</strong> Việc cấu hình sai đường dẫn có thể gây thất thoát dữ liệu và có thể xảy ra lỗi trong quá trình đồng bộ dữ liệu.
                </p>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-folder"></i> Folder Path</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    @if(count($gg_paths)!=0)
                    @foreach($gg_paths as $k=>$v) 
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12">{{@$v->name}}</label>
                        <div class="col-md-6 col-sm-9 col-xs-12 input-group">
                            <span class="input-group-addon"><i class="fa fa-google"></i></span>
                            <input type="text" class="form-control" name="storage[{{$v->id}}]" value="{{$v->id_google}}"/>
                            <span class="input-group-addon"><i class="fa fa-check"></i></span>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <p class="alert alert-danger"><strong>Lưu ý!</strong> Không tìm thấy dữ liệu cấu hình, vui lòng kiểm tra lại cấu hình hoặc liên hệ quản trị để biết thêm thông tin chi tiết.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
