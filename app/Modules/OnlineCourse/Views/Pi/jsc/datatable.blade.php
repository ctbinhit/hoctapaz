@push('scripts')
<script>
    $(document).ready(function () {

        var TableHelper = {
            remove: {
                IcheckSelected: function (pArray) {
                    $.each(pArray, function (k, v) {
                        $('#item-select-' + v).slideUp();
                    });
                }
            },
            icheck: {
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
            }
        }

        // ===== DELETE SELETED ITEMS ==================================================================================

        $('.jquery-bcore-btn').on('click', function () {
            var this_text = $(this).html();
            var this_ = this;
            var action = $(this).data('action');
            var items_ = $('.' + $(this).data('items'));
            items = TableHelper.icheck.getArrayItemsSelected(items_);
            var data = {
                items: items,
                act: 'rs' // Remove selected items 
            };
            if (items.length === 0) {
                new PNotify({
                    title: 'Thông báo',
                    styling: 'bootstrap3',
                    text: 'Vui lòng check vào ô cần xóa.'
                });
            } else {
                var noti = new PNotify({
                    title: 'Bạn có muốn xóa?', text: 'Dữ liệu này sẽ được chuyển vào thùng rác.',
                    icon: 'glyphicon glyphicon-question-sign', hide: false, styling: 'bootstrap3', addclass: 'stack-modal',
                    confirm: {
                        confirm: true,
                        buttons: [{
                                text: 'Xóa',
                                addClass: 'btn-danger',
                                click: function (notice) {
                                    $.ajax({
                                        url: '{{route("_mdle_oc_ajax")}}',
                                        beforeSend: function () {
                                            $(this_).html('<i class="fa fa-spinner faa-spin animated"></i>');
                                        },
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        type: 'POST',
                                        dataType: 'json',
                                        data: data,
                                        success: function (data) {
                                            if (data.status) {
                                                notice.remove();
                                                TableHelper.remove.IcheckSelected(data.lst_id);
                                                $(this_).html('<i class="fa fa-check"></i>');
                                            } else {
                                                $(this_).html('<i class="fa fa-warning"></i>');
                                            }
                                            setTimeout(function () {
                                                $(this_).html(this_text);
                                            }, 2000);
                                        }
                                    });
                                }
                            }, {text: 'Cancel', click: function (notice) {
                                    notice.remove();
                                }}]
                    },
                    buttons: {closer: false, sticker: false},
                    history: {history: false}
                });
            }

            console.log(items);
        });
        // ===== UPDATE VIEW COUNT =================================================================================

        $('.jquery-bcore-viewcount').on('change', function () {

            var vc = $(this).val();
            $(this).parents('form').submit();
        });
        // ===== UPDATE BOOLEAN ====================================================================================

        $('.js-switch').on('change', function () {
            var this_tr = $(this).parents('tr');
            var isChecked = $(this).prop('checked');
            var data = {
                act: $(this).data('act'),
                tbl: $(this_tr).data('tbl'),
                id: $(this_tr).data('id'),
                field: $(this).attr('name')
            };
            $.ajax({
                url: '{{route("_mdle_oc_ajax")}}',
                type: 'POST',
                beforeSend: function () {
                    $(this_tr).css('background', '#CFF');
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                data: data,
                success: function (data) { console.log(data);
                    if (data.status) {
                        $(this_tr).css('background', 'none');
                    } else {
                        $(this_tr).css('background', '#F00');
                    }
                }
            });
        });
        // ===== UPDATE FIELD ======================================================================================
        $('.jquery-bcore-textbox').on('blur', function () {
            var this_tr = $(this).parents('tr');
            var data = {
                act: $(this).data('action'),
                tbl: $(this_tr).data('tbl'),
                id: $(this_tr).data('id'),
                field: $(this).attr('name'),
                field_val: $(this).val()
            };
            $.ajax({
                url: '{{route("_mdle_oc_ajax")}}',
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
                    if (data.status) {
                        $(this_tr).css('background', 'none');
                    } else {
                        $(this_tr).css('background', '#F00');
                    }
                }, error: function (data) {
                }
            });
        });
        $('.jquery-button-remove').on('click', function () {
            var this_ = this;
            var this_tr = $(this).parents('tr');
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
                                    id: $(this_tr).data('id'),
                                    act: 'ri'
                                };
                                $.ajax({
                                    url: '{{route("_mdle_oc_ajax")}}',
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
                                        if (data.status) {
                                            $(this_tr).slideUp();
                                        } else {
                                            $(this_tr).css('background', '#F00');
                                        }
                                    }, error: function (data) {
                                        console.log(data.responseText);
                                    },complete: function(){
                                        notice.remove();
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
