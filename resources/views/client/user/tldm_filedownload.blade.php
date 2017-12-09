
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
                            <li><a href="{{route('client_user_tailieudamua')}}">Tài liệu đã mua</a></li>
                            <li><a href="{{route('client_user_tailieudamua')}}">Tài liệu {{$item->name}}</a></li>
                        </ol>
                    </div>
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"><i class="fa fa-download"></i> Tài liệu: {{$item->name}}</div>
                            <div class="panel-body">
                                <div class="list-files">
                                    <h4>{{$item->do->name}}</h4>
                                    <p>Size: <strong>{{number_format($item->do->size/1024/1024,1)}} MB</strong></p>
                                    <p>Định dạng: <strong>{{$item->do->mimetype}}</strong></p>

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{url()->previous()}}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Quay lại</a>
                                        <a href="{{route('file_private',[$item->id,$item->do->url_encode])}}" target="_blank" class="btn btn-default"><i class="fa fa-download"></i> Tải về máy tính</a>
                                    </div>
                                    <div class="col-md-1 col-md-offset-5 text-right">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" />
@endsection

@push('stylesheet')
<style>
    .personal-name{font-size: 16pt;text-align:center;color: #001D8D;font-weight:bold;}
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function () {


    });
</script>
@endpush