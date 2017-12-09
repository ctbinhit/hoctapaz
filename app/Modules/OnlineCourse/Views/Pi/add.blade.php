
@extends('pi.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3></h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="x_panel">
        <div class="x_content">
            <a href="{{route('mdle_oc_index')}}" class="btn btn-app"><i class="fa fa-arrow-left"></i> Quay lại</a>
            <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>
        </div>
    </div>

    <div class="x_panel">
        <div class="x_title">
            <h2>Quản lý chương <small></small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <form action="{{route('_mdle_oc_save')}}" method="POST" class="form form-horizontal">
                {{csrf_field()}}
                <input type="hidden" name="id" value="{{@$item->id}}" />
                <div class="form-group">
                    <label class="control-label col-md-3 col-xs-12">Tên khóa học</label>
                    <div class="col-md-9 col-xs-12">
                        <input type="text" class="form-control" name="name" value="{{@$item->name}}" placeholder="Tên khóa học..." />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-xs-12">Danh mục</label>
                    <div class="col-md-9 col-xs-12">
                        <select class="form-control" name="id_category_1" id="jquery-app-category-lv1">
                            <option value="-1">-- Chọn danh mục --</option>
                            @foreach($categories as $k=>$v)
                                <option value="{{$v->id}}">{{$v->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <input type="hidden" id="jquery-data-route-ajax" value="{{route('_admin_ajax')}}" />
                <script>
                    $(document).ready(function(){
                        $('#jquery-app-category-lv1').change(function(){
                            if($(this).val()==-1){
                                $('#jquery-app-category-lv2').html('<option value="-1">-- Chọn danh mục 1 --</option>');
                                $('#jquery-app-category-lv2').attr('disabled','');
                                return;
                            }
                            var request_data = {
                                method: 'ajax_loadCategoriesByParentId',
                                data: {
                                    type: 'hoctap',
                                    lang: 1,
                                    id: $(this).val()
                                }
                            };
                            $.ajax({
                                url: $('#jquery-data-route-ajax').val(),
                                type: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                dataType: 'json',
                                data: request_data,
                                beforeSend: function(){
                                    $('#jquery-app-category-lv2').html('<option>Đang tải...</option>');
                                },
                                success: function (data) {
                                    if(data.status){
                                        
                                        if(data.data.length!=0){
                                            var items = '';
                                            $.each(data.data,function(k,v){
                                                items+= '<option>' + v.name + '</option>';
                                            });
                                            $('#jquery-app-category-lv2').html(items);
                                            $('#jquery-app-category-lv2').removeAttr('disabled');
                                        }else{
                                            $('#jquery-app-category-lv2').html('<option value="-1">-- Không có dữ liệu --</option>');
                                            $('#jquery-app-category-lv2').attr('disabled','');
                                        }
                                    }else{
                                        $('#jquery-app-category-lv2').attr('disabled','');
                                    }
                                }, error: function (data) {
                                    console.log(data);
                                }
                            });
                        });
                    });
                </script>

                <div class="form-group">
                    <label class="control-label col-md-3 col-xs-12">Danh mục cấp 2</label>
                    <div class="col-md-9 col-xs-12">
                        <select class="form-control" name="id_category_2" disabled="" id="jquery-app-category-lv2">
                            <option>-- Chọn danh mục 1 --</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-xs-12">Tên giáo viên</label>
                    <div class="col-md-9 col-xs-12">
                        <input disabled type="text" class="form-control" name="#" value="{{Session::get('user')['fullname']}}" placeholder="Tên gv..." />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-xs-12">URL</label>
                    <div class="col-md-9 col-xs-12 input-group">
                        <span class="input-group-addon">{{env('APP_URL')}}/khoa-hoc/</span>
                        <input type="text" id="jquery-field-nameMeta" class="form-control" name="name_meta" value="{{@$item->name_meta}}" placeholder="Địa chỉ khóa học" />
                        <span class="input-group-btn">
                            <button type="button" id="jquery-btn-check-nameMeta" class="btn btn-default">Check</button>
                        </span>
                    </div>
                    <div class="col-xs-12 col-md-9 col-md-offset-3">
                        <div id="jquery-suggestion-nameMeta" class="suggestion-input">Địa chỉ để mọi người có thể truy cập.</div>
                    </div>
                </div>
                
                <script>
                    $(document).ready(function(){
                        $('#jquery-btn-check-nameMeta').on('click',function(){
                            $(this).attr('disabled','');
                            $(this).html('<i class="fa fa-spinner faa-spin animated"></i>');
                            var this_btn = this;
                            var request_data = {
                                method: 'ajax_checkNameMeta',
                                data: {
                                    tbl: 'm1_courses',
                                    val: $('#jquery-field-nameMeta').val()
                                }
                            };
                            /* =========================================================================================
                             * Created by BÌNH CAO | (+84) 964 247 742 | http://binhcao.com/about-me.html
                             * =========================================================================================
                             */
                            $.ajax({
                                url: $('#jquery-data-route-ajax').val(),
                                type: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                dataType: 'json',
                                data: request_data,
                                beforeSend: function () {
                                    // Before Send
                                },
                                success: function (data) {
                                    console.log(data);
                                    $(this_btn).parents('.form-group').removeClass('has-success has-warning');
                                    if(data.status){
                                        
                                        if(data.result){
                                            $('#jquery-btn-save').removeAttr('disabled');
                                            $(this_btn).parents('.form-group').addClass('has-success');
                                            $('#jquery-suggestion-nameMeta')
                                                    .html('<p class="text-success">Địa chỉ này có thể dùng!</p>');
                                        }else{
                                           $(this_btn).parents('.form-group').addClass('has-warning');
                                            $('#jquery-btn-save').attr('disabled','');
                                            $('#jquery-suggestion-nameMeta')
                                                    .html('<p class="text-danger">Địa chỉ này đã tồn tại trên hệ thống!</p>');
                                        }
                                        
                                    }else{
                                        $(this_btn).parents('.form-group').addClass('has-warning');
                                        $('#jquery-suggestion-nameMeta')
                                                    .html('<p class="text-danger">Vui lòng nhập địa chỉ!</p>');
                                    }
                                    $(this_btn).removeAttr('disabled').html('Kiểm tra');
                                }, 
                                error: function (data) {
                                    //console.log(data);
                                },
                                complete: function(data){
                                    console.log(data);
                                }
                            });
                            // ----- End ajax --------------------------------------------------------------------------
                        });
                    });
                </script>

                <div class="form-group">
                    <label class="control-label col-md-3 col-xs-12">Giá lẻ</label>
                    <div class="col-md-9 col-xs-12">
                        <input type="text" class="form-control" name="distributor_price" value="{{@$item->distributor_price}}" placeholder="Giá" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-xs-12">Giảm giá</label>
                    <div class="col-md-9 col-xs-12">
                        <input type="number" class="form-control" name="promotion_percent" value="{{@$item->promotion_percent}}" placeholder="Phần trăm khuyến mãi, (vd: 10%,20%)" />
                        <div class="suggestion-input">Mặc định là 0</div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-xs-12">Mô tả khóa học</label>
                    <div class="col-md-9 col-xs-12">
                        <textarea class="form-control" name="description">{{@$item->description}}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-xs-12">Nội dung giới thiệu</label>
                    <div class="col-md-9 col-xs-12">
                        <textarea class="form-control" name="introduction_text">{{@$item->introduction_text}}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-xs-12">Nội dung khuyến mãi</label>
                    <div class="col-md-9 col-xs-12">
                        <textarea class="form-control" name="promotion_text">{{@$item->promotion_text}}</textarea>
                    </div>
                </div>

                <div class="form-group fg-ckeditor">
                    <label class="control-label col-md-12 col-xs-12 text-left">Nội dung khóa học</label>
                    <div class="col-md-12 col-xs-12">
                        <textarea rows="50" class="form-control ckeditor-content" id="ckeditor-content" name="content">{{@$item->content}}</textarea>
                    </div>
                </div>

                @php
                $highlight_checked = @$item->highlight?'checked':'';
                @endphp

                <div class="form-group">
                    <label class="control-label col-md-3 col-xs-2">Nổi bật</label>
                    <div class="col-md-9 col-xs-10">
                        <input type="checkbox" name="highlight" {{@$highlight_checked}} class="jquery-icheck" />
                    </div>
                </div>

                @php
                $display_checked = @$item->display?'checked':'';
                @endphp

                <div class="form-group">
                    <label class="control-label col-md-3 col-xs-2">Hiển thị</label>
                    <div class="col-md-9 col-xs-10">
                        <input type="checkbox" name="display" {{@$display_checked}} class="jquery-icheck" />
                    </div>
                </div>

                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-9 col-xs-12 col-md-offset-3">
                        <button id="jquery-btn-save" class="btn btn-success" disabled=""><i class="fa fa-save"></i> Lưu</button>
                    </div>
                </div>

            </form>
        </div>     
    </div>
</div>
@endsection

@push('scripts')

<!-- CK Editor & CK Finder -->
<script src="{!! asset('public/admin/plugins/ckeditor/ckeditor.js') !!}"></script>
<script>
                    $(document).ready(function () {
                    CKEDITOR.config.filebrowserImageUploadUrl = '{!! route("client_ckeditor_upload_image"). '?_token = ' .csrf_token() !!}';
                    CKEDITOR.replace('ckeditor-content', {
                    language: 'vi',
                            uiColor: '#F3F3F3',
                            height: '300px'
                    });
                    });
</script>

@endpush