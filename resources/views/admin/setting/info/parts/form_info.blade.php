<input type="hidden" name="form_data[{{$v->id}}][id]" value="" />
<div class="form-group">
    <label class="control-label col-md-2 col-sm-3 col-xs-12">Tên công ty | doanh nghiệp</label>
    <div class="col-md-10 col-sm-9 col-xs-12">
        <input type="text" class="form-control" name="form_data[{{$v->id}}][title]" value="{{$wd[$v->id]->title}}" 
               placeholder="Tên công ty | doanh nghiệp, vd: Toàn Năng Company">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-2 col-sm-3 col-xs-12">Hotline</label>
    <div class="col-md-10 col-sm-9 col-xs-12">
        <input type="text" class="form-control" name="form_data[{{$v->id}}][hotline]" value="{{$wd[$v->id]->hotline}}" 
               placeholder="Hotline ( Hotline của công ty )">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-2 col-sm-3 col-xs-12">Địa chỉ</label>
    <div class="col-md-10 col-sm-9 col-xs-12">
        <input type="text" class="form-control" name="form_data[{{$v->id}}][address]" value="{{$wd[$v->id]->address}}" 
               placeholder="Địa chỉ ( Địa chỉ công ty )">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-2 col-sm-3 col-xs-12">Email</label>
    <div class="col-md-10 col-sm-9 col-xs-12">
        <input type="text" class="form-control" name="form_data[{{$v->id}}][email]" value="{{$wd[$v->id]->email}}" 
               placeholder="Email ( Thư điện tử )">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-2 col-sm-3 col-xs-12">Website</label>
    <div class="col-md-10 col-sm-9 col-xs-12">
        <input type="text" class="form-control" name="form_data[{{$v->id}}][website_url]" value="{{$wd[$v->id]->website_url}}" 
               placeholder="vd: toannang.com.vn">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-2 col-sm-3 col-xs-12">Copyright</label>
    <div class="col-md-10 col-sm-9 col-xs-12">
        <input type="text" class="form-control" name="form_data[{{$v->id}}][copyright]" value="{{$wd[$v->id]->copyright}}" 
               placeholder="vd: Copyright&copy;2017 ToanNang Co., Ltd">
    </div>
</div>