
@extends('client.layouts.master')

@section('content')
<div class="examonline">
    <div class="sup-nav">
        <a href="{{route('client_index')}}"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a> 
        <i class="fa fa-angle-double-right"></i>
        <a href="javascript:void(0)">{{$item->title}}</a>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading"><i class="fa fa-info"></i> {{$item->title}}</div>
                <div class="panel-body">
<!--                    <div class="alert alert-info">
                        {!!$item->description!!}
                    </div>-->
                    <div class="col-md-12">
                        {!!$item->content!!}
                    </div>
                </div>
                <div class="panel-footer">
                    <p>Từ khóa: {{$item->seo_keywords}}</p>
                    <a href="{{route('client_index')}}" class="btn btn-default"><i class="fa fa-home"></i> Trang chủ</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection