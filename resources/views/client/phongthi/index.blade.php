
@extends('client.layouts.master')

@section('content')
<div class="examonline">
    <div class="sup-nav">
        <a href="{{route('client_index')}}"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a> <i class="fa fa-angle-double-right"></i>
        <a href="{{url()->full()}}">Phòng thi</a> 
    </div>
    <div class="exam-left">

        <div class="l_panel">
            <div class="l-title"><i class="fa fa-search"></i> Tìm kiếm</div>
            <div class="l-content">
                <form action="" class="">
                    <div class="form-group">
                        <div class="col-xs-12 input-group">
                            <input type="text" name="keywords" id="keywords" 
                                   class="form-control" placeholder="Từ khóa..." value="{{Request::get('keywords')}}"/>
                            <span class="input-group-btn">
                                <button class="btn btn-default"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                        <div class="col-xs-12">
                            <input type="radio" name="filterBy" value="keywords" checked/> <i class="fa fa-tags"></i> Từ khóa
                            <input type="radio" name="filterBy" value="username" {{Request::get('filterBy')=='username'?'checked':''}}/> <i class="fa fa-user"></i> Giáo viên

                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="l_panel">
            <div class="l-title"><i class="fa fa-list-ul"></i> Danh mục</div>
            <div class="l-content">
                <ul class="list-simple">
                    @foreach($categories_hoctap as $k=>$v)
                    <li><a href="{{route('client_exam_phongthi_danhmuc',$v->name_meta)}}"><i class="fa fa-book"></i> {!! $v->name !!}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="l_panel">
            <div class="l-title"><i class="fa fa-users"></i> Giảng viên tiêu biểu</div>
            <div class="l-content">
                <ul class="list-simple">
                    Đang cập nhật
                </ul>
            </div>
        </div>

        <div class="l_panel">
            <img style="width: 100%;" src="http://www.orchid-maunalani.com/wp-content/uploads/2017/09/khoa-hoc-truc-tuyen_feature.jpg" />
        </div>

        <div class="l_panel">
            <img style="width: 100%;" src="data:image/jpeg;base64,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" />
        </div>

        <div class="l_panel">
            <img style="width: 100%;" src="data:image/png;base64,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" />
        </div>

    </div>
    <div class="exam-right">
        @if(Request::has('keywords'))
        <div class="alert alert-info">
            <p>Kết quả tìm kiếm cho từ khóa: <a href="{{url()->current()}}" class="btn btn-warning btn-xs"><i class="fa fa-remove"></i> {{Request::get('keywords')}}</a></p>

        </div>
        @endif
        <div class="r-panel">
            <div class="r-title"><i class="fa fa-bar-chart-o"></i> Đề thi mới nhất.
                <span class="readmore">
                    <a href="#">Xem thêm <i class="fa fa-angle-double-right"></i></a>
                </span></div>
            <div class="r-content">
                @if(count($items)!=0)
                <div class="exams">
                    @foreach($items as $k=>$v)
                    <div class="exam">
                        <div class="exam-photo">
                            <img data-src="holder.js/300x200" alt="300x200" src="{{$v->avatar}}" style="width: 100%; height: 100%">
                        </div>
                        <div class="exam-info">
                            <h6>{{$v->name}}</h6>
                            <ul>
                                <li><i class="fa fa-clock-o"></i> <strong>{{ number_format($v->time/60,1)}}</strong> Phút</li>  
                                <li><i class="fa fa-calendar"></i> {{$v->created_at}}</li>
                                <li><i class="fa fa-user"></i> <span>{{$v->fullname}}</span></li>
                                <li>Giá: {{number_format($v->price,0)}} VNĐ</li>
                                <li><div class="label label-info">{{CategoryService::getNameById($v->id_category)}}</div></li>
                            </ul>
                            <div class="exam-info-bottom-right">
                                <a href="{{route('client_exam_phongthi_redirect',$v->name_meta)}}" class="btn btn-default">Thi ngay <i class="fa fa-sign-in"></i></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="alert alert-info">

                    <p class="text-info"><i class="fa fa-warning"></i> Không tìm thấy phòng thi nào khả dụng.</p>
                </div>
                @endif
            </div>
        </div>

        @foreach($categories_hoctap as $k=>$v)
        <div class="clearfix"></div>
        <div class="r-panel">
            <div class="r-title"><i class="fa fa-list-ul"></i> {{$v->name}} 
                <span class="readmore">
                    <a href="{{route('client_exam_phongthi_danhmuc',$v->name_meta)}}">Xem thêm <i class="fa fa-angle-double-right"></i></a>
                </span></div>
            <div class="r-content">
                <p>Chưa có dữ liệu</p>
            </div>

        </div>

        @endforeach

    </div>
</div>
@endsection

@push('stylesheet')

@endpush