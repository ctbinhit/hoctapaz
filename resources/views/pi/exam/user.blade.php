
@extends('pi.layouts.master')

@section('content')

<div class="page-title">
    <div class="title_left">
        <h3>{{__('label.them')}} {{ @$title }}</h3>
    </div>
</div>
<div class="clearfix"></div>
<form class="form-horizontal form-label-left" onsubmit="return;" id="frm_exam_add" action="{{route('pi_exam_save_post')}}" method="POST" enctype="multipart/form-data">
    <div class="row">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ @$item->id }}" />
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{ __('schools.danhsachsinhvien')}} <small> Danh sách học sinh/sinh viên đã thi</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th style="width: 1%">#</th>
                                <th style="width: 35%">{{__('label.ten')}}</th>
                                <th style="width: 10%">{{__('label.hoanthanh')}}</th>
                                <th style="width: 5%">{{__('label.điểm')}}</th>
                                <th style="width: 8%">{{__('label.trangthai')}}</th>
                                <th style="width: 20%">{{__('schools.ngaythi')}}</th>
                                <th style="width: 25%">{{__('label.thaotac')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#</td>
                                <td><a>Lê Hoàng Nam</a></td>
                                <td>45/50</td>
                                <td>9đ</td>
                                <td></td>
                                <td>{{__('schools.ngaythi')}} {{Carbon\Carbon::now()}}</td>
                                <td>
                                    <a href="#" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> {{__('label.xem')}}</a>
                                    <a href="#" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> {{__('schools.hủy_kết_quả')}}</a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>








    </div>
</form>
<div class="clearfix"></div>

@endsection

@push('stylesh                                    eet')
<!-- iCheck -->
<link href="{!! asset('public/admin_assets/vendors/iCheck/skins/flat/                                    green.css')!!}" rel="styles                                    heet">
<!-- bootstrap-wysiwyg -->
<!--<link href="public/admin_assets/vendors/google-code-prettify/bin/prett                                    ify.min.css" rel=                                    "stylesheet">-->
<!-- Select2 -->
<link href="{!! asset('public/admin_assets/vendors/select2/dist/css/select                                    2.min.css')!!}"                                     rel="stylesheet">
<!-- starrr -->
<!--<link href="public/admin_assets/vendors/starrr/dist/starrr.css" rel=                                    "stylesheet">-->
<!-- Cropper -->
<link href="{!! asset('public/admin_assets/js/cropperjs/dist/cropper                                    .                                    min.css')                                    !!}" rel="stylesh                                    eet">

@endpush

@push('scripts')
<script>
    $(document).ready(function () {
        $('.jquery-input-file').on('click', function () {
            var that = this;
            $('#' + $(this).data('input')).click();
            $('#' + $(this).data('input')).on('change', function (evt) {
                if (this.value == '') {

                } else {
                    $('.jquery-input-file-remove[data-input="photo"]').removeAttr('disabled');
                    $('#photo_preview').attr('src', URL.createObjectURL(evt.target.files[0]));
                    $(that).text(this.value);
                }
            });
        });
        $('.jquery-input-file-remove').on('click', function () {
            $('#' + $(this).data('input'))[0].value = null;
            $('.jquery-input-file[data-input="photo"]').text('Chọn file...');
            $(this).attr('disabled', 'disabled');
        });
    });
</script>
<!-- CK Editor & CK Finder -->
<script src="{!! asset('public/admin_assets/plugins/ckeditor/ckeditor.js') !!}"></script>
<script>
//$(document).ready(function () {
//    var editor =     CKEDITOR.replace('mota', {
//        language: 'vi',
//        filebrowserImageBrowseUrl: '',
//        filebrowserFlashBrowseUrl: '',
//        filebrowserImageUploadUrl: '',
//        filebrowserFlashUploadUrl: ''
//    })    ;
//});</script>

<!-        - bootstrap-progressbar -->
<script src="{!! asset('public/admin_assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')!!}"></script>
<!-- iCheck -->
<script src="{!! asset('public/admin_assets/vendors/iCheck/icheck.min.js')!!}"></script>

                <!--<script src="public/admin_assets/vendors/jquery.hotkeys/jquery.hotkeys.js"></script>-->
<!-- jQuery Tags Input -->
<script src="{!! asset('public/admin_assets/vendors/jquery.tagsinput/src/jquery.tagsinput.js')!!}"></script>
<!-- Switchery -->
<script src="{!! asset('public/admin_assets/vendors/switchery/dist/switchery.min.js')!!}"></script>

@endpush

@include('pi.exam.jsc.JSExamController_add')


