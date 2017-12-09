<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title> 404 - Site not found.</title>
        <base href="{{env('APP_URL')}}/admin" />

        <!-- Bootstrap -->
        <link href="{!! asset('public/admin/bower_components/bootstrap/dist/css/bootstrap.min.css')!!}" rel="stylesheet">

        <!-- Font Awesome -->
        <link href="{!! asset('public/admin/bower_components/font-awesome/css/font-awesome.min.css')!!}" rel="stylesheet">
        <link href="{!! asset('public/admin/bower_components/font-awesome-animation/dist/font-awesome-animation.min.css')!!}" rel="stylesheet">

        <!-- Animated -->
        <link href="{!! asset('public/admin/bower_components/animate.css/animate.min.css')!!}" rel="stylesheet">

        <!-- Bootstrap addon -->
        <link href="{!! asset('public/admin/build/css/bootstrap-plus.css')!!}" rel="stylesheet">

        <!-- jQuery -->
        <script src="{!! asset('public/admin/bower_components/jquery-2x/dist/jquery.min.js')!!}"></script>
    </head>
    <body>

        <div class="container">

            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 text-center">
                            <h1 class="text-info"><i class="fa fa-search"></i> ERROR 404!</h1>
                            <p class="text-info">Chúng tôi không thể tìm thấy trang mà bạn yêu cầu, địa chỉ đã bị xóa hoặc đã bị chuyển sang nơi khác.</p>
                            <br>
                            
                            <a href="{{route('client_index')}}" title="Quay lại trang chủ" class="label label-info"><i class="fa fa-home"></i> Trang chủ</a>
                            <a href="http://toannang.com.vn" target="_blank" title="Ghé thăm công ty Toàn Năng" class="label label-info">ToanNang Co., Ltd</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <!-- Bootstrap -->
        <script src="{!! asset('public/admin/bower_components/bootstrap/dist/js/bootstrap.min.js')!!}"></script>
    </body>
</html>

