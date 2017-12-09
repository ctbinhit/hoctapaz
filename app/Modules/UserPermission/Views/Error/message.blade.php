
@extends('admin.layouts.master')
@section('content')
<div class="">

    <ol class="breadcrumb">
        <li><a href="{{route('admin_index')}}">Dashboard</a></li>
        <li><a href="#">Error permission</a></li>
    </ol>

    <div class="x_panel">
        <div class="x_content">
            <div class="alert alert-danger">
                <h2>Thông báo!</h2>
                <p>
                    {{$info->message}}
                </p>
            </div>
            <a href="{{url()->previous()}}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Quay lại</a>
            <a href="{{route('admin_index')}}" class="btn btn-default"><i class="fa fa-home"></i> Trang chủ</a>
        </div>
    </div>
</div>
@endsection