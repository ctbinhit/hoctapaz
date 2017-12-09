@if($items!=null)
@if(count(array_except($items,'sum'))!=0)
    @foreach(array_except($items,'sum') as $k=>$v)
    <tr data-code="{{$v->product_code}}" data-name="{{$v->product_name}}" style="position: relative;">
        <td>{{$k+1}}</td>
        <td><div class="label label-info">{{$v->product_name}}</div></td>
        <td><span>{{number_format($v->product_real_price,0)}}</span> VNĐ</td>
        <td><input type="number" class="form-control jquery-jcc-productCount" name="product_count" value="{{$v->product_count}}"/></td>
        <td><span>{{number_format($v->total,0)}}</span> VNĐ</td>
        <td>
            <a href="javascript:void(0)" class="jquery-jcc-remove-item btn btn-danger btn-sm" 
               title="Xóa sản phẩm này khỏi giỏ hàng."><i class="fa fa-trash"></i></a>
        </td>
    </tr>
    @endforeach
@else
<tr>
    <td colspan="10" class="text-info text-center">Không có sản phẩm nào trong giỏ hàng.</td>
</tr>
@endif
@else
<tr>
    <td colspan="10" class="text-info text-center">Không có sản phẩm nào trong giỏ hàng.</td>
</tr>
@endif