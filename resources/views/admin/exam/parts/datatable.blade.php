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
<table id="jquery-datatable-default" class="table table-bordered table-effect">
    <thead>
        <tr>
            <th width="30px"><input class="jquery-icheck-all" data-items="item-select" type="checkbox"></th>
            <th data-toggle="tooltip" data-placement="top" title="Đối tác"><i class="fa fa-user"></i></th>
            <th width="25%" data-toggle="tooltip" data-placement="top" title="Tên đề thi">Tên đề thi</th>
            <th data-toggle="tooltip" data-placement="top" title="Danh mục"><i class="fa fa-list"></i></th>
            <th data-toggle="tooltip" data-placement="top" title="Thời gian làm bài"><i class="fa fa-clock-o"></i></th>
            <th data-toggle="tooltip" data-placement="top" title="Phí dự thi"><i class="fa fa-money"></i> L1</th>
            <th data-toggle="tooltip" data-placement="top" title="Phí ôn tập"><i class="fa fa-money"></i> L2</th>
            <th data-toggle="tooltip" data-placement="top" title="Ngày đăng ký"><i class="fa fa-calendar-o"></i></th>
            <th>{{__('label.trangthai')}}</th>
            <th width="200px">{{__('label.thaotac')}}</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($items))
        @if(count($items)!=0)
        @foreach($items as $k=>$v)
        <tr id="jquery-icheck-{{$v->id}}">
            <td style="text-align: center;"><input class="jquery-icheck item-select" data-id="{{$v->id}}" type="checkbox"></td>
            <td><a title="Click để xem thông tin của giáo viên này" href="#">{{@$v->pi_name}} <i class="fa fa-eye"></i></a></td>
            <td><a title="{{$v->name}}" href="{{route('admin_examman_approver_detail',$v->id)}}">{{str_limit($v->name,30)}} <i class="fa fa-eye"></i></a></td>
            <td><div class="label label-info">{{str_limit($v->category_name,30)}}</div></td>
            <td><div class="label label-info">{{$v->time/60}} phút</div></td>
            <td><div class="label label-info">{{number_format($v->price,0,'.',',')}} VNĐ</div></td>
            <td><div class="label label-info">{{number_format($v->price2,0,'.',',')}} VNĐ</div></td>
            <td>{{ Carbon\Carbon::parse($v->created_at)->format('d-m-Y h:i:s') }}</td>
            <td style="width: 10%;"><div class="label label-warning">{{__('label.dangcho')}}</div></td>
            <td>
                @if(isset($template_recycle))
                <a href="javascript:void(0)" data-id="{{$v->id}}" data-tbl="{{$v->tbl}}" data-action="reca" 
                   class="btn btn-primary jquery-button-recycle"><i class="fa fa-recycle"></i></a>
                @else

                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Thao tác <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('admin_examman_approver_detail',$v->id)}}" class=""><i class="fa fa-eye"></i> Xét duyệt</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="javascript:;" class="jquery-btn-removeExam"><i class="fa fa-trash"></i> Xóa</a></li>
                    </ul>
                </div>

                @endif
            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="10">{{__('message.khongcodulieu')}}</td>
        </tr>
        @endif
        @endif
    </tbody> 
    @if(isset($items))
    @if(count($items)!=0)
    <tfoot>
        <tr>
            <td colspan="2">

            </td>
            <td style="text-align:center;" colspan="10"> {{$items->links()}}</td>
        </tr>
    </tfoot>
    @endif
    @endif
</tbody> 

</table>

