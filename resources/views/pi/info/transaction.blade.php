@extends('pi.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>User</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-3">
            @include('pi.info.parts.nav_left')
        </div>
        <div class="col-md-9">
            <div class="x_panel">
                <div class="x_title">
                    <h2>User <small> Lịch sử giao dịch</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="alert alert-info">
                        <p><strong><i class="fa fa-warning"></i> Thông báo</strong> Đang cập nhật...<p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection