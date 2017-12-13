@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-edit"></i> Yêu cầu <small></small></h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <a href="{{route('admin_index')}}" class="btn btn-app"><i class="fa fa-dashboard"></i> Dashboard</a>
                    <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>

                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-search"></i>
                        @if(Request::has('keyword'))
                        <small>
                            Đang tìm kiếm cho từ khóa: <a href="{{url()->current()   }}" class="label label-info">{{Request::get('keyword')}}</a> (Click để hủy bỏ )
                        </small>
                        @else
                        Tìm kiếm
                        @endif
                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form class="form form-horizontal"> 
                        <div class="form-group">
                            <label for="txtSearch" class="col-md-2 control-label">Từ khóa: </label>
                            <div class="col-md-8 input-group">
                                <input type="text" name="keyword" class="form-control"/>
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>

                    </form>
                </div>
            </div>


            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-list"></i> Danh sách đơn yêu cầu</h2><div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Ngày đăng</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>SĐT</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $k=>$v)
                            <tr>
                                <td title="{{$v->created_at}}">{{$v->created_at->diffForHumans()}}</td>
                                <td><b>{{$v->name}}</b></td>
                                <td>{{$v->email}}</td>
                                <td>{{$v->phone}}</td>
                                <td>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection