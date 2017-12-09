@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-download"></i> Quản lý tài nguyên</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="x_panel">
        <div class="x_content">
            <a href="{{route('admin_index')}}" class="btn btn-app"><i class="fa fa-dashboard"></i> Dashboard</a>
            <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>
        </div>
    </div>

    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-css3"></i> Trình quản lý phiên bản <small> CSS, JAVASCRIPT, IMAGE</small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <form class="form form-horizontal" action="{{route('mdle_admin_apm_save')}}" method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="version_css" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Phiên bản CSS:</label>
                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 input-group">
                        <input type="number" name="version_css" id="version_css" value="{{@$css->version}}"
                               class="form-control" placeholder="Phiên bản CSS" />
                        <span class="input-group-addon"><i class="fa fa-css3"></i></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="version_javascript" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Phiên bản Javascript:</label>
                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 input-group">
                        <input type="number" name="version_javascript" id="version_javascript" value="{{@$javascript->version}}"
                               class="form-control" placeholder="Phiên bản javascript" />
                        <span class="input-group-addon"><i class="fa fa-microchip"></i></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="disable_cache" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Cache:</label>
                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                        <input type="checkbox" name="cache_css" id="disable_cache" 
                               class="js-switch {{@$css->cache?'js-switch-checked':''}}" /> CSS <br><br>
                        <input type="checkbox" name="cache_javascript" id="disable_cache" 
                               class="js-switch {{@$javascript->cache?'js-switch-checked':''}}" /> Javascript <br><br>
                        <div class="alert alert-info">
                            <p>Lưu ý: trình duyệt khách hàng sẽ luôn tải tài nguyên mới nhất từ website ở chế độ <b>không lưu cache</b> ( Chế độ dành cho nhà phát triển.)</p>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="version_css" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12"></label>
                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                        <div class="text-muted"><i class="fa fa-clock-o"></i> CSS Cập nhật lần cuối vào lúc <b>{{$css->updated_at}}</b></div>
                        <div class="text-muted"><i class="fa fa-clock-o"></i> Javascript Cập nhật lần cuối vào lúc <b>{{$css->updated_at}}</b></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="disable_cache" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12"></label>
                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Cập nhật</button>
                    </div>
                </div>



            </form>

        </div>
    </div>

</div>
@endsection