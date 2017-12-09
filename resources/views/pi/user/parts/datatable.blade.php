@push('stylesheet')
<style>
    .table-effect tr{
        transition: 1s ease;
    }
    .table-effect th{
        text-align: center;
    }
</style>
@endpush
<table class="table table-hover table-effect">
    <thead>
        <tr>
<!--            <th>#</th>-->
            <th>{{__('label.stt')}}</th>
            <th>{{__('label.ten')}}</th>
            <th><i class="fa fa-image"></i></th>
            <th>{{__('label.hienthi')}}</th>
            <th>{{__('label.thaotac')}}</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($items))
        @foreach($items as $k=>$item)
        <tr>
            <td style="width:5%">{{@$item->id}}</td>
            <td style="width:40%">
                <a href="{{route('admin_user_edit')}}">{{$item->fullname}} <i class="fa fa-pencil"></i></a>
            </td>
            <td>
                @if(isset($items_photo->photo[$item->id][0]))
                <img class="thumbnail" style="width:65px;height:50px;" src="{{ route('storage',[Crypt::encryptString($items_photo->photo[$item->id][0]->url)]) }}" />
                @else
                #
                @endif
            </td>
            <td style="width: 10%;"><input type="checkbox" data-id="{{$item->id}}" data-field="highlight" data-tbl="{{$item->tbl}}" data-action="ub" {{@$item->highlight==1?'checked=""':''}} class="js-switch" name="display" data-switchery="true" style="display: none;"></td>

            <td style="width: 20%">
                <a href="{{route('admin_user_edit',[$item->id])}}" data-id="{{$item->id}}" data-tbl="{{$item->tbl}}" data-action="edit" class="btn btn-default"><i class="fa fa-edit"></i></a>
                <a href="javascript:void(0)" data-id="{{$item->id}}" data-tbl="{{$item->tbl}}" data-action="remove" class="btn btn-danger jquery-button-remove"><i class="fa fa-remove"></i></a>
                <a href="javascript:void(0)" data-id="{{$item->id}}" data-tbl="{{$item->tbl}}" data-action="view" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                <a href="javascript:void(0)" data-id="{{$item->id}}" data-tbl="{{$item->tbl}}" data-action="report" class="btn btn-success"><i class="fa fa-line-chart"></i></a>
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
    @if(isset($items))
    <tfoot>
        <tr>
            <td style="text-align:center;" colspan="10"> {{$items->links()}}</td>
        </tr>
    </tfoot>
    @endif
</table>

@push('scripts')
<script>
    $(document).ready(function () {
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

