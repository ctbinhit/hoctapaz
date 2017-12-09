@extends('admin.layouts.master')
@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>{{__('label.them')}} {{ @$title }}</h3>
        </div>

    </div>
    <div class="clearfix"></div>
    <form class="form-horizontal form-label-left" action="{{route('_admin_user_save',$type)}}" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ @$item->id }}" />

        <div class="col-md-9 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{ __('label.thongtinchung')}} <small></small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div class="form-group">
                        <label class="control-label col-md-2">Họ và tên</label>
                        <div class="form-group col-md-10">
                            <input type="text" class="form-control" name="fullname" value="{{@$item->fullname}}" placeholder="Họ và tên"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">Email</label>
                        <div class="form-group col-md-10">
                            <input type="text" class="form-control" name="email" value="{{@$item->email}}" placeholder="Email"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">Username</label>
                        <div class="form-group col-md-10">
                            <input type="text" class="form-control" name="username" value="{{@$item->username}}" placeholder="Username"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">CMND</label>
                        <div class="form-group col-md-10">
                            <input type="text" class="form-control" name="cmnd" value="{{@$item->id_card}}" placeholder="CMND"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">Phone</label>
                        <div class="form-group col-md-10">
                            <input type="text" class="form-control" name="phone" value="{{@$item->phone}}" placeholder="Điện thoại"/>
                        </div>
                    </div>

                    @if($lst_per_groups!=null)
                    <div class="form-group">
                        <label for="nameOfTheInput" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Nhóm user:</label>
                        <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                            <select class="form-control" name="ipg">
                                 <option>-- User groups --</option>
                                @foreach($lst_per_groups as $k=>$v)
                                <option {{@$item->id_permission_group==$v->id?'selected':''}} value="{{$v->id}}">{{$v->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif

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
                    <div class="form-group">
                        <div class="form-group col-md-12">
                            <img src="{{@$item->facebook_avatar}}" />
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-3">
                            <a href="{{route('admin_user_index',$type)}}" class="btn btn-primary">Quay lại</a>
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Lưu</button>
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

@endpush

