<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{route('admin_index')}}" class="site_title"><i class="icon-toannang"></i> <span>Admin page</span></a>
        </div>
        <div class="clearfix"></div>
        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
<!--                <img src="" alt="..." class="img-circle profile_img">-->
            </div>
            <div class="profile_info">
                <h2>{{ __('default.chao')}} <b>{{ @$current_admin->fullname }}</b></h2>
            </div>
        </div>
        <!-- /menu profile quick info -->
        <br/>
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

            <div class="menu_section">
                <h3>Quản trị</h3>
                <ul class="nav side-menu">
                    <li><a href="{{ route('admin_index')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>

                    @include('admin.layouts.navigation.hoctapaz')


                </ul>
            </div>

            <div class="menu_section">
                <h3>AZ Modules</h3>
                <ul class="nav side-menu">
                    <li><a href="{{route('mdle_admin_collaborator_exchange_index')}}"><i class="fa fa-exchange"></i> Yêu cầu nạp/rút</a></li>
                    <li><a href="{{route('admin_user_index','professor')}}"><i class="fa fa-users"></i> Danh sách đối tác</a></li>
                    @include('admin.layouts.navigation.mail')
                </ul>
            </div>

            @if(Route::has('mdle_ad_bkp_uph'))
            <div class="menu_section">
                <h3>Thu nhập</h3>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-money"></i> Thông kê <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('mdle_ad_bkp_uph')}}">Lịch sử giao dịch</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            @endif



            @include('admin.layouts.navigation.product')

            @include('admin.layouts.navigation.article')

            @include('admin.layouts.navigation.user')

            @include('admin.layouts.navigation.theme')

            @include('admin.layouts.navigation.seo')

            @include('admin.layouts.navigation.setting')

        </div>

        <!--        <div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="Settings">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Lock">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                </div>-->
        <!-- /menu footer buttons -->
    </div>
</div>