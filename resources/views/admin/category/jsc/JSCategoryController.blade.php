

<style>
    .js-datatables-btn{
        overflow: hidden;
        position: relative;
        padding: 2px 15px;
        transition: 0.5s ease;
    }
    .js-datatables-btn p{
        padding: 0px;
        margin: 0px;
        position: absolute;
        top: 2px;
        left: 7px;
        transition: 0.5s ease;
    }
    .js-datatables-btn i{
        position: relative;
        left: -500%;
        transition: 0.5s ease;
    }
    .js-datatables-btn:hover{
        background: #F00;
        border-color: #F00;

    }
    .js-datatables-btn:hover i{
        left: 0%;color: #FFF;
    }
    .js-datatables-btn:hover p{
        left: 100%;
    }
</style>
<script>
    /* ================================================= DATATABLE CONFIGURATION =======================================
    | -----------------------------------------------------------------------------------------------------------------
    | =================================================================================================================
    */
    var Option_lenght = [
        {!!(($BVIEW->get_OptionString('lenght')))!!}
    ];
    var packageLang = {
        lengthMenu: "{{__('label.hienthi')}} _MENU_ {{__('message.ketquatrentrang')}}",
        zeroRecords: "{{__('message.khongcodulieu')}}",
        info: "{{__('label.hienthi')}} _PAGE_ {{__('label.tren')}} _PAGES_",
        infoEmpty: "No records available",
        infoFiltered: "(filtered from _MAX_ total records)",
        sInfoPostFix: "",
        sInfoThousands: ",",
        sSearch: "{{__('label.timkiem')}}:",
        sLoadingRecords: "{{__('message.dangtai')}}...",
        sProcessing: "{{__('message.dangxuly')}}...",
        sZeroRecords: "{{__('message.khongtimthayketquanao')}}",
        oPaginate: {
            sFirst: "{{__('label.dau')}}",
            sLast: "{{__('label.cuoi')}}",
            sNext: "{{__('label.ke')}}",
            sPrevious: "{{__('label.lui')}}"
        },
        oAria: {
            sSortAscending: ": activate to sort column ascending",
            sSortDescending: ": activate to sort column descending"
        }
    };
    var datatbl, editor;
    $(document).ready(function () {
        init_datatbl();
        init_datatbl_editor();
    });
    function init_datatbl_editor() {
        editor = new $.fn.dataTable.Editor({
            ajax: {
                url: '{{route($route_ajax)}}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                dataType: 'json',
                data: function (d) {
                    d.type = '{{$type}}';
                    d.tbl = '{{$tbl}}';
                    d.bcore_action = 'update_checkbox';
                },
                success: function (data) {
//                    console.log('Data edited: ');
//                    console.log(data);
                }
            },
            display: 'envelope',
            idSrc: 'id',
            table: "#jquery-datatable-default",
            formOptions: {
                inline: {
                    submit: 'allIfChanged'
                }
            },
            fields: [
                {
                    label: "Display:",
                    name: "display",
                    type: "checkbox",
                    separator: "|",
                    options: [
                        {label: 0, value: 1}
                    ],
                    def: function () {
                        return 1;
                    }
                },
                {
                    label: "Highlight:",
                    name: "highlight",
                    type: "checkbox",
                    separator: "|",
                    options: [
                        {label: '', value: 1}
                    ]
                },
                {
                    label: 'Name:',
                    name: 'name'
                },
                {
                    label: 'View:',
                    name: 'views'
                },
                {
                    label: 'Created at:',
                    name: 'created_at'
                },
                {
                    label: 'STT:',
                    name: 'ordinal_number'
                }
            ]
        });
        editor.on('preSubmit', function (e, data, action) {
            $.each(data.data, function (k, v) {
                if (v.display === '')
                    data.data[k].display = 0;
                if (v.highlight === '')
                    data.data[k].highlight = 0;
            });
        });
        editor
                .on('onOpen', function () {
                    // Listen for a tab key event
                    $(document).on('keydown.editor', function (e) {
                        if (e.keyCode === 9) {
                            e.preventDefault();
                            // Find the cell that is currently being edited
                            var cell = $('div.DTE').parent();
                            if (e.shiftKey && cell.prev().length && cell.prev().index() !== 0) {
                                // One cell to the left (skipping the first column)
                                cell.prev().click();
                            } else if (e.shiftKey) {
                                // Up to the previous row
                                cell.parent().prev().children().last(0).click();
                            } else if (cell.next().length) {
                                // One cell to the right
                                cell.next().click();
                            } else {
                                // Down to the next row
                                cell.parent().next().children().eq(1).click();
                            }
                        }
                    });
                })
                .on('onClose', function () {
                    $(document).off('keydown.editor');
                });
    }

    function init_datatbl() {
        datatbl = $('#jquery-datatable-default').DataTable({
            keys: true,
            select: true,
            deferRender: true,
            ajax: {
                url: '{{route($route_ajax)}}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $('.table tbody').html('<tr class="odd"><td colspan="9" class="dataTables_empty">Loading...</td></tr>');
                },
                type: 'POST',
                dataType: 'json',
                data: function (d) {
                    d.bcore_action = 'get_items';
                    d.type = '{{$type}}';
                    d.tbl = '{{$tbl}}';
                }
            },
            columnDefs: [
                {
                    searchable: false,
                    orderable: false,
                    targets: [0, 3, 6, 7, 8]
                },
//                {
//                    targets: 6,
//                    data: function (row, type, val, meta) {
//                        return row.highlight;
//                    }
//                },
//                {
//                    targets: 7,
//                    data: function (row, type, val, meta) {
//                        return row.display;
//                    }
//                },
            ],
            columns: [
                {
                    title: 'STT',
                    defaultContent: "",
                    visible: false,
                    width: "2%",
                },
                {
                    data: 'ordinal_number',
                    render: function (data, type, row) {
                        if (type === 'display') {
                            return data + ' <i class="fa fa-pencil"/>';
                        }
                        return data;
                    },
                    title: "{{$BVIEW->get_fieldValueSring('ordinal_number.title')}}",
                    visible: {{$BVIEW->get_fieldValueSring('ordinal_number.visible')}},
                    width: "{{$BVIEW->get_fieldValueSring('ordinal_number.width')}}",
                    className: "{{$BVIEW->get_fieldValueSring('ordinal_number.className')}}",
                },
                {
                    data: "name",
                    defaultContent: "N/N",
                    title: "{{$BVIEW->get_fieldValueSring('name.title')}}",
                    visible: {{$BVIEW->get_fieldValueSring('name.visible')}},
                    width: "{{$BVIEW->get_fieldValueSring('name.width')}}",
                    className: "{{$BVIEW->get_fieldValueSring('name.className')}}",
                },
                {
                    defaultContent: "<img style='width:30px;height:30px;' src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTazdhvufuOkkTFDxbkAp3Ttt7IFp4B43Id2X3TD1tWCLOdGHz5' />",
                    width: "5%",
                    visible: true,
                },
                {
                    data: "views",
                    title: "{{$BVIEW->get_fieldValueSring('views.title')}}",
                    visible: {{$BVIEW->get_fieldValueSring('views.visible')}},
                    width: "{{$BVIEW->get_fieldValueSring('views.width')}}",
                    className: "{{$BVIEW->get_fieldValueSring('views.className')}}",
                },
                {
                    data: "created_at",
                    render: function (data, type, row) {
                        if (type === 'display') {
                            return moment(data, "YYYY-MM-DD H:i:s").fromNow();
                        }
                        return data;
                    },
                    title: "{{$BVIEW->get_fieldValueSring('created_at.title')}}",
                    visible: {{$BVIEW->get_fieldValueSring('created_at.visible')}},
                    width: "{{$BVIEW->get_fieldValueSring('created_at.width')}}",
                    className: "{{$BVIEW->get_fieldValueSring('created_at.className')}}",
                },
                {
                    data: "highlight",
                    render: function (data, type, row) {
                        if (type === 'display') {
                            return '<input type="checkbox" data-id="' + row.id + '" data-f="highlight" \n\
                class="editor-active jquery-datatbl-checkbox" />';
                        }
                        return data;
                    },
                    title: "{{$BVIEW->get_fieldValueSring('highlight.title')}}",
                    visible: {{$BVIEW->get_fieldValueSring('highlight.visible')}},
                    width: "{{$BVIEW->get_fieldValueSring('highlight.width')}}",
                    className: "{{$BVIEW->get_fieldValueSring('highlight.className')}}",
                },
                // DISPLAY ======================================================================
                {
                    data: "display",
                    render: function (data, type, row) {
                        if (type === 'display') {
                            return '<input type="checkbox" data-f="display" class="editor-active jquery-datatbl-checkbox" />';
                        }
                        return data;
                    },
                    title: "{{$BVIEW->get_fieldValueSring('display.title')}}",
                    visible: {{$BVIEW->get_fieldValueSring('display.visible')}},
                    width: "{{$BVIEW->get_fieldValueSring('display.width')}}",
                    className: "{{$BVIEW->get_fieldValueSring('display.className')}}",
                },
                {
                    render: function (data, type, row) {
                        if (type === 'display') {
                            return "<button data-datatbl='jquery-datatable-default' data-action='delete' class='js-datatables-btn'><i class='fa fa-remove'></i> <p>{{__('label.xoa')}}</p></button>\n\
                <button data-datatbl='jquery-datatable-default' data-action='redirect' class='js-datatables-btn'><i class='fa fa-edit'></i> <p>{{__('label.sua')}}</p></button>";
                        }
                    },
                    defaultContent: '',
                    title: "{{$BVIEW->get_fieldValueSring('action.title')}}",
                    visible: {{$BVIEW->get_fieldValueSring('action.visible')}},
                    width: "{{$BVIEW->get_fieldValueSring('action.width')}}",
                    className: "{{$BVIEW->get_fieldValueSring('action.className')}}",
                }
            ],
            rowCallback: function (row, data) {
                // Set the checked state of the checkbox in the table
                $.each($('.jquery-datatbl-checkbox', row), function (k, v) {
                    var tmp_f = $(v).data('f');
                    $(v).prop('checked', data[tmp_f] == 1);
                });
            },
            // Datatable BUTTON
            dom: '<"toolbar_top"f><"toolbar_top_right"l><t><"tbl_bottom"ip><"clearfix"><"toolbar_bottom"B>',
            buttons: [
                {
                    text: '<i class="fa fa-refresh"></i> {{__("label.tailai")}}',
                    action: function (e, dt, node, config) {
                        dt.ajax.reload();
                    }
                },
                {
                    text: '<i class="fa fa-remove"></i> {{__("label.xoadachon")}}',
                    action: function () {
                        var lst_items_id = [];
                        var count = datatbl.rows({selected: true}).count();
                        if (count > 0) {
                            $.each(datatbl.rows({selected: true}).data(), function (k, v) {
                                lst_items_id.push(v.id);
                            });
                            datatables_delete(lst_items_id);
                        }

                    }
                },
                {
                    extend: 'selectAll',
                    text: '<i class="fa fa-clipboard"></i> {{__("label.chontatca")}}'
                },
                {
                    extend: 'selectNone',
                    text: '<i class="fa fa-clipboard"></i> {{__("label.bochontatca")}}'
                },
                {
                    extend: 'copy',
                    text: '<i class="fa fa-clipboard"></i> {{__("label.copy")}}'
                },
                {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o"></i> {{__("label.saveAsExcel")}}'
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf-o"></i> {{__("label.viewPDF")}}',
                    download: 'open',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5]
                    },
                    content: [{style: 'fullWidth'}]
                    , styles: {// style for printing PDF body
                        fullWidth: {fontSize: 18, bold: true, alignment: 'right', margin: [0, 0, 0, 0]}
                    },
                },
                {
                    extend: 'pdf',
                    text: '<i class="fa fa-file-pdf-o"></i> {{__("label.exportPDF")}}',
                    key: {
                        key: 'c',
                        altKey: true
                    }
                },
                {
                    extend: 'pdf', // Extend button type
                    text: '<i class="fa fa-save"></i> {{__("label.exportPDFCurPage")}}', // Button text
                    title: '', // Title of the PDF Document
                    filename: 'Danh sách', // Name of the pdf file
                    // extension: '.pdf', // File extension
                    // orientation: 'portrait', // Paper orientation for the created PDF. This can be [portrait] or [landscape]
                    pageSize: 'A4', // Paper size for the created PDF. This can be [A3], [A4], [A5], [LEGA], [LETTER] or [TABLOID]
                    message: 'ToanNang Co., Ltd', // Optional description message that will be shown above the table in the created PDF. Please note that this option is now deprecated in favour of the
                    messageTop: 'TOP', // Message to be shown at the top of the table, or the caption tag if displayed at the top of the table.
                    messageBottom: 'BOTTOM', // Message to be shown at the bottom of the table, or the caption tag if displayed at the bottom of the table.
                    exportOptions: {// exportOption to save only data shown on the current Datatable page
                        modifier: {
                            page: 'current'
                        }
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i> {{__("label.print")}}'
                }
            ],
            // ========== Custom số lượng hiển thị =====================================================================
            lengthMenu: Option_lenght,
            //lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "{{__('label.tatca')}}"]],
            // ========== Mặc định sort cột thứ 2 ========================= ============================================
            order: [
                [1, 'asc']
            ],
            // ========== Custom ngôn ngữ hiển thị =====================================================================
            language: packageLang
        });
        // Ordinal number update

        datatbl.on('click', 'td i', function (e) {
            e.stopImmediatePropagation(); // stop the row selection when clicking on an icon

            editor.inline($(this).parent());
        });
        //

        datatbl.on('xhr', function (e, settings, json) {
            //console.log('Ajax event occurred. Returned data: ', settings);
        });
        //
        $('#jquery-datatable-default tbody').on('click', 'td i', function (e) {
            e.stopImmediatePropagation(); // stop the row selection when clicking on an icon
            editor.inline($(this).parent());
        });
        datatbl.on('stateLoaded.dt', function (e, settings, data) {
            console.log(data.myCustomValue);
        });
        // ========== Tạo index cho cột đầu tiên =======================================================================
        datatbl.on('order.dt search.dt page.dt', function () {
            datatbl.column(0).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
//            datatbl.column(7).nodes().each(function (cell, i) {
//                cell.innerHTML = "<button data-datatbl='jquery-datatable-default' data-action='remove' class='js-datatables-btn'>{{__('label.xoa')}}</button>\n\
//                <button data-datatbl='jquery-datatable-default' data-action='edit' class='js-datatables-btn'>{{__('label.sua')}}</button>";
//            });
            // ========== Set Event cho các button thao tác ============================================================
        }).draw();
        $('.js-datatables-btn').on('click', function () {
            $(this).off('click');
        });
        // ========== SET EVENT ========================================================================================
        datatbl.on('click.dt', '.js-datatables-btn', function (e) {
            // Select phần tử cha của Button
            var tbl_row = $(this).parents('tr');
            // Lấy data của row hiện tại
            var tbl_row_data = datatbl.row(tbl_row).data();
            // Get Id từ row data
            var tbl_row_id = tbl_row_data.id;
            // Get data của Button
            var btn_data = $(this).data();
            switch (btn_data.action) {
                case 'redirect':
                    window.location.href = '{{route("admin_category_edit",[$tbl,$type])}}/' + tbl_row_id;
                    break;
                case 'delete':
                    // Tham số id luôn bỏ vào dạng Array
                    datatables_delete([tbl_row_id], tbl_row);
                    break;
                default:
                    return;
            }

        });
        datatbl.on('change', 'input.jquery-datatbl-checkbox', function () {
            var tmp_f = $(this).data('f');
            editor
                    .edit($(this).closest('tr'), false)
                    .set(tmp_f, $(this).prop('checked') ? 1 : 0)
                    .submit();
        });
    }

    function datatables_refresh() {
        datatbl.ajax.reload();
    }

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
                tbl: '{{$tbl}}',
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
                                                tbl: '{{$tbl}}',
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
            }, error: function (data) {
            }
        });
    }


</script