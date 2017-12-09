
@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>{{__('label.them')}} {{ @$title }}</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <form id="form_article_add" class="form-horizontal form-label-left" action="{{route('admin_article_save_post')}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ @$item->id }}" />
        <input type="hidden" name="type" value="{{ @$type }}" />
        @if(@$UI->fieldGroup([
        'views','ordinal_number','photo'
        ]))
        <div class="col-md-9 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{ __('label.thongtinchung')}} <small></small></h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-md-7">
                        <div class="row">
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
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="javascript:void(0)" class="btn btn-default jquery-input-file" data-input="photo">Chọn file...</a>
                                <a disabled="" href="javascript:void(0)" class="jquery-input-file-remove btn btn-warning" data-input="photo">Xóa hình</a>
                                <input class="hidden" id="photo" type="file" name="photo" placeholder="Chọn file"/>
                            </div> <hr>
                            <div class="col-md-12">
                                @if(@$UI->field('photo'))
                                @if(isset($item->data_photo))
                                <img class="thumbnail" style="width:250px;height:250px;" src="{{ html_image($item->data_photo->url_encode,250,250,100) }}" />
                                @else
                                <div style="text-align: center;">
                                    <img alt="100%x1280" data-src="holder.js/100%x180" id="photo_preview" 
                                         class="thumbnail" style="height: 220px; width: 250px; display: block;margin: 0 auto;" 
                                         src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTcxIiBoZWlnaHQ9IjE4MCIgdmlld0JveD0iMCAwIDE3MSAxODAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzEwMCV4MTgwCkNyZWF0ZWQgd2l0aCBIb2xkZXIuanMgMi42LjAuCkxlYXJuIG1vcmUgYXQgaHR0cDovL2hvbGRlcmpzLmNvbQooYykgMjAxMi0yMDE1IEl2YW4gTWFsb3BpbnNreSAtIGh0dHA6Ly9pbXNreS5jbwotLT48ZGVmcz48c3R5bGUgdHlwZT0idGV4dC9jc3MiPjwhW0NEQVRBWyNob2xkZXJfMTVlMTgzODhmMzcgdGV4dCB7IGZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMHB0IH0gXV0+PC9zdHlsZT48L2RlZnM+PGcgaWQ9ImhvbGRlcl8xNWUxODM4OGYzNyI+PHJlY3Qgd2lkdGg9IjE3MSIgaGVpZ2h0PSIxODAiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSI1OS41NjI1IiB5PSI5NC41NTYyNSI+MTcxeDE4MDwvdGV4dD48L2c+PC9nPjwvc3ZnPg==" data-holder-rendered="true">
                                </div>
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="col-md-3 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('label.caidat')}} <small> nội dung của bài viết</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    @if($UI->field('highlight'))
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12">{{__('label.noibat')}}</label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <div class="">
                                <label>
                                    <input type="checkbox" {!!@$item->highlight==1?'checked=""':''!!} 
                                    class="js-switch" name="highlight" data-switchery="true" style="display: none;">
                                </label>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($UI->field('display'))
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12">{{__('label.hienthi')}}</label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <div class="">
                                <label>
                                    <input type="checkbox" {{@$item->display==1?'checked=""':''}} 
                                    class="js-switch" name="display" data-switchery="true" style="display: none;">
                                </label>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-3">
                            <a href="{{route('admin_article_index',$type)}}" class="btn btn-primary">Quay lại</a>
                            <button disabled="" id="jquery-btn-submit" type="submit" class="btn btn-success"><i class="fa fa-save"></i> Lưu</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @if(@$UI->fieldGroup([
        'name','name_meta','description','content'
        ]))
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('label.noidung')}} <small> Nội dung bài viết</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                            @foreach($_LISTLANG as $_LANGKEY => $_LANGVAL)
                            <li role="presentation" class="{{$_LANGKEY==0?'active':''}}"><a href="#tab_content{{$_LANGKEY+1}}" id="home-tab" role="tab" data-toggle="tab" aria-expanded="false">{{ $_LANGVAL->name}}</a></li>
                            @endforeach
                        </ul>
                        <div class="clearfix"></div>
                        <div id="myTabContent" class="tab-content">
                            @foreach($_LISTLANG as $_LANGKEY => $_LANGVAL)
                            <div role="tabpanel" class="tab-pane fade {{$_LANGKEY==0?'active in':''}}" id="tab_content{{$_LANGKEY+1}}" aria-labelledby="home-tab">
                                <input type="hidden" name="data_lang[{{$_LANGVAL->id}}][id]" value="{{@$item_lang[$_LANGVAL->id]->id}}"/>
                                @if($UI->field('name'))
                                <div class="form-group">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12">{{@$UI->field_name('name')}}</label>
                                    <div class="col-md-10 col-sm-10 col-xs-12">
                                        <input type="text" class="form-control jquery-input-nameMeta" 
                                               name="data_lang[{{$_LANGVAL->id}}][name]" 
                                               value="{{@$item_lang[$_LANGVAL->id]->name}}" 
                                               placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.ten') ]))!!}"
                                               data-fill="name_meta{{$_LANGVAL->id}}"
                                               required
                                               >
                                        <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                            {!!@$UI->field_note('name',true)!!}</div>
                                    </div>
                                </div>
                                @endif
                                @if($UI->field('name_meta'))
                                <div class="form-group">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12">{{@$UI->field_name('name_meta')}}</label>
                                    <div class="col-md-10 col-sm-10 col-xs-12 input-group">
                                        <input type="text" class="form-control jquery-input-nm" id="name_meta{{$_LANGVAL->id}}" 
                                               name="data_lang[{{$_LANGVAL->id}}][name_meta]" 
                                               value="{{@$item_lang[$_LANGVAL->id]->name_meta}}"
                                               data-id="{{@$item_lang[$_LANGVAL->id]->id}}"
                                               data-lang="{{@$item_lang[$_LANGVAL->id]->id_lang}}"
                                               data-state="js-cnm-state{{$_LANGVAL->id}}"
                                               placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.tenkhongdau') ]))!!}"
                                               required>
                                        <span class="input-group-addon">
                                            <i id="js-cnm-state{{$_LANGVAL->id}}" class="fa fa-check"></i>
                                        </span>
                                        <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                            {!!@$UI->field_note('name_meta',true)!!}</div>
                                    </div>
                                </div>
                                @endif
                                @if($UI->field('description'))
                                <div class="form-group">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12">{{@$UI->field_name('description')}}</label>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <textarea rows="5" class="form-control {{@$UI->ckeditor('description')}}" 
                                                  name="data_lang[{{$_LANGVAL->id}}][description]" 
                                                  placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.mota') ]))!!}">{{@$item_lang[$_LANGVAL->id]->description}}</textarea>
                                        <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                            {!!@$UI->field_note('description',true)!!}</div>
                                    </div>
                                </div>
                                @endif
                                @if($UI->field('description2'))
                                <div class="form-group">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12">{{@$UI->field_name('description2')}}</label>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <textarea rows="5" class="form-control {{@$UI->ckeditor('description2')}}" 
                                                  name="data_lang[{{$_LANGVAL->id}}][description2]" 
                                                  placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.mota') ]))!!}">{{@$item_lang[$_LANGVAL->id]->description2}}</textarea>
                                        <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                            {!!@$UI->field_note('description2',true)!!}</div>
                                    </div>
                                </div>
                                @endif
                                @if($UI->field('content'))
                                <div class="form-group">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12">{{@$UI->field_name('content')}}</label>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12 hide">
                                        <textarea rows="5" class="form-control" 
                                                  id="content_{{$_LANGVAL->id}}"
                                                  name="data_lang[{{$_LANGVAL->id}}][content]" 
                                                  placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.noidung') ]))!!}">{{@$item_lang[$_LANGVAL->id]->content}}</textarea>
                                        <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                            {!!@$UI->field_note('content',true)!!}</div>
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="js-summernote" data-textarea="content_{{$_LANGVAL->id}}"></div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if(@$UI->fieldGroup(['seo_title','seo_keywords','seo_description']))
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('label.seo')}} <small> Seo bài viết</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                            @foreach($_LISTLANG as $_LANGKEY => $_LANGVAL)
                            <li role="presentation" class="{{$_LANGKEY==0?'active':''}}">
                                <a href="#tab_content_lang{{$_LANGKEY+1}}" id="home-tab" role="tab" data-toggle="tab" 
                                   aria-expanded="false">{{ $_LANGVAL->name}}</a></li>
                            @endforeach
                        </ul>
                        <div class="clearfix"></div>
                        <div id="myTabContent" class="tab-content">
                            @foreach($_LISTLANG as $_LANGKEY => $_LANGVAL)
                            <div role="tabpanel" class="tab-pane fade {{@$_LANGKEY==0?'active in':''}}" id="tab_content_lang{{$_LANGKEY+1}}" aria-labelledby="home-tab">
                                @if(@$UI->field('seo_title'))
                                <div class="form-group">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12">{{@$UI->field_name('seo_title')}}</label>
                                    <div class="col-md-10 col-sm-10 col-xs-12">
                                        <input type="text" class="form-control" name="data_lang[{{$_LANGVAL->id}}][seo_title]" 
                                               value="{{@$item_lang[$_LANGVAL->id]->seo_title}}" placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.tieude') ]))!!}">
                                        <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                            {{@$UI->field_note('seo_title',true)}}</div>
                                    </div>
                                </div>
                                @endif
                                @if(@$UI->field('seo_keywords'))
                                <div class="form-group">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12">{{@$UI->field_name('seo_keywords')}}</label>
                                    <div class="col-md-10 col-sm-10 col-xs-12">
                                        <input type="text" class="tags form-control jquery-input-tag" name="data_lang[{{$_LANGVAL->id}}][seo_keywords]" 
                                               value="{{@$item_lang[$_LANGVAL->id]->seo_keywords}}" />
                                        <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                            {{@$UI->field_note('seo_keywords',true)}}</div>
                                    </div>
                                </div>
                                @endif
                                @if(@$UI->field('seo_description'))
                                <div class="form-group">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12">{{$UI->field_name('seo_description')}}</label>
                                    <div class="col-md-10 col-sm-10 col-xs-12">
                                        <textarea class="form-control" name="data_lang[{{$_LANGVAL->id}}][seo_description]" 
                                                  placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.mota') ]))!!}">{{@$item_lang[$_LANGVAL->id]->seo_description}}</textarea>
                                        <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                            {{@$UI->field_note('seo_description',true)}}</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </form>
    <div class="clearfix"></div>
