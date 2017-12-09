@extends('pi.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-edit"></i> Thông tin cá nhân</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-3">
            @include('pi.info.parts.nav_left')
        </div>
        <div class="col-md-9">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Thông tin cá nhân <small></small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <form action="{{route('_pi_me_detail_save')}}" method="POST" class="form form-horizontal" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="act" value="si" />

                        <div class="form-group">
                            <label for="fullname" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Ảnh đại diện:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="file" name="user_photo" accept="image/*"/> <div class="label label-info">200x200px</div> <br><br>
                                        <input type="radio" name="profile_picture" value="" 
                                               class="jquery-icheck"/> Sử dụng ảnh đã up <br><br>
                                        @if(@$user_info->id_facebook!=null)
                                        <input type="radio" name="profile_picture" value="fb" 
                                               class="jquery-icheck"/> Sử dụng ảnh Facebook 
                                        <img src="{{@$user_info->facebook_avatar}}" style="width:40px;height:40px;border-radius:50%;" /><br><br>
                                        @endif
                                        @if(@$user_info->id_google!=null)
                                        <input type="radio" name="profile_picture" value="gg" class="jquery-icheck" {{@$user_info->avatar=='gg'?'checked':''}}/> Sử dụng ảnh Google
                                        <img src="{{@$user_info->google_avatar}}" style="width:40px;height:40px;border-radius:50%;" /><br><br>
                                        @endif
                                    </div>
                                    <div class="col-md-6">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fullname" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Họ và tên:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                <input type="text" name="fullname" id="fullname" class="form-control"
                                       value="{{@$user_info->fullname}}" placeholder="Họ và tên..." />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Điện thoại:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                <input type="text" name="phone" id="phone" class="form-control"
                                       value="{{@$user_info->phone}}" placeholder="Điện thoại..." />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Email:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                <input type="text" name="email" id="email" class="form-control"
                                       value="{{@$user_info->email}}" placeholder="Email..." />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="gender" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Giới tính:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                <input type="radio" name="gender" id="gender" value="1" class="jquery-icheck" checked/> Nam
                                <input type="radio" name="gender" id="gender" value="0" class="jquery-icheck" {{@$user_info->gender==0?'checked':''}}/> Nữ
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="date_of_birth" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Ngày sinh:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 input-group date" id="datetimepicker1">
                                <input type="text" name="date_of_birth" class="form-control"
                                       value="{{@$user_info->date_of_birth}}" placeholder="Ngày sinh..." />
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="id_card" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">CMND:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                <input type="text" name="id_card" id="id_card" class="form-control"
                                        value="{{@$user_info->id_card}}" placeholder="CMND..." />
                            </div>
                        </div>

                        <div class="ln_solid"></div>

                        <div class="form-group">
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 col-lg-offset-2 col-md-offset-2 col-sm-offset-3">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Lưu</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

            <div class="x_panel">
                <div class="x_title">
                    <h2>Vị trí <small> Địa chỉ, nơi sinh sống...</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="" method="POST" class="form form-horizontal">
                        {{csrf_field()}} <input type="hidden" name="act" value="sl" />
                        <div class="form-group">
                            <label for="address" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Địa chỉ:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                <input type="text" name="address" id="address" class="form-control" 
                                       value="{{@$user_info->address}}" placeholder="Địa chỉ..." />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="id_country" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Quốc gia:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                {!!$select_countries!!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="id_city" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Thành phố:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="id_ward" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Phường:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="id_district" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Quận:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">

                            </div>
                        </div>
                        <div class="ln_solid"></div>

                        <div class="form-group">
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 col-lg-offset-2 col-md-offset-2 col-sm-offset-3">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Lưu</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <div class="x_panel">
                <div class="x_title">
                    <h2>Tài khoản <small> Thông tin tài khoản MXH, số dư...</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="" method="POST" class="form form-horizontal">
                        <div class="form-group">
                            <label for="coin" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Số dư:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 input-group">
                                <input type="text" name="coin" id="coin" class="form-control" value="{{number_format(@$user_info->coin,0)}}" disabled=""/>
                                <span class="input-group-addon">
                                    <i class="fa fa-money"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="coin" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Google:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 input-group">
                                @if(@$user_info->id_facebook!=null)
                                <input type="text" name="facebook" id="facebook" class="form-control" value="{{@$user_info->id_facebook}}" disabled=""/>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-success"><i class="fa fa-google"></i> Đã kết nối</button>
                                </span>
                                @else
                                <input type="text" name="facebook" id="facebook" class="form-control" value="Chưa kết nối." disabled=""/>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default"><i class="fa fa-google"></i></button>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="facebook" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Facebook:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 input-group">
                                <input type="text" name="facebook" id="facebook" class="form-control" value="Chưa kết nối." disabled=""/>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default"><i class="fa fa-facebook"></i></button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('stylesheet')
<style>
    .input-group{padding-left: 10px !important;}
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function () {
        $('#datetimepicker1').datetimepicker({
            locale: 'vi',
            format: 'YYYY/MM/DD'
        });
    });
</script>
@endpush
