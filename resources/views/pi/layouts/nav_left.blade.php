<!--
/* ========================================= TOANNANG Co., Ltd =========================================================
  | Developed by Bình Cao | Phone: (+84) 964 247 742
  | Email: ctbinhit@gmail.com or binhcao.toannang@gmail.com
  | --------------------------------------------------------------------------------------------------------------------
  | ====================================================================================================================
 */
-->

<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{route('pi_index_index')}}" class="site_title"><i class="fa icon-tnco"></i> <span>Toàn Năng</span></a>
        </div>
        <div class="clearfix"></div>
        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
<!--                <img src="" alt="..." class="img-circle profile_img">-->
            </div>
            <div class="profile_info">
                <span>{{ __('default.chao')}}, </span>
                <h2>{{ @$user_info->fullname }}</h2>
            </div>
        </div>
        <!-- /menu profile quick info -->
        <br />
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

            <div class="menu_section">
                <h3>Quản trị</h3>
                <ul class="nav side-menu">
                    <li><a href="{{ route('pi_index_index')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li><a href="{{route('mdle_pi_collaborator_exchange_index')}}"><i class="fa fa-money"></i> Nạp & Rút</a></li>
                    @if(Route::has('mdle_oc_pi_exam_index'))
                    <li><a><i class="fa fa-check-square-o"></i> Trắc nghiệm (Beta)<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('mdle_oc_pi_exam_index')}}" title="Quản lý bài thi"> Phòng thi</a></li>
                        </ul>
                    </li>
                    @endif
                    <li class="hidden"><a><i class="fa fa-book"></i> {{__('schools.khoahoc')}} (Beta)<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('mdle_oc_index')}}">{{__('schools.quanlykhoahoc')}}</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-file-word-o"></i> Tài liệu<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('mdle_pi_doc_approved','tai-lieu-hoc')}}"> Tài liệu đang bán</a></li>
                            <li><a href="{{route('mdle_pi_doc_index','tai-lieu-hoc')}}"> Tài liệu tải lên</a></li>
                            <li><a href="#"> Tài liệu đã xóa</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-file-word-o"></i> Đề thi thử<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('mdle_pi_doc_index','de-thi-thu')}}"> Tài liệu tải lên</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <div class="sidebar-footer hidden-small">
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
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>