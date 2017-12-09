<script src="{{asset('public/client/plugins/jssor/jssor.slider-25.0.7.min.js')}}"></script>
<script>
    jssor_1_slider_init = function () {
        var jssor_1_SlideshowTransitions = [
            {$Duration: 1200, x: 0.2, y: -0.1, $Delay: 20, $Cols: 8, $Rows: 4, $Clip: 15, $During: {$Left: [0.3, 0.7], $Top: [0.3, 0.7]}, $Formation: $JssorSlideshowFormations$.$FormationStraightStairs, $Assembly: 260, $Easing: {$Left: $Jease$.$InWave, $Top: $Jease$.$InWave, $Clip: $Jease$.$OutQuad}, $Outside: true, $Round: {$Left: 1.3, $Top: 2.5}},
            {$Duration: 1500, x: 0.3, y: -0.3, $Delay: 20, $Cols: 8, $Rows: 4, $Clip: 15, $During: {$Left: [0.1, 0.9], $Top: [0.1, 0.9]}, $SlideOut: true, $Formation: $JssorSlideshowFormations$.$FormationStraightStairs, $Assembly: 260, $Easing: {$Left: $Jease$.$InJump, $Top: $Jease$.$InJump, $Clip: $Jease$.$OutQuad}, $Outside: true, $Round: {$Left: 0.8, $Top: 2.5}},
            {$Duration: 1500, x: 0.2, y: -0.1, $Delay: 20, $Cols: 8, $Rows: 4, $Clip: 15, $During: {$Left: [0.3, 0.7], $Top: [0.3, 0.7]}, $Formation: $JssorSlideshowFormations$.$FormationStraightStairs, $Assembly: 260, $Easing: {$Left: $Jease$.$InWave, $Top: $Jease$.$InWave, $Clip: $Jease$.$OutQuad}, $Outside: true, $Round: {$Left: 0.8, $Top: 2.5}},
            {$Duration: 1500, x: 0.3, y: -0.3, $Delay: 80, $Cols: 8, $Rows: 4, $Clip: 15, $During: {$Left: [0.3, 0.7], $Top: [0.3, 0.7]}, $Easing: {$Left: $Jease$.$InJump, $Top: $Jease$.$InJump, $Clip: $Jease$.$OutQuad}, $Outside: true, $Round: {$Left: 0.8, $Top: 2.5}},
            {$Duration: 1800, x: 1, y: 0.2, $Delay: 30, $Cols: 10, $Rows: 5, $Clip: 15, $During: {$Left: [0.3, 0.7], $Top: [0.3, 0.7]}, $SlideOut: true, $Reverse: true, $Formation: $JssorSlideshowFormations$.$FormationStraightStairs, $Assembly: 2050, $Easing: {$Left: $Jease$.$InOutSine, $Top: $Jease$.$OutWave, $Clip: $Jease$.$InOutQuad}, $Outside: true, $Round: {$Top: 1.3}},
            {$Duration: 1000, $Delay: 30, $Cols: 8, $Rows: 4, $Clip: 15, $SlideOut: true, $Formation: $JssorSlideshowFormations$.$FormationStraightStairs, $Assembly: 2049, $Easing: $Jease$.$OutQuad},
            {$Duration: 1000, $Delay: 80, $Cols: 8, $Rows: 4, $Clip: 15, $SlideOut: true, $Easing: $Jease$.$OutQuad},
            {$Duration: 1000, y: -1, $Cols: 12, $Formation: $JssorSlideshowFormations$.$FormationStraight, $ChessMode: {$Column: 12}},
            {$Duration: 1000, x: -0.2, $Delay: 40, $Cols: 12, $SlideOut: true, $Formation: $JssorSlideshowFormations$.$FormationStraight, $Assembly: 260, $Easing: {$Left: $Jease$.$InOutExpo, $Opacity: $Jease$.$InOutQuad}, $Opacity: 2, $Outside: true, $Round: {$Top: 0.5}},
            {$Duration: 2000, y: -1, $Delay: 60, $Cols: 15, $SlideOut: true, $Formation: $JssorSlideshowFormations$.$FormationStraight, $Easing: $Jease$.$OutJump, $Round: {$Top: 1.5}}
        ];
        var jssor_1_options = {
            $AutoPlay: 1,
            $SlideshowOptions: {
                $Class: $JssorSlideshowRunner$,
                $Transitions: jssor_1_SlideshowTransitions,
                $TransitionsOrder: 1
            },
            $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$
            },
            $BulletNavigatorOptions: {
                $Class: $JssorBulletNavigator$
            }
        };
        var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);
        /*#region responsive code begin*/
        /*remove responsive code if you don't want the slider scales while window resizing*/
        function ScaleSlider() {
            var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
            if (refSize) {
                refSize = Math.min(refSize, 1920);
                jssor_1_slider.$ScaleWidth(refSize);
            } else {
                window.setTimeout(ScaleSlider, 30);
            }
        }
        ScaleSlider();
        $Jssor$.$AddEvent(window, "load", ScaleSlider);
        $Jssor$.$AddEvent(window, "resize", ScaleSlider);
        $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
        /*#endregion responsive code end*/
    };
</script>
<script>
    $(document).ready(function () {
        jssor_1_slider_init();
    });
</script>
<style>
    /* jssor slider loading skin double-tail-spin css */
    .jssorl-004-double-tail-spin img {
        animation-name: jssorl-004-double-tail-spin;
        animation-duration: 1.2s;
        animation-iteration-count: infinite;
        animation-timing-function: linear;
    }
    @keyframes jssorl-004-double-tail-spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
    .jssorb053 .i {position:absolute;cursor:pointer;}
    .jssorb053 .i .b {fill:#fff;fill-opacity:0.5;stroke:#000;stroke-width:400;stroke-miterlimit:10;stroke-opacity:0.5;}
    .jssorb053 .i:hover .b {fill-opacity:.7;}
    .jssorb053 .iav .b {fill-opacity: 1;}
    .jssorb053 .i.idn {opacity:.3;}

    .jssora093 {display:block;position:absolute;cursor:pointer;}
    .jssora093 .c {fill:none;stroke:#fff;stroke-width:400;stroke-miterlimit:10;}
    .jssora093 .a {fill:none;stroke:#fff;stroke-width:400;stroke-miterlimit:10;}
    .jssora093:hover {opacity:.8;}
    .jssora093.jssora093dn {opacity:.6;}
    .jssora093.jssora093ds {opacity:.3;pointer-events:none;}
</style>
<div id="slide">
    <div class="wap-slide">
        <div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:950px;height:440px;overflow:hidden;visibility:hidden;">
            <!-- Loading Screen -->
            <div data-u="loading" class="jssorl-004-double-tail-spin" style="position:absolute;top:0px;left:0px;text-align:center;background-color:rgba(0,0,0,0.7);">
                <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="{{asset('public/client/imgs/double-tail-spin.svg')}}" />
            </div>
            <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:950px;height:440px;overflow:hidden;">
                @foreach($slide_top as $k=>$v)
                <div>
                    <img data-u="image" src="{{Storage::disk('localhost')->url($v->url)}}" />
                </div>
                @endforeach
<!--

                <div>
                    <img data-u="image" src="public/client_assets/images/slide2.png" />
                </div>
                <div>
                    <img data-u="image" src="public/client_assets/images/slide3.png" />
                </div>-->
                <a data-u="any" href="https://www.jssor.com" style="display:none">image gallery</a>
            </div>
            <!-- Bullet Navigator -->
            <div data-u="navigator" class="jssorb053" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
                <div data-u="prototype" class="i" style="width:16px;height:16px;">
                    <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                    <path class="b" d="M11400,13800H4600c-1320,0-2400-1080-2400-2400V4600c0-1320,1080-2400,2400-2400h6800 c1320,0,2400,1080,2400,2400v6800C13800,12720,12720,13800,11400,13800z"></path>
                    </svg>
                </div>
            </div>
            <!-- Arrow Navigator -->
            <div data-u="arrowleft" class="jssora093" style="width:50px;height:50px;top:0px;left:30px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
                <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                <circle class="c" cx="8000" cy="8000" r="5920"></circle>
                <polyline class="a" points="7777.8,6080 5857.8,8000 7777.8,9920 "></polyline>
                <line class="a" x1="10142.2" y1="8000" x2="5857.8" y2="8000"></line>
                </svg>
            </div>
            <div data-u="arrowright" class="jssora093" style="width:50px;height:50px;top:0px;right:30px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
                <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                <circle class="c" cx="8000" cy="8000" r="5920"></circle>
                <polyline class="a" points="8222.2,6080 10142.2,8000 8222.2,9920 "></polyline>
                <line class="a" x1="5857.8" y1="8000" x2="10142.2" y2="8000"></line>
                </svg>
            </div>
        </div>
    </div>
    <div class="banner-right">
        <div class=title-slide">
            <ul class="tabs">
                <li class="tab-link current" data-tab="tab-1">TIN MỚI NHẤT</li>
                <li class="tab-link" data-tab="tab-2">SẢN PHẨM MỚI</li>
            </ul>   
        </div>
        <div id="tab-1" class="tab-content current">
            @foreach($db_tintucmoinhat as $k=>$news)
            <li>
                <a href="{{route('client_news_detail',$news->name_meta)}}" title="{{$news->seo_description}}">
                    <img title="{{$news->seo_description}}" src="{{html_thumbnail(@$news->data_photo->url_encode,70,60)}}" width="70px" height="60px"/>
                </a>
                <h3><a href="{{route('client_news_detail',$news->name_meta)}}" title="{{$news->seo_description}}">{{str_limit($news->description,80)}}...</a></h3>
            </li>
            <div class="clearfix"></div>
            @endforeach
        </div>
        <div id="tab-2" class="tab-content">
            <li>
                <a href="#">
                    <img src="https://cdn.tgdd.vn/Files/2017/09/26/1024788/vivo-v7plus_800x450.jpg" width="70px" height="60px"/>
                </a>
                <h3><a href="#">Miễn phí gọi nội mạng, free Facebook, và 2GB data 4G chỉ với 59K cho Vinaphone</a></h3>
            </li>
            <li>
                <a href="#">
                    <img src="https://cdn.tgdd.vn/Files/2017/09/26/1024826/20170926_152055_800x450.jpg" width="70px" height="60px"/>
                </a>
                <h3><a href="#">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore...</a></h3>
            </li>
            <li>
                <a href="#">
                    <img src="https://cdn.tgdd.vn/Files/2017/09/26/1024788/vivo-v7plus_800x450.jpg" width="70px" height="60px"/>
                </a>
                <h3><a href="#">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore...</a></h3>
            </li>
            <li>
                <a href="#">
                    <img src="https://cdn.tgdd.vn/Files/2017/09/26/1024826/20170926_152055_800x450.jpg" width="70px" height="60px"/>
                </a>
                <h3><a href="#">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore...</a></h3>
            </li>
            <li>
                <a href="#">
                    <img src="https://cdn.tgdd.vn/Files/2017/09/26/1024788/vivo-v7plus_800x450.jpg" width="70px" height="60px"/>
                </a>
                <h3><a href="#">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore...</a></h3>
            </li>
        </div>
    </div>
</div>
