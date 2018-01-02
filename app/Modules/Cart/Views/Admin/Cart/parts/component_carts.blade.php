<style>
    table th,td{text-align: center;}
    .unread{
        font-weight: bold;
        background: #fff3f3;
    }
</style>
<table class="table table-bordered">

    <thead>
        <tr>
            <th><i class="fa fa-sort-numeric-desc"></i></th>
            <th data-toggle="tooltip" data-placement="top" title="Ngày đặt hàng"><i class="fa fa-clock-o"></i></th>
            <th data-toggle="tooltip" data-placement="top" title="Người đặt hàng"><i class="fa fa-user"></i></th>
            <th data-toggle="tooltip" data-placement="top" title="Email"><i class="fa fa-envelope"></i></th>
            <th data-toggle="tooltip" data-placement="top" title="Số điện thoại"><i class="fa fa-phone"></i></th>
            <th data-toggle="tooltip" data-placement="top" title="Tổng giá trị đơn hàng"><i class="fa fa-money"></i></th>
            <th class="tr_trangthai" width="15%" data-toggle="tooltip" data-placement="top" title="Trạng thái đơn hàng">Trạng thái</th>
            <th>Thao tác</th>
        </tr>
    </thead>

    <tbody>
        @if(count($items)!=0)
        @foreach($items as $k=>$v)
        <tr data-id="{{$v->id}}" class="{{$v->seen==0?'unread':''}}">
            <td>{{$k+1}}</td>
            <td data-toggle="tooltip" data-placement="top" title="{{$v->created_at}}">{{diffInNow($v->created_at)}}</td>
            <td data-toggle="tooltip" data-placement="top" title="{{$v->phone}}">{{$v->name}}</td>
            <td><i class="label label-info">{{$v->email}}</i></td>
            <td><i class="label label-info">{{$v->phone}}</i></td>
            <td>{{number_format($v->total_amount,0)}} VNĐ</td>
            <td>
                <select class="form-control js-selectChangeState" name="state">
                    @foreach($stateList as $state)
                    <option {{$state->id==$v->state?'selected':''}} value="{{$state->id}}">{{$state->name}}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <a href="{{route('mdle_admin_cart_detail',$v->id)}}" title="Xem chi tiết đơn hàng" class="btn btn-default"><i class="fa fa-list"></i></a>
            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="11" class="text-center">Không có dữ liệu.</td>
        </tr>
        @endif
    </tbody>

    <tfoot>
        <tr>
            <td colspan="6">
                Tổng đơn hàng đặt trong ngày: 
            </td>
            <td colspan="4">
                {{$items->links()}}
            </td>
        </tr>
    </tfoot>
</table>
<input type="hidden" id="mdle_admin_cart_ajax" value="{{route('_mdle_admin_cart_ajax')}}" />
<script>
    $('.js-selectChangeState').on('change', function () {

        var this_tr = $(this).parents('tr');
        var state_val = $(this).val();
        $.ajax({
            url: $('#mdle_admin_cart_ajax').val(),
            type: 'POST',
            beforeSend: function(){
                $('.tr_trangthai').html('<i class="fa fa-spinner faa-spin animated"></i> Đang lưu...');
            },
            dataType: 'json',
            data: {
                act: 'cs',
                id: $(this_tr).data('id'),
                state: state_val
            }, success: function (data) {
                if(data.state){
                    $('.tr_trangthai').html('<i class="fa fa-check"></i> Đã lưu...');
                    setTimeout(function(){
                        $('.tr_trangthai').html('Trạng thái');
                    },3000);
                }else{
                    $('.tr_trangthai').html('<i class="fa fa-warning"></i> Error');
                }
            }, error: function (data) {
                console.log(data);
            }
        });
    });
</script>