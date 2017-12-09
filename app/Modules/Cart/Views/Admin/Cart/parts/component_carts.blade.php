<style>
    .unread{
        font-weight: bold;
        background: #fff3f3;
    }
</style>
<table class="table table-bordered">

    <thead>
        <tr>
            <td>STT</td>
            <td><i class="fa fa-clock-o"></i></td>
            <td>Tên người đặt</td>
            <td>SĐT</td>
            <td>Tổng tiền</td>
            <td>VIP</td>
            <td>Trạng thái</td>
            <td>Thao tác</td>
        </tr>
    </thead>

    <tbody>
        @if(count($items)!=0)
        @foreach($items as $k=>$v)
        <tr class="{{$v->seen==0?'unread':''}}">
            <td>{{$k+1}}</td>
            <td title="{{$v->created_at}}">{{$v->diffInNow}}</td>
            <td>{{$v->name}}</td>
            <td>{{$v->phone}}</td>
            <td>{{number_format($v->total,0)}} VNĐ</td>
            <td></td>
            <td>
                <select class="form-control" name="state" disabled="">
                    @foreach($list_state as $state)
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
            <td colspan="10" class="text-center">Không có dữ liệu.</td>
        </tr>
        @endif
    </tbody>

    <tfoot>
        <tr>
            <td colspan="6">
                Tổng đơn hàng đặt trong ngày: 
            </td>
            <td colspan="2">
                {{$items->links()}}
            </td>
        </tr>

    </tfoot>

</table>

