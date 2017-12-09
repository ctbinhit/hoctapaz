

@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Thêm {{ @$title }}</h3>
        </div>

        <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12">
        @if(Session::has('message'))
        <div class="alert {{Session::get('message_type','alert-info')}} alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Thông báo: </strong>  {{@Session::get('message')}}
        </div>
        @endif
    </div>
    <form class="form-horizontal form-label-left" action="{{route('admin_setting_language_save')}}" method="POST">
        <div class="col-md-9 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Thông tin chung <small>ToanNang Co., Ltd</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#"><i class="fa fa-save"></i> Lưu</a>
                                </li>
                                <li><a href="#"><i class="fa fa-recycle"></i> Khôi phục cài đặt gốc</a>
                                </li>
                            </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ @$item['id'] }}" />
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Tên ngôn ngữ</label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
<!--                            <input type="text" class="form-control" name="ten" placeholder="Tên ngôn ngữ">-->
                            <select class="form-control" name="ten">
                                @foreach($lst_country_code as $k=>$v) 
                                <option value="{{ $v->name }}"> {{ $v->name }}
                                    @endforeach 
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Đơn vị tiền tệ</label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <input type="text" class="form-control" name="donvitiente" placeholder="Đơn vị tiền tệ">
                        </div>
                    </div>

<!--                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Mã ngôn ngữ</label>
                        <div class="col-md-10 col-sm-10 col-xs-12">

                        </div>
                    </div>-->
                </div>
            </div>
        </div>

        <div class="col-md-3 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Cài đặt <small>ToanNang Co., Ltd</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Hiển thị</label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <div class="">
                                <label>
                                    <input type="checkbox" class="js-switch" name="display" checked="" data-switchery="true" style="display: none;">
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-3">
                            <button type="button" class="btn btn-primary">Hủy bỏ</button>
                            <!--                            <button type="reset" class="btn btn-primary"></button>-->
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Lưu</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Tọa độ | Vị trí <small>ToanNang Co., Ltd</small></h2>
                    <ul class="nav n                                            avbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#"><i class="fa fa-save"></i> Lưu</a>
                                </li>
                                <li><a href="#"><i class="fa fa-recycle"></i> Khôi phục cài đặt gốc</a>
                                </li>
                            </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tìm địa điểm</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text"  class="form-control" id="autocomplete" placeholder="Enter your address">
                                <span class="input-group-btn">
                                    <button type="button" onclick="fillInAddress()" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-4">
                            <div class="input-group input-group-sm">
                                <label class="input-group-addon" for="dataY">ID</label>
                                <input type="text" class="form-control" id="location_id" placeholder="ID vị trí" disabled="">
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="input-group input-group-sm">
                                <label class="input-group-addon" for="dataY">lng</label>
                                <input type="text" class="form-control" id="location_x" name="toado_x" placeholder="Tọa độ x">
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="input-group input-group-sm">
                                <label class="input-group-addon" for="dataY">lat</label>
                                <input type="text" class="form-control" id="location_y" name="toado_y" placeholder="Tọa độ y">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div id="map" style="width: 100%;height:500px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="clearfix"></div>
</div>
@endsection

@section('header_css')
<!-- iCheck -->
<link href="public/admin_assets/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
<!-- bootstrap-wysiwyg -->
<link href="public/admin_assets/vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
<!-- Select2 -->
<link href="public/admin_assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<!-- Switchery -->
<link href="public/admin_assets/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
<!-- starrr -->
<link href="public/admin_assets/vendors/starrr/dist/starrr.css" rel="stylesheet">
<!-- bootstrap-daterangepicker -->
<link href="public/admin_assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
@endsection

