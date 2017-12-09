@extends('pi.layouts.master')

@section('content')
<div class="">

    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Thống kê <small></small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="alert alert-info"><strong>Thông báo </strong> Đang cập nhật.</div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Thống kê doanh thu <small></small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="alert alert-info"><strong>Thông báo </strong> Đang cập nhật.</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Thông báo <small>từ quản trị viên</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="alert alert-info"><strong>Thông báo </strong> Đang cập nhật.</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Thông báo <small>từ hệ thống</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="alert alert-info"><strong>Thông báo </strong> Đang cập nhật.</div>
                </div>
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