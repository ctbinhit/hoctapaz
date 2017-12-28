@extends('pi.layouts.master')

@section('content')
<style>
    table th,td{
        text-align: center;
    }
</style>

<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-bar-chart-o"></i> Thống kê doanh thu & giao dịch</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="x_panel">
        <div class="x_content">
            <a href="{{url()->previous()}}" class="btn btn-app"><i class="fa fa-arrow-left"></i> Quay lại</a>
            <a href="{{route('admin_index')}}" class="btn btn-app"><i class="fa fa-dashboard"></i> Dashboard</a>
            <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>
            <a href="{{route('mdle_pi_collaborator_transactions')}}" class="btn btn-app"><i class="fa fa-exchange"></i> Nạp & Rút</a>
            <a href="#" class="btn btn-app"><i class="fa fa-phone"></i> Hỗ trợ</a>
        </div>
    </div>

    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-list"></i> Doanh thu mới nhất</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <table class="table table-bodered">
                <thead>
                    <tr>
                        <th><i class="fa fa-sort-alpha-asc"></i></th>
                        <th data-toggle="tooltip" data-placement="top" title="Mã bài thi"><i class="fa fa-code"></i></th>
                        <th data-toggle="tooltip" data-placement="top" title="Họ và tên SV"><i class="fa fa-user"></i></th>
                        <th data-toggle="tooltip" data-placement="top" title="Thời gian làm bài"><i class="fa fa-clock-o"></i></th>
                        <th data-toggle="tooltip" data-placement="top" title="Thời gian bắt đầu"><i class="fa fa-clock-o"></i></th>
                        <th data-toggle="tooltip" data-placement="top" title="Thời gian nộp bài"><i class="fa fa-clock-o"></i></th>
                        <th data-toggle="tooltip" data-placement="top" title="Ngày đăng ký"><i class="fa fa-calendar"></i></th>
                        <th data-toggle="tooltip" data-placement="top" title="Điểm"><i class="fa fa-bar-chart-o"></i></th>
                        <th data-toggle="tooltip" data-placement="top" title="Doanh thu"><i class="fa fa-money"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $k=>$v)
                    <tr>
                        <td>{{$k+1}}</td>
                        <td><i class="label label-info">{{$v->code}}</i></td>
                        <td data-toggle="tooltip" data-placement="top" title="{{$v->user_email or 'Chưa có'}}">{{$v->user_fullname}}</td>
                        <td><i class="label label-info">{{number_format(($v->time - ($v->time_end!=null?$v->time_end : $v->time))/60,2)}} phút</i></td>
                        <td><b class="label label-info">{!!$v->time_in or 'Chưa thi'!!}</b></td>
                        <td><b class="label label-info">{!!$v->time_out or 'Chưa thi'!!}</b></td>
                        <td data-toggle="tooltip" data-placement="top" title="{{$v->created_at}}"><i class="label label-info">{{diffInNow($v->created_at)}}</i></td>
                        <td><b class="label label-info">{{$v->score or 'Chưa thi'}}</b></td>
                        <td class="text-success">+{{number_format($v->erm_price,0)}} VNĐ</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="10" style="text-align: left;">
                            <div class="col-md-4">
                                Số dư khả dụng: <b>{{number_format($eum_total)}}</b> VNĐ
                            </div>
                            <div class="col-md-6">
                                {{$items->links()}}
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>
@endsection

