@push('stylesheet')
<style>
    .table-effect tr{
        transition: 1s ease;
    }
    .table-effect tr,th,td{
        text-align: center;
    }
</style>
@endpush
<table class="table table-bordered table-effect">
    <thead>
        <tr>
            <th>{{__('label.stt')}}</th>
            <th>{{__('label.ten')}}</th>
            <th><i class="fa fa-list" title="Danh mục"></i></th>
            <th><i class="fa fa-image"></i></th>
            <th>{{__('label.gia')}}</th>
            <th> Giá KM</th>
            <th><i class="fa fa-eye"></i></th>
            <th><i class="fa fa-clock-o"></i></th>
            <th><i class="fa fa-star" title="Nổi bật"></i></th>
            <th>{{__('label.hienthi')}}</th>
            <th>{{__('label.thaotac')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach(@$items as $k=>$v)
        <tr>
            <td style="width:5%"><input class="jquery-bcore-textbox" data-id="{{$v->id}}" data-field="ordinal_number" data-tbl="{{$v->tbl}}" data-action="uf" style="width:100%" type="number" value="{{$v->ordinal_number}}"></td>
            <td style="width:30%">
                <a href="{{route('admin_product_edit',[$type,$v->id])}}">{{@$v->name}} <i class="fa fa-pencil"></i></a>
            </td>
            <td>
                @if($v->data_category!=null)
                {{$v->data_category->name}}
                @endif
            </td>
            <td>
                @if($v->data_photo!=null)
                <img class="thumbnail" style="width:40px;height:40px;" src="{{html_image($v->data_photo->url_encode,50,50)}}" />
                @else
                No image
                @endif
            </td>
            <td><b>{{ number_format(@$v->price,0) }}</b> VNĐ</td>
            <td>{{@$v->promotion_price==0?'#':number_format($v->promotion_price,0).' VNĐ'}}</td>
            <td>{{$v->views}}</td>
            <td>{{ $v->created_at }}</td>
            <td><input type="checkbox" data-id="{{$v->id}}" data-field="highlight" data-tbl="{{$v->tbl}}" data-action="ub" {{@$v->highlight==1?'checked=""':''}} class="js-switch" name="display" data-switchery="true" style="display: none;"></td>
            <td><input type="checkbox" data-id="{{$v->id}}" data-field="display" data-tbl="{{$v->tbl}}" data-action="ub" {{@$v->display==1?'checked=""':''}} class="js-switch" name="display" data-switchery="true" style="display: none;"></td>
            <td style="width: 20%">
                <a href="{{route('admin_product_edit',[$type,$v->id])}}" data-id="{{$v->id}}" data-tbl="{{$v->tbl}}" data-action="edit" class="btn btn-default"><i class="fa fa-edit"></i></a>
                <a href="javascript:void(0)" data-id="{{$v->id}}" data-tbl="{{$v->tbl}}" data-action="remove" class="btn btn-danger jquery-button-remove"><i class="fa fa-remove"></i></a>
                <a href="javascript:void(0)" data-id="{{$v->id}}" data-tbl="{{$v->tbl}}" data-action="view" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                <a href="javascript:void(0)" data-id="{{$v->id}}" data-tbl="{{$v->tbl}}" data-action="report" class="btn btn-success"><i class="fa fa-line-chart"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align:center;" colspan="11"> {{@$items->links()}}</td>
        </tr>
    </tfoot>
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

