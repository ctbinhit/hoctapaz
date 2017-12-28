<div class="col-md-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-bar-chart-o"></i> Analytics
                <small>Nếu bạn có thắc mắc trong quá trình sử dụng, xin vui lòng gởi mail phản hồi về địa chỉ <strong><a href="mailto:kythuat@toannang.com.vn">kythuat@toanang.com.vn</a></strong> </small>
            </h2>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">

            <div class="col-md-9 col-sm-9 col-xs-12">

                <ul class="stats-overview">
                    <li>
                        <span class="name"> Tổng truy cập </span>
                        <span class="value text-success"> ... </span>
                    </li>
                    <li>
                        <span class="name"> Tổng đơn hàng </span>
                        <span class="value text-success"> ... </span>
                    </li>
                    <li class="hidden-phone">
                        <span class="name"> Thư liên hệ </span>
                        <span class="value text-success"> ... </span>
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
                <a href="{{route('admin_product_index',['sanpham'])}}" class="btn btn-app"><i class="fa fa-list"></i> Sản phẩm</a>
                <a href="{{route('admin_article_index','tintuc')}}" class="btn btn-app"><i class="fa fa-book"></i> Tin tức</a>
                <a href="{{route('mdle_admin_cart_index')}}" class="btn btn-app"><i class="fa fa-shopping-cart"></i> Đơn hàng</a>
                <a href="{{route('admin_user_index','user')}}" class="btn btn-app"><i class="fa fa-users"></i> Users</a>
                <a href="#" class="btn btn-app"><i class="fa fa-envelope"></i> Thư</a>
                <a href="#" class="btn btn-app"><i class="fa fa-envelope-square"></i> Liên hệ</a>
                <a href="{{route('admin_setting_index')}}" class="btn btn-app"><i class="fa fa-gear"></i> Hệ thống</a>
            </div>
            <!-- end project-detail sidebar -->

        </div>
    </div>
</div>