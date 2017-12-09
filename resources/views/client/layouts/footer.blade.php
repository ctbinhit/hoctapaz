<footer style="{!! $bg_footer !!}">

    <div class="wap-footer">
        <div class="thongtin">
            <a cl href="index.php"><img src="{{asset('public/client/images/logo.png')}}" alt="hoctapaz" /></a>
            <div class="noidung">
                <p>Tên công ty: {{@$website_info->seo_title}}</p>
                <p>Địa chỉ: {{@$website_info->address}}</p>
                <p>Email: {{@$website_info->email}}</p>
                <p>Phone: {{@$website_info->hotline}}</p>
            </div>
            <i class="pf pf-visa"></i>
            <i class="pf pf-mastercard"></i>
            <i class="pf pf-paypal"></i>
            <i class="pf pf-jcb"></i>
        </div>
        <div class="khachhang">
            <div class="title-kh">Khách hàng</div>

            <a href="#"><i class="fa fa-angle-right"></i>Tài khoản</a>
            <a href="#"><i class="fa fa-angle-right"></i>Khuyến mãi</a>
            <a href="{{route('client_index_articleo','dieu-khoan-chinh-sach')}}"><i class="fa fa-angle-right"></i>Điều khoản & chính sách</a>
            <a href="#"><i class="fa fa-angle-right"></i>Tài liệu học</a>
        </div>
        <div class="khachhang">
            <div class="title-kh">Hỗ trợ khách hàng</div>
            <a href="{{route('client_index_articleo','gioi-thieu')}}"><i class="fa fa-angle-right"></i>Giới thiệu</a>
            <a href="{{route('client_index_articleo','lien-he')}}"><i class="fa fa-angle-right"></i>Liên hệ</a>
            <a href="{{route('client_index_articleo','huong-dan-thanh-toan')}}"><i class="fa fa-angle-right"></i>Hướng dẫn thanh toán</a>
            <a href="{{route('client_index_articleo','huong-dan-mua-hang')}}"><i class="fa fa-angle-right"></i>Hướng dẫn mua hàng</a>
            <a href="{{route('client_index_articleo','faq')}}"><i class="fa fa-angle-right"></i>FAQ</a>
        </div>
        <div class="fanpage">
            <div class="title-kh">Like nhận ưu đãi mới</div>
<!--            <div class="fb-page" data-href="https://www.facebook.com/tokhongphaidangvuadau/" data-tabs="timeline" 
                 data-height="163" data-small-header="true" data-adapt-container-width="true" data-hide-cover="true" 
                 data-show-facepile="true"><blockquote cite="https://www.facebook.com/facebook" class="fb-xfbml-parse-ignore">
                    <a href="https://www.facebook.com/tokhongphaidangvuadau/">Facebook</a></blockquote></div>-->
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 tn-footer-copyright">
                {{@$TNSITE->copyright}}
            </div>
        </div>
    </div>
  

    
    @include('client.layouts.js')
</footer>