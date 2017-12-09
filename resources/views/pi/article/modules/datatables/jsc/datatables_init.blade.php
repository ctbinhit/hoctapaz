@push('scripts')
<script>
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
            // ========== Mặc định sort cột thứ 2 ======================================================================
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
                    window.location.href = '{{route("admin_article_edit",[$type])}}/' + tbl_row_id;
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
</script>
@endpush