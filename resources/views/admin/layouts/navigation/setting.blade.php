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