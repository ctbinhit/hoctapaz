@extends('admin.layouts.master')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            <p><strong>Thông báo:</strong> Website đang trong quá trình nâng cấp!</p>
        </div>
    </div>

    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Hệ thống
                    <small>Nếu bạn có thắc mắc trong quá trình sử dụng, xin vui lòng gởi mail phản hồi về địa chỉ <strong><a href="mailto:kythuat@toannang.com.vn">kythuat@toanang.com.vn</a></strong> </small>
                </h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">

                <div class="col-md-9 col-sm-9 col-xs-12">

                    <ul class="stats-overview">
                        <li>
                            <span class="name"> Tổng truy cập </span>
                            <span class="value text-success"> 2300 </span>
                        </li>
                        <li>
                            <span class="name"> Tổng đơn hàng </span>
                            <span class="value text-success"> 2000 </span>
                        </li>
                        <li class="hidden-phone">
                            <span class="name"> Thư liên hệ </span>
                            <span class="value text-success"> 20 </span>
                        </li>
                    </ul>
                    <br />

                    <div id="mainb" style="height:auto;border: 1px solid #ccc; padding: 10px;">
                        <h2>Thống kê số lượng tài khoản năm 2017</h2>
                        @if(count($CHART_USERCOUNT)!=0)
                        <canvas id="jquery-chart-userCount" width="400" height="200"></canvas>
                        @else
                        <p>Không có dữ liệu biểu đồ.</p>
                        @endif
                    </div>

                </div>
                @if(count($CHART_USERCOUNT)!=0)
                <script>
                    $(document).ready(function () {
                    var ctx = document.getElementById("jquery-chart-userCount");
                    var myLineChart = new Chart(ctx, {
                    type: 'line',
                            data: {
                            labels: [
                                    @foreach($CHART_USERCOUNT as $k => $v)
                                    'Tháng {{$v->thang}}',
                                    @endforeach
                            ],
                                    datasets: [{
                                    label: 'Số lượng user',
                                            data: [
                                                    @foreach($CHART_USERCOUNT as $k => $v)
                                            {{$v -> soluong}},
                                                    @endforeach
                                            ],
                                    }]
                            },
                            options: {
                            color: ['#F00']
                            }
                    });
                    });
                </script>
                @endif
                <!-- start project-detail sidebar -->
                <div class="col-sm-3 mail_list_column">
                    <button id="compose" class="btn btn-sm btn-success btn-block" type="button">Đề xuất</button>

                    <a href="{{route('admin_product_index',['sanpham'])}}" class="btn btn-app"><i class="fa fa-list"></i> Sản phẩm</a>
                    <a href="{{route('admin_article_index','tintuc')}}" class="btn btn-app"><i class="fa fa-book"></i> Tin tức</a>
                    <a href="{{route('mdle_admin_cart_index')}}" class="btn btn-app"><i class="fa fa-shopping-cart"></i> Đơn hàng</a>
                    <a href="{{route('admin_user_index','user')}}" class="btn btn-app"><i class="fa fa-users"></i> Users</a>
                    <a href="#" class="btn btn-app"><i class="fa fa-envelope"></i> Thư</a>
                    <a href="#" class="btn btn-app"><i class="fa fa-envelope-square"></i> Liên hệ</a>
                    <a href="{{route('admin_setting_index')}}" class="btn btn-app"><i class="fa fa-gear"></i> Hệ thống</a>
                    <!--                    <a href="#">
                                            <div class="mail_list">
                                                <div class="left">
                                                    <i class="fa fa-circle"></i>
                                                </div>
                                                <div class="right">
                                                    <h3>Đơn hàng <small>3.00 PM</small></h3>
                                                    <p>Đang cập nhật</p>
                                                </div>
                                            </div>
                                        </a>
                                     
                                        <a href="#">
                                            <div class="text-center">
                                                <strong>See All Alerts</strong>
                                                <i class="fa fa-angle-right"></i>
                                            </div>
                                        </a>-->

                </div>
                <!-- end project-detail sidebar -->

            </div>
        </div>
    </div>
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
<!-- iCheck -->
<!--<link href="public/admin_assets//vendors/iCheck/skins/flat/green.css" rel="stylesheet">
 Datatables 
<link href="public/admin_assets//vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="public/admin_assets//vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="public/admin_assets//vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="public/admin_assets//vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="public/admin_assets//vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">-->
@endpush

@push('scripts')
<script src="{{asset('public/admin/bower_components/chart.js/dist/Chart.min.js')}}"></script>
<script src="{{asset('public/admin/js/speedtest.js')}}"></script>


<!-- iCheck 
<script src="public/admin_assets//vendors/iCheck/icheck.min.js"></script>
 Datatables 
<script src="public/admin_assets//vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="public/admin_assets//vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="public/admin_assets//vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="public/admin_assets//vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="public/admin_assets//vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="public/admin_assets//vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="public/admin_assets//vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="public/admin_assets//vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="public/admin_assets//vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="public/admin_assets//vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="public/admin_assets//vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="public/admin_assets//vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>-->

<!-- Flot -->
<!--<script src="public/admin_assets/vendors/Flot/jquery.flot.js"></script>
<script src="public/admin_assets/vendors/Flot/jquery.flot.pie.js"></script>
<script src="public/admin_assets/vendors/Flot/jquery.flot.time.js"></script>
<script src="public/admin_assets/vendors/Flot/jquery.flot.stack.js"></script>
<script src="public/admin_assets/vendors/Flot/jquery.flot.resize.js"></script>-->

<!-- Flot plugins -->
<!--<script src="public/admin_assets/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
<script src="public/admin_assets/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
<script src="public/admin_assets/vendors/flot.curvedlines/curvedLines.js"></script>-->
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