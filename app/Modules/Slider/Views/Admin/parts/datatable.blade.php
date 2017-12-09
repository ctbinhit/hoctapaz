<table class="table table-striped" id="table_controller">
    <thead>
        <tr>
            <th style="width: 5%;">
                <input class="jquery-icheck-all" data-items="item-select" type="checkbox">
            </th>
            <th style="width: 10%;"><i class="fa fa-sort-numeric-asc"></i></th>
            <th><i class="fa fa-picture-o"></i></th>
            <th style="width:25%"><i class="fa fa-pagelines"></i></th>
            <th><i class="fa fa-clock-o"></i></th>
            <th>Ẩn/Hiện</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        @if(count($items)!=0)
        @foreach($items as $k =>$v)
        <tr data-id="{{$v->id}}" data-tbl="{{$v->tbl}}">
            <td style="text-align: center;">
                <input class="jquery-icheck item-select" data-id="{{$v->id}}" type="checkbox"></td>
            <td>
                <input style="width:100%" class="jquery-ajaxField" name="ordinal_number" type="number" 
                       value="{{$v->ordinal_number}}" data-id="{{$v->id}}" >
            </td>
            <td>
                <img style="width: 70px;height:45px;margin-bottom:0px;" 
                     class="thumbnail" src="{{html_image($v->image,70,45)}}" />
            </td>
            <td><a href="{{route('mdle_admin_slider_edit',[$type,$v->id])}}">{{$v->title}} <i class="fa fa-pencil"></i></a></td>
            <td>{{$v->created_at}} <br> ({{@$v->created_at_human}})</td>
            <td>
                @if(Route::has('_mdle_admin_slider_ajax'))
                <input type="checkbox" class="js-switch jquery-ajaxSwitch {{$v->display==1?'js-switch-checked':''}}" 
                       name="display" data-tbl="photos" data-id="{{$v->id}}" data-switchery="true">
                @else
                <i class="fa fa-warning"></i>
                @endif
            </td>
            <td>
                <a href="{{route('mdle_admin_slider_edit',[$type,$v->id])}}" class="btn btn-default">
                    <i class="fa fa-edit"></i></a>
                @if($v->url_redirect!=null)
                <a href="{{$v->url_redirect}}" target="_blank" class="btn btn-primary" titl="Di chuyển tới link">
                    <i class="fa fa-link"></i></a>
                @endif
                <a href="javascript:void(0)" class="btn btn-danger jquery-btn-ri"
                   data-id="{{$v->id}}" data-name="{{$v->name}}" ><i class="fa fa-remove"></i></a>
            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="10"><p class="text-info">Không có dữ liệu...</p></td>
        </tr>
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="10">
                <div class="row">
                    <div class="col-md-1">
                        <button class="btn btn-danger jquery-btn-ris"><i class="fa fa-trash"></i></button>
                    </div>
                    <div class="col-md-2">
                        <form action="{{route('_mdle_slider_index',$type)}}" 
                              method="post" name="frm_changeDisplayCount">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{$type}}" name="type"/>
                            <select class="form-control jquery-bcore-viewcount" name="vc">
                                <option>--Hiển thị--</option>
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="-1">Tất cả</option>
                            </select>
                        </form>
                    </div>
                    <div class="col-md-4">
                        {{$items->links()}}
                    </div>
                </div>
            </td>
        </tr>
    </tfoot>
</table>

<input type="hidden" id="_mdle_admin_slider_ajax" name="_mdle_admin_slider_ajax" 
       value="{{route('_mdle_admin_slider_ajax')}}" />
