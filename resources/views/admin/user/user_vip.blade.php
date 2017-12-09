@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>USER VIP <small></small></h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('label.danhsach')}} {{@$title}}</small></h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <a href="{{route('admin_user_index',$type)}}" class="btn btn-app"><i class="fa fa-arrow-left"></i> Quay lại</a>
                    <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> {{__('label.tailai')}}</a>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Thông tin</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form class="form form-horizontal" action="{{route('_admin_user_vip_save',[$type,$item->id])}}" method="POST">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$item->id}}" />
                        <div class="form-group">
                            <label for="name" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Tên:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                <input type="text" id="name" value="{{$item->fullname}}" class="form-control" placeholder="..." />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="coin" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Số dư:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                <input type="text" class="form-control" value="{{number_format($item->coin,0)}} VNĐ" disabled=""/>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Email:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                <input type="text" class="form-control" value="{{$item->email}}" disabled=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="created_at" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Ngày tham gia:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                <input type="text" class="form-control" value="{{$item->created_at}}" disabled=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="vip_name" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">VIP hiện tại:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                <input type="text" class="form-control" value="{{$item->data_vip->name}}" disabled=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="upgrade_to_vip" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Nâng lên vip:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">

                                <select class="form-control" name="id_vip">
                                    <optgroup label="User VIP">
                                        @foreach($vip_models as $k=>$v)
                                        <option value="{{$v->id}}">{{$v->name}} - {{$v->discount}}%</option>
                                        @endforeach
                                    </optgroup>
                                </select>

                            </div>
                        </div>

                        <div class="ln_solid"></div>

                        <div class="form-group">
                            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 col-md-offset-2">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> {{__('label.capnhat')}}</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
@include('admin.user.jsc.JSUserController_index')
@endpush
