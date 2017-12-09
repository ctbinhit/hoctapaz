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
<!-- iCheck -->
<!--<link href="{!!asset('public/admin_assets/plugins/jQuery.iCheck/skins/all.css')!!}" rel="stylesheet" />-->
<link href="{!!asset('public/admin_assets/plugins/jQuery.iCheck/skins/square/blue.css')!!}" rel="stylesheet" />

@endpush
@if(isset($items))
<table id="jquery-datatable-default" class="table table-hover table-effect">
    <thead>
        <tr>
            <td><input class="jquery-icheck-all" data-items="item-select" type="checkbox"></td>
            <th>{{__('label.stt')}}</th>
            <th>{{__('label.ten')}}</th>
            <th><i class="fa fa-picture-o"></i></th>
            <th><i class="fa fa-eye"></i></th>
            <th>{{__('schools.tgthi')}}</th>
            <th>{{__('schools.luotthi')}}</th>
            <th>{{__('label.ngaytao')}}</th>
            <th>{{__('label.noibat')}}</th>
            <th>{{__('label.hienthi')}}</th>
            <th>{{__('label.trangthai')}}</th>
            <th>{{__('label.thaotac')}}</th>
        </tr>
    </thead>
    <tbody>
        @if(count($items)!=0)
        @foreach($items as $k=>$v)
        <tr id="jquery-icheck-{{$v->id}}">
            <td style="text-align: center;">
                @if($v->approved_by!=-1)
                <input class="jquery-icheck item-select" data-id="{{$v->id}}" type="checkbox">
                @endif
            </td>
            <td style="width:2%">
                @if($v->approved_by!=-1)
                <input style="width:100%" class="jquery-bcore-textbox" data-id="{{$v->id}}" data-field="ordinal_number" 
                       data-tbl="{{$v->tbl}}" data-action="uf" type="number" value="{{$v->ordinal_number}}">
                @endif
            </td>
            <td style="width: 30%;">
                @if($v->approved_by!=-1)
                <a href="{{ route('pi_exam_edit',$v->id)}}">
                    {{$v->name}} <i class="fa fa-pencil"></i>
                </a>
                @else
                {{$v->name}}
                @endif
            </td>
            <td>
                <img src="" />
            </td>
            <td>{{$v->views}}</td>
            <td>{{$v->time/60}} {{__('schools.phut')}}</td>
            <td>0</td>
            <td>{{ Carbon\Carbon::parse($v->created_at)->format('d-m-Y h:i:s') }}</td>
            @if($v->approved_by!=-1)
            <td><input type="checkbox" data-id="{{$v->id}}" data-field="highlight" data-tbl="{{$v->tbl}}" 
                       data-action="ub" {{@$v->highlight==1?'checked=""':''}} class="js-switch" name="display" data-switchery="true" style="display: none;"></td>
            <td><input type="checkbox" data-id="{{$v->id}}" data-field="display" data-tbl="{{$v->tbl}}" 
                       data-action="ub" {!!@$v->display==1?'checked=""':''!!} class="js-switch" name="display" data-switchery="true" style="display: none;"></td>
            @else
            <td></td>
            <td></td>
            @endif
            <td style="width: 10%;">
                @if($v->approved_by==null)
                <span style="color:yellow;">{{__('label.choduyet')}}</span>
                @elseif($v->approved_by==-1)
                <span style="color:#F00;">{{__('label.bituchoi')}}</span>
                @else
                <span style="color:green;">{{__('label.daduyet')}}</span>
                @endif
            </td>
            <td style="width: 20%;">
                @if($v->approved_date != null)
                    @if($v->state == null)
                    <a href="{{ route('pi_exam_edit',$v->id)}}" class="btn btn-default"><i class="fa fa-edit"></i></a>
                    @elseif($v->state == 1)
                    <a href="{{route('pi_exam_user',$v->id)}}" class="btn btn-primary"><i class="fa fa-users"></i></a>
                    <a href="javascript:void(0)" class="btn btn-primary"><i class="fa fa-bar-chart"></i></a>
                    @elseif($v->state == 0)
                    <a href="{{ route('pi_exam_edit',$v->id)}}" class="btn btn-default"><i class="fa fa-edit"></i></a>
                    @endif
                @else
                <button class="btn btn-default">Đang chờ duyệt</button>
                @endif



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
                                <select class="form-control jquery-display-count" name="display_count">
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
                    <button type="button" data-tbl="{{$items[0]->tbl}}" data-action="rs" 
                            class="btn btn-default jquery-bcore-btn" data-items="item-select">
                        <i class="fa fa-trash"></i> {{__('label.xoadachon')}}
                    </button>
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