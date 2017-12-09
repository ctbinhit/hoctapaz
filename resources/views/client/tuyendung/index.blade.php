@extends('client.layouts.master')

@section('content')
<div class="row" style="margin: 50px 0px 250px 0px">
    <div class="container">
        <div class="row">
            @if(isset($items))
            @foreach($items as $k=>$v)
            <div class="col-md-4">
                <img src="{{route('storage_google',[@$data_photos['photo'][0]['url']])}}" style="width: 100%;height: 200px;" class="thumbnail"/>
                <div class="name">
                    <h4 style="text-align: center;font-size: 10pt;">{{$v->name}}</h4>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
@endsection