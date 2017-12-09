@push('stylesheet')

<link href="{!! asset('public/plugins/Nestable2-master/jquery.nestable.css') !!}" rel="stylesheet">

<style type="text/css">
  .cf:after {
        visibility: hidden;
        display: block;
        font-size: 0;
        content: " ";
        clear: both;
        height: 0
    }
 
    h1 {
        font-size: 1.75em;
        margin: 0 0 .6em 0
    }
    a {
        color: #2996cc
    }
    a:hover {
        text-decoration: none
    }
    p {
        line-height: 1.5em
    }
    .small {
        color: #666;
        font-size: .875em
    }
    .large {
        font-size: 1.25em
    }
    .nestable-lists {
        display: block;
        clear: both;
        padding: 30px 0;
        width: 100%;
        border: 0;
        border-top: 2px solid #ddd;
        border-bottom: 2px solid #ddd
    }
    #nestable-menu {
        padding: 0;
        margin: 20px 0
    }
    #nestable-output,
    #nestable2-output {
        width: 100%;
        height: 7em;
        font-size: .75em;
        line-height: 1.333333em;
        font-family: Consolas, monospace;
        padding: 5px;
        box-sizing: border-box;
        -moz-box-sizing: border-box
    }
    #nestable2 .dd-handle {
        color: #fff;
        border: 1px solid #999;
        background: #bbb;
        background: -webkit-linear-gradient(top, #bbb 0%, #999 100%);
        background: -moz-linear-gradient(top, #bbb 0%, #999 100%);
        background: linear-gradient(top, #bbb 0%, #999 100%)
    }
    #nestable2 .dd-handle:hover {
        background: #bbb
    }
    #nestable2 .dd-item>button:before {
        color: #fff
    }
    @media only screen and (min-width: 700px) {
        .dd {
            float: left;
            width: 48%
        }
        .dd+.dd {
            margin-left: 2%
        }
    }
    .dd-hover>.dd-handle {
        background: #2ea8e5!important
    }
    .dd3-content {
        display: block;
        height: 30px;
        margin: 5px 0;
        padding: 5px 10px 5px 40px;
        color: #333;
        text-decoration: none;
        font-weight: bold;
        border: 1px solid #ccc;
        background: #fafafa;
        background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
        background: -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
        background: linear-gradient(top, #fafafa 0%, #eee 100%);
        -webkit-border-radius: 3px;
        border-radius: 3px;
        box-sizing: border-box;
        -moz-box-sizing: border-box
    }
    .dd3-content:hover {
        color: #2ea8e5;
        background: #fff
    }
    .dd-dragel>.dd3-item>.dd3-content {
        margin: 0
    }
    .dd3-item>button {
        margin-left: 30px
    }
    .dd3-handle {
        position: absolute;
        margin: 0;
        left: 0;
        top: 0;
        cursor: pointer;
        width: 30px;
        text-indent: 30px;
        white-space: nowrap;
        overflow: hidden;
        border: 1px solid #aaa;
        background: #ddd;
        background: -webkit-linear-gradient(top, #ddd 0%, #bbb 100%);
        background: -moz-linear-gradient(top, #ddd 0%, #bbb 100%);
        background: linear-gradient(top, #ddd 0%, #bbb 100%);
        border-top-right-radius: 0;
        border-bottom-right-radius: 0
    }
    .dd3-handle:before {
        content: '≡';
        display: block;
        position: absolute;
        left: 0;
        top: 3px;
        width: 100%;
        text-align: center;
        text-indent: 0;
        color: #fff;
        font-size: 20px;
        font-weight: normal
    }
    .dd3-handle:hover {
        background: #ddd
    }
</style>
@endpush
@push('scripts')
<!-- Sortable -->
<script src="{!! asset('public/plugins/Nestable2-master/jquery.nestable.js')!!}"></script>
<script>
    $(document).ready(function () {
        $('.jquery-input-file').on('click', function () {
            var that = this;
            $('#' + $(this).data('input')).click();
            $('#' + $(this).data('input')).on('change', function (evt) {
                if (this.value == '') {

                } else {
                    $('.jquery-input-file-remove[data-input="photo"]').removeAttr('disabled');
                    $('#photo_preview').attr('src', URL.createObjectURL(evt.target.files[0]));
                    $(that).text(this.value);
                }
            });
        });
        $('.jquery-input-file-remove').on('click', function () {
            $('#' + $(this).data('input'))[0].value = null;
            $('.jquery-input-file[data-input="photo"]').text('Chọn file...');
            $(this).attr('disabled', 'disabled');
        });
    });
</script>
<script>
    $(document).ready(function () {
        var firstTime = true;
        var updateOutput = function (e)
        {
            var list = e.length ? e : $(e.target),
                    output = list.data('output');
            if (window.JSON) {
//                console.log(window.JSON.stringify(list.nestable('serialize')));
//                console.log(list.nestable('serialize'));
                if (firstTime == false) {
                    var data = {
                        bcore_action: 'update_lst_cate_position',
                        categories: list.nestable('serialize')
                    };
                    $.ajax({
                        url: '{!!route("admin_category_ajax")!!}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function (xhr) {
                            $('#jquery-status-sortable').html('<i class="fa fa-spinner faa-spin animated"></i> {{__("message.dangluu")}}');
                            $('#jquery-status-sortable').fadeIn();
                        },
                        type: 'POST',
                        dataType: 'json',
                        data: data
                        , success: function (data) {
                            var res = true;
                            $.each(data.result, function (k, v) {
                                if (v == false) {
                                    res = false;
                                }
                            });
                            if (res == true) {
                                $('#jquery-status-sortable').html('<i class="fa fa-check"></i> {{__("message.daluu")}}');
                            } else {
                                $('#jquery-status-sortable').html('<i class="fa fa-error"></i> {{__("message.coloixayratrongquatrinhxuly")}}');
                            }
                        }, error: function (data) {
                            console.log(data.responseText);
                        }
                    });
                }
                firstTime = false;
            } else {
                // output.val('JSON browser support required for this demo.');
            }
        };
        $('#sortable_categories').nestable({
            maxDepth: 2,
            callback: function (l, e) {
                // l is the main container
                // e is the element that was moved
            }
        }).on('change', updateOutput)
                .on('drag', function (event, item, source, destination) {
                    // item: item we're moving.
                    // source: original source of the item.
                    // destination: new position of the item.
                    console.log(event);
                });
        updateOutput($('#sortable_categories').data('output', function () {

        }));

        $('.dd3-content').on('click', function () {
            $('#category_name').val($(this).data('text'));
            $('#id_category').val($(this).data('id'));
        });
    });</script>

@endpush