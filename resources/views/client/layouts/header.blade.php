
<header>
    @isset($pmn_header)
    @if($pmn_header->display)
    <div class="header-top">
        <div class="wap-header">
            <marquee onmouseover="this.stop()" onmouseout="this.start()" scrollamount="{{$pmn_header->scrollamount}}">
                {{$pmn_header->content}}
            </marquee>
        </div>
    </div>
    @endif
    @endisset
    <div id="banner">
        <div class="wap-banner">
            <div class="logo">
                <a href="{{route('client_index')}}"><img src="{{asset('public/client/images/logoza.png')}}" alt="hoctapaz" /></a>
            </div>
            <div class="menu">
                <i class="fa fa-bars"></i>
                <ul>
                    <span class="dot_show_menu"></span>
                    <li><a class="faa-parent animated-hover" href="{{route('client_exam_phongthi')}}"> <i class="fa fa-television faa-horizontal"></i>Phòng thi online</a></li>
                    <li><a class="faa-parent animated-hover" href="{{route('client_exam_tracnghiemtructuyen')}}"> <i class="fa fa-book faa-horizontal"></i>Trắc nghiệm trực tuyến</a></li>
                    <li><a class="faa-parent animated-hover jquery-dangcapnhat" href="#"> <i class="fa fa-file-text-o faa-horizontal"></i></i>Đề thi thử</a></li>
                    <li><a class="faa-parent animated-hover" href="{{route('mdle_client_doc_index','tai-lieu-hoc')}}"> <i class="fa fa-database faa-horizontal"></i></i>Tài liệu học</a></li>
                </ul>
            </div>
            <div class="search">
                <i class="fa fa-search"></i>
            </div>
            <div class="right_banner pull-right">
                <p class="pull-left">
                    <a href="{{route('client_index_articleo','huong-dan-su-dung')}}"><i class="fa fa-dropbox"></i> Hướng dẫn sử dụng</a>
                    <a href="{{route('client_index_articleo','huong-dan-nap-tien')}}"><i class="fa fa-money"></i> Hướng dẫn nạp tiền</a>
                    <a href="{{route('client_partner_index')}}"><i class="fa fa-handshake-o"></i> Trở thành đối tác</a>
                </p>
                <!--Tài khoản-->
                <div class="accout pull-right">
                    @if(UserService::isLoggedIn())
                    <div class="shop">
                        <a href="#"><i class="thumbnail fa fa-bell"></i>
                            <span style="position:relative;left:-8px;top:-15px;" 
                                  class="badge faa-ring animated" id="jquery-notification-badge">0</span></a>
                        <a href="{{route('mdle_cart_index')}}" title="Có {{OrderService::cartCount()}} sản phẩm trong giỏ hàng.">
                            <i class="thumbnail fa fa-shopping-cart"></i>
                            <span style="position:relative;left:-8px;top:-15px;" class="badge"
                                  id="jquery-cart-badge">{{OrderService::cartCount()}}</span></a>
                    </div>
                    <div class="img_logo">  <a href="{{route('client_user_info')}}">
                            <img style="width:32px;height:32px;border-radius:50%;" 
                                 src="{{UserService::photo_thumbnail()}}" />
                        </a>
                    </div>
                    <ul>
                        <li style="width:30px;"><i class="fa fa-angle-down"></i>
                            <ul>
                                <span class="dot_show_menu"></span>
                                <li><a class="faa-parent animated-hover" title="Trang cá nhân" 
                                       href="{{route('client_user_info')}}"><i class="fa fa-info faa-horizontal"></i>   Trang cá nhân</a></li>
                                <li><a class="faa-parent animated-hover" title="Tài khoản" 
                                       href="{{route('client_user_caidat')}}"><i class="fa fa-user faa-horizontal"></i>  Tài khoản</a></li>
                                <li><a class="faa-parent animated-hover" title="Tài khoản" 
                                       href="{{route('client_user_donate')}}"><i class="fa fa-money faa-horizontal"></i>  Nạp tiền</a></li>
                                <li><a class="faa-parent animated-hover" title="Lịch sử" 
                                       href="{{route('client_user_lichsugiaodich')}}"><i class="fa fa-history faa-horizontal"></i>  Lịch sử</a></li>
                                <li><a class="faa-parent animated-hover" title="Thoát" 
                                       href="{{route('client_login_destroy')}}"><i class="fa fa-sign-out fa-fw faa-horizontal"></i> Đăng xuất</a></li>
                            </ul>
                        </li>
                    </ul>
                    @else
                    <p>
                        <a href="{{route('mdle_cart_index')}}" title="Có {{OrderService::cartCount()}} sản phẩm trong giỏ hàng.">
                            <i class="thumbnail fa fa-shopping-cart"></i>
                            <span style="position:relative;left:-8px;top:-15px;" class="badge"
                                  id="jquery-cart-badge">{{OrderService::cartCount()}}</span></a>
                        <a class="faa-parent animated-hover" href="{{route('client_login_signup')}}">
                            <i class="fa fa-pencil-square-o faa-flash"></i> Đăng ký</a> | 
                        <a class="faa-parent animated-hover" href="{{route('client_login_index')}}">
                            <i class="fa fa-sign-in faa-flash"></i> Đăng Nhập</a>
                    </p>
                    @endif
                </div> 
            </div>
        </div>
    </div>
</header>
<div class="conten_search">
    <div class="wap-search">
        <select class="form-control">
            <option value="0">Chọn danh mục</option>
            <option value="1">Danh mục thứ nhất</option>
            <option value="2">Danh mục thứ hai</option>
            <option value="3">Danh mục thứ ba</option>
            <option value="4">Danh mục thứ tư</option>
        </select>
        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Bạn cần tìm gì...">
        <button type="button" class="btn btn-default">Tìm kiếm</button>

    </div>
</div>
