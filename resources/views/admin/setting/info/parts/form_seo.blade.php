
<input type="hidden" name="form_data[{{$v->id}}][id]" value="{{ @$item_lang[@$_LANGVAL->id]['id'] }}" />
<div class="form-group">
    <label class="control-label col-md-2 col-sm-3 col-xs-12">{{__('label.tieude')}}</label>
    <div class="col-md-10 col-sm-9 col-xs-12">
        <input type="text" class="form-control" name="form_data[{{$v->id}}][seo_title]" value="{{$wd[$v->id]->seo_title}}" placeholder="Tên đề website">
    </div>
</div>
<div class="control-group">
    <label class="control-label col-md-2 col-sm-3 col-xs-12">{{__('label.tukhoa')}}</label>
    <div class="col-md-10 col-sm-9 col-xs-12">
        <input id="tags_1" type="text" class="tags form-control jquery-input-tag" name="seo_keywords" 
               value="{{$wd[$v->id]->seo_keywords}}" />
        <div id="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-2 col-sm-3 col-xs-12">{{__('label.mota')}}</label>
    <div class="col-md-10 col-sm-9 col-xs-12">
        <textarea class="resizable_textarea form-control" name="seo_description" 
                  placeholder="Mô tả ngắn về website | dưới 166 ký tự">{{$wd[$v->id]->seo_description}}</textarea>
    </div>
</div>

