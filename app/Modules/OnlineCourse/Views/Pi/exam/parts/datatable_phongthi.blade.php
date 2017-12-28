@push('stylesheet')
<style>
    .table-effect tr{
        transition: 1s ease;
    }
    .table-effect th{
        text-align: center;
    }
    .table-effect tbody td{
        text-align: center;
    }
</style>
@endpush

@if(isset($items))
<table id="jquery-datatable-default" class="table table-bordered table-effect">
    <thead>
        <tr>
            <td><input class="jquery-icheck-all" data-items="item-select" type="checkbox"></td>
            <th data-toggle="tooltip" data-placement="top" title="Tên hiển thị">{{__('label.ten')}}</th>
            <th data-toggle="tooltip" data-placement="top" title="Danh mục"><i class="fa fa-list"></i></th>
            <th data-toggle="tooltip" data-placement="top" title="Thời gian thi"><i class="fa fa-clock-o"></i></th>
            <th data-toggle="tooltip" data-placement="top" title="Lượt thi"><i class="fa fa-users"></i></th>
            <th data-toggle="tooltip" data-placement="top" title="Ngày bắt đầu"><i class="fa fa-calendar"></i> Ngày đăng ký</th>
            <th data-toggle="tooltip" data-placement="top" title="Ngày hết hạn"><i class="fa fa-calendar"></i> Ngày hết hạn</th>
            <th data-toggle="tooltip" data-placement="top" title="Trạng thái"><i class="fa fa-check-circle-o"></i></th>
            <th>{{__('label.thaotac')}}</th>
        </tr>
    </thead>
    <tbody>
        @if(count($items)!=0)
        @foreach($items as $k=>$v)
        <tr id="jquery-icheck-{{$v->id}}" data-id="{{$v->id}}" data-name="{{$v->name}}" data-price="{{$v->price}}">
            <td style="text-align: center;">
                <input class="jquery-icheck item-select" data-id="{{$v->id}}" type="checkbox">
            </td>
            <td style="width: 30%;">{{$v->name}}</td>
            <td><i class="label label-info">{{$v->cate_name}}</i></td>
            <td><i class="label label-info">{{$v->time/60}} {{__('schools.phut')}}</div></td>
            <td><i class="label label-info">{{$v->total_users or 0}}</i></td>
            <td>{{diffInNow($v->created_at)}} <br>{{ Carbon\Carbon::parse($v->created_at)->format('d-m-Y h:i:s') }}</td>
            <td>{{diffInNow($v->expiry_date)}} <br>{{ Carbon\Carbon::parse($v->expiry_date)->format('d-m-Y h:i:s') }}</td>
            <td style="width: 10%;">
                @if($v->state==1)
                <p class="label label-success" data-toggle="tooltip" data-placement="top" title="Đã duyệt"><i class="fa fa-check-square"></i></p>
                @elseif($v->state==0)
                <p class="label label-primary" data-toggle="tooltip" data-placement="top" title="Đang chờ duyệt"><i class="fa fa-spinner faa-spin animated"></i></p>
                @elseif($v->state==-1)
                <p class="label label-danger" data-toggle="tooltip" data-placement="top" title="Đã bị từ chối"><i class="fa fa-remove"></i></p>
                @endif
            </td>
            <td style="width: 20%;">
                <!-- Single button -->
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Hành động <span class="caret"></span>
                    </button>
                    @if($v->state==1)
                    <ul class="dropdown-menu">
                        <li><a href="javascript:;" class="jquery-btn-viewExamDetail"><i class="fa fa-eye"></i> Xem chi tiết</a></li>
                        <li><a href="{{route('mdle_oc_pi_exam_score',$v->id)}}" class=""><i class="fa fa-bar-chart-o"></i> Kết quả thi</a></li>
                        <li><a href="javascript:;" class=""><i class="fa fa-clock-o"></i> Gia hạn</a></li>
                        <li><a href="javascript:;" class="jquery-btn-cancel"><i class="fa fa-remove"></i> Hủy phòng thi</a></li>
                    </ul>
                    @elseif($v->state==0)
                    <ul class="dropdown-menu">
                        <li><a href="javascript:;" class="jquery-btn-viewExamDetail"><i class="fa fa-eye"></i> Xem chi tiết</a></li>
                        <li><a href="javascript:;" class=""><i class="fa fa-clock-o"></i> Gia hạn</a></li>
                        <li><a href="javascript:;" class="jquery-btn-cancel"><i class="fa fa-remove"></i> Hủy yêu cầu</a></li>
                    </ul>
                    @elseif($v->state==-1)
                    <ul class="dropdown-menu">
                        <li><a href="javascript:;" class="jquery-btn-cancel"><i class="fa fa-eye"></i> Ẩn</a></li>
                    </ul>
                    @endif
                </div>
            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="10">{{__('message.khongcodulieu')}}</td>
        </tr>
        @endif

    </tbody> 
    @if(count($items)!=0)
    <tfoot>
        <tr>
            <td colspan="99">
                <div class="col-md-12">
                    {{$items->links()}}
                </div>
            </td>

        </tr>
    </tfoot>
    @endif

