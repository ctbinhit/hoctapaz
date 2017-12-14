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
            <td><input class="jquery-icheck-all" data-items="item-select" type="checkbox"></td>
            <th style="width: 5%;">{{@$UI->field_name('ordinal_number')}}</th>
            @if($UI->field('name'))<th style="width: 30%;">{{@$UI->field_name('name')}}</th>@endif
            @if($UI->field('photo'))<th style="width: 5%;"><i class="fa fa-picture-o"></i></th>@endif
            @if($UI->field('views'))<th>{{@$UI->field_name('views')}}</th>@endif
            @if(!isset($template_recycle))
            @if($UI->field('created_at'))<th>{{@$UI->field_name('created_at')}}</th>@endif
            @if($UI->field('highlight'))<th>{{@$UI->field_name('highlight')}}</th>@endif
            @if($UI->field('display'))<th>{{@$UI->field_name('display')}}</th>@endif
            @else
            @if($UI->field('deleted_at'))<th>Ngày xóa</th>@endif
            <th>TG Xóa</th>
            @endif

            <th>{{__('label.thaotac')}}</th>
        </tr>
    </thead>
    <tbody>
        @if(count($items)!=0)
        @foreach($items as $k=>$v)
        <tr id="jquery-icheck-{{$v->id}}" data-id="{{$v->id}}" data-name="{{$v->name}}">
            <td style="text-align: center;"><input class="jquery-icheck item-select" data-id="{{$v->id}}" type="checkbox"></td>
            @if(!isset($template_recycle))
            <td style="width:2%">
                <input style="width:100%" class="jquery-bcore-textbox" data-id="{{$v->id}}" data-field="ordinal_number" 
                       data-tbl="{{$v->tbl}}" data-action="uf" type="number" value="{{$v->ordinal_number}}">
            </td>
            <td style="width: 35%;">
                <a href="{{route('admin_article_edit',[$type,$v->id])}}">
                    {{$v->name}} <i class="fa fa-pencil"></i>
                </a>
            </td>
            @else
            <td style="width:2%">{{$v->ordinal_number}}</td>
            <td style="width: 35%;">{{$v->name}}</td>
            @endif
            <td>
                @if($v->data_photo!=null)
                <img src="{{html_image($v->data_photo->url_encode,40,40,100)}}" />
                @endif
            </td>
            <td>{{$v->views}}</td>
            @if(!isset($template_recycle))
            <td>{{ Carbon\Carbon::parse($v->created_at)->format('d-m-Y h:i:s') }}</td>
            <td><input type="checkbox" data-id="{{$v->id}}" data-field="highlight" data-tbl="{{$v->tbl}}" 
                       data-action="ub" {{@$v->highlight==1?'checked=""':''}} class="js-switch" name="display" data-switchery="true" style="display: none;"></td>
            <td><input type="checkbox" data-id="{{$v->id}}" data-field="display" data-tbl="{{$v->tbl}}" 
                       data-action="ub" {!!@$v->display==1?'checked=""':''!!} class="js-switch" name="display" data-switchery="true" style="display: none;"></td>
            @else
            <td>{{ Carbon\Carbon::parse($v->deleted)->format('d-m-Y h:i:s') }}</td>
            <td></td>
            @endif
            <td>
                <a href="{{route('admin_article_edit',[$type,$v->id])}}" class="btn btn-default"><i class="fa fa-edit"></i></a>
                @if(isset($template_recycle))
                <a href="javascript:void(0)" data-id="{{$v->id}}" data-tbl="{{$v->tbl}}" data-action="reca" 
                   class="btn btn-primary jquery-button-recycle"><i class="fa fa-recycle"></i></a>
                @else
                <a href="javascript:void(0)" data-id="{{$v->id}}" data-tbl="{{$v->tbl}}" data-action="remove" 
                   class="btn btn-danger jquery-button-remove"><i class="fa fa-remove"></i></a>
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
            <td colspan="9">
                <div class="col-md-2">
                    <select class="form-control" name="per_page">
                        <option>-- Hiển thị --</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                    </select>
                </div>
                <div class="col-md-4">
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
                <div class="col-md-6">
                    {{$items->links()}}
                </div>
            </td>

        </tr>
    </tfoot>
    @endif

</tbody> 

</table>
<input type="hidden" id="_admin_article_ajax" value="{{route('_admin_article_ajax')}}" />
@push('scripts')
<!-- iCheck -->
<script src="{!!asset('public/admin_assets/plugins/jQuery.iCheck/icheck.min.js')!!}"></script>
<script>
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
            var this_btn = this;
            var tr = $(this).parents('tr');

            $.confirm(jquery_confirm_options({
                text: 'Thông báo', type: 'blue',
                content: 'Bạn có muốn xóa bài viết này? <br> (<b>' + $(tr).data('name') + '</b>)',
                buttons: {
                    confirm: {
                        text: '<i class="fa fa-trash"></i> Xóa ngay', btnClass: 'btn btn-danger',
                        action: function () {
                            $.ajax({
                                url: $('#_admin_article_ajax').val(),
                                beforeSend: function () {
                                    $(this_btn).css('background', '#CFF');
                                },
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    act: 'rm',
                                    id: $(tr).data('id')
                                },
                                success: function (data) {
                                    if (data.state) {
                                        $(this_btn).parents('tr').slideUp();
                                        notice.remove();
                                    } else {
                                        $(this_btn).css('background', '#F00');
                                    }
                                }, error: function (data) {
                                    console.log(data);
                                }
                            });
                        }
                    },
                    cancel: {
                        text: 'Thôi', btnClass: 'btn btn-default'
                    }
                }
            }));
        });
    });
</script>
@endpush