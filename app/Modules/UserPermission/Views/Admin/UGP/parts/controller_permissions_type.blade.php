<h3>{!!$type_data['name']!!}</h3>
<ul>
    @foreach($items as $k=>$v)
    <li style="margin: 5px 0px;">
        <div class="col-md-3">
            {!!$v['name']!!} 
        </div>
        <div class="col-md-2">
            <div class="label label-info">{{$k}}</div>
        </div>
        <div class="col-md-1">
            <input type="checkbox" name="permissions[{{$id_controller}}][{{$type}}][{{$k}}]" class="js-switch"/>
        </div>
        <div class="clearfix"></div>
    </li>
    @endforeach
</ul>