</tbody> 

</table>
<input type="hidden" id="_mdle_oc_pi_exam_ajax" value="{{route('_mdle_oc_pi_exam_ajax')}}" />
@endif

@push('scripts')
<!-- Change display count -->
<script>
    $(document).ready(function () {
        $('.jquery-display-count').on('change', function () {
            $(this).parents('form').submit();
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('.jquery-icheck-all').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });

        $('.jquery-icheck-all').on('ifChecked', function (event) {
            var items = $('.' + $(this).data('items'));
            $(items).iCheck('check');
        }).on('ifUnchecked', function (event) {
            var items = $('.' + $(this).data('items'));
            $(items).iCheck('uncheck');
        });

        $('.jquery-icheck').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>

<script>
    $(document).ready(function () {

        var PEC = {
            route: {
                pi_exam_ajax: $('#_mdle_oc_pi_exam_ajax').val()
            },
            initialize: function () {
                // ===== REGISTER EVENTS ===============================================================================
                PEC.register.events.buttons.button_remove('.jquery-btn-removeExam');
                PEC.register.events.buttons.button_viewDetail('.jquery-viewExamDetail');
                PEC.register.events.buttons.button_createExamOnline('.jquery-btn-createExamMode1');
                PEC.register.events.buttons.button_createExamOnlineTest('.jquery-btn-createExamMode2');
                PEC.register.events.buttons.button_createExamOnlineCustomMode('.jquery-btn-createExamMode3');
            },
            helper: {
                find_tr: function ($object) {
                    return $($object).parents('tr');
                }
            },
            core: {
                func_779b: function ($button) {
                    var tr = PEC.helper.find_tr($button);
                    $.ajax({
                        url: PEC.route.pi_exam_ajax,
                        type: 'POST',
                        beforeSend: function () {

                        },
                        dataType: 'json',
                        data: {
                            act: '779b01b6ac7f4d64459a3e1f52c0e90f',
                            id: $(tr).id
                        }, success: function (res) {
                            if (res.response_state) {
                                $(tr).slideUp();
                            } else {
                                $.alert(jquery_alert_options({
                                    title: 'Thông báo',
                                    content: 'Có lỗi xảy ra trong quá trình thao tác, vui lòng thử lại sau.'
                                }));
                            }
                        }, error: function (res) {
                        }
                    });
                },
                func_6144($button) {
                    var tr = PEC.helper.find_tr($button);
                    $.ajax({
                        url: PEC.route.pi_exam_ajax,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            act: 'e1e9130e17e60b2dce990bea6bb0c5da',
                            id: $(tr).data('id')
                        }, success: function (res) {
                            if (res.response_state) {
                                $(tr).slideUp();
                            } else {
                                $.alert(jquery_alert_options({
                                    title: 'Thông báo',
                                    content: 'Có lỗi xảy ra trong quá trình thao tác, vui lòng thử lại sau.'
                                }));
                            }
                        }, error: function (data) {
                            console.log(data);
                        }
                    });
                },
                func_387b: function ($button) {
                    var tr = PEC.helper.find_tr($button);
                    $.ajax({
                        url: PEC.route.pi_exam_ajax,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            act: '5efd453f68aac1ffc4156e76a7aebdfa',
                            id: $(tr).data('id')
                        }, success: function (res) {
                            if (res.response_state) {
                                $(tr).slideUp();
                            } else {
                                $.alert(jquery_alert_options({
                                    title: 'Thông báo',
                                    content: 'Có lỗi xảy ra trong quá trình thao tác, vui lòng thử lại sau.'
                                }));
                            }
                        }, error: function (data) {
                            console.log(data);
                        }
                    });
                },
                func_af08: function ($button) {
                    var tr = PEC.helper.find_tr($button);
                    $.ajax({
                        url: PEC.route.pi_exam_ajax,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            act: 'c98b5521a0f9123f84e93c16a12b5b2c',
                            id: $(tr).data('id')
                        }, success: function (res) {
                            if (res.response_state) {
                                $(tr).slideUp();
                            } else {
                                $.alert(jquery_alert_options({
                                    title: 'Thông báo',
                                    content: 'Có lỗi xảy ra trong quá trình thao tác, vui lòng thử lại sau.'
                                }));
                            }
                        }, error: function (data) {
                            console.log(data);
                        }
                    });
                }

            },
            register: {
                events: {
                    buttons: {
                        button_remove: function ($element) {
                            $($element).on('click', function () {

                                var tr______ = $(this).parents('tr');
                                var this_btn = this;
                                var app_id__ = $(tr______).data('name');
                                var app_name = $(tr______).data('name');
                                var app_pric = $(tr______).data('name');

                                $.confirm(jquery_confirm_options({
                                    title: 'Xóa', icon: 'fa fa-warning', autoClose: 'cancel|10000',
                                    content: 'Bạn có muốn xóa app <b>' + app_name + '</b> ?',
                                    buttons: {
                                        confirm: {
                                            text: 'Xóa ngay', btnClass: 'btn btn-danger',
                                            action: function () {
                                                PEC.core.func_779b(this_btn);
                                            }
                                        },
                                        cancel: {
                                            text: 'Hủy', btnClass: 'btn btn-default'
                                        }
                                    }
                                }));
                            });
                        },
                        button_viewDetail: function ($element) {

                        },
                        button_createExamOnline: function ($element) {
                            $($element).on('click', function () {
                                var tr______ = $(this).parents('tr');
                                var this_btn = this;
                                var app_id__ = $(tr______).data('name');
                                var app_name = $(tr______).data('name');
                                var app_pric = $(tr______).data('name');

                                $.confirm(jquery_confirm_options({
                                    title: 'Tạo phòng thi online', icon: 'fa fa-warning', autoClose: 'cancel|10000',
                                    content: 'Bạn có muốn chuyển <b>' + app_name + '</b> vào phòng thi ?, Bài thi sẽ được duyệt trong vòng 6h kể từ lúc gửi đi.\n\
                                                 <br> Nếu bài thi hợp lệ sẽ tự động được đưa vào trạng thái kinh doanh.',
                                    buttons: {
                                        confirm: {
                                            text: 'Gửi yêu cầu & tạo phòng thi.', btnClass: 'btn btn-primary',
                                            action: function () {
                                                PEC.core.func_6144(this_btn);
                                            }
                                        },
                                        cancel: {
                                            text: 'Hủy', btnClass: 'btn btn-default'
                                        }
                                    }
                                }));
                            });
                        },
                        button_createExamOnlineTest: function ($element) {
                            $($element).on('click', function () {
                                var tr______ = $(this).parents('tr');
                                var this_btn = this;
                                var app_id__ = $(tr______).data('name');
                                var app_name = $(tr______).data('name');
                                var app_pric = $(tr______).data('name');

                                $.confirm(jquery_confirm_options({
                                    title: 'Đề thi thử.', icon: 'fa fa-warning', autoClose: 'cancel|10000',
                                    content: 'Bạn có muốn chuyển <b>' + app_name + '</b> vào trạng thái đề thi thử ?, \n\
                        <br> Bài thi sẽ được duyệt trong vòng 6h kể từ lúc gửi đi.\n\
                                                 <br> Nếu bài thi hợp lệ sẽ tự động được đưa vào trạng thái kinh doanh.',
                                    buttons: {
                                        confirm: {
                                            text: 'Gửi yêu cầu & tạo đề thi thử.', btnClass: 'btn btn-primary',
                                            action: function () {
                                                PEC.core.func_af08(this_btn);
                                            }
                                        },
                                        cancel: {
                                            text: 'Hủy', btnClass: 'btn btn-default'
                                        }
                                    }
                                }));
                            });
                        },
                        button_createExamOnlineCustomMode: function ($element) {
                            $($element).on('click', function () {
                                var tr______ = $(this).parents('tr');
                                var this_btn = this;
                                var app_id__ = $(tr______).data('name');
                                var app_name = $(tr______).data('name');
                                var app_pric = $(tr______).data('name');

                                $.confirm(jquery_confirm_options({
                                    title: 'Tạo trắc nghiệm online', icon: 'fa fa-warning', autoClose: 'cancel|10000',
                                    content: 'Bạn có muốn chuyển <b>' + app_name + '</b> vào trạng thái bài thi trắc nghiệm online ?, \n\
                        <br> Bài thi sẽ được duyệt trong vòng 6h kể từ lúc gửi đi.\n\
                                                 <br> Nếu bài thi hợp lệ sẽ tự động được đưa vào trạng thái kinh doanh.',
                                    buttons: {
                                        confirm: {
                                            text: 'Gửi yêu cầu & tạo trắc nghiệm.', btnClass: 'btn btn-primary',
                                            action: function () {
                                                PEC.core.func_387b(this_btn);
                                            }
                                        },
                                        cancel: {
                                            text: 'Hủy', btnClass: 'btn btn-default'
                                        }
                                    }
                                }));
                            });
                        }
                    }
                }
            }
        };
        PEC.initialize();
    });
</script>
@endpush