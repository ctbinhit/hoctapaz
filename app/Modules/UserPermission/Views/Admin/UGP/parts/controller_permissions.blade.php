
<ul>
    @foreach($items as $k1=>$per)
    <li style="margin:5px 0px;">
        <div class="col-md-3">{{$per['name']}}</div>
        <div class="col-md-2">
            <div class="label label-info">{{$k1}}</div>
        </div>
        <div class="col-md-2">Mặc định: {!!$per['default']?'<i class="fa fa-check"></i>':'<i class="fa fa-remove"></i>'!!}</div>
        <div class="col-md-1"><input type="checkbox" name="permissions[{{$id_controller}}][{{$k1}}]" class="js-switch"></div></li>
    @endforeach
</ul>

