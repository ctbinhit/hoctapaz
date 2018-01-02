@extends('pi.layouts.master')

@section('content')
<form class="form form-horizontal" method="post" action="{{route('_mdle_pi_post_save',$type)}}" enctype="multipart/form-data">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3><i class="fa fa-plus"></i> Thêm file </h3>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="x_panel">
            <div class="x_content">
                <a href="{{route('mdle_pi_doc_index',$type)}}" class="btn btn-app"><i class="fa fa-arrow-left"></i> Quay lại</a>
                <button class="btn btn-app"><i class="fa fa-save"></i> Lưu</button>
            </div>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="x_panel">
            <div class="x_title">
                <h2>Thông tin file</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                {{csrf_field()}}
                <input type="hidden" name="id" id="id" value="{{@$item->id}}" />
                <input type="hidden" name="type" id="type" value="{{$type}}" />
                <input type="hidden" name="allow_uservip" id="allow_uservip" value="" />

                <div class="form-group">
                    <label for="name" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Tên file:</label>
                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                        <input type="text" name="name" id="name" class="form-control"
                               value="{{old('name', @$item->name)}}" placeholder="Tên file" required=""/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Danh mục:</label>
                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                        <select class="form-control" name="id_category">
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

                <div class="form-group">
                    <label for="description" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">VIP:</label>
                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                        @if(count($db_uservipmodels)!=0)
                        <select id="js-mselect" multiple="">
                            <optgroup label="Loại VIP"></optgroup>
                            @foreach($db_uservipmodels as $k=>$v)
                            <option value="{{$v->id}}">{!!$v->name!!} ({!!@$v->note!!})</option>
                            @endforeach
                        </select>
                        @else
                        <p class="text-warning"><i class="fa fa-warning"></i> Chưa có vip nào.</p>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="description" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Mô tả:</label>
                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                        <textarea class="form-control js-ckeditor" name="description" id="description"
                                  placeholder="Mô tả..." rows="5" id="description" required="">{{old('description', @$item->description)}}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="content" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Nội dung:</label>
                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                        <textarea class="form-control js-ckeditor" name="content" id="content"
                                  placeholder="Nội dung..." rows="8" id="description" required="">1{{old('content', @$item->content)}}</textarea>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Thông tin file</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="form-group">
                            <label for="price" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Giá:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 input-group">
                                <input type="number" name="price" id="price" class="form-control"
                                       value="{{old('price', @$item->price)}}" placeholder="Giá tài liệu..." required=""/>
                                <span class="input-group-addon">VNĐ</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="file_demo" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">File demo:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                <input type="file" name="file_demo" id="file_demo" accept=".pdf"/>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 col-lg-offset-2 col-md-offset-2">
                                <div class="alert alert-info">
                                    <strong>Lưu ý!</strong> File này được trích 1 đoạn từ file tài liệu và không vượt quá 5Mb <b>Download</b>.
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="file" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">File:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                <input type="file" name="file" id="file" accept=".pdf,.doc,.docx"/>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 col-lg-offset-2 col-md-offset-2">
                                <div class="alert alert-info">
                                    <strong>Lưu ý!</strong> Trình xem trước chỉ có thể hiển thị file dưới 25mb, nếu vượt quá 
                                    kích thước cho phép thì không thể xem online chỉ có thể <b>Download</b>.
                                </div>
                            </div>
                        </div>

                        @isset($item)
                        <div class="form-group">
                            <label for="file" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">File đã upload:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                <embed style="width: 100%;height: 500px;" src="{{route('document',$item->url_encode)}}#toolbar=0&navpanes=0&scrollbar=0"></embed>
                            </div>
                        </div>
                        @endisset
                        <div class="form-group">
                            <label for="state" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Trạng thái:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                <select class="form-control" name="state" disabled="">
                                    <option value="uploaded" selected> Chỉ upload</option>
                                    <option value="pedding"> Gửi cho quản trị duyệt & đăng bán</option>
                                </select>
                            </div>
                            <div class="col-md-10 col-md-offset-2">
                                <div class="alert alert-info">
                                    <strong>Lưu ý! </strong> Việc chọn trạng thái <b class="text-info">Gửi cho quản trị duyệt & đăng bán</b> là 
                                    đồng nghĩa với việc chấp nhận với điều khoản & chính sách của trang hoctapAZ, sau khi lưu 
                                    file tài liệu này sẽ được kiểm duyệt viên kiểm tra, sau đó sẽ được đưa lên trang chủ nếu file
                                    đã đủ điều kiện.
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 col-md-offset-2 col-lg-offset-2">
                                <a href="{{route('mdle_pi_doc_index',$type)}}" class='btn btn-default'><i class="fa fa-arrow-left"></i> Quay lại</a>
                                <button type="button" class="btn btn-success jquery-btn-submit"><i class="fa fa-save"></i> Lưu</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Nội dung SEO</h2><div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="form-group">
                            <label for="seo_title" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Title:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                <input type="text" name="seo_title" id="seo_title" class="form-control"
                                       value="{{old('seo_title', @$item->seo_title)}}" placeholder="Seo title..." />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="seo_keywords" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Keywords:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                <input type="text" name="seo_keywords" id="seo_keywords" class="form-control jquery-input-tag"
                                       value="{{old('seo_keywords', @$item->seo_keywords)}}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="seo_description" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Description:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                <textarea class="form-control" id="seo_description" rows="5" placeholder="Seo description..."
                                          name="{{old('seo_description', @$item->seo_description)}}">{{old('seo_description',@$item->seo_description)}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<input type="hidden" id="pdf_url" value="{{route('document',@$item->url_encode)}}"/>
<input type="hidden" id="pdf_worker" value="{{asset('public/plugins/pdfjs-1.9.426-dist/build/pdf.worker.js')}}" />
@endsection

@push('stylesheet')
<link rel="stylesheet" href="{!! asset('public/admin/node_modules/summernote/dist/summernote.css') !!}"/>

<!-- Jquery multiple select -->
<link rel="stylesheet" href="{!! asset('public/admin/bower_components/jQuery-MultiSelect/jquery.multiselect.css') !!}"/>

@endpush

@push('scripts')
<!-- jQuery multiple select -->
<script src="{!! asset('public/admin/bower_components/jQuery-MultiSelect/jquery.multiselect.js')!!}"></script>
<script>
    $(document).ready(function(){
    $('#js-mselect').multiselect({
    columns  : 2,
            search   : true,
            selectAll: true,
            texts    : {
            placeholder: 'Chọn loại vip',
                    search     : 'Tìm kiếm vip'
            }
    });
    });</script>

<!-- jQuery Tags Input -->
<script src="{!! asset('public/admin/bower_components/jquery.tagsinput/src/jquery.tagsinput.js')!!}"></script>

<!-- CK Editor & CK Finder -->
<script src="{!! asset('public/admin/bower_components/ckeditor/ckeditor.js') !!}"></script>
<script>
    $('.js-ckeditor').each(function(){

    CKEDITOR.replace($(this).attr('id'), {
    customConfig: '{!! asset("public/admin/ckeditor/articleo/config.js") !!}',
    });
    });</script>

<script>

    $(document).ready(function(){
    $('.jquery-btn-submit').on('click', function(){
    var this_form = $(this).parents('form');
    var btn_text = $(this).text();
    var e_id = $(this_form).find('#id').val();
    var e_file = $(this_form).find('#file').val();
    var e_name = $(this_form).find('#name').val();
    var e_description = CKEDITOR.instances.description.getData();
    var e_content = CKEDITOR.instances.content.getData();
    var e_price = $(this_form).find('#price').val();
    var e_seo_title = $(this_form).find('#seo_title').val();
    var e_seo_description = $(this_form).find('#seo_description').val();
    var e_seo_keywords = $(this_form).find('#seo_keywords').val();
    var e_uservip = $('#js-mselect').val();
    $('#allow_uservip').val(e_uservip);
    if (e_uservip == null){
    $.alert(jquery_alert_options({title: 'Thông báo', type:'red', content: 'Vui lòng chọn danh sách loại VIP.'}));
    return;
    }

    var form_input = [
            e_name, e_uservip,
            e_description,
            e_content,
            e_price, e_seo_title, e_seo_description, e_seo_keywords
    ];
    if (e_id == ''){
    if (e_file == ''){
    $.alert(jquery_alert_options({title: 'Thông báo', type:'red', content: 'Vui lòng chọn file.'}));
    return;
    }
    }

    var flag = true;
    $.each(form_input, function(k, v){
    console.log(v);
    if (v == ''){
    flag = false;
    }
    });
    if (flag == false){
    $.alert(jquery_alert_options({title: 'Thông báo', type:'red', content: 'Vui lòng nhập đầy đủ thông tin trước khi lưu.'}));
    return;
    }

    $(this_form).find('button,a').attr('disabled', '').off('click');
    $(this).html('<i class="fa fa-spinner faa-spin animated"></i> Đang lưu...').attr('disabled', '');
    $(this_form).submit();
    });
    });
</script>

@endpush

@include('Document::Pi.Document.parts.bviewer')