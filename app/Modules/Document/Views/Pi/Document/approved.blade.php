@extends('pi.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-file-word-o"></i> Tài liệu đang bán</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="x_panel">
        <a href="{{route('pi_index_index')}}" class="btn btn-app"><i class="fa fa-dashboard"></i> Dashboard</a>
        <a href="{{route('mdle_pi_doc_index',$type)}}" class="btn btn-app"><i class="fa fa-hdd-o"></i> Tài liệu đã tải lên</a>
        <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>

    </div>

    <div class="x_panel">
        <div class="x_title">
            <h2>Quản lý file</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 8%;"><i class="fa fa-sort-numeric-asc"></i></th>
                        <th>File</th>
                        <th>Giá</th>
                        <th>Danh mục</th>
                        <th><i class="fa fa-users"></i></th>
                        <th><i class="fa fa-eye"></i></th>
                        <th>Tổng thu</th>
                        <th>Ngày bán</th>
                        <th>Ngày kết thúc</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($items)!=0)
                    @foreach($items as $k=>$v)
                    <tr>
                        <td>
                            <input type="number" class="form-control jquery-ajaxField" name="ordinal_number" data-id="{{$v->id}}" value="{{$v->ordinal_number}}"/>
                        </td>
                        <td>{{$v->name}}</td>
                        <td>{{number_format($v->price,0)}} VNĐ</td>
                        <td>{{$v->type=='de-thi-thu'?'Đề thi thử':'Tài liệu học'}}</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0 VNĐ</td>
                        <td>{{diffInNow($v->start_date)}}<br>{{$v->created_at}}</td>
                        <td>{{diffInNow($v->expire_date)}}<br>{{$v->created_at}}</td>
                        <td>

                            @if($v->state=='selling')
                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-eye"></i></button>
                            <button type="button" class="btn btn-warning btn-sm jquery-btn-cancel-request"><i class="fa fa-remove"></i> Ngưng bán</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="10">Không có dữ liệu.</td>
                    </tr>
                    @endif
                </tbody>
            </table>

        </div>
    </div>

</div>
<input type="hidden" name="_mdle_doc_ajax" id="_mdle_doc_ajax" value="{{route('_mdle_pi_doc_ajax',$type)}}" />
@endsection