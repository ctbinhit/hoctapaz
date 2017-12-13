@extends('client.layouts.master')

@section('content')
<div class="container-fluid qao-area">
    <div class="row">
        <div class="container">
            <!-- PAGE TITLE AREA -->
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1><i class="fa fa-question"></i> <small>
                                <a href="{{route('mdle_client_qa_index')}}">Hỏi đáp online</a>
                            </small></h1>
                    </div>
                </div>
            </div>

            <!-- Breadcrumb -->
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb">
                        <li><a href="{{route('client_index')}}"><i class="fa fa-home"></i> Trang chủ</a></li>
                        <li><a href="{{route('mdle_client_qa_index')}}"><i class="fa fa-question-circle-o"></i> Hỏi đáp online</a></li>
                        <li class="active"><i class="fa fa-question"></i> {{$item->title}}</li>
                    </ol>
                </div>
            </div>

            <!-- CONTENT AREA -->
            <div class="row">
                <div class="col-md-3">
                    @include('QA::Client.qaonline.parts.navbar_left')
                </div>
                <div class="col-md-9">

                    <div class="r-panel">
                        <div class="r-title"><i class="fa fa-question"></i> {{$item->title}}</div>
                        <div class="r-content">

                            <div class="pan-question">
                                <div class="q-header">
                                    <div class="q-photo">

                                        <img src="{{@$item->user_photo}}" />
                                    </div>
                                    <div class="q-info">
                                        <div class="q-name">Tên: {{$item->user_name}}</div>
                                        <div class="q-date"><i class="fa fa-clock-o"></i> {{diffInNow($item->created_at)}}</div>
                                    </div>
                                </div>
                                <div class="q-body">
                                    {!!$item->content!!}
                                </div>
                                <div class="q-footer">

                                    <div class="q-date">Ngày đăng {{$item->created_at}}</div>
                                    <div class=""><script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-59ef1eb4096d3a39"></script> 
                                        <div class="addthis_inline_share_toolbox"></div></div>
                                </div>

                            </div>

                            <div class="pan-question">
                                <div class="q-comment">
                                    <div class="q-wrap">
                                        @if(UserService::isLoggedIn())
                                        <div class="tmp-1">
                                            <input type="text" name="cmt" id="js-q-cmt" placeholder="Trả lời..." />
                                            <button id="js-q-cmt-b"><i class="fa fa-send"></i></button>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="tmp-2" style="display: none;">
                                            <form class="form form-horizontal" action="{{route('_mdle_client_qa_detail_save',$item->id)}}" method="POST">
                                                {{csrf_field()}}
                                                <div class="form-group">
                                                    <div class="col-lg-12 col-md-12  col-sm-9 col-xs-12">
                                                        <textarea class="form-control" name="content" id="noidungbinhluan"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 col-md-offset-2">
                                                        <button class="btn btn-default pull-right" type="submit"><i class="fa fa-send"></i> Đăng</button>
                                                        <button class="btn btn-default pull-right" type="button"><i class="fa fa-camera"></i> Tải lên từ máy tính</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="clearfix"></div>
                                        </div>
                                        @else
                                        <div class="panel panel-warning">
                                            <div class="panel-heading"><i class="fa fa-sign-in"></i> Đăng nhập</div>
                                            <div class="panel-body">
                                                <p>Bạn chưa đăng nhập, vui lòng đăng nhập để có thể bình luận.</p>
                                            </div>
                                            <div class="panel-footer">
                                                <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-sign-in"></i> Đăng nhập</a> 
                                                <a href="#" class="btn btn-warning btn-xs">Quên mật khẩu <i class="fa fa-question"></i></a> 
                                                hoặc
                                                <a href="#" class="btn btn-default btn-xs"><i class="fa fa-edit"></i> Đăng ký</a>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="pan-cmts" id="js-cmts-area" data-id="{{$item->id}}">
                                @include('QA::Client/qaonline/parts/cmts',['$items_cmt'=>$item_cmt])
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="_mdle_client_qa_ajax" value="{{route('_mdle_client_qa_ajax')}}" />
<input type="hidden" id="this_route" value="{{route('mdle_client_qa_detail',$item->id)}}" />
<input type="hidden" id="this_url" value="{{url()->full()}}" />


<!-- CKEditor -->
<script src="{{asset('public/bower_components/ckeditor/ckeditor.js')}}"></script>
<!--<script src="{{asset('public/plugins/ckeditor/plugins/ckeditor_wiris/integration/WIRISplugins.js')}}"></script><script>CKEDITOR.dtd.$removeEmpty['span'] = false;</script>-->
<script>
    CKEDITOR.editorConfig = function (config) {
        config.height = '500px';
    };
    CKEDITOR.replace('noidungbinhluan');
</script>
<!-- /Ckeditor -->
<script>
    $(document).ready(function () {
        $('#js-q-cmt').on('focus', function () {
            $('.tmp-1').fadeOut();
            $('.tmp-2').slideDown('slow');
        });
    });
</script>

@endsection

@push('scss')
<link rel="stylesheet" href="{{asset('public/client/css/qao.css')}}"/>
@endpush

@push('scripts')

@endpush

