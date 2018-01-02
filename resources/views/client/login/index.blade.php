
@extends('client.layouts.master')

@section('content')
<style>
    .panel{
        margin-bottom: 10px !important;
    }
    .form{
        margin-bottom: 10px !important;
    }
    .form-horizontal .from-group{
        margin-bottom: 10px !important;
    }
</style>
<div class="clearfix"></div>
<div class="row">
    <div class="container">
        <form class="form form-horizontal" name="frm_login" action="" method="POST">
            <div class="panel panel-default" style="width: 500px;margin: 0 auto;">
                <div class="panel-heading"><i class="fa fa-users"></i> Đăng nhập</div>
                <div class="panel-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    {{ csrf_field() }}
                    <div class="from-group">
                        <label class="control-label col-md-2 col-sm-4 col-xs-12"><i class="fa fa-user"></i></label>
                        <div class="col-md-10 col-sm-8 col-xs-12">
                            <input type="text" class="form-control" name="username" placeholder="Tên đăng nhập..."/>
                        </div><div class="clearfix"></div>
                    </div>

                    <div class="from-group">
                        <label class="control-label col-md-2 col-sm-4 col-xs-12"><i class="fa fa-unlock-alt"></i></label>
                        <div class="col-md-10 col-sm-8 col-xs-12">
                            <input type="password" class="form-control" name="password" placeholder="Mật khẩu..."/>
                        </div><div class="clearfix"></div>
                    </div>


                    <div class="from-group">
                        <div class="col-md-10 col-sm-10 col-xs-6 col-md-offset-2">
                            <button type="submit" class="btn btn-default"><i class="fa fa-sign-in faa-tada animated-hover"> Đăng nhập </i></button>
                            <div class="pull-right">
                                <a href="{{route('client_login_with','facebook')}}" class="btn btn-primary btn-xs"><i class="fa fa-facebook"></i> Facebook</a> |
                                <a href="{{route('client_login_with','google')}}" class="btn btn-danger btn-xs"><i class="fa fa-google-plus"></i> Google+</a>
                            </div>
                        </div><div class="clearfix"></div>
                    </div>
                </div>
                <div class="panel-footer">
                    <a href="{{route('client_login_signup')}}" class="btn btn-primary btn-xs"><i class="fa fa-user-plus"></i> Đăng ký</a>
                    <a href="#" class="btn btn-danger btn-xs">Quên mật khẩu?</a>
                    <a target="_blank" href="{{route('client_index_articleo','dieu-khoan-dang-ky')}}" class="btn btn-warning btn-xs"><i class="fa fa-book"></i> Điều khoản đăng ký</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection