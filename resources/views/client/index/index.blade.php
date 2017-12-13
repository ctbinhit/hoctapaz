@extends('client.layouts.master')

@section('content')
<!--slide -->
@include('client.layouts.slide')
<!--Slider End -->
<!--Public Online-->
<div id="puplic">
    <div class="wap-puplic">
        <div class="conten-left">
            <!--Khóa học-->
            <div class="title-left">
                CỘNG ĐỒNG HỌC TẬP TRỰC TUYẾN HOCTAPAZ.COM.VN
            </div>
            <div class="exam">
                <div class="item-exem">
                    <div class="img-exem">
                        <h2><a href="{{route('client_exam_phongthi')}}">Phòng Thi online</a></h2>
                    </div>
                </div>
                <div class="item-exem">
                    <div class="img-exem">
                        <h2><a href="{{route('client_exam_tracnghiemtructuyen')}}">Trắc nghiệm trực tuyến</a></h2>
                    </div>
                </div>
                <div class="item-exem">
                    <div class="img-exem">
                        <h2><a href="{{route('mdle_client_doc_index','de-thi-thu')}}">Đề thi thử</a></h2>
                    </div>
                </div>
                <div class="item-exem">
                    <div class="img-exem">
                        <h2><a href="{{route('mdle_client_doc_index','tai-lieu-hoc')}}">Tài liệu học</a></h2>
                    </div>
                </div>
                <!--End Khóa học-->
            </div>
            <!--Danh mục khóa học-->
            <div class="danhmuc hide">
                <div class="item-dm">
                    <img src="public/client/images/toan.jpg" alt="Toán"  height="170px"/> 
                    <div class="background-dm" style="background: rgba(63, 81, 181, 0.62);">
                        <div class="content-dm">
                            <img src="public/client/images/icon_toan.png" alt="Toán"  height="49px" width="49px"/> 
                            <h3><a href="/hoc-online.html">Toán</a></h3>
                            <p>Bài giảng môn toán</p>
                        </div>
                    </div>
                </div>
                <div class="item-dm">
                    <img src="public/client/images/vatly.jpg" alt="vật lý"  height="170px"/> 
                    <div class="background-dm" style="background: rgba(0, 101, 17, 0.62);">
                        <div class="content-dm">
                            <img src="public/client/images/icon-vatly.png" alt="Toán"  height="49px" width="49px"/> 
                            <h3><a href="/hoc-online.html">Vật lý</a></h3>
                            <p>Bài giảng môn vật lý</p>
                        </div>
                    </div>
                </div>
                <div class="item-dm">
                    <img src="public/client/images/hoahoc.jpg" alt="Hóa Học"  height="170px"/> 
                    <div class="background-dm" style="background: rgba(63, 81, 181, 0.62);">
                        <div class="content-dm">
                            <img src="public/client/images/icon-hoa.png" alt="Toán"  height="49px" width="49px"/> 
                            <h3><a href="/hoc-online.html">Hóa Học</a></h3>
                            <p>Bài giảg môn Hóa</p>
                        </div>
                    </div>
                </div>
                <div class="item-dm">
                    <img src="public/client/images/toan.jpg" alt="Toán"  height="170px"/> 
                    <div class="background-dm" style="background: rgba(63, 81, 181, 0.62);">
                        <div class="content-dm">
                            <img src="public/client/images/icon_toan.png" alt="Toán"  height="49px" width="49px"/> 
                            <h3><a href="/hoc-online.html">Toán</a></h3>
                            <p>Bài giảng môn toán</p>
                        </div>
                    </div>
                </div>
                <div class="item-dm">
                    <img src="public/client/images/vatly.jpg" alt="vật lý"  height="170px"/> 
                    <div class="background-dm" style="background: rgba(0, 101, 17, 0.62);">
                        <div class="content-dm">
                            <img src="public/client/images/icon-vatly.png" alt="Toán"  height="49px" width="49px"/> 
                            <h3><a href="/hoc-online.html" class="">Vật lý</a></h3>
                            <p>Bài giảng môn vật lý</p>
                        </div>
                    </div>
                </div>
                <div class="item-dm">
                    <img src="public/client/images/hoahoc.jpg" alt="Hóa Học"  height="170px"/> 
                    <div class="background-dm" style="background: rgba(63, 81, 181, 0.62);">
                        <div class="content-dm">
                            <img src="public/client/images/icon-hoa.png" alt="Toán"  height="49px" width="49px"/> 
                            <h3><a href="/hoc-online.html">Hóa Học</a></h3>
                            <p>Bài giảg môn Hóa</p>
                        </div>
                    </div>
                </div>
                <div class="item-dm">
                    <img src="public/client/images/toan.jpg" alt="Toán"  height="170px"/> 
                    <div class="background-dm" style="background: rgba(63, 81, 181, 0.62);">
                        <div class="content-dm">
                            <img src="public/client/images/icon_toan.png" alt="Toán"  height="49px" width="49px"/> 
                            <h3><a href="/hoc-online.html">Toán</a></h3>
                            <p>Bài giảng môn toán</p>
                        </div>
                    </div>
                </div>
                <div class="item-dm">
                    <img src="public/client/images/vatly.jpg" alt="vật lý"  height="170px"/> 
                    <div class="background-dm" style="background: rgba(0, 101, 17, 0.62);">
                        <div class="content-dm">
                            <img src="public/client/images/icon-vatly.png" alt="Toán"  height="49px" width="49px"/> 
                            <h3><a href="/hoc-online.html">Vật lý</a></h3>
                            <p>Bài giảng môn vật lý</p>
                        </div>
                    </div>
                </div>
                <div class="item-dm">
                    <img src="public/client/images/hoahoc.jpg" alt="Hóa Học"  height="170px"/> 
                    <div class="background-dm" style="background: rgba(63, 81, 181, 0.62);">
                        <div class="content-dm">
                            <img src="public/client/images/icon-hoa.png" alt="Toán"  height="49px" width="49px"/> 
                            <h3><a href="/hoc-online.html">Hóa Học</a></h3>
                            <p>Bài giảg môn Hóa</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <!--End Danh mục khóa học-->

            <div class="alert alert-warning">
                <p><i class="fa fa-spinner faa-spin animated"></i> Chức năng <strong>lớp học trực tuyến</strong> đang cập nhật...</p>
            </div>

            <!--Lớp học trực tuyến-->
            <div class="class-online hide">
                <div class="title-online">Lớp học trực tuyến</div>
                <div class="view-online">
                    <p><a href="#">Xem tất cả</a></p>
                    <p><a href="#">Tạo lớp học <i class="fa fa-outdent"></i></a></p>
                </div>
                <div class="wap-online">
                    <div class="item-online">
                        <div class="img-online">
                            <img src="public/client/images/giaovien.jpg" alt="Nguyễn Huyền Mai" />
                        </div>
                        <h4>Nguyễn Huyền Linh</h4>
                        <p class="ngaydang"><i class="fa fa-calendar"></i>09/09/2017</p>
                        <div class="conten-online">
                            <p><i class="fa fa-book"></i> Toán</p>
                            <p><i class="fa fa-building"></i> Lớp 12</p>
                            <p><i class="fa fa-user"></i> 122</p>
                        </div>
                        <div class="chitiet">
                            <a href="#">Xem chi tiết</a>
                        </div>
                    </div>
                    <div class="item-online">
                        <div class="img-online">
                            <img src="public/client/images/giaovien.jpg" alt="Nguyễn Huyền Mai" />
                        </div>
                        <h4>Nguyễn Huyền Linh</h4>
                        <p class="ngaydang"><i class="fa fa-calendar"></i>09/09/2017</p>
                        <div class="conten-online">
                            <p><i class="fa fa-book"></i> Toán</p>
                            <p><i class="fa fa-building"></i> Lớp 12</p>
                            <p><i class="fa fa-user"></i> 122</p>
                        </div>
                        <div class="chitiet">
                            <a href="#">Xem chi tiết</a>
                        </div>
                    </div>
                    <div class="item-online">
                        <div class="img-online">
                            <img src="public/client/images/giaovien.jpg" alt="Nguyễn Huyền Mai" />
                        </div>
                        <h4>Nguyễn Huyền Linh</h4>
                        <p class="ngaydang"><i class="fa fa-calendar"></i>09/09/2017</p>
                        <div class="conten-online">
                            <p><i class="fa fa-book"></i> Toán</p>
                            <p><i class="fa fa-building"></i> Lớp 12</p>
                            <p><i class="fa fa-user"></i> 122</p>
                        </div>
                        <div class="chitiet">
                            <a href="#">Xem chi tiết</a>
                        </div>
                    </div>
                    <div class="item-online">
                        <div class="img-online">
                            <img src="public/client/images/giaovien.jpg" alt="Nguyễn Huyền Mai" />
                        </div>
                        <h4>Nguyễn Huyền Linh</h4>
                        <p class="ngaydang"><i class="fa fa-calendar"></i>09/09/2017</p>
                        <div class="conten-online">
                            <p><i class="fa fa-book"></i> Toán</p>
                            <p><i class="fa fa-building"></i> Lớp 12</p>
                            <p><i class="fa fa-user"></i> 122</p>
                        </div>
                        <div class="chitiet">
                            <a href="#">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <!--End Lớp học trực tuyến-->

            @include('client.components.sanpham.noibat')

            @include('client.components.sanpham.moinhat')





            <!--Hỏi đáp-->
            <div class="answer">
                <div class="title-answer"> <a href="{{route('mdle_client_qa_index')}}">Hỏi đáp online</a></div>
                <div class="danhmuc-mh">
                    <select id="qa_categories">
                        <option>-- Chọn danh mục --</option>
                        @foreach($db_qa_categories as $v)
                        <option value="{{route('mdle_client_qa_category',$v->name_meta)}}">{{$v->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="wap-answer">
                    @foreach($db_newest_qa as $k=>$v)
                    <div class="item-answer">
                        <a href="{{route('mdle_client_qa_detail',$v->id)}}"><div class="comment">{{$v->answer_count}}</div></a>
                        <div class="img-answer">
                            <img src="{{$v->user_photo}}" alt="hinh" />
                        </div>
                        <h4>{{$v->user_name}}</h4>
                        <span>{{$v->created_at}}</span>
                        <div class="noidung">
                            <p>{!!$v->content!!}</p>
                        </div>
                        <div class="clear"></div>
                        <div class="nav-answer">
                            <a href="{{route('mdle_client_qa_category', $v->cate_name_meta)}}"> {{$v->category_name}}</a>
                        </div>
                    </div>
                    @endforeach
                    <div class="clear"></div>
                    <div class="tag-dm">

                    </div>
                </div>
            </div>
            <!--End Hỏi đáp-->
        </div>
        <div class="conten-right hide">
            <h3>Bảng xếp hạng</h3>
            <div class="wap-queue">
                <div class="item-queue">
                    <div class="img-queue">
                        <img src="public/client/images/giaovien.jpg" alt="hinh" />
                    </div>
                    <h4>Nguyễn Kim Thọ</h4>
                    <a>Điểm GP <span class="badge">432</span></a>
                </div>
                <div class="item-queue">
                    <div class="img-queue">
                        <img src="public/client/images/giaovien.jpg" alt="hinh" />
                    </div>
                    <h4>Nguyễn Kim Thọ</h4>
                    <a>Điểm GP <span class="badge">432</span></a>
                </div>
                <div class="item-queue">
                    <div class="img-queue">
                        <img src="public/client/images/giaovien.jpg" alt="hinh" />
                    </div>
                    <h4>Nguyễn Kim Thọ</h4>
                    <a>Điểm GP <span class="badge">432</span></a>
                </div>
                <div class="item-queue">
                    <div class="img-queue">
                        <img src="public/client/images/giaovien.jpg" alt="hinh" />
                    </div>
                    <h4>Nguyễn Kim Thọ</h4>
                    <a>Điểm GP <span class="badge">432</span></a>
                </div>
                <div class="item-queue">
                    <div class="img-queue">
                        <img src="public/client/images/giaovien.jpg" alt="hinh" />
                    </div>
                    <h4>Nguyễn Kim Thọ</h4>
                    <a>Điểm GP <span class="badge">432</span></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End Public Online-->

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#qa_categories').on('change', function () {
            window.open($(this).val());
        });
    });
</script>
@endpush