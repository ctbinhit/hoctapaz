@push('stylesheet')
<style>
    .table-effect tr{
        transition: 1s ease;
    }
    .table-effect th,td{
        text-align: center;
    }
</style>
@endpush
<table class="table table-hover table-effect">
    <thead>
        <tr>
            <th>{{__('label.stt')}}</th>
            <th>{{__('label.ten')}}</th>
            <th>VIP</th>
            <th><i class="fa fa-envelope"></i></th>
            <th><i class="fa fa-phone"></i></th>
            <th>{{__('label.sodu')}}</th>
            <th>{{__('label.ngaytao')}}</th>
            <th><i class="fa fa-image"></i></th>
            <th>{{__('label.thaotac')}}</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($items))
        @foreach($items as $k=>$item)
        <tr>
            <td style="width:5%">{{@$k+1}}</td>
            <td style="width:30%">
                <a href="{{route('admin_user_edit')}}">{{$item->fullname}} <i class="fa fa-pencil"></i></a>
            </td>
            <td>#</td>
            <td>{{$item->email}}</td>
            <td>{{$item->phone}}</td>
            <td>{{$item->coin}} VNĐ</td>
            <td>{{$item->created_at}}</td>
            </td>
            <td>
                <img src="{{$item->facebook_avatar}}" style="width:30px;height:30px;border-radius:50%;" title="{{$item->fullname}}"/>
            </td>

            <td style="width: 20%">
                <a href="{{route('admin_user_partner_edit',[$item->id])}}" data-id="{{$item->id}}" data-tbl="{{$item->tbl}}" data-action="edit" class="btn btn-default"><i class="fa fa-edit"></i></a>
                <a href="javascript:void(0)" class="btn btn-info"><i class="fa fa-envelope"></i></a>
                <a href="javascript:void(0)" class="btn btn-primary"><i class="fa fa-plus"></i> Coin</a>
                @if($item->lock_by!=null)
                <a href="{{route('admin_user_partner_lock',$item->id)}}" class="btn btn-danger" title="Mở khóa"><i class="fa fa-lock"></i></a>
                @else
                <a href="{{route('admin_user_partner_lock',$item->id)}}" class="btn btn-success" title="Khóa tài khoản này"><i class="fa fa-unlock"></i></a>
                @endif

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

