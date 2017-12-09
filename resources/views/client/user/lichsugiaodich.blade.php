
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
                            <li><a href="javascript:void(0)">Lịch sử giao dịch</a></li>
                        </ol>
                    </div>
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"><i class="fa fa-users"></i> Lịch sử giao dịch</div>
                            <div class="panel-body text-center">
                                <i class="fa fa-spinner faa-spin animated"></i> Đang cập nhật...
                            </div>
                            <div class="panel-footer">

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