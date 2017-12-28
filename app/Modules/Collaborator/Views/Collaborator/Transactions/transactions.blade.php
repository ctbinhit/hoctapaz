@extends('pi.layouts.master')

@section('content')

<style>
    table th,td{text-align: center;}
</style>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3></h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_content">
                    <a href="{{url()->previous()}}" class="btn btn-app"><i class="fa fa-arrow-left"></i> Quay lại</a>
                    <a href="{{route('admin_index')}}" class="btn btn-app"><i class="fa fa-dashboard"></i> Dashboard</a>
                    <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>
                    <a href="{{route('mdle_pi_collaborator_rf')}}" class="btn btn-app"><i class="fa fa-edit"></i> Yêu cầu rút</a>
                </div>
            </div>

            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-exchange"></i> Lịch sử nạp & rút <small></small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <table class="table table-bordered" >
                        <thead>
                            <tr>
                                <th></th>
                                <th data-toggle="tooltip" data-placement="top" title="Ngày gửi"><i class="fa fa-calendar"></i></th>
                                <th data-toggle="tooltip" data-placement="top" title="Tổng số tiền rút">Số tiền rút</th>
                                <th data-toggle="tooltip" data-placement="top" title="Ghi chú của đơn yêu cầu">Ghi chú</th>
                                <th data-toggle="tooltip" data-placement="top" title="Đơn yêu cầu nạp/rút">Loại</th>
                                <th data-toggle="tooltip" data-placement="top" title="Trạng thái của đơn yêu cầu">Trạng thái</th>
                                <th data-toggle="tooltip" data-placement="top" title="Được duyệt bởi quản trị.">Duyệt bởi</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($items)!=0)
                            @foreach($items as $k=>$v)
                            @php
                            $tr_state = $v->state==1? 'success':'info';
                            @endphp
                            <tr data-id="{{$v->id}}">
                                <td>{{$k+1}}</td>
                                <td data-toggle="tooltip" data-placement="top" title="{{$v->created_at}}"><b class="label label-{{$tr_state}}">{{diffInNow($v->created_at)}}</b></td>
                                <td>{{number_format($v->amount,0)}} VNĐ</td>
                                <td>{{$v->note}}</td>
                                <td><i class="label label-{{$tr_state}}">{{$v->type=='ycr'?'Rút':'Nạp'}}</i></td>
                                <td><i class="label label-{{$tr_state}}">{{$v->state==0?'Đang chờ duyệt':'Đã duyệt'}}</i></td>
                                <td>...</td>
                                <td>
                                    @if($v->state==0)
                                    <a href="javascript:;" data-toggle="tooltip" data-placement="top" title="Xóa đơn yêu cầu"
                                       class="btn btn-xs btn-danger btn-delete"><i class="fa fa-trash"></i></a>
                                    @else
                                    <i data-toggle="tooltip" data-placement="top" title="Đơn đã được duyệt hoàn tất." class="fa fa-check text-success"></i>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="10" class="text-center"><i class="fa fa-warning"></i> Bạn chưa có lịch sử giao dịch nào...</td>
                            </tr>
                            @endif
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
    </div>



</div>
<input type="hidden" id="mdle_collaborator_ajax" value="{{route('_mdle_pi_collaborator_ajax')}}" />
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('.btn-delete').on('click', function () {
            var tr = $(this).parents('tr');
            var tr_id = tr.data('id');

            $.confirm({
                title: 'Delete form', type: 'blue',
                content: 'Bạn có muốn xóa đơn yêu cầu này?',
                buttons: {
                    confirm: {
                        text: 'Xóa ngay', btnClass: 'btn btn-danger',
                        action: function () {
                            $.ajax({
                                url: $('#mdle_collaborator_ajax').val(),
                                type: 'POST',
                                dataType: 'json',
                                data: {act: 'delete', id: tr_id
                                }, success: function (data) {
                                    if (data.state) {
                                        $(tr).remove();
                                    } else {
                                        $.alert({
                                            title: 'Lịch sử nạp/rút', type: 'blue',
                                            content: data.message
                                        });
                                    }
                                }, error: function (data) {
                                    console.log(data);
                                }
                            });
                        }
                    },
                    cancel: {
                        text: 'Hủy', btnClass: 'btn btn-default',
                        action: () => {
                        }
                    }
                }
            });



        });
    });
</script>
@endpush