@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-gear"></i> Facebook API <small> Account kit</small></h3>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="x_panel">
        <div class="x_title">
            <h2>API <small>Cập nhật lần cuối vào lúc <b>{{DiffInNow($item->updated_at)}}</b> - {{@$item->updated_at}}</small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <form class="form form-horizontal" method="POST" action="{{route('_admin_setting_account_facebook')}}">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="app_id" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Mã ứng dụng:</label>
                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                        <input type="text" name="app_id" id="app_id" value="{{@$item->app_id}}"
                               class="form-control" placeholder="ID Ứng dụng..." />
                    </div>
                </div>

                <div class="form-group">
                    <label for="app_version" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Version:</label>
                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                        <input type="text" name="app_version" id="app_version" value="{{@$item->app_version}}"
                               class="form-control" placeholder="Phiên bản..." />
                    </div>
                </div>

                <div class="form-group">
                    <label for="app_key" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Secret key:</label>
                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                        <input type="text" name="app_key" id="app_key" value="{{@$item->app_key}}"
                               class="form-control" placeholder="Secret key..." />
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-10 col-lg-10 col-xs-12 col-sm-12 col-md-offset-2">
                        <a href="{{route('admin_setting_account')}}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Quay lại</a>
                        <button class="btn btn-success"><i class="fa fa-save"></i> Lưu</button>
                    </div>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection