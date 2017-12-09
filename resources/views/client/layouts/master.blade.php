<!DOCTYPE html>
<html lang="vi">
    <head>
        <title>{{@$seo_title}}</title>
        <meta charset="UTF-8">
        <meta http-equiv="CACHE-CONTROL" CONTENT="NO-CACHE">
        <meta http-equiv="PRAGMA" CONTENT="NO-CACHE">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <!-- Open Graph data -->
        <meta property="og:title" content="{!!@$seo_title!!}" >
        <meta property="og:type" content="{{isset($seo_author)?@$seo_author:'article'}}" >
        <meta property="og:url" content="{{url()->full()}}" >
        <meta property="og:image" content="{{@$seo_image}}" >
        <meta property="og:description" content="{{@$seo_description}}" />
        <meta property="og:site_name" content="{{@$seo_site_name}}" />
        <!--        <meta property="article:published_time" content="{{@$seo_published_time}}" />
                <meta property="article:modified_time" content="{{@$seo_modified_time}}" />-->
        <meta property="article:section" content="{{@$seo_author}}" />
        <meta property="article:tag" content="{{@$seo_keywords}}" />
        <meta property="og:type" content="article">
        <meta property="fb:app_id" content="552682171742827">


        <!--        <meta property="fb:admins" content="{{@$seo_facebook_id}}" />-->
        <!--        <meta property="og:price:amount" content="15.00" />
                <meta property="og:price:currency" content="USD" />-->

        <!-- SEO -->
        <meta name="description" content="{{@$seo_description}}">
        <meta name="keywords" content="{{@$seo_keywords}}">
        <meta name="language" content="{{isset($seo_language)?$seo_language:'vi'}}" />
        <meta http-equiv="content-language" content="{{isset($seo_content_language)?$seo_content_language:'vi,en'}}">
        <meta name='revisit-after' content='1 days' />
        <base href="{{env('APP_URL')}}" />
        <meta name="theme-color" content="#d96565">

        <!-- Dublin Core -->
        <link rel="schema.DC" href="https://purl.org/dc/elements/1.1/" />
        <meta name="DC.title" content="{{@$seo_title}}" />
        <meta name="DC.identifier" content="{{env('APP_URL')}}" />
        <meta name="DC.description" content="{{@$seo_description}}" />
        <meta name="DC.subject" content="{{@$seo_title}}" />
        <meta name="DC.language" scheme="UTF-8" content="{{isset($seo_content_language)?@$seo_content_language:'vi,en'}}" />

        <!-- Geo -->
        <!--<meta name="geo.region" content="VN" />
        <meta name="geo.position" content="">
        <meta name="geo.placename" content="">-->
        <meta name="author" content="{{@$seo_author}}">
        <meta name="copyright" content="{{@$seo_copyright}}" />
        <!--<meta name="ICBM" content="">-->

        <!-- VIEWPORT --> 
        <meta name="viewport" content="width=device-width, initial-scale=1">



        <!-- LARAVEL TOKEN -->
        <meta name="csrf-token" content="{{ csrf_token() }}">



        <!-- FAVICON -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{@Storage::disk('localhost')->url('favicon/apple-touch-icon.png')}}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{@Storage::disk('localhost')->url('favicon/favicon-32x32.png')}}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{@Storage::disk('localhost')->url('favicon/favicon-16x16.png')}}">
        <link rel="manifest" href="{{@Storage::disk('localhost')->url('favicon/manifest.json')}}">
        <link rel="mask-icon" href="{{@Storage::disk('localhost')->url('favicon/safari-pinned-tab.svg')}}" color="#5bbad5">

        <link href="{{public_bower('bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet" />
        <link href="{{public_bower('font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" />
        <link href="{{public_bower('font-awesome-animation/dist/font-awesome-animation.min.css')}}" rel="stylesheet" />
        <link href="{{public_bower('paymentfont/css/paymentfont.min.css')}}" rel="stylesheet" />

        <link href="{{public_bower('wow/css/libs/animate.css')}}" rel="stylesheet" />

        <link href="{{public_bower('slick-carousel/slick/slick.css')}}" rel="stylesheet" />
        <link href="{{public_bower('slick-carousel/slick/slick-theme.css')}}" rel="stylesheet" />

        <!-- Jquery Confirm -->
        <link href="{{asset('public/bower_components/jquery-confirm2/dist/jquery-confirm.min.css')}}" rel="stylesheet" />

        <!-- Style sheet -->
        <link href="{{asset('public/client/fonts/fonts.min.css')}}" rel="stylesheet" />
        <link href="{{asset('public/client/css_/style.css')}}" rel="stylesheet" />
        <link href="{{asset('public/client/css/theme.min.css')}}" rel="stylesheet" />
        <link href="{{asset('public/client/css/article.min.css')}}" rel="stylesheet" />

        <!-- Object animation -->
        <link href="{{asset('public/client/css_/object-animated.min.css')}}" rel="stylesheet" />
        @stack('stylesheet')

        <!-- JQUERY -->
        <script src="{{public_bower('jquery/dist/jquery.min.js')}}"></script>
        <script>$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});</script>
<!--        <script src="{{asset('public/client_assets/assets/jquery-migrate-3.0.0.js')}}"></script>-->
        <script src="{{asset('public/js/jquery.pjax.min.js')}}"></script>
        <script src="{{asset('public/js/jquery.pjax.init.js')}}"></script>

        <!-- PUSHER -->
<!--        <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
        <script src="{{asset('public/client/js/pusher_init.js')}}"></script>-->

        <!-- Global Site Tag (gtag.js) - Google Analytics -->
<!--        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-106134606-1"></script>-->
        <script>
//            window.dataLayer = window.dataLayer || [];
//            function gtag() {
//            dataLayer.push(arguments);
//            }
//            ;
//            gtag('js', new Date());
//            gtag('config', 'UA-106134606-1');
        </script>



    </head>
    <body id="body">
        @include('client.components.chat.chat')
        @include('client.components.facebook.facebook')

        <div id="page" class="page">

            @include('client.layouts.header')

            <!-- SECTION CONTENT -->
            <section id="jquery-pjax-content" class="container-fluid">
                @stack('scss')
                @yield('content')
                @stack('sscr')
            </section>

            <!-- END SECTION CONTENT -->
            @include('client.layouts.footer')

            <!-- Javascript libraries -->
            @stack('scripts')
            @include('client.bootstrap')
        </div>

        <!-- Bootstrap -->
        <script src="{{public_bower('bootstrap/dist/js/bootstrap.min.js')}}"></script>
        
        <!-- SLICK -->
        <script src="{{public_bower('slick-carousel/slick/slick.min.js')}}"></script>

        <!-- Jquery confirm -->
        <script type="text/javascript" src="{{public_bower('jquery-confirm2/dist/jquery-confirm.min.js')}}"></script>
        <script>
            function jquery_confirm_options(options){
            return $.extend({
            icon: 'fa fa-warning', animation: 'RotateY', closeAnimation: 'RotateY', animationBounce: 0,
                    theme: 'material', type: 'blue', animationSpeed: 500, backgroundDismiss: false
            }, options);
            }
            function jquery_alert_options(options){
            return $.extend({
            icon: 'fa fa-warning', animation: 'RotateY', closeAnimation: 'RotateY', animationBounce: 0,
                    theme: 'material', type: 'blue', animationSpeed: 400, backgroundDismiss: false
            }, options);
            }
        </script>

        <!-- Jquery mmenu -->

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

        <script>
//            PNotify.desktop.permission();
//            (new PNotify({
//            title: 'Website học tập trực tuyến AZ',
//                    text: 'Chào mừng bạn đến với website học tập AZ.',
//                    type: 'success',
//                    styling: 'bootstrap3'
//            })).get().click(function(e) {
//            if ($('.ui-pnotify-closer, .ui-pnotify-sticker, .ui-pnotify-closer *, .ui-pnotify-sticker *').is(e.target)) return;
//                
//                
//                
//            });
        </script>
        @include('client.components.notification.notification')
    </body>
</html>
