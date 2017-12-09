<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-user"></i> {{ @$current_admin->fullname }}
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li>
                            <a href="{{route('admin_me_info')}}">
                                <i class="fa fa-edit pull-right"></i>
                                {{__('default.thongtincanhan')}}</a>
                        </li>
                        <li>
                            <a href="{{route('admin_setting_index')}}">
                                <i class="fa fa-gear pull-right"></i>
                                <span>{{__('default.cauhinh')}}</span>
                            </a>
                        </li>
                        <li><a href="javascript:;">{{ __('default.trogiup')}}
                                <i class="fa fa-support pull-right"></i>
                            </a></li>
                        <li><a href="{{route('admin_logout')}}"><i class="fa fa-sign-out pull-right"></i> {{__('default.dangxuat')}}</a></li>
                    </ul>
                </li>
                
                <li class="">
                    <a target="_blank" href="{{route('client_index')}}" title="Xem trang chủ" class="user-profile dropdown-toggle">
                        <i class="fa fa-laptop"></i> Xem Website
                    </a>
                </li>
                
                <li>
                    <a href="javascript:;">
                        <i class="fa fa-exchange"></i> Log
                    </a>
                </li>

                <li class="dropdown hide">
                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell-o"></i>
                        <span class="badge bg-green">3</span>
                    </a>
                    <ul class="dropdown-menu list-unstyled msg_list">
                        <li>
                            <a href="#">
                                <span class="image"><img src="https://graph.facebook.com/v2.10/1170187313115890/picture?type=normal" alt="Profile Image" /></span>
                                <span>
                                    <span>Hệ thống</span>
                                    <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                    Có một yêu cầu xác nhận bài thi từ <strong>Trần Thị Thủy Tiên</strong>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="image"><img src="https://graph.facebook.com/v2.10/1170187313115890/picture?type=normal" alt="Profile Image" /></span>
                                <span>
                                    <span>Hệ thống</span>
                                    <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                    Có một yêu cầu xác nhận file từ <strong>Trần Thị Thủy Tiên</strong>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="image"><img src="https://graph.facebook.com/v2.10/1170187313115890/picture?type=normal" alt="Profile Image" /></span>
                                <span>
                                    <span>Hệ thống</span>
                                    <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                    Có một yêu cầu xác nhận file từ <strong>Trần Thị Thủy Tiên</strong>
                                </span>
                            </a>
                        </li>
                    </ul>

                </li>

                <li role="presentation" class="dropdown hide">
                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-envelope-o"></i>
                        <span class="badge bg-green">6</span>
                    </a>
                    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                        <li>
                            <a>
<!--                                <span class="image"><img src="#" alt="Profile Image" /></span>-->
                                <span>
                                    <span>John Smith</span>
                                    <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                </span>
                            </a>
                        </li>
                        <li>
                            <a>
                                <span class="image"><img src="#" alt="Profile Image" /></span>
                                <span>
                                    <span>John Smith</span>
                                    <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                </span>
                            </a>
                        </li>
                        <li>
                            <a>
                                <span class="image"><img src="#" alt="Profile Image" /></span>
                                <span>
                                    <span>John Smith</span>
                                    <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                </span>
                            </a>
                        </li>
                        <li>
                            <a>
                                <span class="image"><img src="#" alt="Profile Image" /></span>
                                <span>
                                    <span>John Smith</span>
                                    <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                </span>
                            </a>
                        </li>
                        <li>
                            <div class="text-center">
                                <a>
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>

                <li role="presentation" class="dropdown hide">
                    <a href="javascript:;" title="Tin tức từ Công Ty Toàn Năng" class="dropdown-toggle info-number" 
                       data-toggle="dropdown" aria-expanded="true">
                        <i class="icon-toannang"></i>
                        <span class="badge bg-green">1</span>
                    </a>
                    <ul class="dropdown-menu list-unstyled msg_list" role="menu">
                        <li>
                            <a>
<!--                                <span class="image"><img src="#" alt="Profile Image" /></span>-->
                                <span>
                                    <span>Công Ty Toàn Năng</span>
                                    <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                    Nhân dịp ngày 20-11 giảm giá 10% nâng cấp SSL cho những website có chủ đề về giáo dục, đào tạo 
                                    chi tiết khuyến mãi xin vui lòng truy cập vào link...
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</div>
