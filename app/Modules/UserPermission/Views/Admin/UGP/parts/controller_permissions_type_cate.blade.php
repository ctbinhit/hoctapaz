<h3>{!!$type_data['name']!!}</h3>
@if(count($categories)!=0)
<ul style="padding:5px;list-style: none;">
    @foreach($categories as $k=>$v)
    <li><h4 style="color: #F00;"><i class="fa fa-list"></i> {{$v->name}}</h4>
        <ul>
            @foreach($items as $k1=>$v1)
            <li style="margin: 5px 0px;">
                <div class="col-md-3">
                    {!!$v1['name']!!}
                </div>
                <div class="col-md-2">
                    <div class="label label-info">{{$k1}}</div>
                </div>
                <div class="col-md-1">
                    <input type="checkbox" name="permissions[{{$id_controller}}][{{$type}}][{{$v->id}}][{{$k1}}]" class="js-switch"/>
        </div>
        <div class="clearfix"></div>
            </li>
            @endforeach
        </ul>
    </li>
    @endforeach

</ul>
@else
<p>Không có danh mục nào.</p>
@endif