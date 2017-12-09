@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-file-pdf-o"></i> Tài liệu</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="x_panel">
        <div class="x_content">
            <a href="{{route('admin_index')}}" class="btn btn-app"><i class="fa fa-dashboard"></i> Dashboard</a>
            <a href="{{route('mdle_admin_doc_index',$type)}}" class="btn btn-app"><i class="fa fa-file-pdf-o"></i> Tài liệu chờ duyệt</a>
            <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>
        </div>
    </div>

    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-spinner fa-spin animated"></i> Danh sách tài liệu đã bị hủy.</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <table class="table table-bordered" >

                <thead>
                    <tr>
                        <th>Tên tài liệu</th>
                        <th><i class="fa fa-user"></i> Tên GV</th>
                        <th>Giá</th>
                        <th>Ngày duyệt</th>
                        <th>Ngày hết hạn</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($items as $k=>$v)
                    <tr data-id="{{$v->id}}">
                        <td>{{$v->name}}</td>
                        <td>GV Trần Văn A</td>
                        <td>{{number_format($v->price,0)}} VNĐ</td>
                        <td>{{diffInNow($v->approved_date)}}</td>
                        <td>Không thời hạn</td>
                        <td>Chờ duyệt</td>
                        <td>
                            <button class="btn btn-default btn-xs jquery-btn-view"><i class="fa fa-eye"></i> Xem chi tiết</button>
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


    <input type="hidden" name="_mdle_admin_doc_ajax" id="_mdle_admin_doc_ajax" 
           value="{{route('_mdle_admin_doc_ajax',$type)}}" />
</div>
@endsection

@push('stylesheet')

<link href="{{asset('public/fonts/entypo/entypo.css')}}" rel="stylesheet" type="text/css"/>

@endpush

@push('scripts')
<script>
    $(document).ready(function () {

    });
</script>
@endpush