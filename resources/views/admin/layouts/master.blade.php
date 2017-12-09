<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="ajax-request" content="{{route('_admin_ajax_request')}}" />
        <title> Administrator | Công ty TNHH Dịch Vụ Công Nghệ Toàn Năng</title>

        <base href="{{env('APP_URL')}}/admin" />
        
        <!-- Icons -->
        <link href="{!! asset('public/plugins/icons/brand/style.css')!!}" rel="stylesheet">
        
        <!-- Bootstrap -->
        <link href="{!! asset('public/admin/bower_components/bootstrap/dist/css/bootstrap.min.css')!!}" rel="stylesheet">

        <!-- Font Awesome -->
        <link href="{!! asset('public/admin/bower_components/font-awesome/css/font-awesome.min.css')!!}" rel="stylesheet">
        <link href="{!! asset('public/admin/bower_components/font-awesome-animation/dist/font-awesome-animation.min.css')!!}" rel="stylesheet">

        <!-- Animated -->
        <link href="{!! asset('public/admin/bower_components/animate.css/animate.min.css')!!}" rel="stylesheet">

        <!-- NProgress -->
        <link href="{!! asset('public/admin/bower_components/nprogress/nprogress.css')!!}" rel="stylesheet">

        <!-- Datetime & Date range picker -->
        <link href="{!! asset('public/admin/bower_components/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')!!}" rel="stylesheet">
        <link href="{!! asset('public/admin/bower_components/bootstrap-daterangepicker/daterangepicker.css')!!}" rel="stylesheet">

        <!-- iCheck -->
        <link href="{!! asset('public/admin/bower_components/iCheck/skins/all.css')!!}" rel="stylesheet">

        <!-- Switchery -->
        <link href="{!! asset('public/admin/bower_components/switchery/dist/switchery.min.css')!!}" rel="stylesheet">

        <!-- Pnotify -->
        <link href="{!! asset('public/admin/bower_components/pnotify/dist/pnotify.css')!!}" rel="stylesheet">
        <link href="{!! asset('public/admin/bower_components/pnotify/dist/pnotify.buttons.css')!!}" rel="stylesheet">

        <!-- Jquery confirm -->
        <link href="{!! asset('public/admin/bower_components/jquery-confirm2/css/jquery-confirm.css')!!}" rel="stylesheet">


        @yield('header_css')

        @stack('stylesheet')


        <!-- Custom Theme Style -->
        <link href="{!! asset('public/admin/build_/css/custom.min.css')!!}" rel="stylesheet">

        <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- jQuery -->
        <script src="{!! asset('public/admin/bower_components/jquery-2x/dist/jquery.min.js')!!}"></script>
        <script>$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});</script>
    </head>

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                @include('admin.layouts.nav_left')

                <!-- top navigation -->
                @include('admin.layouts.nav_top')
                <!-- /top navigation -->

                <!-- page content -->
                <div class="right_col" role="main">
                    @yield('content')
                </div>
                <!-- /page content -->

                <!-- footer content -->
                 @include('admin.layouts.footer')
                <!-- /footer content -->
            </div>
        </div>

        @include('admin.BJS')

        <!-- Bootstrap -->
        <script src="{!! asset('public/admin/bower_components/bootstrap/dist/js/bootstrap.min.js')!!}"></script>

        <!-- NProgress -->
        <script src="{!! asset('public/admin/bower_components/nprogress/nprogress.js')!!}"></script>

        <!-- iCheck -->
        <script src="{!! asset('public/admin/bower_components/iCheck/icheck.min.js')!!}"></script>

        <!-- DateJS -->
        <script src="{!! asset('public/admin/bower_components/DateJS/build/date.js')!!}"></script>

        <!-- bootstrap-daterangepicker -->
        <script src="{!! asset('public/admin/bower_components/moment/min/moment.min.js')!!}"></script>
        <script src="{!! asset('public/admin/bower_components/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')!!}"></script>
        <script src="{!! asset('public/admin/bower_components/bootstrap-daterangepicker/daterangepicker.js')!!}"></script>

        <!-- Switchery -->
        <script src="{!! asset('public/admin/bower_components/switchery/dist/switchery.min.js')!!}"></script>

        <!-- Autosize -->
        <script src="{!! asset('public/admin/bower_components/autosize/dist/autosize.min.js')!!}"></script>

        <!-- Jquery confirm -->
        <script src="{!! asset('public/admin/bower_components/jquery-confirm2/js/jquery-confirm.js')!!}"></script>
        

        @yield('footer_js')
        @stack('scripts')

        <!-- PNotify -->
        <script type="text/javascript" src="{!! asset('public/admin/node_modules/pnotify/src/pnotify.js') !!}"></script>
        <link href="{!! asset('public/admin/node_modules/pnotify/src/pnotify.css') !!}" rel="stylesheet" type="text/css" />
        <link href="{!! asset('public/admin/node_modules/pnotify/src/pnotify.brighttheme.css') !!}" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="{!!asset('public/admin/node_modules/pnotify/src/pnotify.animate.js') !!}"></script>
        <script type="text/javascript" src="{!!asset('public/admin/node_modules/pnotify/src/pnotify.buttons.js') !!}"></script>
        <link href="{!! asset('public/admin/node_modules/pnotify/src/pnotify.buttons.css') !!}" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="{!!asset('public/admin/node_modules/pnotify/src/pnotify.confirm.js')!!}"></script>
        <link href="{!!asset('public/admin/node_modules/pnotify/src/pnotify.nonblock.css')!!}" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="{!!asset('public/admin/node_modules/pnotify/src/pnotify.nonblock.js')!!}"></script>
        <script type="text/javascript" src="{!!asset('public/admin/node_modules/pnotify/src/pnotify.mobile.js')!!}"></script>
        <link href="{!!asset('public/admin/node_modules/pnotify/src/pnotify.mobile.css')!!}" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="{!!asset('public/admin/node_modules/pnotify/src/pnotify.desktop.js')!!}"></script>
        <script type="text/javascript" src="{!!asset('public/admin/node_modules/pnotify/src/pnotify.history.js')!!}"></script>
        <link href="{!!asset('public/admin/node_modules/pnotify/src/pnotify.history.css')!!}" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="{!!asset('public/admin/node_modules/pnotify/src/pnotify.callbacks.js')!!}"></script>
        <script type="text/javascript" src="{!!asset('public/admin/node_modules/pnotify/src/pnotify.reference.js')!!}"></script>

        @include('admin.layouts.notification')

        <script>
            $(document).ready(function(){
            $('.jquery-drp').daterangepicker();
            });
        </script>

        <!-- Custom Theme Scripts -->
        <script src="{{asset('public/admin/build_/js/custom.js')}}"></script>
        <script>
            $(document).ready(function(){
                $('.jquery-icheck').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%'
                });
            });
        </script>
    </body>
</html>