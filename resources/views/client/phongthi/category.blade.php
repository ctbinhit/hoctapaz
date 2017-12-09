
@extends('client.layouts.master')

@section('content')
<div class="examonline">
    <div class="sup-nav">
        <a href="{{route('client_index')}}"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a> <i class="fa fa-angle-double-right"></i>
        <a href="{{route('client_exam_phongthi')}}">Phòng thi <i class="fa fa-angle-double-right"></i></a>
        <a href="{{url()->full()}}">{{$this_cate->name}}</a>
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
            <div class="l-title"><i class="fa fa-list-ul"></i> Danh mục chính</div>
            <div class="l-content">
                <ul class="list-simple">
                    @foreach($categories as $k=>$v)
                    <li><a href="{{route('client_exam_phongthi_danhmuc',$v->name_meta)}}"><i class="fa fa-book"></i> {!! $v->name !!}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="l_panel">
            <div class="l-title"><i class="fa fa-list-ul"></i> Danh mục con</div>
            <div class="l-content">
                <ul class="list-simple">
                    @if(count($sub_cates)!=0)
                    @foreach($sub_cates as $k=>$v)
                    <li><a href="{{route('client_exam_phongthi_danhmuc',$v->name_meta)}}"><i class="fa fa-book"></i> {!! $v->name !!}</a></li>
                    @endforeach
                    @else
                    <p>Chưa có danh mục khả dụng.</p>
                    @endif
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