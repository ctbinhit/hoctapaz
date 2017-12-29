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
            <h2><i class="fa fa-hdd-o"></i> Quản lý file</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 8%;"><i class="fa fa-sort-numeric-asc"></i></th>
                        <th>File</th>
                        <th>Giá</th>
                        <th data-toggle="tooltip" data-placement="top" title="Danh mục"><i class="fa fa-list"></i></th>
                        <th><i class="fa fa-users"></i></th>
                        <th><i class="fa fa-eye"></i></th>
                        <th data-toggle="tooltip" data-placement="top" title="Tổng thu"><i class="fa fa-money"></i></th>
                        <th data-toggle="tooltip" data-placement="top" title="Ngày đăng"><i class="fa fa-calendar"></i></th>
                        <th data-toggle="tooltip" data-placement="top" title="Ngày hết hạn"><i class="fa fa-calendar"></i></th>
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
                <tfoot>
                    <tr>
                        <td colspan="10">{{$items->links()}}</td>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>

</div>
<input type="hidden" name="_mdle_doc_ajax" id="_mdle_doc_ajax" value="{{route('_mdle_pi_doc_ajax',$type)}}" />
@endsection