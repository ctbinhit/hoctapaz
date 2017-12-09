@extends('admin.layouts.master')

@push('scripts')
<!--<script async defer 
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_BQq_ctdaxlP2MY1Jr8KbefZRgexcw9E&callback=initMap"></script>-->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_BQq_ctdaxlP2MY1Jr8KbefZRgexcw9E&libraries=places"
defer></script>

<script src="{{asset('public/admin/js/map_single.js')}}"></script>
<script>
    $(document).ready(function () {
        setInfoWindow(
                $('#title').val(),
                $('#description').val()
                );
        initMap(
                $('#pos_latitude').val(),
                $('#pos_longitude').val()
                );

    });
</script>
@endpush



@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-map-marker"></i> Vị trí & bản đồ <small> ( Đơn )</small></h3>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="x_panel">
        <div class="x_content">
            <a href="{{route('admin_index')}}" class="btn btn-app"><i class="fa fa-dashboard"></i> Dashboard</a>
            <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>
            <a href="#" class="btn btn-app"><i class="fa fa-google"></i> Google API</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5">
            <div class="x_panel">
                <div class="x_title">
                    <h3>Thông tin vị trí</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form class="form" action="" method="POST">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{@$map_info->id}}" />
                        <div class="form-group">
                            <label for="title" class="control-label">Tên:</label>
                            <div class="">
                                <input type="text" name="title" id="title" value="{{@$map_info->infowindow_title}}" 
                                       class="form-control" placeholder="Tên doanh nghiệp..." />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="control-label">Mô tả ngắn:</label>
                            <div>
                                <input type="text" name="description" id="description" value="{{@$map_info->infowindow_description}}" 
                                       class="form-control" placeholder="Mô tả ngắn..." />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address" class="control-label">Địa chỉ:</label>
                            <div>
                                <input type="text" name="address" id="address" value="{{@$map_info->address_formated}}"
                                       class="form-control" placeholder="Địa chỉ doanh nghiệp" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="pos_latitude" class="control-label">Latitude:</label>
                            <div>
                                <input type="text" name="pos_latitude" id="pos_latitude" value="{{@$map_info->latitude}}"
                                       class="form-control" placeholder="Tọa độ latitude" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="pos_longitude" class="control-label">Longitude:</label>
                            <div>
                                <input type="text" name="pos_longitude" id="pos_longitude" value="{{@$map_info->longitude}}"
                                       class="form-control" placeholder="Tọa độ longitude" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="marker_image" class="control-label">Hình marker:</label>
                            <div>
                                <input type="text" name="marker_image" id="marker_image" value="{{@$map_info->marker_image}}"
                                       class="form-control" placeholder="Hình marker" />
                            </div>
                        </div>

                        <div class="ln_solid"></div>

                        <div class="form-group">
                            <div>
                                <a href="#" class="btn btn-default"><i class="fa fa-laptop"></i> Xem thử</a>
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Lưu</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="x_panel">
                <div class="x_content">
                    <input type="text" name="search-map" id="search-map" 
                           class="form-control" placeholder="Nhập địa chỉ" />
                    <div id="map_preview" style="width: 100%;height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection