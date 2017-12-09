@extends('pi.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>User</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-3">
            @include('pi.info.parts.nav_left')
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Bảo mật <small> Mật khẩu...</small></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <form action="" class="form form-horizontal">
                                <div class="form-group">
                                    <label for="password_old" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Mật khẩu cũ:</label>
                                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                        <input type="password" name="password_old" id="password_old" class="form-control" placeholder="Mật khẩu cũ..." />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password_old" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Mật khẩu mới:</label>
                                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                        <input type="password" name="password_old" id="password_old" class="form-control" placeholder="Mật khẩu mới..." />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password_old" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Nhập lại mật khẩu:</label>
                                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                        <input type="password" name="password_old" id="password_old" class="form-control" placeholder="Nhập lại MK mới..." />
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 col-lg-offset-2 col-md-offset-2 col-sm-offset-3">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Cập nhật</button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Bảo mật 2 lớp (Đang bảo trì) <small> Đăng nhập bằng cách xác thực từ email, sđt</small></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <form action="" method="POST" onsubmit="return false;" class="form form-horizontal">
                                <div class="alert alert-warning">
                                    <p><strong>Lưu ý: </strong> Sau khi kích hoạt chức năng <b>Bảo mật 2 lớp </b> bạn chỉ có thể đăng 
                                    nhập vào tài khoản khi có mã số xác thực được hệ thống gửi vào hòm thư điện tử của bạn mỗi lần truy cập.</p>
                                    <p>Điều kiện áp dụng: bạn phải xác thực email với tài khoản mới có thể áp dụng chức năng này.</p>
                                    <p>Mọi thắc mắc vui lòng liên hệ <b>Quản trị viên</b> để được hỗ trợ.</p>
                                </div>
                                <div class="form-group">
                                    <label for="password_old" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Email xác thực:</label>
                                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                        <input type="text" name="email" id="password_old" class="form-control" placeholder="Email..." />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password_old" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Bật/Tắt:</label>
                                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                        <input type="checkbox" name="on_off" class="form-control js-switch" placeholder="Email..." />
                                    </div>
                                </div>

                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 col-lg-offset-2 col-md-offset-2 col-sm-offset-3">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Cập nhật</button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection