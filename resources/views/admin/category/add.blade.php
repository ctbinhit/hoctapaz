@extends('admin.layouts.master')
@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-plus"></i> {{__('label.them')}} {{ @$title }}</h3>
        </div>

    </div>
    <div class="clearfix"></div>
    <form class="form-horizontal form-label-left" action="{{route('admin_category_save_post')}}" method="POST" enctype="multipart/form-data">
        
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_content">
                    <a href="{{url()->previous()}}" class="btn btn-app"><i class="fa fa-arrow-left"></i> Quay lại</a>
                    <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>
                    <button type="submit" class="btn btn-app"><i class="fa fa-save"></i> Lưu</button>
                </div>
            </div>
        </div>
        
<!--        <div class="col-md-12">
            <div class="alert alert-danger">
                <h4><i class="fa fa-warning"></i> Có lỗi xảy ra.</h4>
                <ul>
                    <li>Error message 1</li>
                    <li>Error message 2</li>
                    <li>Error message 3</li>
                </ul>
            </div>
        </div>-->

        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ @$item['id'] }}" />
        <input type="hidden" name="type" value="{{ @$type }}" />
        <input type="hidden" name="tbl" value="{{ @$tbl }}" />
        <input type="hidden" name="id_category" value="{{ @$item['id_category'] }}" class="form-control" id="id_category" placeholder="Chưa có danh mục"/>

        <div class="col-md-6 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-edit"></i> {{ __('label.thongtinchung')}} <small> Thông tin cơ bản</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    @if($UI->field('views'))
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">{{$UI->field_name('views')}}</label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <input type="number" name="views" class="form-control" value="{{isset($item->views)?$item->views:'0'}}" placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.luotxem') ]))!!}">
                            <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                {!!@$UI->field_note('views')!!}
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($UI->field('ordinal_number'))
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">{{$UI->field_name('ordinal_number')}}</label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <input type="number" name="ordinal_number" class="form-control" value="{{isset($item->ordinal_number)?$item->ordinal_number:1}}" placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.stt') ]))!!}">
                            <div id="suggestions-container">
                                {!!@$UI->field_note('ordinal_number')!!}
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($UI->field('highlight'))
                    <div class="form-group">
                        <label for="highlight" class="control-label col-md-2 col-sm-2 col-xs-12">{!!$UI->field_name('highlight')!!}:</label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <select name="highlight" id="highlight" class="form-control">
                                <option>Yes</option>
                                <option>No</option>
                            </select>
                            <div id="suggestions-container">
                                {!!@$UI->field_note('highlight')!!}
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($UI->field('highlight'))
                    <div class="form-group">
                        <label for="display" class="control-label col-md-2 col-sm-2 col-xs-12">{!!$UI->field_name('display')!!}:</label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <select name="display" id="display" class="form-control">
                                <option>Yes</option>
                                <option>No</option>
                            </select>
                            <div id="suggestions-container">
                                {!!@$UI->field_note('display')!!}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-photo"></i> Hình ảnh</h2><div class="clearfix"></div>
                </div>
                <div class="x_content">
                    @if(!$UI->field('photo'))
                    <div class="form-group">
                        <label for="nameOfTheInput" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Photo:</label>
                        <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                            <input id="photo" type="file" name="file_photo" placeholder="Chọn file"/>
                        </div>
                    </div>
                    @else
                    <p class="alert alert-info"><i class="fa fa-info"></i> Danh mục này không hỗ trợ upload photo</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-sort-numeric-asc"></i> Thứ tự <small>Thứ tự các phần tử</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-md-6">
                        @isset($items_cate)
                        <div class="dd" id="sortable_categories">
                            <ol class="dd-list">
                                {!!$UI->category_initSortable($items_cate,$items_cate_data)!!}
                            </ol>
                        </div>
                        @endisset
                        <div class="row">
                            <div class="col-md-12" id="jquery-status-sortable">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <p><i class="fa fa-info"></i> Chọn danh mục cha bằng cách nhấn vào tên danh mục bên trái</p>
                            </div>
                            <label class="control-label col-md-3 col-sm-4 col-xs-12">{{__("label.danhmuccha")}}</label>
                            <div class="col-md-9 col-sm-8 col-xs-12 input-group">
                                <input type="text" class="form-control" value="{{@$item['id_category']}}{{@$items_cate_data[$item['id_category']]->name}}" disabled="" id="category_name" name="category_name" placeholder="Chưa có danh mục"/>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default"><i class="fa fa-remove"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('label.noidung')}} <small> Nội dung danh mục</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                            @foreach($_LISTLANG as $_LANGKEY => $_LANGVAL)
                            <li role="presentation" class="{{$_LANGKEY==0?'active':''}}"><a href="#tab_content{{$_LANGKEY+1}}" id="home-tab" role="tab" data-toggle="tab" aria-expanded="false">{{ $_LANGVAL->name}}</a></li>
                            @endforeach
                        </ul>
                        <div class="clearfix"></div>
                        <div id="myTabContent" class="tab-content">
                            @foreach($_LISTLANG as $_LANGKEY => $_LANGVAL)
                            <div role="tabpanel" class="tab-pane fade {{$_LANGKEY==0?'active in':''}}" id="tab_content{{$_LANGKEY+1}}" aria-labelledby="home-tab">
                                <input type="hidden" name="formdata[{{$_LANGVAL->id}}][id]" value="{{@$item_lang[$_LANGVAL->id]['id']}}"/>
                                @if($UI->field('name'))
                                <div class="form-group">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12">{!!$UI->field_name('name')!!}</label>
                                    <div class="col-md-10 col-sm-10 col-xs-12">
                                        <input type="text" class="form-control jquery-bcore-metaname" data-listen="formdata[{{$_LANGVAL->id}}][name_meta]" name="formdata[{{$_LANGVAL->id}}][name]" value="{{@$item_lang[$_LANGVAL->id]['name']}}" placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.ten') ]))!!}">
                                        <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                            {!!@$UI->field_note('name')!!}
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($UI->field('name_meta'))
                                <div class="form-group">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12">{!!$UI->field_name('name_meta')!!}</label>
                                    <div class="col-md-6 col-sm-8 col-xs-12">
                                        <input type="text" class="form-control" disabled="" id="formdata[{{$_LANGVAL->id}}][suggestion-name_meta]" value="{{@$item_lang[$_LANGVAL->id]['name_meta']}}" />
                                        <input type="hidden" class="form-control"  name="formdata[{{$_LANGVAL->id}}][name_meta]" id="formdata[{{$_LANGVAL->id}}][name_meta]" value="{{@$item_lang[$_LANGVAL->id]['name_meta']}}" placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.ten') ]))!!}">
