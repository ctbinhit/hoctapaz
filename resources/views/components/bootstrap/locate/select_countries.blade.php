@if(count($items)!=0)
<select name="id_country" class="form-control">
    @foreach($items as $v)
    <option value="{{$v->id}}">{{$v->name}}</option>
    @endforeach
</select>
@else
<select name="id_country" class="form-control" disabled="">
    <option>-- Không có dữ liệu --</option>
</select>
@endif