@push('scripts')
<script>
    $(document).ready(function () {
        $('.jquery-ajaxField').ajaxField({on: 'blur', action: 'uf', table: 'photos'});

        $('.jquery-ajaxSwitch').ajaxSwitch({on: 'change'});

        $('.jquery-btn-ri').on('click', function () {
            var this_btn = this;
            var tr = $(this_btn).parents('tr');
            $.confirm(jquery_confirm_options({
                icon: 'fa fa-trash', autoClose: 'cancelAction|5000',
                title: 'Thông báo', type: 'red', content: 'Bạn có muốn xóa <b>' + $(this).data('name') + '</b> ?',
                buttons: {
                    confim: {
                        text: 'Đồng ý', keys: ['enter'], btnClass: 'btn btn-primary',
                        action: function () {
                            slideAjax.removeItem($(this_btn).data('id'), tr);
                        }
                    },
                    cancelAction: {text: 'Hủy', keys: ['esc']}
                }
            }));
        });

        $('.jquery-btn-ris').on('click', function () {
            var this_btn = this;
            var items_selected = $('.item-select:checked');

            if (items_selected.length == 0) {
                $.alert(jquery_alert_options({
                    title: 'Thông báo',
                    content: 'Vui lòng chọn vào ô cần xóa trước khi bấm nút này!'
                }));
                return;
            }
            var array_id = [];
            var array_tr = [];
            $.each(items_selected, function (k, v) {
                array_tr.push($(v).parents('tr'));
                array_id.push($(v).parents('tr').data('id'));
            });
            $.confirm(jquery_confirm_options({
                icon: 'fa fa-trash', autoClose: 'cancelAction|5000',
                title: 'Thông báo', type: 'red', content: 'Bạn có muốn xóa những item đã chọn ?',
                buttons: {
                    confim: {
                        text: 'Đồng ý', keys: ['enter'], btnClass: 'btn btn-primary',
                        action: function () {
                            slideAjax.removeItems(array_id, array_tr, this_btn);
                        }
                    },
                    cancelAction: {text: 'Hủy', keys: ['esc']}
                }
            }));

        });

        var slideAjax = {
            removeItems: function (list_id, list_tr, btn) {
                var btn_text = $(btn).html();
                var data_send = {act: 'ris', items: list_id};
                $.ajax({
                    url: $('#_mdle_admin_slider_ajax').val(),
                    type: 'POST', dataType: 'json', data: data_send,
                    beforeSend: function (xhr) {
                        $(btn).html('<i class="fa fa-spinner faa-spin animated"></i> Đang xóa...');
                    },
                    success: function (data) {
                        if (data.response_state) {
                            $.each(list_tr, function (k, v) {
                                $(v).fadeOut();
                                setTimeout(function () {
                                    $(v).remove();
                                }, 2000);
                            });
                        }
                    }, error: function (data) {
                        //console.log(data);
                    }, complete: function (jqXHR, textStatus) {
                        $(btn).html(btn_text);
                    }
                });
            },
            removeItem: function (id_item, tr) {
                $.ajax({
                    url: $('#_mdle_admin_slider_ajax').val(),
                    type: 'POST', dataType: 'json',
                    data: {act: 'ri', id: id_item},
                    success: function (data) {
                        if (data.response_state) {
                            $(tr).addClass('animated fadeOutLeftBig');
                            setTimeout(function () {
                                $(tr).remove();
                            }, 2000);
                        } else {
                            $.alert(jquery_alert_options({
                                title: 'Thông báo', icon: 'fa fa-warning', 
                                content: 'Xóa không thành công, có lỗi xảy ra!', type: 'red',
                                buttons: {
                                    reloadAction: {text: 'Tải lại trang', btnClass: 'btn btn-primary',
                                        action: function () {
                                            window.location.reload();
                                        }},
                                    confirmAction: {text: 'Thoát', btnClass: 'btn btn-danger'}
                                }
                            }));
                        }
                    }, error: function (data) {
                        $.alert(jquery_alert_options({
                            title: 'Thông báo', icon: 'fa fa-warning', content: 'Có lỗi không mong muốn vừa xảy ra, \n\
                    vui lòng thử lại sau hoặc liên hệ quản trị để biết thêm thông tin.', type: 'red',
                            buttons: {confirmAction: {text: 'Thoát', btnClass: 'btn btn-danger'}}
                        }));
                    }
                });
            }
        };

        // ===== UPDATE VIEW COUNT =====================================================================================
        $('.jquery-bcore-viewcount').on('change', function () {
            var vc = $(this).val();
            $(this).parents('form').submit();
        });

    });
</script>
@endpush