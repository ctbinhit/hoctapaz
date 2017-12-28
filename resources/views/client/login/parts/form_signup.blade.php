@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="from-group">
    <label class="control-label col-md-3 col-sm-4 col-xs-12">Họ và tên</label>
    <div class="col-md-9 col-sm-8 col-xs-12">
        <input type="text" class="form-control" name="fullname" placeholder="Họ và tên..." value="{{old('fullname')}}"/>
    </div>                             
    <div class="clearfix"></div>
</div>

<div class="from-group">
    <label class="control-label col-md-3 col-sm-4 col-xs-12">Tên đăng nhập</label>
    <div class="col-md-9 col-sm-8 col-xs-12">
        <input type="text" class="form-control" name="username" placeholder="Tên đăng nhập..." value="{{old('username')}}"/>
    </div><div class="clearfix"></div>
</div>

<div class="from-group">
    <label class="control-label col-md-3 col-sm-4 col-xs-12">Mật khẩu</label>
    <div class="col-md-9 col-sm-8 col-xs-12">
        <input type="password" class="form-control" name="password" placeholder="Mật khẩu..."/>
    </div><div class="clearfix"></div>
</div>

<div class="from-group">
    <label for="password_confirmation" class="control-label col-md-3 col-sm-4 col-xs-12">Nhập lại</label>
    <div class="col-md-9 col-sm-8 col-xs-12">
        <input type="password" class="form-control" name="password_confirmation" placeholder="Nhập lại mật khẩu..."/>
    </div><div class="clearfix"></div>
</div>

<div class="from-group">
    <label class="control-label col-md-3 col-sm-4 col-xs-12">Email</label>
    <div class="col-md-9 col-sm-8 col-xs-12">
        <input type="text" class="form-control" name="email" placeholder="Email..." value="{{old('email')}}"/>
    </div><div class="clearfix"></div>
</div>

@if(Session::has('html_callback'))
<div class="from-group">
    <div class="col-md-9 col-sm-8 col-xs-12 col-md-offset-3 col-sm-offset-4">
        <p class="text-{{Session::get('html_callback')->message_type}}">{{Session::get('html_callback')->message}}</p>
    </div>
</div>
@endif

<div class="from-group">
    <div class="col-md-9 col-sm-10 col-xs-6 col-md-offset-3">
        <a href="{{route('client_login_index')}}" class="btn btn-default">Quay lại <i class="fa fa-home"></i></a>
        <button type="submit" class="btn btn-success">Đăng ký <i class="fa fa-sign-in"></i></button>
    </div><div class="clearfix"></div>
</div>