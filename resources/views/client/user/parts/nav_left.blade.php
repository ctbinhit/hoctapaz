
@push('stylesheet')
<style>
    .stl-nav-left{

    }

    .stl-nav-left .list-group{

    }

    .stl-nav-left .list-group .list-group-item{
        transition: 0.5s ease;
    }
    .stl-nav-left .list-group .list-group-item:hover{
        background: #0066cc;cursor: pointer;
    }
    .stl-nav-left .list-group .list-group-item:hover a{
        color: #FFF;
    }

    .stl-nav-left a{
        color: #333;text-decoration: none;

    }


</style>
@endpush
<div class="row stl-nav-left">
    <div class="col-md-12">
        <a href="#" class="thumbnail">
            <img alt="100%x180" style="border-radius: 50%;width: 100%;" data-src="holder.js/100%x180" style="height: 180px; width: 100%; display: block;" 
                 src="{{UserService::photo_url()}}" data-holder-rendered="true"> </a>
    </div>
    <div class="col-md-12">
        <h1 class="personal-name">{{UserService::fullname()}}</h1>
    </div>
    <div class="col-md-12">
        <ul class="list-group">
            <li class="list-group-item"><a href="{{route('client_user_info')}}"><i class="fa fa-home"></i> Thông tin cá nhân</a></li>
            <li class="list-group-item"><a href="{{route('client_user_friends')}}"><i class="fa fa-users"></i> Bạn bè</a></li>
            <li class="list-group-item"><a href="{{route('client_user_friends')}}"><i class="fa fa-envelope"></i> Mail <span class="badge">11</span></a></li>
            <li class="list-group-item"><a href="{{route('client_user_tailieudamua')}}"><i class="fa fa-file"></i> Tài liệu đã mua</a></li>
            <li class="list-group-item"><a href="#" data-href="{{route('client_user_ketquathi')}}"><i class="fa fa-graduation-cap"></i> Kết quả thi</a></li>
            <li class="list-group-item"><a href="{{route('client_user_lichsugiaodich')}}"><i class="fa fa-money"></i> Lịch sử giao dịch</a></li>
            <li class="list-group-item"><a href="{{route('client_user_caidat')}}"><i class="fa fa-gear"></i> Cài đặt</a></li>
            <li class="list-group-item"><a href="{{route('client_login_destroy')}}"><i class="fa fa-sign-out"></i> Đăng xuất</a></li>
        </ul>
    </div>
</div>