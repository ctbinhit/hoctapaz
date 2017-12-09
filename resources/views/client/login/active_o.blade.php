
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

        <div class="panel panel-{{$message_type}}" style="width: 500px;margin: 0 auto;">
            <div class="panel-heading"><i class="fa fa-users"></i> {{$title}}</div>
            <div class="panel-body">
                <p class="text-info">{{$message}}</p>
            </div>
            <div class="panel-footer">
                <a href="{{route('client_index')}}" class="btn btn-default btn-xs"><i class="fa fa-home"></i> Trang chủ</a>
                @if($message_type=='success')
                <a href="{{route('client_login_index')}}" class="btn btn-default btn-xs"><i class="fa fa-sign-in"></i> Đăng nhập</a>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection