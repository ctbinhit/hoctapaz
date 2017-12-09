@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Thông tin chi tiết <small> {{$item->name}}</small></h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Thao tác</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="" method="POST">
                        <a href="{{route('admin_examman_approver')}}" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Quay lại</a>
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{$item->id}}" />
                        <button type="submit" class="btn btn-lg btn-success"><i class="fa fa-check"></i> Xác nhận</button>
                        <a href="{{route('admin_examman_approver_reject',$item->id)}}" class="btn btn-lg btn-warning"><i class="fa fa-envelope"></i> Từ chối</a>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Thông tin chung</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <p>Đề thi: {{$item->name}}</p>
                    <p>Mô tả: {{$item->description}}</p>
                    <p>Thời gian: {{$item->time/60}} phút</p>
                    <p>Giá tiền: {{$item->price}} VNĐ/Lượt</p>
                    <p>Seo title: {{$item->seo_title}}</p>
                    <p>Seo description: {{$item->seo_description}}</p>
                    <p>Seo keywords: {{$item->seo_keywords}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>File PDF</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    Loading...
                </div>
            </div>
        </div>

    </div>
</div>

@endsection


