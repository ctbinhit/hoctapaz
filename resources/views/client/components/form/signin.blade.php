<form class="form form-horizontal" action="{{$action}}" method="POST">
    {{csrf_field()}}
    @isset($cwr)
    <input type="hidden" name="cwr" value="{{$cwr}}" />
    @endisset
    <div class="form-group">
        <label for="username" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Tên đăng nhập:</label>
        <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
            <input type="text" name="username" id="username" class="form-control" placeholder="Tên đăng nhập..." />
        </div>
    </div>

    <div class="form-group">
        <label for="password" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Mật khẩu:</label>
        <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
            <input type="password" name="password" id="password" class="form-control" placeholder="Mật khẩu..." />
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 col-md-offset-2">
            <a href="{{route('client_index')}}" class="btn btn-default"><i class="fa fa-home"></i> Trang chủ</a>
            <button type="submit" class="btn btn-success"><i class="fa fa-sign-in"></i> Đăng nhập</button>
        </div>
    </div>

</form>