@section('footer_js')
<!-- CK Editor & CK Finder -->
<script src="{!! asset('public/admin_assets/plugins/ckeditor/ckeditor.js') !!}"></script>
<script>
//$(document).ready(function () {
//    var editor = CKEDITOR.replace('mota', {
//        language: 'vi',
//        filebrowserImageBrowseUrl: '',
//        filebrowserFlashBrowseUrl: '',
//        filebrowserImageUploadUrl: '',
//        filebrowserFlashUploadUrl: ''
//    });
//});
</script>
<!-- bootstrap-progressbar -->
<script src="public/admin_assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
<!-- iCheck -->
<script src="public/admin_assets/vendors/iCheck/icheck.min.js"></script>
<!-- bootstrap-wysiwyg -->
<script src="public/admin_assets/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
<script src="public/admin_assets/vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
<script src="public/admin_assets/vendors/google-code-prettify/src/prettify.js"></script>
<!-- jQuery Tags Input -->
<script src="public/admin_assets/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>

<!-- Select2 -->
<script src="public/admin_assets/vendors/select2/dist/js/select2.full.min.js"></script>
<!-- Parsley -->
<script src="public/admin_assets/vendors/parsleyjs/dist/parsley.min.js"></script>
<!-- Autosize -->
<script src="public/admin_assets/vendors/autosize/dist/autosize.min.js"></script>
<!-- jQuery autocomplete -->
<script src="public/admin_assets/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
<!-- starrr -->
<script src="public/admin_assets/vendors/starrr/dist/starrr.js"></script>
<!-- GOOGLE MAP API -->
<script>
                                        var map, marker, placeSearch, autocomplete;

                                        function initMap() {
                                            var uluru = {lat: 10.8513770197085, lng: 106.62518201970852};
                                            map = new google.maps.Map(document.getElementById('map'), {
                                                zoom: 12,
                                                center: uluru
                                            });
                                            marker = new google.maps.Marker({
                                                position: uluru,
                                                map: map
                                            });
                                        }

                                        function initAutocomplete() {
                                            initMap();
                                            // Create the autocomplete object, restricting the search to geographical
                                            // location types.
                                            autocomplete = new google.maps.places.Autocomplete(
                                                    /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
                                                    {types: ['geocode']});

                                            // When the user selects an address from the dropdown, populate the address
                                            // fields in the form.
                                            autocomplete.addListener('place_changed', fillInAddress);
                                        }

                                        function fillInAddress() {
                                            // Get the place details from the autocomplete object.
                                            var place = autocomplete.getPlace();
                                            if (typeof (place) === 'undefined') {
                                                new PNotify({
                                                    title: 'Bản đồ',
                                                    text: 'Không tìm thấy địa chỉ phù hợp.',
                                                    type: 'info',
                                                    styling: 'bootstrap3'
                                                });
                                                $('#autocomplete').val('');
                                                return false;
                                            }

                                            if (!place.geometry) {
                                                new PNotify({
                                                    title: 'Bản đồ',
                                                    text: 'Không tìm thấy địa chỉ phù hợp.',
                                                    type: 'info',
                                                    styling: 'bootstrap3'
                                                });
                                            }
                                            // If the place has a geometry, then present it on a map.
                                            if (place.geometry.viewport) {
                                                map.fitBounds(place.geometry.viewport);
                                            } else {
                                                map.setCenter(place.geometry.location);
                                                map.setZoom(17);  // Why 17? Because it looks good.
                                            }
                                            marker.setPosition(place.geometry.location);
                                            marker.setVisible(true);
                                            $('#location_id').val(place.place_id);
                                            $('#location_x').val(place.geometry.viewport.b.b);
                                            $('#location_y').val(place.geometry.viewport.f.b);
                                        }

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
                                        function geolocate() {
                                            if (navigator.geolocation) {
                                                navigator.geolocation.getCurrentPosition(function (position) {
                                                    var geolocation = {
                                                        lat: position.coords.latitude,
                                                        lng: position.coords.longitude
                                                    };
                                                    var circle = new google.maps.Circle({
                                                        center: geolocation,
                                                        radius: position.coords.accuracy
                                                    });
                                                    autocomplete.setBounds(circle.getBounds());
                                                });
                                            }
                                        }
</script>
<!--<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyArI9DJNvIdPIflWXad12I4gzaEWobozzo&callback=initMap"
type="text/javascript"></script>-->

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyArI9DJNvIdPIflWXad12I4gzaEWobozzo&libraries=places&callback=initAutocomplete"
async defer></script>
@endsection