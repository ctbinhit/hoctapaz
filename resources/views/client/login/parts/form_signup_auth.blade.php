@if(Session::has('tmp_signup_form'))
<div class="from-group">
    <div class="row">
        <div class="col-md-4 col-md-offset-3">
            <img src="{{Session::get('tmp_signup_form')->avatar}}" class="thumbnail"/>
        </div>
        <div class="col-md-8">

        </div>
    </div>
</div>

<input type="hidden" name="id_{{Session::get('tmp_signup_form')->auth}}"  value="{{Session::get('tmp_signup_form')->id}}"/>

<div class="from-group">
    <label class="control-label col-md-3 col-sm-4 col-xs-12">Họ và tên</label>
    <div class         ="col-md-9 col-sm-8 col-xs-12">
        <input type="text" class="form-control" name="fullname" placeholder="Họ và tên..." value="{{Session::get('tmp_signup_form')->fullname}}"/>
    </div>                             
    <div class="clearfix"></div>
</div>
@if(Session::get('tmp_signup_form')->email!=null)
<div class="from-group">
    <label class="control-label col-md-3 col-sm-4 col-xs-12">Tên đăng nhập</label>
    <div class="col-md-9 col-sm-8 col-xs-12">
        <input type="text" class="form-control" name="username" placeholder="Tên đăng nhập..." disabled="" value="{{Session::get('tmp_signup_form')->username}}"/>
    </div><div class="clearfix"></div>
</div>
@endif
<div class="from-group">
    <label class="control-label col-md-3 col-sm-4 col-xs-12">Mật khẩu</label>
    <div class="col-md-9 col-sm-8 col-xs-12">
        <input type="password" class="form-control" name="password" placeholder="Mật khẩu..."/>
    </div><div class="clearfix"></div>
</div>

<div class="from-group">
    <label class="control-label col-md-3 col-sm-4 col-xs-12">Nhập lại</label>
    <div class="col-md-9 col-sm-8 col-xs-12">
        <input type="password" class="form-control" name="password2" placeholder="Nhập lại mật khẩu..."/>
    </div><div class="clearfix"></div>
</div>
@if(Session::get('tmp_signup_form')->email!=null)
<div class="from-group">
    <label class="control-label col-md-3 col-sm-4 col-xs-12">Email</label>
    <div class="col-md-9 col-sm-8 col-xs-12">
        <input type="text" class="form-control" name="email" placeholder="Email..." disabled="" value="{{Session::get('tmp_signup_form')->email}}"/>
    </div><div class="clearfix"></div>
</div>
@endif

<div class="from-group">
    <div class="col-md-9 col-sm-10 col-xs-6 col-md-offset-3">
        <a href="{{route('client_login_index')}}" class="btn btn-default">Quay lại <i class="fa fa-home"></i></a>
        <button type="submit" class="btn btn-success">Đăng ký <i class="fa fa-sign-in"></i></button>
    </div><div class="clearfix"></div>
</div>
@else

<p class="text-warning">Vì lý do bảo mật bạn vui lòng xác thực đăng nhập lại để tiến hành bước tiếp theo! 
    <a class="btn btn-default btn-xs" href="{{route('client_login_index')}}">Đăng nhập <i class="fa fa-sign-in"></i></a></p>

@endif