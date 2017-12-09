
@extends('client.layouts.master')

@section('content')
<div class="row user-wall">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('client.user.parts.nav_left')
            </div>

            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12">
                        <ol class="breadcrumb">
                            <li><a href="{{route('client_index')}}"><i class="fa fa-home"></i> Trang chủ</a></li>
                            <li><a href="{{route('client_user_info')}}"> Thông tin cá nhân</a></li>
                        </ol>
                    </div>
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"><i class="fa fa-user"></i> Thông tin cá nhân</div>
                            <div class="panel-body">
                                <p>Họ và tên: {{$user->fullname}}</p>
                                <p>Email: {{$user->email}}</p>
                                <p>Điện thoại: {{$user->phone}}</p>
                                <p>Giới tính: {{$user->gender}}</p>
                                <p>Ngày đăng ký: {{$user->created_at}}</p>
                            </div>
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="text-info">Thông tin cá nhân</p>
                                    </div>
                                    <div class="col-md-2 col-md-offset-4 text-right">
                                        <a href="{{route('client_user_caidat')}}" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> Chỉnh sửa</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection

@push('stylesheet')
<style>
    .personal-name{font-size: 16pt;text-align:center;color: #001D8D;font-weight:bold;}
</style>
@endpush