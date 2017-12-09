
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
                            <li><a href="javascript:void(0)">Tài liệu đã mua</a></li>
                        </ol>
                    </div>
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"><i class="fa fa-folder"></i> Tài liệu đã mua</div>
                            <div class="panel-body">
                                <div class="list-files">
                                    @if(count($files)!=0)
                                    @foreach($files as $k=>$v)
                                    <div class="file">
                                        <span class="file-name"><i class="fa fa-file-pdf-o"></i> {{$v->do->name}}</span>
                                        <div class="file-description">{!!$v->do->description!!}</div>

                                        <div class="file-date">{{$v->do->created_at}}</div>
                                        <div class="action-right">
                                            <a href="#" title="Click vào đây để xem trước."><i class="fa fa-eye"></i></a>
                                            <a class="" href="{{route('client_user_tailieudamua_download',$v->id)}}" title="Click vào đây để tải về."><i class="fa fa-download"></i></a>
                                        </div>
                                    </div>
                                    @endforeach
                                    @else
                                    <p>Không có dữ liệu nào trong mục này.</p>
                                    @endif
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="text-info">Design by ToanNang Co., Ltd</p>
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
        var UFC = {
            elements: {

            },
            init: function () {

                UFC.registerEvent.btn_download('.jquery-btn-downloadFile');

            },
            registerEvent: {
                btn_download: function ($btnClasses) {
                    $($btnClasses).on('click', function () {
                        $.ajax({
                            url: '',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                action: '',
                                data: ''
                            }, success: function (data) {
                                console.log(data);
                            }, error: function (data) {
                                console.log(data);
                            }
                        });
                        $.confirm(jquery_confirm_options({
                            title: 'Download File'
                        }));

                    });
                }
            }
        };

        UFC.init();


    });
</script>
@endpush