<input type="hidden" name="form_data[{{$v->id}}][id]" value="form_data[{{@$v->id}}][id]" />
<div class="form-group">
    <label class="control-label col-md-2 col-sm-2 col-xs-12"><i class="fa fa-facebook"></i></label>
    <div class="col-md-10 col-sm-10 col-xs-12">
        <input type="text" class="form-control" name="form_data[{{$v->id}}][fb_fanpage]" value="{{@$wd[$v->id]->fb_fanpage}}" placeholder="Link fanpage facebook">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-2 col-sm-2 col-xs-12"><i class="fa fa-skype"></i></label>
    <div class="col-md-10 col-sm-10 col-xs-12">
        <input type="text" class="form-control" name="form_data[{{$v->id}}][skype]" value="{{@$wd[$v->id]->skype}}" placeholder="SĐT skype">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-2 col-sm-2 col-xs-12"><i class="fa fa-google-plus"></i></label>
    <div class="col-md-10 col-sm-10 col-xs-12">
        <input type="text" class="form-control" name="form_data[{{$v->id}}][google]" value="{{@$wd[$v->id]->google}}" placeholder="Link google+">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-2 col-sm-2 col-xs-12"><i class="fa fa-twitter"></i></label>
    <div class="col-md-10 col-sm-10 col-xs-12">
        <input type="text" class="form-control" name="form_data[{{$v->id}}][twitter]" value="{{@$wd[$v->id]->twitter}}" placeholder="Link twitter">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-2 col-sm-2 col-xs-12">Viber</label>
    <div class="col-md-10 col-sm-10 col-xs-12">
        <input type="text" class="form-control" name="form_data[{{$v->id}}][viber]" value="{{@$wd[$v->id]->viber}}" placeholder="SĐT Viber">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-2 col-sm-2 col-xs-12">Zalo</label>
    <div class="col-md-10 col-sm-10 col-xs-12">
        <input type="text" class="form-control" name="form_data[{{$v->id}}][zalo]" value="{{@$wd[$v->id]->zalo}}" placeholder="SĐT Zalo">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-2 col-sm-2 col-xs-12"><i class="fa fa-youtube"></i></label>
    <div class="col-md-10 col-sm-10 col-xs-12">
        <input type="text" class="form-control" name="form_data[{{$v->id}}][youtube]" value="{{@$wd[$v->id]->youtube}}" placeholder="Link youtube">
    </div>
</div>