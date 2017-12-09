
@extends('pi.layouts.master')

@section('content')
<form action="{{route('_mdle_oc_chapter_save',$course_info->id)}}" method="POST" class="form form-horizontal">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3></h3>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="x_panel">
            <div class="x_content">
                <a class="btn btn-app" href="{{route('mdle_oc_chapter_index',$item->id_course)}}" ><i class="fa fa-arrow-left"></i> Quay lại</a>
                <button type="submit" class="btn btn-app"><i class="fa fa-save"></i> Lưu</button>
                <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>
            </div>
        </div>

        <div class="x_panel">
            <div class="x_title">
                <h2>Thông tin khóa học <small>
                    </small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <ul class="list-group">
                    <li class="list-group-item">Tên khóa học: {{$course_info->name}}</li>
                    <li class="list-group-item">Tên giáo viên: {{$course_info->professor_name}}</li>

                    <li class="list-group-item">Ngày tạo: {{$course_info->created_at}}</li>
                    <li class="list-group-item">Ngày sửa: {{$course_info->updated_at}}</li>
                </ul>
            </div>
        </div>

        <div class="x_panel">
            <div class="x_title">
                <h2>Quản lý chương <small>
                    </small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @if($course_info->id!=null)

                {{csrf_field()}}
                <input type="hidden" name="id" value="{{@$item->id}}" />
                <input type="hidden" name="id_course" value="{{$course_info->id}}" />
                <div class="form-group">
                    <label class="control-label col-md-3 col-xs-12">Tên chương</label>
                    <div class="col-md-9 col-xs-12">
                        <input type="text" class="form-control" name="name" value="{{@$item->name}}" 
                               placeholder="Tên chương..." />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-xs-12">Mô tả</label>
                    <div class="col-md-9 col-xs-12">
                        <textarea class="form-control" name="description"
                                  placeholder="Mô tả...">{{@$item->description}}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-xs-12">Giá</label>
                    <div class="col-md-9 col-xs-12">
                        <input type="text" class="form-control" name="price" value="{{@$item->price}}" 
                               placeholder="Giá" />
                    </div>
                </div>

                @php
                $display_checked = @$item->display?'checked':'';
                @endphp
                <div class="form-group">
                    <label class="control-label col-md-3 col-xs-2">Hiển thị</label>
                    <div class="col-md-9 col-xs-10">
                        <input type="checkbox" name="display" {{$display_checked}} class="jquery-icheck" />
                    </div>
                </div>

                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-9 col-xs-12 col-md-offset-3">
                        <a class="btn btn-default" href="{{route('mdle_oc_chapter_index',$item->id_course)}}" >Quay lại</a>
                        <button class="btn btn-success"><i class="fa fa-save"></i> Lưu</button>
                    </div>
                </div>


                @else
                <div class="alert alert-danger">
                    <p><strong>Lỗi:</strong> Có lỗi xảy ra trong quá trình tải dữ liệu.</p>
                </div>
                @endif
            </div>     
        </div>
    </div>
</form>
@endsection
