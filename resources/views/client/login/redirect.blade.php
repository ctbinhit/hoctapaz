
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
            <div class="panel panel-success" style="width: 500px;margin: 0 auto;">
                <div class="panel-heading"><i class="fa fa-spinner faa-spin animated"></i> Authenicate</div>
                <div class="panel-body">
                    
                    <div class="from-group">
                        <div class="" style="text-align: center;">
                            <img class="thumbnail" src="{{Session::get('user_tmp')['avatar']}}" 
                                 style="width:100px;height:100px;border-radius: 50%;margin: 0 auto;"/>
                        </div>
                        <div class="" style="text-align: center;">
                            <p class="text-info">Chào {{Session::get('user_tmp')['fullname']}}</p>
                        </div>
                    </div>

                    <div class="from-group">
                        <div class="col-md-10 col-sm-10 col-xs-6 col-md-offset-2">
                            <a href="{{route('client_login_index')}}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Quay lại</a>
                            <a href="{{route('client_login_accept')}}" class="btn btn-success">Tiếp tục với tư cách {{session('user_tmp')['fullname']}} <i class="fa fa-sign-in"></i></a>
                        </div><div class="clearfix"></div>
                    </div>
                </div>
                <div class="panel-footer">
                    <a href="#" class="btn btn-warning btn-xs">Đây không phải là tài khoản của bạn?</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection