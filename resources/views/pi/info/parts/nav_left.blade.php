
<div class="x_panel">

    <div class="x_content">
        <div>
            <img class="thumbnail" style="width:200px;height:200px;margin:0 auto;border-radius:50%;" src="{{UserService::photo_thumbnail()}}" />
        </div>
        <h2 class="text-center">{{$current_user->display_name}}</h2>

        <ul class="list-unstyled user_data">
            <li><i class="fa fa-map-marker user-profile-icon"></i>
            </li>

            <li>
                <i class="fa fa-briefcase user-profile-icon"></i> 
            </li>

            <li class="m-top-xs">
                <i class="fa fa-external-link user-profile-icon"></i>
            </li>
        </ul>

        <ul class="list-group">
            <li class="list-group-item"><a href="{{route('pi_me_detail')}}"><i class="fa fa-user"></i> Thông tin cá nhân</a></li>
            <li class="list-group-item"><a href="{{route('pi_me_transaction')}}"><i class="fa fa-money"></i> Lịch sử giao dịch</a></li>
            <li class="list-group-item"><a href="{{route('pi_me_friends')}}"><i class="fa fa-users"></i> Bạn bè</a></li>
            <li class="list-group-item"><a href="{{route('pi_me_security')}}"><i class="fa fa-shield"></i> Bảo mật</a></li>
            <li class="list-group-item"><a href="{{route('pi_me_setting')}}"><i class="fa fa-gear"></i> Cài đặt</a></li>
        </ul>
    </div>
</div>

