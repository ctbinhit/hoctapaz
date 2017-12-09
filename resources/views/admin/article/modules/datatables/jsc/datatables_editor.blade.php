@push('scripts')
<script>
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
</script>
@endpush