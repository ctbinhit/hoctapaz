@extends('client.layouts.master')

@section('content')
<div class="row">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Thanh toán</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h3>Thông tin giao hàng</h3>
                @if(!UserService::isLoggedIn())
                <div class="alert alert-warning">
                    <p><strong>Thông báo!</strong> Bạn chưa đăng nhập vào hệ thống 
                        <strong><span class="main-color-second text-bold">A</span><span class="main-color-first text-bold">Z</span></strong>, vui lòng đăng nhập
                        để nhận được điểm tích lũy và có thể theo dõi đơn hàng 1 cách dễ dàng.</p>
                    <p>Nếu bạn chưa có tài khoản thì bấm vào <a href="{{route('client_login_signup')}}" class="label label-info">đây</a> để đăng ký. (Miễn phí)</p>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading"><i class="fa fa-sign-in"></i> Đăng nhập</div>
                    <div class="panel-body">
                        <form class="form form-horizontal" method="POST" action="{{route('_client_login_index')}}">
                            {{csrf_field()}}
                            <input type="hidden" name="cwr" value="{{url()->full()}}">

                            <div class="form-group">
                                <label for="username" class="control-label col-lg-4 col-md-4 col-sm-3 col-xs-12">Tên đăng nhập:</label>
                                <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12">
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Tên đăng nhập..." />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="control-label col-lg-4 col-md-4 col-sm-3 col-xs-12">Mật khẩu:</label>
                                <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12">
                                    <input type="password" name="password" id="username" class="form-control" placeholder="Mật khẩu..." />
                                </div>
                            </div>
                            @if(Session::has('html_callback'))
                            <div class="form-group">
                                <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12 col-md-offset-4">
                                    <p class="text-{{Session('html_callback')->message_type}}">{{Session('html_callback')->message}}</p>
                                </div>
                            </div>
                            @endif

                            <div class="form-group">
                                <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12 col-md-offset-4">
                                    <button type="submit" class="btn btn-success">Đăng nhập</button>
                                    <a href="javascript:void(0)" class="links"> Quên mật khẩu?</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @else

                <form class="form form-horizontal" name="frm_payment_info" id="frm_payment_info" method="POST" onsubmit="return false;" action="">

                    <div class="form-group">
                        <label for="nameOfTheInput" class="control-label col-lg-4 col-md-4 col-sm-3 col-xs-12">Họ và tên:</label>
                        <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12">
                            <input type="text" name="txt_hovaten" class="form-control" value="{{$ui->fullname}}" placeholder="Họ và tên..."/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nameOfTheInput" class="control-label col-lg-4 col-md-4 col-sm-3 col-xs-12">Địa chỉ giao hàng:</label>
                        <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12">
                            <input type="text" name="txt_diachi" class="form-control" value="{{$ui->address}}" placeholder="Địa chỉ giao hàng..." />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="control-label col-lg-4 col-md-4 col-sm-3 col-xs-12">Email:</label>
                        <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12">
                            <input type="text" name="txt_email" class="form-control" value="{{$ui->email}}" placeholder="Email người đặt..." />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nameOfTheInput" class="control-label col-lg-4 col-md-4 col-sm-3 col-xs-12">SĐT:</label>
                        <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12">
                            <input type="text" name="txt_phone" class="form-control" value="{{$ui->phone}}" placeholder="Số điện thoại..." />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nameOfTheInput" class="control-label col-lg-4 col-md-4 col-sm-3 col-xs-12">SĐT dự phòng:</label>
                        <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12">
                            <input type="text" name="txt_phone2" class="form-control" placeholder="Điện thoại dự phòng (Nếu có)..." />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nameOfTheInput" class="control-label col-lg-4 col-md-4 col-sm-3 col-xs-12">Ghi chú:</label>
                        <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12">
                            <textarea class="form-control" name="txt_note" rows="4" 
                                      placeholder="Viết 1 vài ghi chú cho shipper hoặc quản trị, vd: Nhà bạn gần trường học, bệnh viện..."></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nameOfTheInput" 
                               class="control-label col-lg-4 col-md-4 col-sm-3 col-xs-12">Hình thức thanh toán:</label>
                        <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12">
                            <input type="radio" name="httt" value="993da28babb425eca88aca91184c752e" checked> Thanh toán khi nhận hàng. <br>
                            <input type="radio" name="httt" value="07d5b024ba9a8a78210f3df6f07db0fe"> Thanh toán bằng ví 
                            <span class="main-color-second text-bold">A</span><span class="main-color-first text-bold">Z</span>. 
                            <span class="label label-info">bạn có {{number_format($ui->coin,0)}} VNĐ</span><br>
                            <input type="radio" name="httt" value="97b01ce40e54ca5bc2c9da5e2ad58e75" disabled=""> Thanh toán bằng thẻ ngân hàng. (Đang bảo trì)
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <a href="{{route('mdle_cart_index')}}" class="btn btn-default">
                                <i class="fa fa-arrow-left"></i> Quay lại, mua thêm.</a>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> <span>Đặt ngay</span></button>
                        </div>
                    </div>
                </form>
                <script>
                    $(document).ready(function () {
                        var PaymentController = {
                            request: {
                                url: '{{route("mdle_client_order_ajax")}}'
                            },
                            debug: true,
                            log: function (data) {
                                if (PaymentController.debug) {
                                    console.log(data);
                                }
                            },
                            elements: {
                                form: null
                            },
                            init: function (form) {
                                PaymentController.elements.form = form;
                                PaymentController.registerEvent.form_submit();
                            },
                            state: {
                                form_uploading: function () {
                                    $(PaymentController.elements.form).find('input').attr('disabled', '');
                                    $(PaymentController.elements.form).find('textarea').attr('disabled', '');
                                    $(PaymentController.elements.form).find('button').attr('disabled', '');

                                    $(PaymentController.elements.form)
                                            .find('button[type="submit"]')
                                            .find('i')
                                            .removeClass('fa-check')
                                            .addClass('fa-spinner faa-spin animated')
                                            .attr('disabled', '')
                                            .parent()
                                            .find('span')
                                            .html('Đang xử lý...');
                                },
                                form_default: function () {
                                    $(PaymentController.elements.form).find('input').removeAttr('disabled', '');
                                    $(PaymentController.elements.form).find('textarea').removeAttr('disabled', '');
                                    $(PaymentController.elements.form).find('button').removeAttr('disabled', '');
                                    $(PaymentController.elements.form)
                                            .find('button[type="submit"]')
                                            .find('i')
                                            .removeClass('fa-spinner faa-spin animated')
                                            .addClass('fa-check')
                                            .removeAttr('disabled', '');
                                    $(PaymentController.elements.form)
                                            .find('button[type="submit"]').find('span').html('Thanh toán');
                                }
                            },
                            action: {
                                paying: function (form_data) {
                                    $.ajax({
                                        url: PaymentController.request.url,
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            act: '312af04ac0d72c5df7796032f508d3dc',
                                            data: form_data
                                        }, success: function (data) {
                                            var timeDelay = 0;
                                            if ( typeof  (data.redirect_delay) != 'undefined') {
                                                timeDelay = data.redirect_delay;
                                            }
                                            if (data.state) {
                                                $.alert({
                                                    title: 'Đơn hàng của bạn đã được đặt thành công!',
                                                    content: data.message
                                                });
                                                setTimeout(function () {
                                                   window.location.assign(data.redirect);
                                                }, timeDelay);
                                            } else {
                                                $.alert({
                                                    title: 'Thông báo!',
                                                    content: data.message,
                                                    buttons: {
                                                        cancel: {
                                                            text: 'OK',
                                                            btnClass: 'btn btn-default',
                                                            keys: ['enter','esc']
                                                        },
                                                        somethingElse:{
                                                            text : 'Nạp thêm',
                                                            btnClass: 'btn btn-primary',
                                                            keys: ['n'],
                                                            action: function(){
                                                                window.location.assign('{{route("mdle_bkp_napthe")}}');
                                                            }
                                                        }
                                                    }
                                                });
                                                PaymentController.state.form_default();
                                            }
                                            PaymentController.log(data);
                                        }, error: function (data) {
                                            $.alert({
                                                title: 'Lỗi hệ thống!',
                                                content: 'Có lỗi xảy ra trong quá trình xử lý đơn hàng!'
                                            });
                                            PaymentController.log(data);
                                        }, complete: function(){
                                            
                                        }
                                    });
                                }
                            },
                            registerEvent: {
                                form_submit: function () {
                                    $(PaymentController.elements.form).on('submit', function (e) {
                                        e.preventDefault();
                                        var form_data = $(PaymentController.elements.form).serializeArray();
                                        PaymentController.state.form_uploading();
                                        PaymentController.action.paying(form_data);
                                        PaymentController.log(form_data);
                                    });
                                }
                            }
                        };
                        PaymentController.init('#frm_payment_info');
                    });
                </script>

                @endif

            </div>
            <div class="col-md-6">
                <h3>Thông tin đơn hàng</h3>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên SP</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(array_except($ci,'sum') as $k=>$item)
                        <tr>
                            <td>{{$k+1}}</td>
                            <td>{{$item->product_name}}</td>
                            <td>{{number_format($item->product_real_price,0)}} VNĐ</td>
                            <td>{{$item->product_count}}</td>
                            <td class="main-color-second">{{number_format($item->total,0)}} VNĐ</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="10">
                                <p>Tổng tiền: <b class="main-color-first">{{number_format($ci['sum'],0)}}</b> VNĐ</p>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection