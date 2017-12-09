@extends('client.layouts.master')

@section('content')
<input type="hidden" id="route_cart_ajax" value="{{route('mdle_client_order_ajax')}}"/>
<div class="row">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Giỏ hàng</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info jquery-jcc-alert-info">
                    <p><strong class="jquery-jcc-alert-title">Giỏ hàng!</strong> <span class="jquery-jcc-alert-text"></span></p>
                </div>
                <div class="jquery-jcc-table-wrap" style="position: relative;">
                    <div class="jquery-jcc-loading-state">
                        <div class="jquery-jcc-loading-state-content">
                            <i class="fa fa-spinner faa-spin animated"></i> Đang cập nhật...
                        </div>
                    </div>

                    <table class="table table-hover">
                        <thead class="th-center">
                            <tr>
                                <th>STT</th>
                                <th>Tên sản phẩm</th>
                                <th>Đơn giá</th>
                                <th style="width: 100px;">SL</th>
                                <th>Thành tiền</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="td-center jquery-jcc-content">

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="10">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <ul class="jquery-jcc-list-total">
                                                <li>Phí ship: <span>Miễn phí</span></li>
                                                <li>Tổng tiền: <span class="jquery-jcc-items-realPrice-sum">Đang tính...</span></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-10 text-right">
                                            <a href="{{route('client_index')}}" class="btn btn-default"><i class="fa fa-shopping-bag"></i> Tiếp tục mua hàng.</a>
                                            <button class="btn btn-primary jquery-jcc-btn-update"><i class="fa fa-refresh"></i> Cập nhật</button>
                                            <button class="btn btn-danger jquery-jcc-btn-dropCart"><i class="fa fa-trash"></i> Xóa giỏ hàng</button>
                                            <a href="{{route('mdle_cart_payment')}}" class="btn btn-success jquery-jcc-btn-payment"><i class="fa fa-credit-card"></i> Thanh toán</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                </div>

            </div>
            <div class="col-md-3">

            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        var JCC = {
            log: function (data) {
                if (JCC.debug) {
                    console.log(data);
                }
            },
            debug: true,
            showAlert: function (msg, type = 'info', title = 'Giỏ hàng!', autoClose = true) {
                $(JCC.elements.alert.html).removeClass('alert-info alert-danger alert-primary alert-warning')
                        .addClass('alert-' + type);
                $(JCC.elements.alert.html).find('.jquery-jcc-alert-title').html(title);
                $(JCC.elements.alert.html).find('.jquery-jcc-alert-text').html(msg);
                $(JCC.elements.alert.html).slideDown();
                if (autoClose) {
                    setTimeout(function () {
                        $(JCC.elements.alert.html).slideUp();
                    }, 4000);
            }
            },
            elements: {
                table: null,
                alert: {
                    html: '.jquery-jcc-alert-info'
                },
                overlay: '.jquery-jcc-loading-state',
                cart_content: '.jquery-jcc-content',
                info: {
                    total_real_price: '.jquery-jcc-items-realPrice-sum'
                },
                input: {
                    item_count: '.jquery-jcc-productCount'
                },
                btn: {
                    remove_item: '.jquery-jcc-remove-item',
                    update_cart: '.jquery-jcc-btn-update',
                    drop_cart: '.jquery-jcc-btn-dropCart',
                    payment: '.jquery-jcc-btn-payment'
                }
            },
            state: {
                emptyCart: function () {
                    $(JCC.elements.btn.update_cart).fadeOut();
                    $(JCC.elements.btn.drop_cart).fadeOut();
                    $(JCC.elements.btn.payment).fadeOut();
                },
                normal: function () {
                    $(JCC.elements.btn.update_cart).fadeIn();
                    $(JCC.elements.btn.drop_cart).fadeIn();
                    $(JCC.elements.btn.payment).fadeIn();
                }
            },
            init: function (id_table) {
                JCC.elements.table = id_table;
                JCC.registerEvent();
                JCC.action.loadCartHTML();
            },
            registerEvent: function () {
                JCC.events.dc();
                JCC.events.rc();
            },
            action: {
                loadCartHTML: function () {
                    $.ajax({
                        url: $('#route_cart_ajax').val(),
                        type: 'POST',
                        dataType: 'json',
                        beforeSend: function (xhr) {
                            $(JCC.elements.cart_content).hide();
                            $(JCC.elements.cart_content).html('<tr><td colspan="10"><i class="fa fa-spinner faa-spin animated"></i> Loading...</td></tr>');
                            $(JCC.elements.overlay).slideDown();
                        },
                        data: {
                            act: 'html_cart'
                        }, success: function (data) {
                            JCC.log(data);
                            $(JCC.elements.cart_content).html(data.html);
                            $(JCC.elements.cart_content).slideDown();
                            if (data.state) {
                                if (data.isEmpty) {
                                    JCC.state.emptyCart();
                                } else {
                                    JCC.state.normal();
                                    JCC.events.ri();
                                    JCC.showAlert('Đơn hàng của bạn đã được cập nhật.');
                                }
                                $(JCC.elements.info.total_real_price).html(data.sum_text);
                            } else {

                            }
                        }, error: function (data) {
                            JCC.log(data);
                        }, complete: function () {
                            $(JCC.elements.overlay).slideUp();
                        }
                    });
                },
                uc: function () { // Update Cart
                    var data = $(JCC.elements.input.item_count);
                    var form_data = [];
                    $.each(data, function (k, v) {
                        var code = $(v).parents('tr').data('code');
                        var ic = $(v).val();
                        form_data.push({c: code, q: ic});
                    });
                    $.ajax({
                        url: $('#route_cart_ajax').val(),
                        type: 'POST',
                        beforeSend: function (xhr) {
                            $(JCC.elements.cart_content).hide();
                            $(JCC.elements.cart_content)
                                    .html('<tr><td colspan="10"><i class="fa fa-spinner faa-spin animated"></i> Loading...</td></tr>');
                            $(JCC.elements.overlay).slideDown();
                        },
                        dataType: 'json',
                        data: {
                            act: 'update_quanlity',
                            data: form_data
                        }, success: function (data) {
                            JCC.log(data);
                            $(JCC.elements.cart_content).html(data.html);
                            $(JCC.elements.cart_content).slideDown();
                            if (data.isEmpty) {
                                JCC.state.emptyCart();
                            } else {
                                JCC.state.normal();
                                JCC.events.ri();
                                JCC.showAlert('Đơn hàng của bạn đã được cập nhật.');
                            }
                            $(JCC.elements.info.total_real_price).html(data.sum_text);
                        }, error: function (data) {
                            JCC.log(data);
                        }, complete: function () {
                            $(JCC.elements.overlay).slideUp();

                        }
                    });

                },
                ri: function (item_code, btn) {
                    $.ajax({
                        url: $('#route_cart_ajax').val(),
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            act: '0f6969d7052da9261e31ddb6e88c136e',
                            code: item_code
                        }, success: function (data) {
                            if (data.state) {
                                $(btn).parents('tr').addClass('animated fadeOutLeftBig');
                                JCC.showAlert('Xóa thành công!');
                                setTimeout(function () {
                                    $(btn).parents('tr').remove();
                                }, 500);
                                JCC.action.loadCartHTML();
                            } else {
                                $(btn).removeClass('fa-spinner faa-spin animated').addClass('fa fa-warning');
                                $.alert({
                                    title: 'Giỏ hàng!',
                                    content: 'Có lỗi xảy ra, không thể xóa sản phẩm này.',
                                });
                            }
                            JCC.log(data);
                        }, error: function (data) {
                            JCC.log(data);
                        }
                    });
                },
                rc: function () {
                    $.ajax({
                        url: $('#route_cart_ajax').val(),
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            act: 'update',
                            data: ''
                        }, success: function (data) {
                            JCC.log(data);
                        }, error: function (data) {
                            JCC.log(data);
                        }
                    });
                },
                dc: function () {
                    $.post($('#route_cart_ajax').val(),{act: '6e9d25362c485bc3c90c818dfac5dc49'});
                    JCC.action.loadCartHTML();
                }
            },
            events: {
                rc: function () {
                    $(JCC.elements.btn.update_cart).on('click', function () {
                        JCC.action.uc();
                    });
                },
                ri: function () {
                    $(JCC.elements.btn.remove_item).on('click', function () {
                        var this_btn = this;
                        var tr = $(this).parents('tr');
                        var item_code = $(tr).data('code');
                        var item_name = $(tr).data('name');
                        $.confirm({
                            title: 'Xóa sản phẩm!',
                            content: 'Bạn muốn xóa ' + item_name + ' ra khỏi giỏ hàng?',
                            buttons: {
                                confirm: {
                                    text: 'Xóa ngay',
                                    keys: ['enter'],
                                    btnClass: 'btn btn-danger',
                                    action: function () {
                                        JCC.action.ri(item_code, this_btn);
                                        $(this_btn).find('i').removeClass('fa-trash').addClass('fa-spinner faa-spin animated');
                                        $(this_btn).attr('disabled', '');
                                        JCC.action.loadCartHTML();
                                    }
                                },
                                cancel: {
                                    keys: ['esc'],
                                    btnClass: 'btn btn-default',
                                    text: 'Hủy',
                                    action: function () {
                                        return;
                                    }
                                }
                            }
                        });
                    });
                },
                // DROP CART
                dc: function () {
                    $(JCC.elements.btn.drop_cart).on('click', function () {
                        $.confirm({
                            title: 'Xóa xóa giỏ hàng!',
                            content: 'Bạn có muốn xóa toàn bộ sản phẩm trong giỏ hàng?',
                            buttons: {
                                confirm: {
                                    text: 'Xóa ngay',
                                    keys: ['enter'],
                                    btnClass: 'btn btn-danger',
                                    action: function () {
                                        JCC.action.dc();
                                    }
                                },
                                cancel: {
                                    keys: ['esc'],
                                    btnClass: 'btn btn-default',
                                    text: 'Hủy',
                                    action: function () {
                                        return;
                                    }
                                }
                            }
                        });
                    });
                }
            }

        };


        JCC.init();
    });
</script>
@endpush