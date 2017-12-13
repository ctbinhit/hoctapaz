
@extends('client.layouts.master')

@section('content')
<div class="examonline">
    <div class="sup-nav">
        <a href="{{route('client_index')}}"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a> 
        <i class="fa fa-angle-double-right"></i>
        <a href="javascript:void(0)">Trở thành đối tác</a>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading"><i class="fa fa-info"></i> Trở thành đối tác</div>
                <div class="panel-body">
                    <h1 class="text-info"><i class="fa fa-check"></i> Trở thành đối tác | tăng thêm thu nhập!</h1>
                    @if(Session::has('state'))
                    <div class="alert alert-success">
                        <p><strong>Thông báo:</strong> Thông tin của bạn vừa được gửi thành công, chúng tôi sẽ liên hệ lại với bạn trong thời gian sớm nhất.</p>
                        <p>Thân.</p>
                        <p><a href="{{route('client_index')}}" class="btn btn-default"><i class="fa fa-home"></i> Trang chủ</a></p>
                    </div>
                    @else
                    <p>Vui lòng để lại email để có cơ hội trở thành đối tác của <i class="label label-info">hoctapaz.com.vn</i> <i class="fa fa-thumbs-up faa-bounce animated"></i></p>
                    <form class="form form-horizontal" action="{{route('_client_partner_index')}}" method="POST"> 
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="fullname" class="control-label col-md-2">Họ và tên: </label>
                            <div class="col-md-10">
                                <input type="text" name="fullname" id="fullname" placeholder="Họ và tên..."  class="form-control"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="control-label col-md-2">Email: </label>
                            <div class="col-md-10">
                                <input type="text" name="email" id="email" placeholder="Email..."  class="form-control"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone" class="control-label col-md-2">Số ĐT: </label>
                            <div class="col-md-10">
                                <input type="text" name="phone" id="phone" placeholder="SĐT..."  class="form-control"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-2">
                                <a target="_blank" href="{{route('client_index_articleo','dieu-khoan-doi-tac')}}" class="btn btn-warning btn-xs"><i class="fa fa-book"></i> Điều khoản & chính sách của đối tác</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-2">
                                <a href="{{route('client_index')}}" class="btn btn-default"><i class="fa fa-home"></i> Trang chủ</a>
                                <button type="submit" class="btn btn-success"><i class="fa fa-thumbs-up"></i> Đăng ký</button>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
                <div class="panel-footer">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection