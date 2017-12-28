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
<table class="table table-bordered table-effect">
    <thead>
        <tr>
<!--            <th>#</th>-->
            <th>{{__('label.stt')}}</th>
            <th>{{__('label.ten')}}</th>
            <th><i class="fa fa-envelope"></i></th>
            <th><i class="fa fa-phone"></i></th>
            <th>{{__('label.sodu')}}</th>
            <td title="User VIP"><i class="fa fa-star"></i></td>
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
            <td style="width:20%">
                <a href="{{route('admin_user_edit',[$type,$item->id])}}">{{$item->fullname or ''}} <i class="fa fa-pencil"></i></a>
            </td>
            <td><i class="label label-info">{{$item->email}}</i></td>
            <td><i class="label label-info">{{$item->phone}}</i></td>
            <td><i class="label label-info"><strong>{{number_format($item->coin,0)}}</strong> VNĐ</i></td>
            <td><i class="label label-warning">{{$item->vip_name!=null?$item->vip_name:'0'}}</i></td>
            <td data-toggle="tooltip" data-placement="top" title="{{$item->created_at}}">{{diffInNow($item->created_at)}}</td>
            </td>
            <td>
                <img src="{{html_thumbnail($item->photo_url,30,30)}}" style="width:30px;height:30px;border-radius:50%;" title="{{$item->fullname}}"/>
            </td>

            <td style="width: 25%">
                <a href="{{route('admin_user_edit',[$type,$item->id])}}" data-id="{{$item->id}}" data-tbl="{{$item->tbl}}" data-action="edit" class="btn btn-default btn-xs"><i class="fa fa-edit"></i></a>
                <a href="javascript:void(0)" class="btn btn-info btn-xs"><i class="fa fa-envelope"></i></a>
                <a href="javascript:void(0)" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Coin</a>
                <a href="{{route('admin_user_vip',[$type,$item->id])}}" class="btn btn-info btn-xs" title="Nâng cấp vip"><i class="fa fa-star"></i> VIP</a>
                @if($item->lock_by!=null)
                <a href="{{route('admin_user_lock',[$type,$item->id])}}" class="btn btn-danger btn-xs" title="Mở khóa"><i class="fa fa-lock"></i></a>
                @else
                <a href="{{route('admin_user_lock',[$type,$item->id])}}" class="btn btn-success btn-xs" title="Khóa tài khoản này"><i class="fa fa-unlock"></i></a>
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

