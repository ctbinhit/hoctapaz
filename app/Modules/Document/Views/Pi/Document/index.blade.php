@extends('pi.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-file-word-o"></i> Tài liệu </h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="x_panel">
        <a href="{{route('pi_index_index')}}" class="btn btn-app"><i class="fa fa-dashboard"></i> Dashboard</a>
        <a href="{{route('mdle_pi_doc_add',$type)}}" class="btn btn-app"><i class="fa fa-plus"></i> Thêm</a>
        <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>
        <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-trash"></i> Tài liệu đã xóa</a>
        <a href="{{route('mdle_pi_doc_approved',$type)}}" class="btn btn-app"><i class="fa entypo-shop"></i> Xem cửa hàng</a>
    </div>

    <div class="x_panel">
        <div class="x_title">
            <h2>Quản lý file</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 8%;"><i class="fa fa-sort-numeric-asc"></i></th>
                        <th>File</th>
                        <th>Size</th>
                        <th>Giá</th>
                        <th>Mimetype</th>
                        <th>Ngày đăng</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($items)!=0)
                    @foreach($items as $k=>$v)
                    <tr data-id="{{$v->id}}" data-name="{{$v->name}}" data-price="{{$v->price}}">
                        <td>
                            @if($v->state!=DocumentState::reject())
                            <input type="number" class="form-control jquery-ajaxField" name="ordinal_number" data-id="{{$v->id}}" value="{{$v->ordinal_number}}"/>
                            @endif
                        </td>
                        <td>{{$v->name}} <i class="fa fa-edit"></i></td>
                        <td>{{number_format($v->size/1024/1024,2)}} MB</td>
                        <td>{{number_format($v->price,0)}} VNĐ</td>
                        <td title="{{$v->mimetype}}">{{str_limit($v->mimetype,10)}}</td>
                        <td>{{diffInNow($v->created_at)}}<br>{{$v->created_at}}</td>
                        <td>
                            {!!$v->state_text!!}
                        </td>
                        <td>
                            @if($v->state==DocumentState::free())
                            <!-- Single button -->
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Thao tác <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="{{route('mdle_pi_doc_edit',[$type,$v->id])}}">
                                            <i class="fa fa-edit"></i> Chỉnh sửa</a></li>
                                    <li><a href="javascript:;" data-id="{{$v->id}}" class="jquery-btn-remove"><i class="fa fa-remove"></i> Xóa</a></li>
                                </ul>
                            </div>

                            <!-- Single button -->
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Đăng bán <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="javascript:;" data-type="tai-lieu-hoc" data-catename="Tài liệu học" class="jquery-btn-sendtoAdmin">
                                            <i class="fa fa-upload"></i> Tài liệu học</a></li>
                                    <li><a href="javascript:;" data-type="de-thi-thu" data-catename="Đề thi thử" class="jquery-btn-sendtoAdmin">
                                            <i class="fa fa-upload"></i> Đề thi thử</a></li>
                                </ul>
                            </div>
                            @endif
                            @if($v->state==DocumentState::reject())
                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-book"></i> Lý do?</button>
                            <button type="button" class="btn btn-default btn-sm jquery-hide-item"><i class="fa fa-eye"></i> Ẩn</button>
                            @endif
                            @if($v->state==DocumentState::pending())
                            <button type="button" class="btn btn-primary btn-sm jquery-btn-cancel-request"><i class="fa fa-remove"></i> Hủy yêu cầu</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr><td colspan="10">Không có dữ liệu.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
<input type="hidden" name="_mdle_doc_ajax" id="_mdle_doc_ajax" value="{{route('_mdle_pi_doc_ajax',$type)}}" />
@endsection

@push('stylesheet')
<link href="{{asset('public/plugins/icons/entypo/entypo.css')}}" rel="stylesheet"/>
@endpush

