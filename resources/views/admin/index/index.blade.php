@extends('admin.layouts.master')

@section('content')
<div class="row top_tiles">
    <div data-toggle="tooltip" data-placement="top" title="Danh sách đơn hàng mới nhất" class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-shopping-cart"></i></div>
            <div class="count">0</div>
            <h3><a href="{{route('mdle_admin_cart_index')}}">Đơn hàng</a></h3>
            <p>Đơn hàng mới đặt.</p>
        </div>
    </div>
    <div data-toggle="tooltip" data-placement="top" title="Danh sách thành viên đăng ký mới" class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-check-square-o"></i></div>
            <div class="count">0</div>
            <h3><a href="{{route('admin_user_index','user')}}">Đăng ký mới</a></h3>
            <p>Thành viên đăng ký mới.</p>
        </div>
    </div>
    <div data-toggle="tooltip" data-placement="top" title="Danh sách đối tác" class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-edit"></i></div>
            <div class="count">0</div>
            <h3><a href="{{route('admin_user_index','professor')}}">Đối tác</a></h3>
            <p>Đối tác mới đăng ký.</p>
        </div>
    </div>
    <div data-toggle="tooltip" data-placement="top" title="Danh sách đơn nạp/rút mới nhất" class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-check-square"></i></div>
            <div class="count">{{$today_count_naprut or 0}} </div>
            <h3><a href="{{route('mdle_admin_collaborator_exchange_index')}}">Đơn nạp rút</a> </h3>
            <p>Đơn nạp/rút mới nhất (đối tác).</p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            <p><strong>Thông báo:</strong> Website đang trong quá trình nâng cấp!</p>
        </div>
    </div>

    @include('admin.index.charts.visitor')
  
    <div class="col-md-9">
        <div class="x_panel">
            <div class="x_title"><h2>Lịch sử giao dịch thẻ cào</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @if(count($CHART_TRANSACTIONS)!=0)
                <canvas id="jquery-chart-transactionsCard" width="400" height="200"></canvas>
                @else
                <p>Không có dữ liệu biểu đồ.</p>
                @endif
            </div>
            @if(count($CHART_TRANSACTIONS)!=0)
            <script>
                $(document).ready(function () {
                var ctx = document.getElementById("jquery-chart-transactionsCard");
                var myLineChart = new Chart(ctx, {
                type: 'line',
                        data: {
                        labels: [
                                @foreach($CHART_TRANSACTIONS as $k => $v)
                                'Tháng {{$k}}',
                                @endforeach
                        ],
                                datasets: [{
                                label: 'Tổng lần giao dịch',
                                        data: [
                                                @foreach($CHART_TRANSACTIONS as $k => $v)
                                        {{$v}},
                                                @endforeach
                                        ],
                                        backgroundColor: ['rgba(122,122,23,0.5)']
                                }, {
                                label: 'Thất bại',
                                        data: [
                                                @foreach($CHART_TRANSACTIONS_ERROR as $k => $v)
                                        {{$v}},
                                                @endforeach
                                        ],
                                        backgroundColor: ['rgba(255,0,0,0.7)']
                                }, {
                                label: 'Thành công',
                                        data: [
                                                @foreach($CHART_TRANSACTIONS_SUCCESS as $k => $v)
                                        {{$v}},
                                                @endforeach
                                        ],
                                        backgroundColor: ['rgba(8,255,95,0.5)']
                                }]
                        },
                        options: {
                        color: ['#F00']
                        }
                });
                });
            </script>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <div class="x_panel">
            <div class="x_title"><h2><i class="fa fa-info"></i> Tình trạng</h2><div class="clearfix"></div></div>
            <div class="x_content text-center" id="google-speed-test">
                <i class="fa fa-spinner faa-spin animated"></i> Đang phân tích...
            </div>
        </div>
        <div class="x_panel">
            <div class="x_title"><h2><i class="fa fa-database"></i> Tài nguyên</h2><div class="clearfix"></div></div>
            <div class="x_content text-center" id="google-displayResourceSizeBreakdown">
                <i class="fa fa-spinner faa-spin animated"></i> Đang phân tích...
            </div>
        </div>
    </div>
</div>
@endsection

@push('stylesheet')
@endpush

@push('scripts')
<script src="{{asset('public/admin/bower_components/chart.js/dist/Chart.min.js')}}"></script>
<script src="{{asset('public/admin/js/speedtest.js')}}"></script>

<script>
//    function init_flot_chart() {
//        if (typeof ($.plot) === 'undefined') {
//            return;
//        }
//        console.log('init_flot_chart');
//        var arr_data2 = [
//            [gd(2012, 1, 1), 82],
//            [gd(2012, 1, 2), 23],
//            [gd(2012, 1, 3), 66],
//            [gd(2012, 1, 4), 9],
//            [gd(2012, 1, 5), 119],
//            [gd(2012, 1, 6), 6],
//            [gd(2012, 1, 7), 9]
//        ];
//        var chart_plot_02_data = [];
//        for (var i = 0; i < 30; i++) {
//            chart_plot_02_data.push([new Date(Date.today().add(i).days()).getTime(), randNum()]);
//        }
//        var chart_plot_02_settings = {
//            grid: {
//                show: true,
//                aboveData: true,
//                color: "#3f3f3f",
//                labelMargin: 10,
//                axisMargin: 0,
//                borderWidth: 0,
//                borderColor: null,
//                minBorderMargin: 5,
//                clickable: true,
//                hoverable: true,
//                autoHighlight: true,
//                mouseActiveRadius: 100
//            },
//            series: {
//                lines: {
//                    show: true,
//                    fill: true,
//                    lineWidth: 2,
//                    steps: false
//                },
//                points: {
//                    show: true,
//                    radius: 4.5,
//                    symbol: "circle",
//                    lineWidth: 3.0
//                }
//            },
//            legend: {
//                position: "ne",
//                margin: [0, -25],
//                noColumns: 0,
//                labelBoxBorderColor: null,
//                labelFormatter: function (label, series) {
//                    return label + '&nbsp;&nbsp;';
//                },
//                width: 40,
//                height: 1
//            },
//            colors: ['#96CA59', '#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282'],
//            shadowSize: 0,
//            tooltip: true,
//            tooltipOpts: {
//                content: "%s: %y.0",
//                xDateFormat: "%d/%m",
//                shifts: {
//                    x: -30,
//                    y: -50
//                },
//                defaultTheme: false
//            },
//            yaxis: {
//                min: 0
//            },
//            xaxis: {
//                mode: "time",
//                minTickSize: [1, "day"],
//                timeformat: "%d/%m/%y",
//                min: chart_plot_02_data[0][0],
//                max: chart_plot_02_data[20][0]
//            }
//        };
//        if ($("#chart_plot_02").length) {
//            console.log('Plot2');
//
//            $.plot($("#chart_plot_02"),
//                    [{
//                            label: "Lượt truy cập",
//                            data: chart_plot_02_data,
//                            lines: {
//                                fillColor: "rgba(150, 202, 89, 0.12)"
//                            },
//                            points: {
//                                fillColor: "#fff"}
//                        }], chart_plot_02_settings);
//
//        }
//    }
//
//    $(document).ready(function () {
//        init_flot_chart();
//    });

</script>
@endpush