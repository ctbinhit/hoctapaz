<div class="col-md-6 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-share-alt"></i> {{__('label.seo')}} <small> Seo bài viết</small></h2>
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

<div class="col-md-6">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-image"></i> Hình ảnh SEO - Facebook, Google, Twitter...</h2><div class="clearfix"></div>
        </div>
        <div class="x_content">
            @if(isset($item->data_photo_seo[0]->url))
            <div class="form-group">
                <label for="img" class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Hình hiện tại:</label>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                    <img src="{{Storage::disk('localhost')->url($item->data_photo_seo[0]->url)}}" class="thumbnail" style="width: 100%;height: auto;"/>
                </div>
            </div>
            @endif
            <div class="form-group">
                <label for="photo_seo" class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Hình ảnh SEO:</label>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                    <input type="file" name="photo_seo" id="photo_seo" class="form-control"/>
                </div>
            </div>
        </div>
    </div>
</div>