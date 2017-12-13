
@extends('pi.layouts.master')
@include('OnlineCourse::Pi.exam.jsc.JSExamController_add')

@section('content')

<div class="page-title">
    <div class="title_left">
        <h3><i class="fa fa-plus"></i> {{__('label.them')}} {{ @$title }}</h3>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <a href="{{url()->previous()}}" class="btn btn-app"><i class="fa fa-arrow-left"></i> Quay lại</a>
                <a href="{{route('admin_index')}}" class="btn btn-app"><i class="fa fa-dashboard"></i> Dashboard</a>
                <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>
            </div>
        </div>
    </div>
</div>

<form class="form-horizontal form-label-left" onsubmit="return;" id="frm_exam_add" action="{{route('_mdle_oc_pi_exam_save')}}" method="POST" enctype="multipart/form-data">
    <div class="row">

        <div class="col-md-12">
            <div class="alert alert-warning">
                <p><i class="fa fa-warning"></i> <strong>Lưu lý:</strong></p>
                <ul>
                    <li>Dữ liệu bài thi sau khi đã được duyệt sẽ không thể chỉnh sửa hay xóa bởi tài khoản đã đăng.</li>
                    <li>Nếu có sai sót xảy ra, việc yêu cầu chỉnh sửa sẽ làm mất tất cả kết quả thi của user, đối với tài khoản đối tác sẽ chịu 100.000VNĐ phí cho mỗi lần yêu cầu chỉnh sửa.</li>
                    <li>Phí lượt thi & thời gian thi phải nằm trong quy định & chính sách của website.</li>
                </ul>
                <br>
                <p class="">Bài thi sau khi được gửi sẽ được duyệt bởi quản trị trong vòng 24h kể từ lúc đăng bài</p>
                <p class="pull-right text-info"><i class="fa fa-user"></i> BQT Website</p>
                <div class="clearfix"></div>
            </div>
        </div>

        {{ csrf_field() }}
        <input type="hidden" name="id" id="id" value="{{ @$item->id }}" />
        <input type="hidden" name="route_ajax" id="route_ajax" value="{{route('_mdle_oc_pi_exam_ajax')}}" />
        <input type="hidden" name="QCCreated" id="QCCreated" value="{{ isset($item->id)?true:false }}" />
        <input type="hidden" name="time_start" id="time_start"/>
        <input type="hidden" name="time_end" id="time_end"/>

        @if(@$UI->fieldGroup([
        'views','ordinal_number','photo'
        ]))

        <div class="col-md-8 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-edit"></i> {{ __('label.thongtinchung')}} <small> Thông tin bài thi</small></h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12">{{__('schools.tgthi')}}</label>
                                    <div class="col-md-2 col-sm-10 col-xs-12">
                                        <input type="number" id="JSExamController-input-timeh" name="time_h" class="form-control js-cedit" value="{{isset($item->time_h)?$item->time_h:0}}" placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.stt') ]))!!}">
                                    </div>
                                    <label class="control-label col-md-1 col-sm-2 col-xs-12">{{__('schools.gio')}}</label>
                                    <div class="col-md-2 col-sm-10 col-xs-12">
                                        <input type="number" id="JSExamController-input-timem" name="time_m" class="form-control js-cedit" value="{{isset($item->time_m)?$item->time_m:45}}" placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.stt') ]))!!}">
                                    </div>
                                    <label class="control-label col-md-1 col-sm-2 col-xs-12">{{__('schools.phut')}}</label>
                                    <div class="col-md-2 col-sm-10 col-xs-12">
                                        <input type="number" id="JSExamController-input-times" name="time_s" class="form-control js-cedit" value="{{isset($item->time_s)?$item->time_s:0}}" placeholder="{!! ucfirst(__('placeholder.nhap',['name'=> __('label.stt') ]))!!}">
                                    </div>
                                    <label class="control-label col-md-1 col-sm-2 col-xs-12">{{__('schools.giay')}}</label>

                                </div>
                                @if(@$UI->field('category'))
                                <div class="form-group">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12">{{__('label.danhmuc')}}</label>
                                    <div class="col-md-10 col-sm-10 col-xs-12">
                                        <select class="form-control js-cedit" name="id_category" id="id_category">
                                            @foreach($categories as $k=>$v)
                                            @if($v->can_select==0)
                                            <optgroup label="{!!$v->name!!}"></optgroup>
                                            @else
                                            <option value="{{$v->id}}">{!!$v->name!!}</option>
                                            @endif

                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif
                                <div class="form-group">
                                    <label for="jquery-bootstrap-drp-exam-date-range" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">TG diễn ra:</label>
                                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 input-group">
                                        <input type="text" name="tgdienra" id="jquery-bootstrap-drp-exam-date-range" class="form-control js-cedit" placeholder="..." />
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 col-md-offset-2">
                                        <p class="text-info"><i class="fa fa-info"></i> <span id="jquery-info-drp-exam-data-range">Sinh viên chỉ có thể làm bài thi trong thời gian này.</span></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="price" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Phí thi trực tuyến:</label>
                                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                        <input type="number" name="price" id="price" value="{{isset($item->price)?$item->price:old('price')}}"
                                               class="form-control js-cedit" placeholder="Phí thi trực tuyến..." />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="price2" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Phí thi lại:</label>
                                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                        <input type="number" name="price2" id="price2" value="{{isset($item->price2)?$item->price2:old('price2')}}"
                                               class="form-control js-cedit" placeholder="Phí thi lại (Luyện tập trắc nghiệm online)..." />
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="col-md-4 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('label.caidat')}} <small>Gửi yêu cầu.</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="">
                        <p>Kiểm duyệt nội dung chặt chẽ trước khi gửi yêu cầu, bài thi đã gửi đi sẽ không được phép chỉnh sửa, nếu chưa chuẩn bị nội dung nên quay lại vào lúc khác!</p>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <a href="{{route('mdle_oc_pi_exam_index')}}" class="btn btn-default">{{__('label.quaylai')}}</a> 
                                <button type="submit" class="btn btn-success js-cedit"><i class="fa fa-save"></i> {{__('label.gui')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-file-pdf-o"></i> {{__('schools.tailieu')}} <small> Upload tài liệu PDF | DOC</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12"> {{__('label.ten')}}</label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <input type="text" name="name" class="form-control" value="{{isset($item->name)?$item->name:old('name')}}" placeholder="Tên bài thi">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12"> {{__('label.mota')}}</label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <textarea name="description" class="form-control" placeholder="Mô tả bài thi">{{isset($item->description)?$item->description:old('description')}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-4 col-xs-12">{{__('schools.chonfile')}}</label>
                        <div class="col-md-10 col-sm-8 col-xs-12">
                            <input type="file" accept=".pdf,.docx,.doc" name="file_pdf" />
                            <div class="text-info">Chỉ hỗ trợ file .pdf | .doc | .docx</div>
                        </div>
                    </div>
                    @isset($file_pdf)
                    <div class="form-group">
                        <div class="panel panel-primary">
                            <div class="panel-heading"><i class="fa fa-file-pdf-o"></i> Document</div>
                            <div class="panel-body" style="height: 407px;padding:0;">
                                <embed style="width: 100%;height:99%;" src="{{ route('document',$file_pdf->url_encode)}}" />
                            </div>
                        </div>
                    </div>
                    @endisset
                </div>
            </div>
        </div>

        <div class="col-md-4 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-check-square-o"></i> {{__('schools.taotracnghiem')}} <small> Tạo câu hỏi trắc nghiệm</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="exam_qcpan" id="JSExamController-pan-qc">
                        @isset($item)
                        @isset($item->id)
                        @if(count($items)!=0)
                        <ul class="JSExamController-question-ul">
                            @foreach($items as $k=>$v)
                            <li class='JSExamController-question-li'>Câu {{$k+1}}
                                <div> A <input {{$v->result==1?'checked':''}} type="radio" class="qc_radio" name="question{{$k+1}}" value="1"/></div>
                                <div> B <input {{$v->result==2?'checked':''}} type="radio" class="qc_radio" name="question{{$k+1}}" value="2"/></div>
                                <div> C <input {{$v->result==3?'checked':''}} type="radio" class="qc_radio" name="question{{$k+1}}" value="3"/></div>
                                <div> D <input {{$v->result==4?'checked':''}} type="radio" class="qc_radio" name="question{{$k+1}}" value="4"/></div>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <p>Không có dữ liệu...</p>
                        @endif
                        @endisset
                        @endisset
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-7 col-sm-7 col-xs-12">{{__('schools.soluongcauhoi')}}</label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="number" class="form-control" value="{{isset($items)?count($items):10}}" id="JSExamController-input-QC" name="question_count" />
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-12 col-xs-12 col-md-offset-3">
                            <button type="button" id="JSExamController-button-QC-add" class="btn btn-success">
                                {{__('label.tao')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(@$UI->fieldGroup([
        'seo_title','seo_keywords','seo_description'
        ]))
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-share-alt"></i> {{__('label.seo')}} <small> Nội dung seo</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    @if(@$UI->field('seo_title'))
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">{{@$UI->field_name('seo_title')}}</label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <input type="text" class="form-control js-cedit" name="seo_title" id="seo_title" value="{{isset($item->seo_title)?$item->seo_title:old('seo_title')}}" placeholder="">
                            <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                {{@$UI->field_note('seo_title',true)}}</div>
                        </div>
                    </div>
                    @endif
                    @if(@$UI->field('seo_keywords'))
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">{{@$UI->field_name('seo_keywords')}}</label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <input type="text" class="tags form-control jquery-input-tag js-cedit" name="seo_keywords" value="{{isset($item->seo_keywords)?$item->seo_keywords:old('seo_keywords')}}" />
                            <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                {{@$UI->field_note('seo_keywords',true)}}</div>
                        </div>
                    </div>
                    @endif
                    @if(@$UI->field('seo_description'))
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">{{$UI->field_name('seo_description')}}</label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <textarea class="form-control js-cedit" name="seo_description" placeholder="">{{isset($item->seo_description)?$item->seo_description:old('seo_description')}}</textarea>
                            <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                                {{@$UI->field_note('seo_description',true)}}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</form>
<div class="clearfix"></div>

@endsection

@push('stylesheet')

<style>
    .JSExamController-question-ul{
        width: 100%;
        height: 500px;
        overflow-y: scroll;
        list-style: none;
        border: 1px solid #333;

    }
    .JSExamController-question-li{
        width: 100%;
    }
    .JSExamController-question-li div{
        margin: 2px 0px;
    }
    .JSExamController-question-li input[type="radio"]{

    }
</style>
@endpush

@push('scripts')
@isset($item)
<script>
    $(document).ready(function () {
        $('input').attr('disabled', '');
        $('button[type="submit"]').attr('disabled', '');
        $('textarea').attr('disabled', '');
        $('select').attr('disabled', '');
        $('input[type="radio"]').attr('disabled', '');
        $('input[type="checkbox"]').attr('disabled', '');
        $('.js-cedit').removeAttr('disabled');
    });
</script>
@endisset
<script>
    $(document).ready(function () {
        superplaceholder({
            el: seo_title,
            sentences: ['Nhập tiêu đề để seo bài thi lên top 1 cách hiệu quả nhất!', 'Đề thi địa lý lớp 12 , Đề thi địa lý lớp 11, Đề thi địa lý lớp 10'],
            options: {
                loop: true,
                letterDelay: 30,
                startOnFocus: false
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('.jquery-input-file').on('click', function () {
            var that = this;
            $('#' + $(this).data('input')).click();
            $('#' + $(this).data('input')).on('change', function (evt) {
                if (this.value === '') {

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

<script>
//$(document).ready(function () {
//    var editor =     CKEDITOR.replace('mota', {
//        language: 'vi',
//        filebrowserImageBrowseUrl: '',
//        filebrowserFlashBrowseUrl: '',
//        filebrowserImageUploadUrl: '',
//        filebrowserFlashUploadUrl: ''
//    })    ;
//});
</script>
<!-- jQuery Tags Input -->
<script src="{!! asset('public/admin/bower_components/jquery.tagsinput/src/jquery.tagsinput.js')!!}"></script>


@endpush



