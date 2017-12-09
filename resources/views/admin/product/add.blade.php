
@extends('admin.layouts.master')
@include('admin.product.jsc.JSProductController_add')
@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>{{__('label.them')}} {{ @$title }}</h3>
        </div>
        <div class="title_right">

        </div>
    </div>
    <div class="clearfix"></div>

    <form class="form-horizontal form-label-left" action="{{route('admin_product_save_post')}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ @$item['id'] }}" />
        <input type="hidden" name="type" value="{{ @$type }}" />
        <input type="hidden" name="id_category" value="{{ @$item['id_category'] }}" class="form-control" id="id_category" placeholder="Chưa có danh mục"/>

        <div class="col-md-9 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{ __('label.thongtinchung')}} <small> Thông tin chung của sản phẩm</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-md-7">
                        <div class="row">
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
                                    <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                        {!!@$UI->field_note('ordinal_number')!!}
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if($UI->field('price'))
                            <div class="form-group">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">{!!$UI->field_name('price')!!}</label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <input type="number" name="price" class="form-control" value="{{isset($item->price)?$item->price:0}}" placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.stt') ]))!!}">
                                    <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                        {!!@$UI->field_note('price')!!}
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if($UI->field('promotion_price'))
                            <div class="form-group">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">{{$UI->field_name('promotion_price')}}</label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <input type="number" name="promotion_price" class="form-control" value="{{isset($item->promotion_price)?$item->promotion_price:0}}" placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.stt') ]))!!}">
                                    <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                        {!!@$UI->field_note('promotion_price')!!}
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="row">
                            @if($UI->field('photo'))
                            <div class="col-md-12">
                                <a href="javascript:void(0)" class="btn btn-default jquery-input-file" data-input="photo">Chọn file...</a>
                                <a disabled="" href="javascript:void(0)" class="jquery-input-file-remove btn btn-warning" data-input="photo">Xóa hình</a>
                                <input class="hidden" id="photo" type="file" name="photo" placeholder="Chọn file"/>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                @if(isset($item_photo))
                                @if(isset($item_photo) && is_object($item_photo) && isset($item_photo->photo[0]))
                                <img class="thumbnail" style="width:300px;height:300px;" src="{{ html_image(md5($item->data_photo->url),300,300) }}" />
                                @endif
                                @else
                                <div style="text-align: center;">
                                    <img alt="100%x1280" data-src="holder.js/100%x180" id="photo_preview" class="thumbnail" 
                                         style="height: 220px; width: 250px; display: block;margin: 0 auto;" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTcxIiBoZWlnaHQ9IjE4MCIgdmlld0JveD0iMCAwIDE3MSAxODAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzEwMCV4MTgwCkNyZWF0ZWQgd2l0aCBIb2xkZXIuanMgMi42LjAuCkxlYXJuIG1vcmUgYXQgaHR0cDovL2hvbGRlcmpzLmNvbQooYykgMjAxMi0yMDE1IEl2YW4gTWFsb3BpbnNreSAtIGh0dHA6Ly9pbXNreS5jbwotLT48ZGVmcz48c3R5bGUgdHlwZT0idGV4dC9jc3MiPjwhW0NEQVRBWyNob2xkZXJfMTVlMTgzODhmMzcgdGV4dCB7IGZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMHB0IH0gXV0+PC9zdHlsZT48L2RlZnM+PGcgaWQ9ImhvbGRlcl8xNWUxODM4OGYzNyI+PHJlY3Qgd2lkdGg9IjE3MSIgaGVpZ2h0PSIxODAiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSI1OS41NjI1IiB5PSI5NC41NTYyNSI+MTcxeDE4MDwvdGV4dD48L2c+PC9nPjwvc3ZnPg==" data-holder-rendered="true">
                                </div>
                                @endif

                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('label.caidat')}} <small>ToanNang Co., Ltd</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    @if($UI->field('highlight'))
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12">{!!$UI->field_name('highlight')!!}</label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <div class="">
                                <label>
                                    <input type="checkbox" {{@$item->highlight==1?'checked=""':''}} class="js-switch" name="highlight" data-switchery="true" style="display: none;">
                                </label>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($UI->field('display'))
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12">{!!$UI->field_name('display')!!}</label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <div class="">
                                <label>
                                    <input type="checkbox" {{@$item->display==1?'checked=""':''}} class="js-switch" name="display" data-switchery="true" style="display: none;">
                                </label>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-3">
                            <a href="{{route('admin_product_index',$type)}}" class="btn btn-primary">Quay lại</a>
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Lưu</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Hình ảnh thêm <small> <span id="jquery-uploadfiles-count"></span></small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div class="form-group">
                        <input type="file" name="photos[]" id="jquery-app-dropzone-photos" multiple=""/>
                    </div>
                    <div id="jquery-uploadfiles-pandrop">
                        <span class="jquery-uploadfiles-label">Click vào đây để tải hình ảnh thêm</span>
                        <span class="jquery-uploadfiles-span-addnow"><i class="fa fa-plus"></i> Thêm hình</span>
                        <div id="jquery-uploadfiles-files">

                        </div>
                        <span class="jquery-uploadfiles-license">Developed by ToanNang Co., Ltd (Beta)</span>
                        <div class="clearfix"></div>
                    </div>
                    <script>
                        $(document).ready(function () {
                            $('#jquery-uploadfiles-pandrop').on('click', function () {
                                $('#jquery-app-dropzone-photos').click();
                            });
                        });
                    </script>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Hình ảnh đã up <small> <span id="jquery-uploadfiles-count"></span></small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content jquery-app-photos-uploaded">
                    @isset($item_photos)
                    @foreach($item_photos as $k=>$v)
                    <div id="jquery-app-photo-uploaded">
                        <div class="jquery-app-photo-uploaded-overflay"></div>
                        <span class="jquery-app-photo-uploaded-remove" data-ip="{{$v->id}}"><i class="fa fa-remove"></i></span>
                        <img class="thumbnail" src="{{html_image($v->url_encode,100,100,100)}}" />
                        <div class="clearfix"></div>
                    </div>
                    @endforeach
                    <div class="clearfix"></div>
                    @endisset
                </div>
            </div>
        </div>

        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh mục <small> (Kéo thả để sắp xếp vị trí danh mục)</small></h2>
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

        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('label.noidung')}} <small> Nội dung sản phẩm</small></h2>
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
                                <input type="hidden" name="data_lang[{{$_LANGVAL->id}}][id]" value="{{@$item_lang[$_LANGVAL->id]['id']}}"/>
                                @if($UI->field('name'))
                                <div class="form-group">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12">{!!$UI->field_name('name')!!}</label>
                                    <div class="col-md-10 col-sm-10 col-xs-12">
                                        <input type="text" class="form-control" name="data_lang[{{$_LANGVAL->id}}][name]" 
                                               id="jquery-input-name" data-fill="jquery-input-nameMeta"
                                               value="{{@$item_lang[$_LANGVAL->id]['name']}}" placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.ten') ]))!!}">
                                        <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                            {!!@$UI->field_note('name')!!}
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="form-group">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12"> URL</label>
                                    <div class="col-md-10 col-sm-10 col-xs-12">
                                        <input type="text" class="form-control" name="data_lang[{{$_LANGVAL->id}}][name_meta]" 
                                               id="jquery-input-nameMeta"
                                               value="{{@$item_lang[$_LANGVAL->id]['name_meta']}}" placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.ten') ]))!!}">
                                        <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                            Địa chỉ của sản phẩm
                                        </div>
                                    </div>
                                </div>
                                @if($UI->field('name_meta'))
                                <div class="form-group">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12">{!!$UI->field_name('name_meta')!!}</label>
                                    <div class="col-md-10 col-sm-10 col-xs-12">
                                        <input type="text" class="form-control" name="data_lang[{{$_LANGVAL->id }}][name_meta]" value="{{@$item_lang[$_LANGVAL->id]['name_meta']}}" placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.tenkhongdau') ]))!!}">
                                        <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                            {!!@$UI->field_note('name_meta')!!}
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($UI->field('description'))
                                <div class="form-group">
                                    <label style="text-align: left;" class="control-label col-md-2 col-sm-2 col-xs-12">{!!$UI->field_name('description')!!}</label>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <textarea rows="5" class="form-control ckeditor" name="data_lang[{{$_LANGVAL->id }}][description]" 
                                                  placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.mota') ]))!!}">{{@$item_lang[$_LANGVAL->id]['description']}}</textarea>
                                        <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                            {!!@$UI->field_note('description')!!}
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($UI->field('content'))
                                <div class="form-group">
                                    <label style="text-align: left;" class="control-label col-md-2 col-sm-2 col-xs-12">{!!$UI->field_name('content')!!}</label>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <textarea rows="5" class="form-control ckeditor" name="data_lang[{{$_LANGVAL->id}}][content]" 
                                                  placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.noidung') ]))!!}">{{@$item_lang[$_LANGVAL->id]['content']}}</textarea>
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

        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('label.seo')}} <small> Nội dung seo</small></h2>
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
                                        <input type="text" class="form-control" name="data_lang[{{$_LANGVAL->id}}][seo_title]" value="{{@$item_lang[@$_LANGVAL->id]['seo_title']}}" placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.tieude') ]))!!}">
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
                                        <input type="text" class="tags form-control jquery-input-tag" name="data_lang[{{$_LANGVAL->id}}][seo_keywords]" value="{{@$item_lang[@$_LANGVAL->id]['seo_keywords']}}" />
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
                                        <textarea class="form-control" name="data_lang[{{$_LANGVAL->id}}][seo_description]" placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.mota') ]))!!}">{{@$item_lang[@$_LANGVAL->id]['seo_description']}}</textarea>
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
<script>
    $(document).ready(function () {
        bstring.fillSlugValue('#jquery-input-name');
    });
