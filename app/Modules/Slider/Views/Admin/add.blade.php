
@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3></h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="x_panel">
        <div class="x_title">
            <h2>{{ __('label.them')}} <small>Slider</small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <form class="form form-horizontal" action="{{route('_mdle_slider_save')}}" enctype="multipart/form-data" method="POST">
                {{csrf_field()}}
                <input type="hidden" name="type" value="{{$type}}" />
                <input type="hidden" name="id" value="{{@$item->id}}" />

                <div class="form-group">
                    <label class="control-label col-md-2">STT:</label>
                    <div class="col-md-10">
                        <input type="number" class="form-control" name="ordinal_number" 
                               placeholder="Số thứ tự..." value="1" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">URL:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="url_redirect" value="{{@$item->url_redirect}}"
                               placeholder="Đường dẫn... (http://example.com/product/..." />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Tiêu đề:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="title" value="{{@$item->title}}"
                               placeholder="Tiêu đề..." />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Mô tả:</label>
                    <div class="col-md-10">
                        <textarea rows="5" class="form-control" name="description" 
                                  placeholder="Mô tả...">{{@$item->description}}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Chọn file:</label>
                    <div class="col-md-10">
                        <input type="file" name="file" class="form-control" />
                    </div>
                </div>
                
                @isset($item->url_encode)
                <div class="form-group">
                    <label class="control-label col-md-2">Hình cũ:</label>
                    <div class="col-md-10">
                        <img class="thumbnail" src="{{html_image($item->url_encode,267,190)}}" />
                    </div>
                </div>
                @endisset

                <div class="form-group">
                    <label class="control-label col-md-2">Ẩn hiện:</label>
                    <div class="col-md-4">
                        <ul class=" list-inline">
                            <li class="list-group-item"><input type="radio" name="display" class="jquery-icheck" checked/> Hiện</li>
                            <li class="list-group-item"><input type="radio" name="display" class="jquery-icheck"/> Ẩn</li>
                        </ul>
                    </div>
                </div>

                <div class="ln_solid"></div>

                <div class="form-group">
                    <div class="col-md-10 col-md-offset-2">
                        <a href="{{url()->previous()}}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Quay lại</a>
                        <button class="btn btn-success"><i class="fa fa-save"></i> Lưu</button>
                    </div>
                </div>


            </form>
        </div>
    </div>
</div>
@endsection