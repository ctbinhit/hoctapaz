
@extends('pi.layouts.master')

@section('content')
<form action="{{route('_mdle_oc_lesson_save',[$course_info->id,$chapter_info->id])}}" method="POST" class="form form-horizontal">
    {{csrf_field()}}
    <input type="hidden" name="id" value="{{@$item->id}}" />
    <input type="hidden" name="id_course" value="{{$course_info->id}}" />
    <input type="hidden" name="id_chapter" value="{{$chapter_info->id}}" />
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3></h3>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="x_panel">
            <div class="x_content">
                <a href="{{route('mdle_oc_lesson_index',[$course_info->id,$chapter_info->id])}}" class="btn btn-app"><i class="fa fa-arrow-left"></i> Quay lại</a>
                @isset($item)
                <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>
                @else
                <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Nhập lại</a>
                @endisset
                <button type="submit" class="btn btn-app"><i class="fa fa-save"></i> Lưu</button>
            </div>
        </div>

        <div class="x_panel">
            <div class="x_title">
                <h2>Thông tin <small></small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <ul class="list-group">
                            <li class="list-group-item">Tên khóa học: {{$course_info->name}}</li>
                            <li class="list-group-item">Tên giáo viên: {{$course_info->professor_name}}</li>
                            <li class="list-group-item">Ngày tạo: {{$course_info->created_at}}</li>
                            <li class="list-group-item">Ngày sửa: {{$course_info->updated_at}}</li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <ul class="list-group">
                            <li class="list-group-item">Tên chương: {{$chapter_info->name}}</li>
                            <li class="list-group-item">Ngày tạo: {{$chapter_info->created_at}}</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

        <div class="x_panel">
            <div class="x_title">
                <h2>Files <small>Hỗ trợ pdf | media file (3gp, mp4, avi...)</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="form-group">
                    <label class="control-label col-md-2 col-xs-12">Chọn file:</label>
                    <div class="col-md-10 col-xs-12">
                        <input type="file" class="form-control" accept=".mp4,.avi,.3gp,.pdf" name="name" />
                    </div>
                </div>
            </div>
        </div>

        <div class="x_panel">
            <div class="x_title">
                <h2>Thông tin chương <small>
                    </small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="form-group">
                    <label class="control-label col-md-2 col-xs-12">Tên bài học</label>
                    <div class="col-md-10 col-xs-12">
                        <input type="text" class="form-control" name="name" value="{{@$item->name}}" 
                               placeholder="Tên bài học..." />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2 col-xs-12">Mô tả</label>
                    <div class="col-md-10 col-xs-12">
                        <textarea class="form-control" name="description"
                                  placeholder="Mô tả...">{{@$item->description}}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2 col-xs-12">Nội dung text</label>
                    <div class="col-md-10 col-xs-12">
                        <textarea rows="8" class="form-control" name="content"
                                  placeholder="Nội dung text...">{{@$item->content}}</textarea>
                    </div>
                </div>


                @php
                if(isset($item->display)){
                $display_checked = @$item->display?'checked':'';
                }  else{
                $display_checked = 'checked';
                }

                @endphp
                <div class="form-group">
                    <label class="control-label col-md-3 col-xs-2">Hiển thị</label>
                    <div class="col-md-9 col-xs-10">
                        <input type="checkbox" name="display" {{$display_checked}} class="jquery-icheck" />
                    </div>
                </div>

            </div>     
        </div>

        <div class="x_panel">
            <div class="x_title">
                <h2>SEO <small>Thông tin seo</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="form-group">
                    <label class="control-label col-md-2 col-xs-12">Seo title:</label>
                    <div class="col-md-10 col-xs-12">
                        <input type="text" class="form-control" name="seo_title" />
                    </div>
                </div>
            </div>

            <div class="x_content">
                <div class="form-group">
                    <label class="control-label col-md-2 col-xs-12">Seo description:</label>
                    <div class="col-md-10 col-xs-12">
                        <textarea class="form-control" name="seo_description"></textarea>
                    </div>
                </div>
            </div>

            <div class="x_content">
                <div class="form-group">
                    <label class="control-label col-md-2 col-xs-12">Seo keywords:</label>
                    <div class="col-md-10 col-xs-12">
                        <input type="text" class="form-control jquery-input-tag tags" name="seo_keywords" />
                        <div id="suggestions-container" style="position: relative; float: left; width: 100%; margin: 10px;">
                            Để seo tốt nhất nên để nội dung dưới 166 ký tự.</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>
@endsection

@push('scripts')
<!-- jQuery Tags Input -->
<script src="{!! asset('public/admin_assets/vendors/jquery.tagsinput/src/jquery.tagsinput.js')!!}"></script>
@endpush