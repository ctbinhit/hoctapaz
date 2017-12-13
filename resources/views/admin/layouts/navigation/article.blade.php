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