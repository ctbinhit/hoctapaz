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
<table id="jquery-datatable-default" class="table table-hover table-effect">
    <thead>
        <tr>
            <td><input class="jquery-icheck-all" data-items="item-select" type="checkbox"></td>
            <th>{{__('label.stt')}}</th>
            <th>{{__('label.ten')}}</th>
<!--            <th><i class="fa fa-picture-o"></i></th>-->
            <th><i class="fa fa-eye"></i></th>
            <th><i class="fa fa-clock-o"></i></th>
            <th><i class="fa fa-hdd-o"></i></th>
            <th>{{__('label.ngaytao')}}</th>
<!--            <th>{{__('label.noibat')}}</th>
            <th>{{__('label.hienthi')}}</th>-->
            <th>{{__('label.trangthai')}}</th>
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
            <td style="width:2%">
                <input style="width:100%" class="jquery-bcore-textbox" data-id="{{$v->id}}" data-field="ordinal_number" 
                       data-tbl="{{$v->tbl}}" data-action="uf" type="number" value="{{$v->ordinal_number}}">
            </td>
            <td style="width: 30%;">
                <a href="{{ route('mdle_oc_pi_exam_edit',$v->id)}}">
                    {{$v->name}} <i class="fa fa-pencil"></i>
                </a>
            </td>
<!--            <td>
                <img src="" />
            </td>-->
            <td>{{$v->views}}</td>
            <td>{{$v->time/60}} {{__('schools.phut')}}</td>
            <td></td>
            <td>{{diffInNow($v->created_at)}} <br>{{ Carbon\Carbon::parse($v->created_at)->format('d-m-Y h:i:s') }}</td>
            <td style="width: 10%;">
                {{$v->state}}
            </td>
            <td style="width: 20%;">
                <!-- Single button -->
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Hành động <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="javascript:;" class="jquery-btn-viewExamDetail"><i class="fa fa-eye"></i> Xem chi tiết</a></li>
                        <li><a href="{{ route('mdle_oc_pi_exam_edit',$v->id)}}"><i class="fa fa-edit"></i> Chỉnh sửa</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="javascript:;" class="jquery-btn-createExamMode1"><i class="fa fa-plus-circle"></i> Tạo phòng thi</a></li>
                        <li><a href="javascript:;" class="jquery-btn-createExamMode2"><i class="fa fa-plus-circle"></i> Tạo đề thi thử</a></li>
                        <li><a href="javascript:;" class="jquery-btn-createExamMode3"><i class="fa fa-plus-circle"></i> Tạo bài trắc nghiệm</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="javascript:;" class="jquery-btn-removeExam"><i class="fa fa-trash"></i> Xóa</a></li>
                    </ul>
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
                <!-- Số lượng hiển thị -->
                @if($UI->check_displayCount())
                <div class="col-md-3"> 
                    <form action="" method="POST" name="frm_changeDisplayCount" class="form form-horizontal">
                        {{ csrf_field() }}
                        <input type="hidden" value="{{$tbl}}" name="tbl"/>

                        <div class="form-group">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">{{__('label.hienthi')}}:</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <select class="form-control jquery-display-count" name="display_count" disabled="">
                                    {!! $UI->load_displayCount($_ControllerName,$tbl)!!}
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-3">
                    @if(isset($template_recycle))
                    <button type="button" data-tbl="{{$items[0]->tbl}}" data-action="recs" 
                            class="btn btn-primary jquery-bcore-btn" data-items="item-select">
                        <i class="fa fa-recycle"></i> {{__('label.phuchoi')}}
                    </button>
                    @else
                    <!--                    <button type="button" data-tbl="{{$items[0]->tbl}}" data-action="rs" 
                                                class="btn btn-default jquery-bcore-btn" data-items="item-select">
                                            <i class="fa fa-trash"></i> {{__('label.xoadachon')}}
                                        </button>-->
                    @endif
                </div>
                <div class="col-md-3">
                    {{$items->links()}}
                </div>
            </td>
            @endif
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
                            id: $(tr).data('id')
                        }, success: function (res) {
                            if(res.response_state){
                                $(tr).slideUp();
                            }else{
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
                            if(res.response_state){
                                $(tr).slideUp();
                            }else{
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
                            if(res.response_state){
                                $(tr).slideUp();
                            }else{
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
                            if(res.response_state){
                                $(tr).slideUp();
                            }else{
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