
@if($enable_form_tag==1)
   <form action="{{route('_admin_update_pw')}}" method="POST" class="form-horizontal form-label-left" novalidate="">
     {{ csrf_field() }}
    @endif
    <div class="item form-group">
        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="first-name">{{__('label.tendangnhap')}} <span class="required"></span>
        </label>
        <div class="col-md-6 col-sm-9 col-xs-12">
            <input disabled="" type="text" name="fullname" required="required" name="username" value="{{@$item->username}}" placeholder="{{__('placeholder.nhap',['name'=>  __('label.tendangnhap')])}}" class="form-control col-md-7 col-xs-12">
        </div>
    </div>
    <div class="item form-group">
        <label for="password_old" class="control-label col-md-2 col-sm-3 col-xs-12">{{__('label.matkhaucu')}}</label>
        <div class="col-md-6 col-sm-9 col-xs-12">
            <input class="form-control col-md-7 col-xs-12" name="password_old" required="required" type="password" placeholder="{{__('placeholder.nhap',['name'=>  __('label.matkhau')])}}">
        </div>
    </div>
    <div class="item form-group">
        <label for="password_new" class="control-label col-md-2 col-sm-3 col-xs-12">{{__('label.matkhaumoi')}}</label>
        <div class="col-md-6 col-sm-9 col-xs-12">
            <input class="form-control col-md-7 col-xs-12" name="password_new"  data-validate-length-range="6,32" required="required" type="password" placeholder="{{__('placeholder.nhap',['name'=>  __('label.matkhau')])}}">
        </div>
    </div>
    <div class="item form-group">
        <label for="password_new2" class="control-label col-md-2 col-sm-3 col-xs-12">{{__('label.nhaplaimatkhau')}}</label>
        <div class="col-md-6 col-sm-9 col-xs-12">
            <input class="form-control col-md-7 col-xs-12" name="password_new2" data-validate-linked="password_new" data-validate-length-range="6,32" required="required" type="password" placeholder="{{__('placeholder.nhap',['name'=>  __('label.matkhau')])}}">
        </div>
    </div>

    @if($enable_form_tag==1)
    <div class="ln_solid"></div>
    <div class="form-group">
        <div class="col-md-9 col-sm-12 col-xs-12 col-md-offset-3">
            <button type="submit" class="btn btn-success">{{__('label.capnhat')}}</button>
        </div>
    </div>
</form>
@endif