</script>

<!-- CK Editor & CK Finder -->
<!--<script src="{!! asset('public/admin_assets/plugins/ckeditor/ckeditor.js') !!}"></script>-->
<script>
//$(document).ready(function () {
//    var editor = CKEDITOR.replace('mota', {
//        language: 'vi',
//        filebrowserImageBrowseUrl: '',
//        filebrowserFlashBrowseUrl: '',
//        filebrowserImageUploadUrl: '',
//        filebrowserFlashUploadUrl: ''
//    });
//});
</script>

<!-- bootstrap-progressbar -->
<script src="{!! asset('public/admin_assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')!!}"></script>


<!-- jQuery Tags Input -->
<script src="{!! asset('public/admin_assets/vendors/jquery.tagsinput/src/jquery.tagsinput.js')!!}"></script>
<!-- Select2 -->
<!--<script src="public/admin_assets/vendors/select2/dist/js/select2.full.min.js"></script>-->
<!-- Parsley -->
<!--<script src="public/admin_assets/vendors/parsleyjs/dist/parsley.min.js"></script>-->
<!-- Autosize -->
<!--<script src="public/admin_assets/vendors/autosize/dist/autosize.min.js"></script>-->
<!-- jQuery autocomplete -->
<!--<script src="public/admin_assets/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>-->
<!-- starrr -->
<!--<script src="public/admin_assets/vendors/starrr/dist/starrr.js"></script>-->

<!-- Cropper -->
<!--<script src="{!! asset('public/admin_assets/js/cropperjs/dist/cropper.min.js') !!}"></script>-->

@endpush