<!--                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-default"><i class="fa fa-edit"></i></button>
                                            <button type="button" class="btn btn-default"><i class="fa fa-refresh"></i></button>
                                        </span>-->
                                        <div id="suggestions-container" id="suggestion-name-meta" style="position: relative; float: left; width: 100%; margin: 10px;">
                                            {!!@$UI->field_note('name_meta')!!}
                                        </div>
                                    </div>

                                </div>
                                @endif
                                @if($UI->field('description'))
                                <div class="form-group">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12">{!!$UI->field_name('description')!!}</label>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <textarea class="form-control ckeditor" name="formdata[{{$_LANGVAL->id}}][description]" placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.mota') ]))!!}">{{@$item_lang[$_LANGVAL->id]['description']}}</textarea>
                                        <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                            {!!@$UI->field_note('description')!!}
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($UI->field('content'))
                                <div class="form-group">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12">{!!$UI->field_name('content')!!}</label>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <textarea class="form-control ckeditor" name="content[{{$_LANGVAL->id}}][content]" placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.noidung') ]))!!}">{{@$item_lang[$_LANGVAL->id]['content']}}</textarea>
                                        <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                            {!!@$UI->field_note('content')!!}
                                        </div>
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

        <div class="col-md-6 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('label.seo')}} <small>Nội dung seo web</small></h2>
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
                                @if($UI->field('seo_title'))
                                <div class="form-group">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12">{!!$UI->field_name('seo_title')!!}</label>
                                    <div class="col-md-10 col-sm-10 col-xs-12">
                                        <input type="text" class="form-control" name="formdata[$_LANGVAL->id][seo_title]" value="{{@$item_lang[@$_LANGVAL->id]['seo_title']}}" placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.tieude') ]))!!}">
                                        <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                            {!!@$UI->field_note('seo_title')!!}
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($UI->field('seo_keywords'))
                                <div class="form-group">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12">{!!$UI->field_name('seo_keywords')!!}</label>
                                    <div class="col-md-10 col-sm-10 col-xs-12">
                                        <input type="text" class="tags form-control jquery-input-tag" name="formdata[{{$_LANGVAL->id}}][seo_keywords]" value="{{@$item_lang[@$_LANGVAL->id]['seo_keywords']}}" />
                                        <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                            {!!@$UI->field_note('seo_keywords')!!}
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($UI->field('seo_description'))
                                <div class="form-group">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12">{!!$UI->field_name('seo_description')!!}</label>
                                    <div class="col-md-10 col-sm-10 col-xs-12">
                                        <textarea class="form-control" name="formdata[{{$_LANGVAL->id}}][seo_description]" placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.mota') ]))!!}">{{@$item_lang[@$_LANGVAL->id]['seo_description']}}</textarea>
                                        <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                            {!!@$UI->field_note('seo_description')!!}
                                        </div>
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

    </form>
    <div class="clearfix"></div>
</div>
@endsection

@push('stylesheet')

@endpush

@push('scripts')
<!-- jQuery Tags Input -->
<script src="{!! asset('public/admin/bower_components/jquery.tagsinput/src/jquery.tagsinput.js')!!}"></script>
<script>
    $(document).ready(function () {
        bcore_metaname.registerEvent('.jquery-bcore-metaname');
    });
</script>
@endpush

@include('admin.category.jsc.JSCategoryController_add')