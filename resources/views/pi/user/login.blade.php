<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <base href="{{env('APP_URL')}}/professor">
        <title>Trang Quản trị giáo viên! | </title>

        <!-- Bootstrap -->
        <link href="{!! asset('public/admin/bower_components/bootstrap/dist/css/bootstrap.min.css')!!}" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="{!! asset('public/admin/bower_components/font-awesome/css/font-awesome.min.css')!!}" rel="stylesheet">
        <link href="{!! asset('public/admin/bower_components/font-awesome-animation/dist/font-awesome-animation.min.css')!!}" rel="stylesheet">
        <!-- NProgress -->
        <link href="{!! asset('public/admin/bower_components/nprogress/nprogress.css')!!}" rel="stylesheet">
        
        <!-- Datetime picker -->
        <link href="{!! asset('public/admin/bower_components/bootstrap-daterangepicker/daterangepicker.css')!!}" rel="stylesheet">
        
        <!-- bootstrap-datetimepicker -->
        <link href="{!! asset('public/admin/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')!!}" rel="stylesheet">

        <!-- iCheck -->
        <link href="{!! asset('public/admin/bower_components/iCheck/skins/all.css')!!}" rel="stylesheet">
        
        <!-- Switchery -->
        <link href="{!! asset('public/admin/bower_components/switchery/dist/switchery.min.css')!!}" rel="stylesheet">
        
        <!-- Pnotify -->
        <link href="{!! asset('public/admin/bower_components/pnotify/dist/pnotify.css')!!}" rel="stylesheet">
        

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
    </head>

    <body class="login">
        <div>
            <a class="hiddenanchor" id="signup"></a>
            <a class="hiddenanchor" id="signin"></a>

            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content">
                        <form action="" method="POST" name="frm_dangnhap">
                            {{ csrf_field() }}
                            <h1>Đăng nhập</h1>
                            <div>
                                <input type="text" class="form-control" placeholder="Username" name="username" required="" />
                            </div>
                            <div>
                                <input type="password" class="form-control" placeholder="Password" name="password" required="" />
                            </div>
                            @if(Session::has('noti_html'))
                            <div class="alert alert-{!!Session('noti_html')->type!!}">
                                <p>{{Session('noti_html')->msg}}</p>
                            </div>
                            @endif
                            <div>
                                <!--                                <a class="btn btn-default submit" href="index.html"></a>-->
                                <button type="submit" class="btn btn-primary">{{__('label.dangnhap')}}</button>
                                <a class="reset_pass" href="#">{{__('label.quenmatkhau')}}?</a>
                            </div>

                            <div class="clearfix"></div>

                            <div class="separator">
                                <p class="change_link">New to site?
                                    <a href="#signup" class="to_register"> {{__('label.taotaikhoan')}} </a>
                                </p>

                                <div class="clearfix"></div>
                                <br />

                                <div>
                                    <h1><i class="fa fa-paw"></i> ToanNang Co., Ltd</h1>
                                    <p>©2016 All Rights Reserved. ToanNang Co., Ltd. <br> Privacy and Terms</p>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>

                <div id="register" class="animate form registration_form">
                    <section class="login_content">
                        <form>
                            <h1>Create Account</h1>
                            <div>
                                <input type="text" class="form-control" placeholder="Username" required="" />
                            </div>
                            <div>
                                <input type="email" class="form-control" placeholder="Email" required="" />
                            </div>
                            <div>
                                <input type="password" class="form-control" placeholder="Password" required="" />
                            </div>
                            <div>
                                <a class="btn btn-default submit" href="index.html">Submit</a>
                            </div>

                            <div class="clearfix"></div>

                            <div class="separator">
                                <p class="change_link">Already a member ?
                                    <a href="#signin" class="to_register"> Log in </a>
                                </p>

                                <div class="clearfix"></div>
                                <br />

                                <div>
                                    <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                                    <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </body>
</html>
