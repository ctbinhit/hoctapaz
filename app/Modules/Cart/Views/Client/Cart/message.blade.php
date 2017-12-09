@extends('client.layouts.master')

@section('content')
<div class="row">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h1>Đơn hàng <small></small></h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 text-info col-md-offset-2">
                <div class="panel panel-success">
                    <div class="panel-heading"><i class="fa fa-shopping-cart"></i> Thông tin đơn hàng.</div>
                    <div class="panel-body">
                        <h4>Đơn hàng của bạn đã được gửi đi vào lúc <strong>{{$cart_info->created_at}}</strong></h4>

                        <p>
                            Bạn vừa đặt hàng thành công trên website học tập 
                            <strong><span class="main-color-second text-bold">A</span><span class="main-color-first text-bold">Z</span></strong>, mã đơn hàng của bạn là <b>{{$cart_info->id}}</b>,
                            chúng tôi sẽ xác nhận đơn hàng của bạn trong vòng 12h kể từ lúc đơn hàng được gửi đi
                        </p>
                        <p>Cảm ơn bạn đã tin tưởng và sử dụng dịch vụ.</p>
                    </div>
                    <div class="panel-footer">
                        <a href="{{route('client_index')}}" class="btn btn-default"><i class="fa fa-home"></i> Trang chủ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection