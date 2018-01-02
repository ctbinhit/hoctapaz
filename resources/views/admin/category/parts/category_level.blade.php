
<span class="input-group-btn">
    <select style="width: 150px" class="form-control" id="js-select-category" name="category[0]">
        <option>-- Chọn DM --</option>
        @foreach($items as $item)
        <option value="{{$item->id}}"> {{$item->name}}</option>
        @endforeach
    </select>
</span>
