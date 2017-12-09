@extends('admin.layouts.master')
@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>{{__('label.lock')}} {{ @$title }}</h3>
        </div>

    </div>
    <div class="clearfix"></div>
    <form class="form-horizontal form-label-left" action="{{route('_admin_user_lock_save',$type)}}" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ @$item->id }}" />

        <div class="col-md-9 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Khóa tài khoản {{$item->fullname}} <small></small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-group col-md-12">
                                    <img src="{{@$item->facebook_avatar}}" class="thumbnail"/>
                                    <hr>
                                    <ul class="list list-group">
                                        <li class="list-group-item"><i class="fa fa-user"></i> {{$item->fullname}}</li>
                                        <li class="list-group-item"><i class="fa fa-envelope"></i> {{$item->email}}</li>
                                        <li class="list-group-item" title="Ngày tạo"><i class="fa fa-clock-o"></i> {{$item->created_date}}</li>
                                        <li class="list-group-item"><i class="fa fa-money"></i> {{$item->coin}}</li>
                                        <li class="list-group-item"><i class="fa fa-genderless"></i> {{$item->gender}}</li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-8">
                            @if($item->lock_by==null)
                            <div class="form-group">
                                <div class="col-md-10 col-md-offset-2">
                                    <p class="text-danger"><i class="fa fa-warning"></i> Sau khi khóa tài khoản này sẽ không thể đăng nhập, bạn có chắc muốn thực hiện?</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Tin nhắn</label>
                                <div class="form-group col-md-10">
                                    <textarea rows="5" class="form-control" name="message" placeholder="Lý do?"></textarea>
                                </div>
                            </div>
                            @else
                            <div class="form-group">
                                <div class="col-md-10 col-md-offset-2">
                                    <p class="text-danger"><i class="fa fa-warning"></i> Tài khoản đang bị khóa!</p>
                                </div>
                            </div>
                            @endif
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-3">
                                    <a href="{{route('admin_user_index',$type)}}" class="btn btn-default">Quay lại</a>
                                    @if($item->lock_by!=null)
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-unlock"></i> Mở khóa</button>
                                    @else
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-lock"></i> Khóa</button>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
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

