
@extends('client.layouts.master')

@section('content')
<div class="examonline">
    <div class="sup-nav">
        <a href="{{route('client_index')}}"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a> <i class="fa fa-angle-double-right"></i>
        <a href="{{route('client_exam_tracnghiemtructuyen')}}"><i class="fa fa-check-square-o"></i> Trắc nghiệm trực tuyến</a> <i class="fa fa-angle-double-right"></i>
        <a href="{{url()->full()}}">{{$this_cate->name}}</a>
    </div>
    <div class="exam-left">

        <div class="l_panel">
            <div class="l-title"><i class="fa fa-list-ul"></i> Danh mục</div>
            <div class="l-content">
                <ul class="list-simple">
                    @foreach($sub_cates as $k=>$v)
                    <li><a href="{{route('client_exam_phongthi_danhmuc',$v->name_meta)}}"><i class="fa fa-book"></i> {!! $v->name !!}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="l_panel">
            <div class="l-title"><i class="fa fa-list-ul"></i> Giảng viên tiêu biểu</div>
            <div class="l-content">
                <ul class="list-simple">
                    Đang cập nhật
                </ul>
            </div>
        </div>

    </div>
    <div class="exam-right">

        <div class="r-panel">
            <div class="r-title"><i class="fa fa-bar-chart-o"></i> Bài trắc nghiệm mới nhất.
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
                                <!--                                <li>{{$v->description}}</li>-->
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

        @foreach($sub_cates as $k=>$v)
        <div class="clearfix"></div>
        <div class="r-panel">
            <div class="r-title"><i class="fa fa-list-ul"></i> {{$v->name}} 
                <span class="readmore">
                    <a href="#">Xem thêm <i class="fa fa-angle-double-right"></i></a>
                </span></div>
            <div class="r-content">
                {!!@$v->html_list_items!!}
            </div>

        </div>

        @endforeach

    </div>
</div>
@endsection

@push('stylesheet')

@endpush