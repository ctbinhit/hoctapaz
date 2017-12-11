<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{route('admin_index')}}" class="site_title"><i class="icon-toannang"></i> <span>Admin page</span></a>
        </div>
        <div class="clearfix"></div>
        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="{{ UserServiceV2::get_current_avatar(@$current_admin) }}" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <h2>{{ __('default.chao')}} <b>{{ @$current_admin->fullname }}</b></h2>
            </div>
        </div>
        <!-- /menu profile quick info -->
        <br />
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

            <div class="menu_section">
                <h3>Quản trị</h3>
                <ul class="nav side-menu">
                    <li><a href="{{ route('admin_index')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>

                    <li><a><i class="fa fa-puzzle-piece"></i> {{__('label.hoctapaz')}} (Beta)<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('admin_category_index',['exam','hoctap'])}}">Quản lý danh mục</a></li>
                            <li><a href="{{route('admin_examman_approver')}}">Kiểm duyệt khóa học & bài thi</a></li>
                            <li><a href="{{route('mdle_admin_doc_index','tai-lieu-hoc')}}">Tài liệu chờ duyệt</a></li>
                            <li><a href="{{route('mdle_admin_doc_index','de-thi-thu')}}">Đề thi chờ duyệt</a></li>
<!--                            <li><a href="#">Quản lý bảng xếp hạng</a></li>
                            <li><a href="#">Quản lý giáo viên</a></li>
                            <li><a href="#">Quản lý học sinh</a></li>-->
                        </ul>
                    </li>

                    <li><a><i class="fa fa-envelope-square"></i> {{__('label.homthu')}} (Beta)<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="#">Hòm thư người dùng</a></li>
                            <li><a href="#">Hòm thư quản trị</a></li>
                            <li><a href="#">Hòm thư báo lỗi</a></li>
                            <li><a href="#">Hòm thư góp ý</a></li>
                        </ul>
                    </li>
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

            <div class="menu_section">
                <h3>Sản phẩm</h3>
                <ul class="nav side-menu">
                    @if(Route::has('mdle_admin_cart_index'))
                    <li><a><i class="fa fa-shopping-cart"></i> {{__('label.donhang')}} <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('mdle_admin_cart_index')}}">Quản lý đơn hàng</a></li>
                            <li><a href="javascript:;">Bảng giá phí vận chuyển</a></li>
                        </ul>
                    </li>
                    @endif
                    <li><a><i class="fa fa-product-hunt"></i> {{__('label.sanpham')}} <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="javascript:;">Bảng giá sỉ</a></li>
                            <li><a href="{{route('admin_product_index',['sanpham'])}}">{{__('label.quanlydanhsach')}}</a></li>
                            <li><a href="{{route('admin_product_add',['sanpham'])}}">{{__('label.themmoi')}}</a></li>

                        </ul>
                    </li>
                </ul>
            </div>

            <div class="menu_section">
                <h3>Bài viết</h3>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-book"></i> {{__('label.quanlytintuc')}} <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('admin_article_index','tintuc')}}">{{__('label.quanlydanhsach')}}</a></li>
                            <li><a href="{{route('admin_article_add','tintuc')}}">{{__('label.themmoi')}}</a></li>
                        </ul>
                    </li>

                    <li><a><i class="fa fa-book"></i> {{__('label.tuyendung')}} <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('admin_article_index','tuyendung')}}">{{__('label.quanlydanhsach')}}</a></li>
                            <li><a href="{{route('admin_article_add','tuyendung')}}">{{__('label.themmoi')}}</a></li>
                        </ul>
                    </li>

                    <li><a><i class="fa fa-book"></i> Một bài viết <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('admin_articleo_index','gioi-thieu')}}"><i class="fa fa-building"></i> Giới thiệu</a></li>
                            <li><a href="{{route('admin_articleo_index','lien-he')}}"><i class="fa fa-support"></i> Liên hệ</a></li>
                            <li><a href="{{route('admin_articleo_index','huong-dan-su-dung')}}"><i class="fa fa-support"></i> Hướng dẫn sử dụng</a></li>
                            <li><a href="{{route('admin_articleo_index','huong-dan-nap-tien')}}"><i class="fa fa-support"></i> Hướng dẫn nạp tiền</a></li>
                            <li><a href="{{route('admin_articleo_index','faq')}}"><i class="fa fa-comment-o"></i> FAQ (Câu hỏi thường gặp)</a></li>
                            <li><a href="{{route('admin_articleo_index','dieu-khoan-chinh-sach')}}"><i class="fa fa-edit"></i> Điều khoản & chính sách</a></li>
                            <li><a href="{{route('admin_articleo_index','dieu-khoan-dang-ky')}}"><i class="fa fa-edit"></i> Điều khoản đăng ký</a></li>
                            <li><a href="{{route('admin_articleo_index','dieu-khoan-doi-tac')}}"><i class="fa fa-edit"></i> Điều khoản đối tác</a></li>
                            <li><a href="{{route('admin_articleo_index','huong-dan-mua-hang')}}"><i class="fa fa-edit"></i> Hướng dẫn mua hàng</a></li>
                            <li><a href="{{route('admin_articleo_index','huong-dan-thanh-toan')}}"><i class="fa fa-edit"></i> Hướng dẫn thanh toán</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="menu_section">
                <h3>Người dùng</h3>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-users"></i> Quản trị <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('admin_user_index','admin')}}">{{__('label.quanlydanhsach')}}</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-users"></i> User <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('admin_user_index','user')}}">{{__('label.quanlydanhsach')}}</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-users"></i> Đối tác <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('admin_user_index','professor')}}">{{__('label.quanlydanhsach')}}</a></li>
                            <li><a href="{{route('admin_user_index','professor')}}">{{__('label.danhsachdangky')}}</a></li>

                        </ul>
                    </li>
                    <li><a href="{{route('mdle_uservip_index')}}"><i class="fa fa-star"></i> User VIP</a></li>
                    <li><a href="{{route('mdle_ug_index')}}"><i class="fa fa-users"></i> Nhóm & Phân quyền</a></li>
                </ul>

            </div>



            <div class="menu_section">
                <h3>Giao diện</h3>
                <ul class="nav side-menu">
                    @if(Route::has('mdle_pmn_index'))
                    <li><a href="{{route('mdle_pmn_index','header')}}"><i class="fa fa-bell"></i> Thông báo trang</a></li>
                    @endif

                    @if(Route::has('mdle_slider_index'))
                    <li><a href="{{route('mdle_slider_index','slider_top')}}"><i class="fa fa-clone"></i> Slider top</a></li>
                    <li><a href="{{route('mdle_slider_index','slider_content')}}"><i class="fa fa-clone"></i> Slider content</a></li>
                    @endif
                    @if(Route::has('mdle_background_index'))
                    <li><a href="{{route('mdle_background_index','footer')}}"><i class="fa fa-photo"></i> Background footer</a></li>
                    @endif
                </ul>
            </div>

            <div class="menu_section">
                <h3>SEO</h3>
                <ul class="nav side-menu">
                    <li><a href="{{route('mdle_admin_seo_analytics')}}"><i class="fa fa-google"></i> Google Analytics</a></li>
                    <li><a href="{{route('mdle_admin_seo_analytics')}}"><i class="fa fa-facebook"></i> Facebook Analytics</a></li>
                    <li><a href="#"><i class="fa fa-sitemap"></i>{{__('label.taositemap')}}</a></li>
                    <li><a href="{{route('mdle_admin_map')}}"><i class="fa fa-map-marker"></i> Vị trí & bản đồ</a></li>
                </ul>
            </div>

            <div class="menu_section">
                <h3>Hệ thống</h3>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-gears"></i> {{__('label.cauhinh')}} <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('admin_setting_index')}}">{{__('label.cauhinhchung')}}</a></li>
                            <li><a href="{{route('admin_setting_timezone')}}">{{__('label.timezone')}}</a></li>
                            <li><a href="{{route('admin_setting_account')}}">{{__('label.taikhoan')}}</a></li>
                        </ul>
                    </li>
                    <li><a href="{{route('mdle_admin_apm_index')}}"><i class="fa fa-css3"></i> Quản lý tài nguyên</a></li>
                </ul>

            </div>

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