@push('scripts')
<script>
    $(document).ready(function () {
        $('.jquery-hide-item').on('click', function () {
            var this_tr = $(this).parents('tr');
            var id_item = $(this_tr).data('id');
            $.ajax({
                url: $('#_mdle_doc_ajax').val(),
                type: 'POST',
                dataType: 'json',
                data: {
                    act: 'hide',
                    id: id_item
                }, success: function (data) {
                    if (data.response_state) {
                        $(this_tr).slideUp();
                    } else {
                        $.alert(jquery_alert_options({
                            title: 'Thông báo', type: 'red',
                            content: 'Có lỗi xảy ra, vui lòng thử lại sau ít phút.'
                        }));
                    }
                }, error: function (data) {
                    console.log(data);
                }
            });
        })

        $('.jquery-ajaxField').ajaxField({on: 'blur', action: 'uf', table: 'files'});

        $('.jquery-btn-sendtoAdmin').on('click', function () {
            $(this_btn).off('click');
            var tr = $(this).parents('tr');
            var f_name = $(tr).data('name');
            var f_price = $(tr).data('price');
            var f_id = $(tr).data('id');
            var rt = $(this).data('type');
            var category_name = $(this).data('catename');
            var this_btn = this;
            $.confirm(jquery_confirm_options({
                title: 'Thông báo', autoClose: 'cancel|25000',
                content: 'Đăng bán tài liệu <b>' + f_name + '</b> với giá ' + f_price + ' VNĐ vào mục <b>' + category_name + '</b> ?<br> ' +
                        'File của bạn sẽ được kiểm duyệt, sau khi kiểm duyệt hoàn tất sẽ tự động được tải lên trang \n\
    chủ để bắt đầu kinh doanh.' +
                        '<br>Lưu ý: <br> \n\
    <i class="fa fa-circle"></i> Tài liệu sai sót về tên, danh mục sẽ được gửi yêu cầu chỉnh sửa.' +
                        '<br><i class="fa fa-circle"></i> Tài liệu vi phạm nghiêm trọng về điều khoản & chính sách\n\
                 sẽ bị xóa và không cần báo trước, tùy mức độ sẽ có mức xử lý khác nhau.',
                buttons: {
                    confirm: {
                        text: '<i class="fa fa-check"></i> Đồng ý điều khoản & Đăng ngay', btnClass: 'btn btn-primary',
                        action: function () {
                            $.ajax({
                                url: $('#_mdle_doc_ajax').val(),
                                type: 'POST',
                                beforeSend: function () {
                                    $(this_btn).find('i').removeClass('fa-upload').addClass('fa-spinner faa-spin animated');
                                },
                                dataType: 'json',
                                data: {
                                    act: 'sta',
                                    id: f_id,
                                    rt: rt
                                }, success: function (res) {
                                    if (res.response_state) {
                                        $.alert(jquery_alert_options({
                                            title: 'Thông báo',
                                            content: res.msg
                                        }));
                                        $(tr).slideUp();
                                    } else {
                                        $(this_btn).find('i').addClass('fa-upload').removeClass('fa-spinner faa-spin animated');
                                        $.alert(jquery_alert_options({
                                            title: 'Error!', type: 'red',
                                            content: res.response_text
                                        }));
                                    }

                                }, error: function (data) {

                                }, complete: function () {

                                }
                            });
                        }
                    },
                    cancel: {
                        text: 'Lúc khác.', btnClass: 'btn btn-default'
                    }
                }
            }));




            $(this_btn).on('click');
        });

        $('.jquery-btn-remove').on('click', function () {
            var id_item = $(this).data('id');
            var this_tr = $(this).parents('tr');
            $.confirm(jquery_confirm_options({
                title: 'Thông báo', autoClose: 'cancel|5000',
                content: 'Bạn có chắc muốn xóa file này?',
                buttons: {
                    confirm: {
                        text: 'Xóa ngay',
                        action: function () {
                            $.ajax({
                                url: $('#_mdle_doc_ajax').val(),
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    act: 'ri',
                                    id: id_item
                                }, success: function (data) {
                                    if (data.response_state) {
                                        $(this_tr).slideUp();
                                    } else {
                                        $.alert(jquery_alert_options({
                                            title: 'Thông báo',
                                            content: 'Không thể xóa file này, có lỗi xảy ra!',
                                        }));
                                    }
                                }, error: function (data) {

                                }
                            });
                        }
                    },
                    cancel: {
                        text: 'Hủy', action: function () {}
                    }
                }
            }));

        });

        $('.jquery-btn-cancel-request').on('click', function () {
            var id_item = $(this).data('id');
            var this_tr = $(this).parents('tr');
            $.confirm(jquery_confirm_options({
                title: 'Thông báo',
                content: 'Bạn có muốn hủy yêu cầu?, việc này đồng nghĩa với việc hủy bỏ việc đăng tải tài liệu này\n\
        kinh doanh trên trang chủ, bạn cần chờ 6h kể từ lúc hủy yêu cầu để được gửi đơn yêu cầu trở lại.',
                autoClose: 'cancel|15000',
                buttons: {
                    confirm: {
                        text: 'Hủy yêu cầu',
                        btnClass: 'btn btn-primary',
                        action: function () {
                            $.ajax({
                                url: $('#_mdle_doc_ajax').val(),
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    act: 'cr',
                                    id: id_item
                                }, success: function (data) {
                                    if (data.response_state) {
                                        window.location.reload();
                                    }
                                }, error: function (data) {
                                    console.log(data);
                                }
                            });
                        }
                    },
                    cancel: {
                        text: 'Quay lại',
                        btnClass: 'btn btn-default',
                    }
                }
            }));
        });

    });
</script>
@endpush