@push('scripts')
<!-- iCheck -->
<script src="{!!asset('public/admin_assets/plugins/jQuery.iCheck/icheck.min.js')!!}"></script>
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
        $('.jquery-bcore-btn').on('click', function () {
            var action = $(this).data('action');
            console.log(action);
            switch (action) {
                case 'rs':
                    DatatableController.remove.items(this);
                    break;
                case 'recs':
                    DatatableController.recycle.items(this);
                    break;
            }
        });

        var DatatableController = {
            func: {
                removeIcheckSelected: function (pArray) {
                    $.each(pArray, function (k, v) {
                        $('#jquery-icheck-' + v).slideUp();
                    });
                },
                getArrayItemsSelected: function (items) {
                    var lst_items = [];
                    $.each($(items), function (k, v) {
                        var id = $(v).data('id');
                        if ($(v).iCheck('update')[0].checked) {
                            lst_items.push(id);
                        }
                    });
                    return lst_items;
                }
            },
            recycle: {
                items: function (this_) {
                    var action = $(this_).data('action');
                    var items_ = $('.' + $(this_).data('items'));
                    items = DatatableController.func.getArrayItemsSelected(items_);
                    var data = {
                        items: items,
                        tbl: $(this_).data('tbl'),
                        action: action
                    };
                    if (items.length === 0) {
                        new PNotify({
                            title: '{{__("label.thongbao")}}',
                            styling: 'bootstrap3',
                            text: '{{__("message.vuilongcheckvaoocanthaotac")}}'
                        });
                    } else {
                        var noti = new PNotify({
                            title: 'Khôi phục bài viết?',
                            text: 'Dữ liệu này sẽ được khôi phục, dữ liệu sẽ an toàn trong vòng 30 ngày kể từ ngày xóa',
                            icon: 'glyphicon glyphicon-question-sign',
                            hide: false,
                            styling: 'bootstrap3',
                            addclass: 'stack-modal',
                            confirm: {
                                confirm: true,
                                buttons: [{
                                        text: 'Phục hồi',
                                        addClass: 'btn-primary',
                                        click: function (notice) {
                                            $.ajax({
                                                url: '{{route("ajax_bcore_action")}}',
                                                beforeSend: function () {
                                                    //$(this_).css('background', '#CFF');
                                                },
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                },
                                                type: 'POST',
                                                dataType: 'json',
                                                data: data,
                                                success: function (data) {
                                                    if (data.result == 1) {
                                                        notice.remove();
                                                        DatatableController.func.removeIcheckSelected(items);
                                                    } else {
                                                        notice.remove();
                                                    }
                                                }, error: function (data) {
                                                    //console.log(data.responseText);
                                                }
                                            });
                                        }
                                    }, {
                                        text: 'Cancel',
                                        click: function (notice) {
                                            notice.remove();
                                        }
                                    }]
                            },
                            buttons: {
                                closer: false,
                                sticker: false
                            },
                            history: {
                                history: false
                            }
                        });
                    }
                }
            },
            remove: {
                items: function (this_) {
                    var action = $(this_).data('action');
                    var items_ = $('.' + $(this_).data('items'));
                    items = DatatableController.func.getArrayItemsSelected(items_);
                    var data = {
                        items: items,
                        tbl: $(this_).data('tbl'),
                        action: 'rs' // Remove selected items 
                    };
                    if (items.length === 0) {
                        new PNotify({
                            title: '{{__("label.thongbao")}}',
                            styling: 'bootstrap3',
                            text: '{{__("message.vuilongcheckvaoocanxoa")}}'
                        });
                    } else {
                        var noti = new PNotify({
                            title: 'Bạn có muốn xóa?',
                            text: 'Dữ liệu này sẽ được chuyển vào thùng rác.',
                            icon: 'glyphicon glyphicon-question-sign',
                            hide: false,
                            styling: 'bootstrap3',
                            addclass: 'stack-modal',
                            confirm: {
                                confirm: true,
                                buttons: [{
                                        text: 'Xóa',
                                        addClass: 'btn-danger',
                                        click: function (notice) {
                                            $.ajax({
                                                url: '{{route("ajax_bcore_action")}}',
                                                beforeSend: function () {
                                                    //$(this_).css('background', '#CFF');
                                                },
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                },
                                                type: 'POST',
                                                dataType: 'json',
                                                data: data,
                                                success: function (data) {
                                                    if (data.result == 1) {
                                                        notice.remove();
                                                        DatatableController.func.removeIcheckSelected(items);
                                                    } else {
                                                        //$(this_).css('background', '#F00');
                                                    }
                                                }, error: function (data) {
                                                    console.log(data.responseText);
                                                }
                                            });
                                        }
                                    }, {
                                        text: 'Cancel',
                                        click: function (notice) {
                                            notice.remove();
                                        }
                                    }]
                            },
                            buttons: {
                                closer: false,
                                sticker: false
                            },
                            history: {
                                history: false
                            }
                        });
                    }
                }
            }
        };

        $('.js-switch').on('change', function () {
            var this_tr = $(this).parents('tr');
            var isChecked = $(this).prop('checked');
            var data = {
                action: $(this).data('action'),
                tbl: $(this).data('tbl'),
                id: $(this).data('id'),
                field: $(this).data('field')
            };
            $.ajax({
                url: '{{route("ajax_bcore_action")}}',
                type: 'POST',
                beforeSend: function () {
                    $(this_tr).css('background', '#CFF');
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                data: data,
                success: function (data) {
                    // console.log(data);
                    if (data.result == '1') {
                        $(this_tr).css('background', 'none');
                    } else {
                        $(this_tr).css('background', '#F00');
                    }
                }, error: function (data) {
                    // console.log(data.responseText);
                }
            });
        });

        $('.jquery-bcore-textbox').on('blur', function () {
            var this_tr = $(this).parents('tr');
            var data = {
                action: $(this).data('action'),
                tbl: $(this).data('tbl'),
                id: $(this).data('id'),
                field: $(this).data('field'),
                field_val: $(this).val()
            };
            $.ajax({
                url: '{{route("ajax_bcore_action")}}',
                type: 'POST',
                beforeSend: function () {
                    $(this_tr).css('background', '#CFF');
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                data: data,
                success: function (data) {
                    if (data.result == '1') {
                        $(this_tr).css('background', 'none');
                    } else {
                        $(this_tr).css('background', '#F00');
                    }
                }, error: function (data) {
                    console.log(data.responseText);
                }
            });
        });

        $('.jquery-button-recycle').on('click', function () {
            var this_ = this;
            var noti = new PNotify({
                title: 'Bạn muốn phục hồi bài viết này?',
                text: 'Dữ liệu này sẽ được phục hồi trở lại, dữ liệu sẽ được an toàn trong 30 ngày kể từ ngày xóa.',
                icon: 'glyphicon glyphicon-question-sign',
                hide: false,
                styling: 'bootstrap3',
                addclass: 'stack-modal',
                confirm: {
                    confirm: true,
                    buttons: [{
                            text: 'Phục hồi',
                            addClass: 'btn-success',
                            click: function (notice) {
                                var data = {
                                    id: $(this_).data('id'),
                                    tbl: $(this_).data('tbl'),
                                    action: $(this_).data('action')
                                };
                                $.ajax({
                                    url: '{{route("ajax_bcore_action")}}',
                                    beforeSend: function () {
                                        $(this_).css('background', '#CFF');
                                    },
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    type: 'POST',
                                    dataType: 'json',
                                    data: data,
                                    success: function (data) {
                                        if (data.result == 1) {
                                            $(this_).parents('tr').slideUp();
                                            notice.remove();
                                        } else {
                                            $(this_).css('background', '#F00');
                                        }
                                    }, error: function (data) {
                                        console.log(data.responseText);
                                    }
                                });
                            }
                        }, {
                            text: 'Cancel',
                            click: function (notice) {
                                notice.remove();
                            }
                        }]
                },
                buttons: {
                    closer: false,
                    sticker: false
                },
                history: {
                    history: false
                }
            });
        });

        $('.jquery-button-remove').on('click', function () {
            var this_ = this;
            var noti = new PNotify({
                title: 'Bạn có muốn xóa?',
                text: 'Dữ liệu này sẽ được chuyển vào thùng rác.',
                icon: 'glyphicon glyphicon-question-sign',
                hide: false,
                styling: 'bootstrap3',
                addclass: 'stack-modal',
                confirm: {
                    confirm: true,
                    buttons: [{
                            text: 'Xóa',
                            addClass: 'btn-danger',
                            click: function (notice) {
                                var data = {
                                    id: $(this_).data('id'),
                                    tbl: $(this_).data('tbl'),
                                    action: $(this_).data('action')
                                };
                                $.ajax({
                                    url: '{{route("ajax_bcore_action")}}',
                                    beforeSend: function () {
                                        $(this_).css('background', '#CFF');
                                    },
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    type: 'POST',
                                    dataType: 'json',
                                    data: data,
                                    success: function (data) {
                                        if (data.result == 1) {
                                            $(this_).parents('tr').slideUp();
                                            notice.remove();
                                        } else {
                                            $(this_).css('background', '#F00');
                                        }
                                    }, error: function (data) {
                                        console.log(data.responseText);
                                    }
                                });
                            }
                        }, {
                            text: 'Cancel',
                            click: function (notice) {
                                notice.remove();
                            }
                        }]
                },
                buttons: {
                    closer: false,
                    sticker: false
                },
                history: {
                    history: false
                }
            });
        });
    });
</script>
@endpush