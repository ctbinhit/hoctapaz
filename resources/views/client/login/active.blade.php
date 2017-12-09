
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

        <div class="panel panel-default" style="width: 500px;margin: 0 auto;">
            <div class="panel-heading"><i class="fa fa-users"></i> Đăng ký thành công</div>
            <div class="panel-body">
                <p class="text-info">Một mail vừa được gửi vào hộp thư {{$user_email}} của bạn, vui lòng xác nhận để kích hoạt tài khoản trước 30p kể từ khi nhận được tin này</p>
            </div>
            <div class="panel-footer">
                <a href="{{route('client_index')}}" class="btn btn-default btn-xs"><i class="fa fa-home"></i> Trang chủ</a>
            </div>
        </div>

    </div>
</div>
@endsection