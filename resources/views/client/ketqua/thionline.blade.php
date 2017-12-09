
@extends('client.layouts.master')

@section('content')
<div class="examonline">
    <div class="sup-nav">
        <a href="{{route('client_index')}}"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a> 
        <i class="fa fa-angle-double-right"></i>
        <a href="javascript:void(0)">Kết quả thi</a>
        <i class="fa fa-angle-double-right"></i>
        <a href="javascript:void(0)">{{$user_result->code}}</a>
    </div>
    <div class="exam-left">
        @include('client.layouts.left')
    </div>
    <div class="exam-right">
        <div class="panel panel-primary">
            <div class="panel-heading"><i class="fa fa-info"></i> Kết quả thi {{$exam->name}}</div>
            <div class="panel-body">
                <p>Tên người thi: <b>{{$user->fullname}}</b></p>
                <p>Số điểm: {{$user_result->score}} điểm</p>
                <p>Thời gian thi: {{$user_result->time_end}} giây</p>
                <p>Ngày thi: {{$user_result->created_at}}</p>
            </div>
            <div class="panel-footer">
                <a href="{{route('client_index')}}" class="btn btn-default"/>
                <i class="fa fa-home"></i> Trang chủ</a>
                <a href="{{route('client_exam_phongthi')}}" class="btn btn-primary"/>
                <i class="fa fa-users"></i> Phòng thi online</a>
            </div>
        </div>

    </div>
</div>
@endsection