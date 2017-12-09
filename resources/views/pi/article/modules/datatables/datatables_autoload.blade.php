
@push('scripts')
<script>
    /* ================================================= DATATABLE CONFIGURATION =======================================
     | -----------------------------------------------------------------------------------------------------------------
     | =================================================================================================================
     */
    var datatbl, editor;
    var Option_lenght = [
        {!!(($BVIEW -> get_OptionString('lenght')))!!}
    ];
    $(document).ready(function () {
        init_datatbl();
        init_datatbl_editor();
    });
</script>
@endpush
@include($plugins_path . 'jsc.datatables')
@include($plugins_path . 'jsc.datatables_package')
@include($plugins_path . 'jsc.datatables_style')
@include($plugins_path . 'jsc.data_transfer')
@include($plugins_path . 'jsc.datatables_init')
@include($plugins_path . 'jsc.datatables_editor')
@push('scripts')
<script>

    function datatables_delete($pLstId, $pLstElements = null) {
        $.ajax({
            url: '{{route($route_ajax)}}',
            type: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                type: '{{$type}}',
                bcore_action: 'delete',
                data: $pLstId
            }, success: function (data) {
                if (data.result == true) {
                    // Nếu tham số $pLstElements != null => ẩn thành phần đó
                    if ($pLstElements !== null)
                        datatbl.row($($pLstElements)).remove().draw();
                    else
                        datatbl.ajax.reload();
                    // =================================================================================================

                    var notice = new PNotify({
                        title: 'Xóa thành công!',
                        text: 'Nếu muốn quay lại vui lòng bấm nút hoàn tác',
                        icon: 'fa fa-info',
                        hide: true,
                        type: 'success',
                        confirm: {
                            confirm: true,
                            buttons: [
                                {
                                    text: 'Hoàn tác',
                                    addClass: 'btn-primary',
                                    click: function (notice) {
                                        // UNDO ============================================================
                                        $.ajax({
                                            url: '{{route($route_ajax)}}',
                                            type: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                            dataType: 'json',
                                            data: {
                                                type: '{{$type}}',
                                                bcore_action: 'undo',
                                                data: data.data
                                            }, success: function (data) {
                                                if (data.result == true) {
                                                    datatbl.ajax.reload();
                                                    notice.update({
                                                        title: 'Hoàn tác',
                                                        text: data.message,
                                                        icon: true,
                                                        type: 'success',
                                                        hide: true,
                                                        confirm: {
                                                            confirm: false
                                                        },
                                                        buttons: {
                                                            closer: true,
                                                            sticker: true
                                                        }
                                                    });
                                                }
                                            }, error: function (data) {
                                                console.log(data);
                                            }
                                        });
                                        // =================================================================

                                    }
                                },
                                {
                                    text: 'Đóng',
                                    click: function (notice) {
                                        notice.remove();
                                    }
                                }
                            ]
                        },
                        buttons: {
                            closer: true,
                            sticker: true
                        },
                        styling: 'bootstrap3'
                    });
                    //
                } else {
                    new PNotify({
                        title: 'Article',
                        text: data.message,
                        type: "error",
                        styling: 'bootstrap3'
                    });
                }
                //console.log(data);
            }, error: function (data) {
                //console.log(data);
            }
        });
    }
</script>
@endpush

