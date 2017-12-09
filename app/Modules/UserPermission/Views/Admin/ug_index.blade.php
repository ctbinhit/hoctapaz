
@extends('admin.layouts.master')
@push('stylesheet')
<style>
    table th,td {
        text-align: center;
    }
</style>
@endpush
@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Quản lý packages</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="x_panel">
        <div class="x_content">
            <a href="{{route('mdle_userpermission_index')}}" class="btn btn-app"><i class="fa fa-arrow-left"></i> Quay lại</a>
            <a href="{{route('mdle_userpermission_ug_add')}}" class="btn btn-app"><i class="fa fa-plus"></i> Tạo mới</a>
        </div>
    </div>

    <div class="x_panel">
        <div class="x_content">

            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <p><strong>Lưu ý:</strong> Việc xóa 1 nhóm phân quyền sẽ làm ảnh hưởng tất cả user nằm trong nhóm đó!<p>
            </div>

            <table class="table table-bordered" >

                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 30%;">Tên</th>
                        <th style="width: 50%;">Mô tả</th>
                        <th style="width: 15%;">Thao tác</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($items as $k=>$v)
                    <tr>

                        <td>{{$k+1}}</td>
                        <td>{{$v->name}}</td>
                        <td>{{$v->description}}</td>
                        <td>
                            <a href="{{route('mdle_userpermission_ug_permissions',$v->id)}}" class="btn btn-default btn-xs">
                                <i class="fa fa-list"></i> Permissions
                            </a>
                            <a href="#" class="btn btn-default btn-xs">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="#" class="btn btn-danger btn-xs">
                                <i class="fa fa-remove"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="99">

                        </td>
                    </tr>
                </tfoot>

            </table>



        </div>
    </div>
</div>


@endsection