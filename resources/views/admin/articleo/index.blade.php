
@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-info"></i> {{$UI->ConfigVal('title')}}</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <form class="form-horizontal form-label-left" action="" method="POST" enctype="multipart/form-data">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_content">
                        <a href="{{route('admin_index')}}" class="btn btn-app"><i class="fa fa-dashboard"></i> Dashboard</a>
                        <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>
                        <button type="submit" class="btn btn-app"><i class="fa fa-save"></i> Lưu</button>
                    </div>
                </div>
            </div>


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
                                    @if(isset($item->photo))
                                    <img class="thumbnail" style="width:300px;height:300px;" src="{{ $item->photo }}" />
                                    @else
                                    <div style="text-align: center;">
                                        <img alt="100%x1280" data-src="holder.js/100%x180" id="photo_preview" class="thumbnail" style="height: 220px; width: 250px; display: block;margin: 0 auto;" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTcxIiBoZWlnaHQ9IjE4MCIgdmlld0JveD0iMCAwIDE3MSAxODAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzEwMCV4MTgwCkNyZWF0ZWQgd2l0aCBIb2xkZXIuanMgMi42LjAuCkxlYXJuIG1vcmUgYXQgaHR0cDovL2hvbGRlcmpzLmNvbQooYykgMjAxMi0yMDE1IEl2YW4gTWFsb3BpbnNreSAtIGh0dHA6Ly9pbXNreS5jbwotLT48ZGVmcz48c3R5bGUgdHlwZT0idGV4dC9jc3MiPjwhW0NEQVRBWyNob2xkZXJfMTVlMTgzODhmMzcgdGV4dCB7IGZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMHB0IH0gXV0+PC9zdHlsZT48L2RlZnM+PGcgaWQ9ImhvbGRlcl8xNWUxODM4OGYzNyI+PHJlY3Qgd2lkdGg9IjE3MSIgaGVpZ2h0PSIxODAiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSI1OS41NjI1IiB5PSI5NC41NTYyNSI+MTcxeDE4MDwvdGV4dD48L2c+PC9nPjwvc3ZnPg==" data-holder-rendered="true">
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

            @if(@$UI->fieldGroup([
            'name','name_meta','description','content'
            ]))
            <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><i class="fa fa-edit"></i> {{__('label.noidung')}} <small></small></h2>
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
                                    <input type="hidden" name="id{{ $_FKEY . $_LANGVAL->id }}" value="{{@$item_lang[$_LANGVAL->id]->id}}"/>
                                    @if($UI->field('name'))
                                    <div class="form-group">
                                        <label class="control-label col-md-2 col-sm-2 col-xs-12">{{@$UI->field_name('name')}}</label>
                                        <div class="col-md-10 col-sm-10 col-xs-12">
                                            <input type="text" class="form-control" name="name{{ $_FKEY . $_LANGVAL->id }}" value="{{@$item_lang[$_LANGVAL->id]->name}}" 
                                                   placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.ten') ]))!!}">
                                            <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                                {!!@$UI->field_note('name',true)!!}</div>
                                        </div>
                                    </div>
                                    @endif
                                    @if($UI->field('title'))
                                    <div class="form-group">
                                        <label class="control-label col-md-2 col-sm-2 col-xs-12">{{@$UI->field_name('title')}}</label>
                                        <div class="col-md-10 col-sm-10 col-xs-12">
                                            <input type="text" class="form-control" name="title{{ $_FKEY . $_LANGVAL->id }}" value="{{@$item_lang[$_LANGVAL->id]->title}}" 
                                                   placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.ten') ]))!!}">
                                            <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                                {!!@$UI->field_note('title',true)!!}</div>
                                        </div>
                                    </div>
                                    @endif
                                    @if($UI->field('name_meta'))
                                    <div class="form-group">
                                        <label class="control-label col-md-2 col-sm-2 col-xs-12">{{@$UI->field_name('name_meta')}}</label>
                                        <div class="col-md-10 col-sm-10 col-xs-12">
                                            <input type="text" class="form-control" name="name_meta{{ $_FKEY . $_LANGVAL->id }}" value="{{@$item_lang[$_LANGVAL->id]->name_meta}}" placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.tenkhongdau') ]))!!}">
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
                                            <textarea rows="5" class="form-control {{@$UI->ckeditor('description')}}" name="description{{ $_FKEY . $_LANGVAL->id }}" 
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
                                            <textarea rows="5" class="form-control {{@$UI->ckeditor('description2')}}" name="description2{{ $_FKEY . $_LANGVAL->id }}" 
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
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <textarea rows="5" class="form-control js-ckeditor" name="content{{ $_FKEY . $_LANGVAL->id }}" id="content{{ $_FKEY . $_LANGVAL->id }}"
                                                      placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.noidung') ]))!!}">{{@$item_lang[$_LANGVAL->id]->content}}</textarea>
                                            <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                                {!!@$UI->field_note('content',true)!!}</div>
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
            @if(@$UI->fieldGroup([
            'seo_title','seo_keywords','seo_description'
            ]))
            <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><i class="fa fa-share-alt"></i> {{__('label.seo')}} <small>ToanNang Co., Ltd</small></h2>
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
                                            <input type="text" class="form-control" name="seo_title{{ @$_FKEY . @$_LANGVAL->id}}" 
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
                                            <input type="text" class="tags form-control jquery-input-tag" name="seo_keywords{{ @$_FKEY . @$_LANGVAL->id}}" 
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
                                            <textarea class="form-control" name="seo_description{{ @$_FKEY . @$_LANGVAL->id}}" 
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
            @if(@$UI->fieldGroup([
            'highlight','display'
            ]))
            <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{__('label.caidat')}} <small></small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        @if($UI->field('highlight'))
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-5 col-xs-12">{{__('label.noibat')}}</label>
                            <div class="col-md-7 col-sm-7 col-xs-12">
                                <div class="">
                                    <label>
                                        <input type="checkbox" {{@$item->highlight==1?'checked=""':''}} 
                                        class="js-switch" name="highlight" data-switchery="true" style="display: none;">
                                    </label>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($UI->field('display'))
                        <div class="form-group">
                            <label class="control-label col-md-2     col-sm-5 col-xs-12">{{__('label.hienthi')}}</label>
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
                    </div>
                </div>
            </div>
            @endif
        </form>
    </div>
    <div class="clearfix"></div>
</div>
@endsection

@push('stylesheet')

@endpush

@push('scripts')
<!-- CK Editor & CK Finder -->
<script src="{!! asset('public/admin/bower_components/ckeditor/ckeditor.js') !!}"></script>
<script>
    $('.js-ckeditor').each(function(){

    CKEDITOR.replace($(this).attr('id'), {
    customConfig: '{!! asset("public/admin/ckeditor/articleo/config.js") !!}'
    });
    });</script>
<!-- jQuery Tags Input -->
<script src="{!! asset('public/admin/bower_components/jquery.tagsinput/src/jquery.tagsinput.js')!!}"></script>

@endpush


