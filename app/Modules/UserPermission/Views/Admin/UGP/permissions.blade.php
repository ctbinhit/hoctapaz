@extends('admin.layouts.master')

@section('content')
<form action="{{route('_mdle_ugp_permissions_save',$item->id)}}" method="POST" class="form form-horizontal">
    {{csrf_field()}}
    <input type="hidden" name="id" value="{{$item->id}}" />
    
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Quyền {{$item->name}}</h3>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="x_panel">
            <div class="x_content">
                <a href="{{url()->previous()}}" class="btn btn-app"><i class="fa fa-arrow-left"></i> Quay lại</a>
                <a href="{{route('admin_index')}}" class="btn btn-app"><i class="fa fa-dashboard"></i> Dashboard</a>
                <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>
                <button type="submit" class="btn btn-app"><i class="fa fa-save"></i> Cập nhật</button>
            </div>
        </div>

        <div class="x_panel">
            <div class="x_title">
                <h2> Danh sách controllers <small></small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @foreach($LPR as $k=>$v)

                <div style="background: #F3F3F3;">
                    <h2 style="background: #333;padding: 15px;color:#FFF;">{{$k}}</h2>

                    <div style="padding: 10px 15px;">
                        @if(is_array($v))

                        @foreach($v as $k1=>$v1)
                        {!!$v1!!}
                        @endforeach

                        @else
                        {!!$v!!} <br>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</form>
@endsection