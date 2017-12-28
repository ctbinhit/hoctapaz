
<!--<div class="text-center">
    {{$items->appends(['keywords'=>Request::get('keywords')])->links()}}
</div>-->

<div class="clearfix"></div>
@if(count($items)!=0)
@foreach($items as $k=>$v)
<div class="document">
    <div class="document-icon">
        <div class="document-overlay">
            <a href="javascript:;" class="ec5d24f67866733b071d02035313c839" data-id="{{$v->id}}">
                <div class="pan_buy">
                    <i class="fa fa-shopping-cart faa-ring animated"></i>
                    <div>MUA NGAY</div>
                </div>
            </a>
            <a href="javascript:;" data-name="{{$v->name}}" data-ud="{{$v->demo_url}}" data-toggle="modal" data-target="#fileDemoModal">
                <div class="pan_view">
                    <i class="fa fa-eye"></i>
                    <div>XEM THỬ</div>
                </div>
            </a>
        </div>
        <i class="fa fa-file-pdf-o fa-4x"></i>
    </div>
    <div class="document-info">
        <div class="document-title"><i class="fa fa-file-pdf-o"></i> {{ str_limit($v->name,35) }}</div>
        <ul class="document-info-list">
            <li><i class="fa fa-user"></i>: {{$v->fullname}}</li>
            <li><i class="fa fa-calendar"></i>: {{$v->approved_date}}</li>
            <li><i class="fa fa-file"></i>: {{$v->mimetype}}</li>
            <li><i class="fa fa-hdd-o"></i>: {{number_format($v->size/1024/1024,1)}} MB</li>
            <li><i class="fa fa-list"></i>: {{@$v->name_category}}</li>
        </ul>

        <div class="document-info-right">
            <i class="fa fa-eye"></i> 127
            <i class="fa fa-download"></i> 1654
            Giá: <b>{{$v->price!=0?number_format($v->price,0):'Miễn phí'}}</b> VNĐ
        </div>

        <div class="document-overlay">
            <div class="document-overlay-text">
                {!!$v->description!!}
            </div>
        </div>
    </div>
</div>
@endforeach
@else
<p><i class="fa fa-warning"></i> Chưa có dữ liệu</p>
@endif
<div class="clearfix"></div>
<div class="text-center">
    {{$items->appends(['keywords'=>Request::get('keywords')])->links()}}
</div>

<!-- MODAL -->
<div id="fileDemoModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Xem thử</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<!-- /MODAL -->
<script>
    $('#fileDemoModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var docName = button.data('name'); // Extract info from data-* attributes
        var docUrl = button.data('ud');
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-title').text('Demo ' + docName);
        modal.find('.modal-body').html('<iframe src="' + docUrl + '" style="width: 100%;height:350px"></iframe>');
    });
</script>

<script>
    $(document).ready(function () {
        var CDC = {
            route: {
                doc_ajax: $('#route_88139f72e980bea9f07063f743ca523c').val(),
                login_page: $('#route_2b6d400505e8748c2023d88237027ce0').val(),
                donate_page: $('#route_c435030c8b679bd6112cb53d9b275cd1').val()
            },
            elements: {
                btn: {
                    payment: '.ec5d24f67866733b071d02035313c839'
                }
            },
            init: function () {
                CDC.registerEvents.all();
            },
            registerEvents: {
                all: function () {
                    $(CDC.elements.btn.payment).on('click', function () {
                        var this_btn = this;
                        $(this_btn).find('i').addClass('fa-spinner faa-spin')
                                .removeClass('fa-shopping-cart faa-bounce').off('click');
                        var id = $(this).data('id');
                        $.ajax({
                            url: CDC.route.doc_ajax,
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                act: '88139f72e980bea9f07063f743ca523c',
                                id: id
                            }, success: function (response) {
                                if (response.is_logged_in) {
                                    if (response.response_state) {
                                        CDC.redirect.payment(response);
                                    } else {
                                        CDC.redirect.donate(response);
                                    }
                                } else {
                                    CDC.redirect.login(response);
                                }
                            }, error: function (response) {

                            }, complete: function () {
                                $(this_btn).find('i').removeClass('fa-spinner faa-spin')
                                        .addClass('fa-shopping-cart faa-bounce').on('click');

                            }
                        });
                    });
                }
            },
            redirect: {
                login: function (response) {
                    $.confirm(jquery_confirm_options({
                        title: 'Thanh toán',
                        content: response.msg,
                        buttons: {
                            dangnhap: {
                                text: 'Đăng nhập', btnClass: 'btn btn-primary',
                                action: function () {
                                    window.open(CDC.route.login_page);
                                }
                            },
                            cancel: {
                                text: 'Thôi', btnClass: 'btn btn-default'
                            }
                        }
                    }));
                },
                donate: function (response) {
                    $.confirm(jquery_confirm_options({
                        title: 'Thanh toán',
                        content: response.msg,
                        buttons: {
                            naptien: {
                                text: 'Nạp ngay', btnClass: 'btn btn-primary',
                                action: function () {
                                    window.open(CDC.route.donate_page);
                                }
                            },
                            cancel: {
                                text: 'Thôi', btnClass: 'btn btn-default'
                            }
                        }
                    }));
                },
                payment: function (response) {
                    $.confirm(jquery_confirm_options({
                        title: 'Thanh toán',
                        content: response.view,
                        columnClass: 'col-md-6 col-md-offset-3',
                        buttons: {
                            confirm: {
                                text: 'Thanh toán', btnClass: 'btn btn-success',
                                action: function () {
                                    CDC.action.payment(response);
                                }
                            },
                            cancel: {
                                text: 'Thoát', btnClass: 'btn btn-default'
                            }
                        }
                    }));
                }
            },
            action: {
                payment: function (res) {
                    $.ajax({
                        url: CDC.route.doc_ajax,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            act: 'f83c2a85d972a89238f31296c63f0dbc',
                            id: res.file_id
                        }, success: function (response) {
                            if (response.response_state) {
                                $.confirm(jquery_confirm_options({
                                    title: 'Thông báo', type: 'blue',
                                    content: 'Thanh toán thành công.',
                                    buttons: {
                                        tailieudamua: {
                                            text: '<i class="fa fa-folder"></i> Tài liệu đã mua', btnClass: 'btn btn-primary',
                                            action: function () {
                                                window.location.href = $('#route_client_user_tailieudamua').val()
                                            }
                                        }
                                    }
                                }));
                            } else {
                                $.alert(jquery_alert_options({
                                    title: 'Thông báo', type: 'red',
                                    content: 'Thanh toán không thành công, vui lòng thử lại sau ít phút.'
                                }));
                            }
                        }, error: function (response) {
                        }
                    });
                }
            }
        };
        // ===== Init [Document Controller] =====
        CDC.init();
        // ======================================
    });
</script>