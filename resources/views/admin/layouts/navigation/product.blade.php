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