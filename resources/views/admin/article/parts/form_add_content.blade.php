<div class="col-md-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-edit"></i> {{__('label.noidung')}} <small> Nội dung bài viết</small></h2>
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