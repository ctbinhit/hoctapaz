
@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="row">
        <div class="col-md-12">
            <div class="page-title">
                <div class="title_left">
                    <h3><i class="fa fa-plus"></i> {{__('label.them')}} {{ @$title }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <form id="form_article_add" class="form-horizontal form-label-left" action="{{route('admin_article_save_post')}}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ @$item->id }}" />
            <input type="hidden" name="type" value="{{ @$type }}" />
            @if(@$UI->fieldGroup([
            'views','ordinal_number','photo'
            ]))
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_content">
                        <a href="{{route('admin_index')}}" class="btn btn-app"><i class="fa fa-dashboard"></i> Dashboard</a>
                        <a href="{{route('admin_article_index',$type)}}" class="btn btn-app"><i class="fa fa-arrow-left"></i> Quay lại</a>
                        <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>
                        <button type="submit" class="btn btn-app" disabled="" id="jquery-btn-submit"><i class="fa fa-save"></i> Lưu</button>


                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><i class="fa fa-edit"></i> {{ __('label.thongtinchung')}} <small></small></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        @if(@$UI->field('views'))
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Lượt xem</label>
                            <div class="col-md-10 col-sm-10 col-xs-12">
                                <input type="number" name="views" class="form-control" value="{{@$item->views}}" placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.luotxem') ]))!!}">
                                <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                    {!!$UI->field_note('views',true)!!}</div>
                            </div>
                        </div>
                        @endif
                        @if(@$UI->field('ordinal_number'))
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Số thứ tự</label>
                            <div class="col-md-10 col-sm-10 col-xs-12">
                                <input type="number" name="ordinal_number" class="form-control" value="{{isset($item->ordinal_number)?$item->ordinal_number:1}}" placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.stt') ]))!!}">
                                <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                    {!!$UI->field_note('ordinal_number',true)!!}</div>
                            </div>
                        </div>
                        @endif
                        @if(@$UI->fieldGroup([
                        'highlight','display'
                        ]))
                        <div class="form-group">
                            @if($UI->field('highlight'))
                            <label class="control-label col-md-2 col-sm-5 col-xs-12">{{__('label.noibat')}}</label>
                            <div class="col-md-1 col-sm-7 col-xs-12">
                                <input type="checkbox" {!!@$item->highlight==1?'checked=""':''!!} 
                                class="js-switch" name="highlight" data-switchery="true" style="display: none;">
                            </div>
                            @endif
                            @if($UI->field('display'))
                            <label class="control-label col-md-2 col-sm-5 col-xs-12">{{__('label.hienthi')}}</label>
                            <div class="col-md-1 col-sm-7 col-xs-12">
                                <div class="">
                                    <label>
                                        <input type="checkbox" {{@$item->display==1?'checked=""':''}} 
                                        class="js-switch" name="display" data-switchery="true" style="display: none;">
                                    </label>
                                </div>
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <div class="col-md-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><i class="fa fa-image"></i> Hình ảnh <small><i class="label label-info">300x300px</i></small></h2><div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        @if(isset($item->data_photo->url))
                        <div class="form-group">
                            <label for="img" class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Hình hiện tại:</label>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <img src="{{Storage::disk('localhost')->url($item->data_photo->url)}}" class="thumbnail" style="width: 100%;height: auto;"/>
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="photo" class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Hình ảnh:</label>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <input class="form-control" id="photo" type="file" name="photo" placeholder="Chọn file"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            @if(@$UI->fieldGroup(['name','name_meta','description','content']))
            
            @include('admin.article.parts.form_add_content')
            
            @endif
            <!-- SEO AREA -->
            @if(@$UI->fieldGroup(['seo_title','seo_keywords','seo_description']))
            
            @include('admin.article.parts.form_add_seo')
            
            @endif
            <!-- /SEO AREA -->
            
        </form>
    </div>
    <div class="clearfix"></div>
</div>

<input type="hidden" id="admin_article_ajax" value="{{route('admin_article_ajax')}}" />
<input type="hidden" id="_admin_summernote_upload" value="{{route('_admin_summernote_upload')}}" />
@endsection

@push('stylesheet')
<link rel="stylesheet" href="{!! asset('public/admin/node_modules/summernote/dist/summernote.css') !!}"/>

@endpush

@push('scripts')
@if(isset($item))
<script>
    $(document).ready(function () {
        check_slug($('.jquery-input-nm')[0]);
    });
</script>
@endif
<script>
    function check_form_state() {
        var form = $('#form_article_add');
        var error_count = $(form).find('.has-warning').length;
        if (error_count == 0) {
            $(form).find('button[type="submit"]').removeAttr('disabled');
        } else {
            $(form).find('button[type="submit"]').attr('disabled', '');
        }
    }
    function check_slug(element) {
        var this_input = element;
        var ele_state = '#' + $(this_input).data('state');
        var content_id = $(this_input).data('id');
        var content_lang = $(this_input).data('lang');
        var content_value = $(this_input).val();
        $.ajax({
            url: $('#admin_article_ajax').val(),
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            data: {
                'act': 'cnm',
                'id': content_id,
                'il': content_lang,
                'val': content_value
            },
            beforeSend: function () {
                $(ele_state).removeClass('fa-check fa-remove').addClass('fa-spinner faa-spin animated');
            },
            success: function (response) {
                if (response.state) {
                    $(ele_state).addClass('fa-check').removeClass('fa-spinner faa-spin animated fa-remove');
                    $(this_input).parents('.input-group').removeClass('has-warning');
                } else {
                    $(this_input).parents('.input-group').addClass('has-warning');
                    $(ele_state).addClass('fa-remove').removeClass('fa-spinner faa-spin animated fa-check');
                }
            },
            complete: function (data) {
                check_form_state();
            }
        });
    }
    $(document).ready(function () {
        bstring.fillSlugValue('.jquery-input-nameMeta');
        $('.jquery-input-nm').on('blur', function () {
            check_flug(this);
        });
    });
</script>

<!-- SUMMERNOTE -->
<script src="{!! asset('public/admin/node_modules/summernote/dist/summernote.min.js') !!}"></script>
<!-- Map plugins -->
<script src="{!! asset('public/admin/bower_components/summernote-map-plugin/summernote-map-plugin.js') !!}"></script>
<script>
    $('.js-summernote').summernote({
        height: 500,
        callbacks: {
            onInit: function () {
                $(this).summernote('code', $('#' + $(this).data('textarea')).val());
            },
            onChange: function () {
                var textarea = $('#' + $(this).data('textarea'));
                $(textarea).val($(this).summernote('code'));
            },
            onImageUpload: function (files, editor, welEditable) {
                for (var i = files.length - 1; i >= 0; i--) {
                    uploadFile(files[i], this);
                }
            }
        },
//            tabsize: 2,
//            airMode: true,
        map: {
            apiKey: 'AIzaSyBJfmJjzVn3S9HamEOrD8mTvRixaOgU1Dw',
            center: {
                lat: -33.8688,
                lng: 151.2195
            },
            zoom: 13
        },
//            toolbar: [
//                ['insert',  'map']
//            ]
    });
    function uploadFile(file, element, welEditable) {
        var fd = new FormData();
        fd.append("summernote_file", file);
        $.ajax({
            url: $('#_admin_summernote_upload').val(),
            data: fd,
            type: "POST",
            dataType: 'json',
            cache: false,
            contentType: false,
            enctype: 'multipart/form-data',
            processData: false,
            success: function (response) {
                $(element).summernote('editor.insertImage', response.path);
            }
        });
    }
</script>

<!-- jQuery Tags Input -->
<script src="{!! asset('public/admin/bower_components/jquery.tagsinput/src/jquery.tagsinput.js')!!}"></script>

@include('admin.article.jsc.JSArticleController_add')
@endpush