</div>

<input type="hidden" id="admin_article_ajax" value="{{route('admin_article_ajax')}}" />
<input type="hidden" id="_admin_summernote_upload" value="{{route('_admin_summernote_upload')}}" />
@endsection

@push('stylesheet')
<link rel="stylesheet" href="{!! asset('public/admin/node_modules/summernote/dist/summernote.css') !!}"/>

@endpush

@push('scripts')

<script>
    function check_form_state() {
        var form = $('#form_article_add');
        var error_count = $(form).find('.has-warning').length;
        console.log(error_count);
        if (error_count == 0) {
            $(form).find('button[type="submit"]').removeAttr('disabled');
        } else {
            $(form).find('button[type="submit"]').attr('disabled', '');
        }
    }
    $(document).ready(function () {
        bstring.fillSlugValue('.jquery-input-nameMeta');
        $('.jquery-input-nm').on('blur', function () {
            //$(this).parents('form').find('#jquery-btn-submit').attr('disabled', '');
            var this_input = this;
            var ele_state = '#' + $(this).data('state');
            var content_id = $(this).data('id');
            var content_lang = $(this).data('lang');
            var content_value = $(this).val();

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
        });
    });
</script>

<!-- SUMMERNOTE -->
<script src="{!! asset('public/admin/node_modules/summernote/dist/summernote.min.js') !!}"></script>
<!-- Map plugins -->
<script src="{!! asset('public/admin/bower_components/summernote-map-plugin/summernote-map-plugin.js') !!}"></script>
<script>

    $(document).ready(function () {
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
            //tabsize: 2,
            //airMode: true,
            map: {
                apiKey: 'AIzaSyBJfmJjzVn3S9HamEOrD8mTvRixaOgU1Dw',
                center: {
                    lat: -33.8688,
                    lng: 151.2195
                },
                zoom: 13
            }
//            toolbar: [
//                //['insert',  'map']
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
    });


</script>

<!-- jQuery Tags Input -->
<script src="{!! asset('public/admin/bower_components/jquery.tagsinput/src/jquery.tagsinput.js')!!}"></script>
<!-- Switchery -->
<script src="{!! asset('public/admin/bower_components/switchery/dist/switchery.min.js')!!}"></script>

@include('admin.article.jsc.JSArticleController_add')
@endpush


