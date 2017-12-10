@extends('client.layouts.master')

@section('content')
<div class="container-fluid qao-area">
    <div class="row">
        <div class="container">
            <!-- PAGE TITLE AREA -->
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1><i class="fa fa-question"></i> <small>Hỏi đáp online</small></h1>
                    </div>
                </div>
            </div>
            <!-- CONTENT AREA -->
            <div class="row">
                <div class="col-md-3">
                    @include('QA::Client.qaonline.parts.navbar_left')
                </div>
                <div class="col-md-9">
                    <div class="r-panel">
                        <div class="r-title"><i class="fa fa-question-circle-o faa-ring animated"></i> Tạo câu hỏi</div>
                        <div class="r-content">

                            <form class="form form-horizontal" id="form_create_qa" action="{{route('_mdle_client_qa_save')}}" method="post" style="margin-top: 10px;">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="title" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Tiêu đề:</label>
                                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                        <input type="text" name="title" id="title" class="form-control" placeholder="Tiêu đề..." />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="id_category" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Danh mục:</label>
                                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                        <select name="id_category" id="id_category" class="form-control">
                                            <option value="-1">-- Chọn danh mục --</option>
                                            @foreach($categories as $k=>$v)
                                            <option value="{{$v->id}}">{!! $v->name !!}</option>
                                            @endforeach     
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <!--                                    <label for="title" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Nội dung:</label>-->
                                    <div class="col-lg-12 col-md-12 col-sm-9 col-xs-12">
                                        <textarea rows="5" name="content" id="content" class="form-control" placeholder="Nội dung..."></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-6 col-md-6 col-sm-9 col-xs-12">
                                        <div class="g-recaptcha" 
                                             data-theme="light"
                                             data-size="100%"
                                             data-type="image"
                                             data-callback="verifyCallback"
                                             data-sitekey="6Ld2djkUAAAAADYLTSwWn-YzrOix0IqbiAqjOPve"></div>
                                    </div>
                                    <div class="col-lg-6">
                                        <a href="{{url()->previous()}}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Quay lại</a>
                                        <button id="js-form-add-qa-btn-submit" onclick="onSubmit(this)" disabled="" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Tạo ngay</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('stylesheet')
<link rel="stylesheet" href="{{asset('public/client/css/qao.css')}}" />
@endpush

@push('scripts')
<!-- Google captcha -->
<script src='https://www.google.com/recaptcha/api.js'></script>
<!-- CKEditor -->
<script src="{{asset('public/bower_components/ckeditor/ckeditor.js')}}"></script>
<!--<script src="{{asset('public/plugins/ckeditor/plugins/ckeditor_wiris/integration/WIRISplugins.js')}}"></script><script>CKEDITOR.dtd.$removeEmpty['span'] = false;</script>-->
<script>
                                            CKEDITOR.editorConfig = function (config) {
                                                config.height = '500px';
                                            };
                                            CKEDITOR.replace('content');
</script>
<!-- /Ckeditor -->

<script>
    function onSubmit(this_btn) {
        if ($('#id_category').val() == -1) {
            $.alert(jquery_alert_options({
                title: 'Thông báo', type: 'red',
                content: 'Vui lòng chọn danh mục trước khi đăng câu hỏi.'
            }));
            return false;
        }
        $(this_btn).parents('form').submit();
    }

    function verifyCallback(response) {
        if (response === null) {
            $.alert(jquery_alert_options({
                title: 'Thông báo', type: 'red',
                content: 'Bạn vui lòng hoàn tất captcha trước khi gửi yêu cầu.'
            }));
        } else {
            $('#js-form-add-qa-btn-submit').removeAttr('disabled');
        }
    }
</script>
@endpush

