
@extends('client.layouts.master')

@section('content')
<div class="row user-wall">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('client.user.parts.nav_left')
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12">
                        <ol class="breadcrumb">
                            <li><a href="{{route('client_index')}}"><i class="fa fa-home"></i> Trang chủ</a></li>
                            <li><a href="{{route('client_user_info')}}"> Thông tin cá nhân</a></li>
                            <li><a href="javascript:void(0)">Ảnh đại diện</a></li>
                        </ol>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">

                        @if(Session::has('page-callback'))
                        @php
                        $pc = Session('page-callback');
                        @endphp
                        <div class="alert alert-{{$pc->type}}">
                            <p>{{$pc->message}}</p>
                        </div>
                        @endif

                        <form class="form form-horizontal" name="frm_update_profile_picture" method="post" enctype="multipart/form-data" action="{{route('_client_user_caidat')}}">
                            {{csrf_field()}}
                            <input type="hidden" name="act" value="update_profilePicture" />
                            <input type="hidden" name="cwu" value="{{url()->current()}}" />
                            <div class="panel panel-default">
                                <div class="panel-heading"><i class="fa fa-user"></i> Ảnh đại diện</div>
                                <div class="panel-body">

                                    <div class="alert alert-info">
                                        <p><strong><i class="fa fa-info"></i> Có thể bạn biết rồi! </strong> Cập nhật ảnh đại diện để cho mọi người biết bạn là ai,
                                            tăng khả năng kết bạn/giao lưu với tất cả mọi người trong cộng đồng học tập.</p>
                                    </div>

                                    <div class="form-group">
                                        <label for="nameOfTheInput" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Hình hiện tại:</label>
                                        <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                            <img src="{{$item->photo_url}}" class="thumbnail" style="height: auto;max-width: 100%"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="profile_picture" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Ảnh đại diện:</label>
                                        <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                            <input type="file" name="profile_picture" id="profile_picture" 
                                                   class="form-control" />
                                            <p class="text-info"><i class="fa fa-info"></i> Kích thước đề xuất: 250x250px</p>
                                        </div>
                                    </div>

                                </div>
                                <div class="panel-footer">
                                    <div class="form-group">
                                        <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 col-md-offset-2">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Cập nhật</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
