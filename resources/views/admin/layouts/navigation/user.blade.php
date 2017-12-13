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
                <li><a href="{{route('admin_newsleeter_index','tro-thanh-doi-tac')}}">{{__('label.danhsachdangky')}}</a></li>

            </ul>
        </li>
        <li><a href="{{route('mdle_uservip_index')}}"><i class="fa fa-star"></i> User VIP</a></li>
        <li><a href="{{route('mdle_ug_index')}}"><i class="fa fa-users"></i> Nhóm & Phân quyền</a></li>
    </ul>

</div>