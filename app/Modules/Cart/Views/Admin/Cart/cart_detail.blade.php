
@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-shopping-cart"></i> Đơn hàng </h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="x_panel">
        <div class="x_content">
            <a href="{{route('mdle_admin_cart_index')}}" class="btn btn-app"><i class="fa fa-arrow-left"></i> Đơn hàng</a>
            <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Thông tin <small> khách hàng</small></h2> <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form class="form form-horizontal" method="post" action="{{route('_mdle_admin_cart_detail_cart_saved',$cart_info->id)}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="nameOfTheInput" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Tên:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                <input type="text" name="name" class="form-control" 
                                       value="{{$cart_info->name}}" placeholder="Họ và tên..." />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">SĐT Liên hệ:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                <input type="text" name="phone" class="form-control" 
                                       value="{{$cart_info->phone}}" placeholder="SĐT..." />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone2" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">SĐT dự phòng:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                <input type="text" name="phone2" class="form-control" 
                                       value="{{$cart_info->phone2}}" placeholder="SĐT dự phòng..." />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="method" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Phương thức:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                <input type="text" name="method" class="form-control" 
                                       value="{{$cart_info->method}}" placeholder="Phương thức thanh toán..." />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Địa chỉ nhận hàng:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                <input type="text" name="address" class="form-control" 
                                       value="{{$cart_info->address}}" placeholder="Địa chỉ nhận hàng..." />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="note" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Ghi chú:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                <textarea rows="5" name="note" class="form-control" 
                                          placeholder="Ghi chú...">{{$cart_info->note}}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="note" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Tình trạng:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                <select class="form-control" name="state">
                                    @foreach($list_state as $state)
                                    <option {{$state->id==$cart_info->state?'selected':''}} value="{{$state->id}}">{{$state->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="ln_solid"></div>

                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-2">
                                <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Cập nhật</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Giỏ hàng <small>danh sách sản phẩm trong giỏ hàng</small></h2> <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên SP</th>
                                <th>Đơn giá</th>
                                <th>SL</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart_dtail as $k=>$v)
                            <tr>
                                <td>{{$k+1}}</td>
                                <td>{{$v->product_name}}</td>
                                <td>{{number_format($v->product_net_price,0)}} VNĐ</td>
                                <td>{{$v->count}}</td>
                                <td>{{number_format($v->count*$v->product_net_price,0)}} VNĐ</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_content">
                    <a href="{{route('mdle_admin_cart_index')}}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Đơn hàng</a>
                    <a href="{{url()->full()}}" class="btn btn-default"><i class="fa fa-refresh"></i> Tải lại</a>
                    <a href="#" class="btn btn-danger"><i class="fa fa-remove"></i> Xóa đơn hàng</a>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection