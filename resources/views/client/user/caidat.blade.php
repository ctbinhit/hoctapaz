
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
                            <li><a href="javascript:void(0)">Cài đặt</a></li>
                        </ol>
                    </div>

                    <div class="col-md-12">
                        <form method="POST" action="" class="form form-horizontal">
                            {{ csrf_field() }}
                            <div class="panel panel-default">
                                <div class="panel-heading"><i class="fa fa-users"></i> Thông tin chung</div>
                                <div class="panel-body text-center">
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Tên hiển thị</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="fullname" value="{{$user->fullname}}" placeholder="Họ và tên"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-right">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Lưu</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-12">
                        <form method="POST" action="" class="form form-horizontal">
                            {{ csrf_field() }}
                            <div class="panel panel-default">
                                <div class="panel-heading"><i class="fa fa-users"></i> Thông tin tài khoản</div>
                                <div class="panel-body text-center">
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Tên đăng nhập</label>
                                        <div class="col-md-10">
                                            <input type="text" disabled="" class="form-control" name="username" value="{{$user->username}}" placeholder="username"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-2">Email</label>
                                        <div class="col-md-10">
                                            <input type="text" disabled="" class="form-control" name="email" value="{{$user->email}}" placeholder="Email"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-2">Mật khẩu cũ</label>
                                        <div class="col-md-10">
                                            <input type="password" class="form-control" name="pw" placeholder="Mật khẩu"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Mật khẩu mới</label>
                                        <div class="col-md-10">
                                            <input type="password" class="form-control" name="pw1" placeholder="Mật khẩu mới"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Nhập lại</label>
                                        <div class="col-md-10">
                                            <input type="password" class="form-control" name="pw2" placeholder="Nhập lại mật khẩu"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-right">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Lưu</button>
                                </div>
                            </div>
                        </form>
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