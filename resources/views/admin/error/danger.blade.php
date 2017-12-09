<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>{{@$data->title}}</title>
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
                    <h1>ERROR 404!</h1>

                    <a href="{{route('client_index')}}" class="btn btn-default"><i class="fa fa-home"></i> Trang chủ</a>
                </div>
            </div>

        </div>


        <!-- Bootstrap -->
        <script src="{!! asset('public/admin/bower_components/bootstrap/dist/js/bootstrap.min.js')!!}"></script>
    </body>
</html>

