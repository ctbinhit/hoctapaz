
@extends('admin.layouts.master')

@push('stylesheet')
<style>
    table th,td{
        text-align: center;
    }
</style>
@endpush

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Lịch sử giao dịch</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="x_panel">
        <div class="x_content">

            <form class="form form-horizontal" method="GET" action="">

                <div class="form-group">
                    <label for="nameOfTheInput" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Từ khóa:</label>
                    <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12 input-group">
                        <input type="text" name="keywords" class="form-control" placeholder="Tìm số pin, seri, giá tiền..." />
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            @if(Request::has('keywords'))
                            <a href="{{url()->current()}}" class="btn btn-danger"><i class="fa fa-remove"></i></a>
                            @endif
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="x_panel">
        <div class="x_title">
            <h2>Lịch sử giao dịch</h2>
            <div class="pull-right">
                <a target="_blank" href="http://napngay.com/giao-dich-tu-the-cao" 
                   class="btn btn-default btn-xs"><i class="fa fa-bank"></i> Lịch sử giao dịch trên Bảo Kim</a>
                <a target="_blank" href="http://napngay.com/thong-tin-tai-khoan" 
                   class="btn btn-info btn-xs"><i class="fa fa-bar-chart"></i> Tra cứu % chiết khấu</a>
                <a target="_blank" href="http://napngay.com/gach-the-truc-tiep" 
                   class="btn btn-default btn-xs"><i class="fa fa-credit-card-alt"></i> Nạp tiền</a>
                <a target="_blank" href="http://napngay.com/withdrawLog/preWithdraw" 
                   class="btn btn-default btn-xs"><i class="fa fa-credit-card"></i> Rút tiền</a>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <table class="table table-bordered" >
                <form action="" method="get">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên user</th>
                            <th>Email</th>
                            <th>Ngày giao dịch</th>
                            <th> 
                                <select class="form-control" name="card_type">
                                    <option value="">-- Loại thẻ --</option>
                                    <option {{Request::get('card_type')=='VIETEL'?'selected':''}} value="VIETEL">Viettel</option>
                                    <option {{Request::get('card_type')=='MOBI'?'selected':''}} value="MOBI">Mobifone</option>
                                    <option {{Request::get('card_type')=='VINAPHONE'?'selected':''}} value="VINAPHONE">Vinaphone</option>
                                    <option {{Request::get('card_type')=='GATE'?'selected':''}} value="GATE">GATE</option>
                                    <option {{Request::get('card_type')=='VTC'?'selected':''}} value="VTC">VTC</option>
                                </select>
                            </th>
                            <th>Card seri</th>
                            <th>Card pin</th>
                            <th>
                                <select class="form-control" name="state">
                                    <option value="">-- Trạng thái --</option>
                                    <option {{Request::get('state')=='success'?'selected':''}} value="success">Thành công</option>
                                    <option {{Request::get('state')=='error'?'selected':''}} value="error">Thất bại</option>
                                </select>
                            </th>
                            <th>
                                <select class="form-control" name="amount">
                                    <option value="">-- Mệnh giá --</option>
                                    <option {{Request::get('amount')==10000?'selected':''}} value="10000">10.000 VNĐ</option>
                                    <option {{Request::get('amount')==20000?'selected':''}} value="20000">20.000 VNĐ</option>
                                    <option {{Request::get('amount')==50000?'selected':''}} value="50000">50.000 VNĐ</option>
                                    <option {{Request::get('amount')==100000?'selected':''}} value="100000">100.000 VNĐ</option>
                                    <option {{Request::get('amount')==200000?'selected':''}} value="200000">200.000 VNĐ</option>
                                    <option {{Request::get('amount')==500000?'selected':''}} value="500000">500.000 VNĐ</option>
                                </select>
                            </th>
                            <th>
                                <button type="submit" class="btn btn-default"><i class="fa fa-filter"></i> Lọc</button>
                            </th>
                        </tr>
                    </thead>
                </form>
                <tbody>
                    @if(count($items)!=0)
                    @foreach($items as $k=>$v)
                    <tr>
                        <td>{{$k+1}}</td>
                        <td>{{@$v->user->fullname}}</td>
                        <td>{{@$v->user->email}}</td>
                        <td>{{$v->created_at}}</td>
                        <td>{{$v->card_type}}</td>
                        <td>{{$v->card_seri}}</td>
                        <td>{{$v->card_pin}}</td>
                        <td style="font-weight: bold;" class="{{$v->state=='success'?'text-success':'text-danger'}}">{{$v->state=='success'?'Thành công':'thất bại'}}</td>
                        <td class="text-danger">{{number_format($v->amount, 2)}} VNĐ</td>
                        <td>
                            <a href="#" class="btn btn-default btn-xs">
                                <i class="fa fa-edit"> Thông tin</i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="99">
                            <p>Không có dữ liệu nào.</p>
                        </td>
                    </tr>
                    @endif
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="99">
                            <div class="row">
                                <div class="col-md-2">
<!--                                    <select class="form-control">
                                        <option>-- Hiển thị --</option>
                                        <option>5</option>
                                        <option>10</option>
                                        <option>20</option>
                                        <option>50</option>
                                    </select>-->
                                </div>
                                <div class="col-md-2">

                                </div>
                                <div class="col-md-4">
                                    {{$items_link->links()}}
                                </div>
                                <div class="col-md-4 text-left">
                                    <p>Tổng giá trị giao dịch: <strong>{{number_format($total,0)}} VNĐ</strong></p>
                                    <p>Tổng giao dịch thành công: <strong>{{@$trans_success_count}}</strong></p>
                                    <p>Tổng giao dịch thất bại: <strong>{{@$trans_error_count}}</strong></p>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tfoot>

            </table>


        </div>
    </div>

    <div class="x_panel">
        <div class="x_content">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Loại thẻ</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @if(count($chart_card_type)!=0)
                            <canvas id="card_type_chart"></canvas>
                            @endif
                        </div>
                    </div>


                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Thống kê thu nhập</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @if(count($chart_card_type)!=0)
                            <canvas id="lineChart"></canvas>
                            @else
                            <p>Không có dữ liệu biểu đồ.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="{{asset('public/admin/bower_components/chart.js/dist/Chart.min.js')}}"></script>
@if(count($chart_card_type)!=0))
<script>
    var ctx = document.getElementById("card_type_chart");
    data = {
    datasets: [{
    backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
    ],
            data: [
                    @foreach($chart_card_type as $k => $v)
                    {{$v->sl}},
                    @endforeach
            ]
    }],
            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: [
                    @foreach($chart_card_type as $k => $v)
                    '{{$v->card_type}}',
                    @endforeach
            ],
    };
    var myChart = new Chart(ctx, {
    type: 'pie',
            data: data,
    });</script>
@endif
@if(count($chart_card_type)!=0))
<script>
    var ctx = document.getElementById("lineChart");
    var myChart = new Chart(ctx, {
    type: 'bar',
            data: {
            labels: [
                    @foreach($chart_card_type as $k => $v)
                    '{{$v->card_type}}',
                    @endforeach
            ],
                    datasets: [{
                    label: 'Loại thẻ',
                            data: [
                                    @foreach($chart_card_type as $k => $v)
                            {{$v->sl}},
                                    @endforeach
                            ],
                            backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                    'rgba(255,99,132,1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                    }]
            },
            options: {
            scales: {
            yAxes: [{
            ticks: {
            beginAtZero:true
            }
            }]
            }
            }
    });
</script>
@endif
@endpush