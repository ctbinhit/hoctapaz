
@extends('client.layouts.master')

@section('content')
<div class="examonline">
    <div class="sup-nav">
        <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a> <i class="fa fa-angle-double-right"></i>
        <a href="tai-lieu-tu-luan.html">Tài liệu học tự luận</a> 
    </div>
    <div class="exam-left">
        @include('client.layouts.left_kh')
    </div>
    <div class="exam-right">
        <div class="noidung">
            <div class="exem-item" style="width: 100%">
                <h3>Tài liệu môn lập trình c#</h3>
                <p>Luyện thi THPT Quốc Gia</p>
                <div class="gia">
                    Giá bán: 420.000 VNĐ
                </div>
                <div class="giakm">
                    Giảm còn: <span>400.000 </span>VNĐ
                </div>
                <div class="clear"></div>
                <div class="img-item">
                    <img data-src="holder.js/300x200" alt="300x200" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMDAiIGhlaWdodD0iMjAwIj48cmVjdCB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjE1MCIgeT0iMTAwIiBzdHlsZT0iZmlsbDojYWFhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjE5cHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+MzAweDIwMDwvdGV4dD48L3N2Zz4=" style="width: 200px; height: 150px;">
                </div>
                <div class="conten">
                    <p>22/07/2016</p>
                    <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh.</p>
                </div>
                <button type="button" class="btn btn-warning">Học thử</button>
                <button type="button" class="btn btn-primary">Mua khóa học</button>
                <div class="clear"></div>
            </div>
            <div class="course-detail">
                <h4>Giới thiệu về khóa học</h4>
                <div class="conten">
                    <p>Fusce dapibus, tellus ac cursus commodo, tortor mauris nibh.</br>

                        Nullam id dolor id nibh ultricies vehicula ut id elit.</br>

                        Duis mollis, est non commodo luctus, nisi erat porttitor ligula.</br>

                        Maecenas sed diam eget risus varius blandit sit amet non magna.</br>

                        Etiam porta sem malesuada magna mollis euismod.</br>

                        Donec ullamcorper nulla non metus auctor fringilla.</p></br>
                </div>
            </div>
        </div>
        <div class="danhmuc_kh">
            <div class="title">Danh mục khóa học</div>
            <div class="conten">
                <ul>
                    <li><a href="#">Phần 1: Phân tích chung</a>
                        <button type="button" class="btn btn-primary btn-xs">Mua Ngay</button>
                        <ul>
                            <li><a href="#">Chương 1: Phân tích chung</a></li>
                            <li><a href="#">Chương 2: Phân tích chung</a></li>
                            <li><a href="#">Chương 3: Phân tích chung</a></li>
                            <li><a href="#">Chương 4: Phân tích chung</a></li>

                        </ul>
                    </li>
                    <li><a href="#">Phần 2: Giải chi tiết</a>
                        <button type="button" class="btn btn-primary btn-xs">Mua Ngay</button>
                        <ul>
                            <li><a href="#">Chương 1: Phân tích chung</a></li>
                            <li><a href="#">Chương 2: Phân tích chung</a></li>
                            <li><a href="#">Chương 3: Phân tích chung</a></li>
                            <li><a href="#">Chương 4: Phân tích chung</a></li>

                        </ul>
                    </li>
                    <li><a href="#">Phần 3: Lập trình hướng đối tượng</a>
                        <button type="button" class="btn btn-primary btn-xs">Mua Ngay</button>
                        <ul>
                            <li><a href="#">Chương 1: Phân tích hệ thống</a></li>
                            <li><a href="#">Chương 2: Tịm hiểu môi trường</a></li>
                            <li><a href="#">Chương 3: Khái niệm mo hình 3 lớp</a></li>
                            <li><a href="#">Chương 4: Phân tích chung</a></li>

                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="same">
            <div class="title-same">Có thể bạn quan tâm</div>
            <div class="wap-item">
                <div class="item-same">
                    <div class="img-same">
                        <img data-src="holder.js/215x150" alt="215x150" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMDAiIGhlaWdodD0iMjAwIj48cmVjdCB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjE1MCIgeT0iMTAwIiBzdHlsZT0iZmlsbDojYWFhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjE5cHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+MzAweDIwMDwvdGV4dD48L3N2Zz4=" style="width: 100%; height: 150px;">
                    </div>
                    <h2><a href="#">Không có gì hết ngoài test</a></h2>
                    <div class="gia">
                        Giá: 320.000 
                    </div>
                    <div class="giakm">
                        Giá:<span>300.000</span>đ
                    </div>
                </div>
                <div class="item-same">
                    <div class="img-same">
                        <img data-src="holder.js/215x150" alt="215x150" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMDAiIGhlaWdodD0iMjAwIj48cmVjdCB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjE1MCIgeT0iMTAwIiBzdHlsZT0iZmlsbDojYWFhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjE5cHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+MzAweDIwMDwvdGV4dD48L3N2Zz4=" style="width: 100%; height: 150px;">
                    </div>
                    <h2><a href="#">Không có gì hết ngoài test</a></h2>
                    <div class="gia">
                        Giá: 320.000 
                    </div>
                    <div class="giakm">
                        Giá:<span>300.000</span>đ
                    </div>
                </div>
                <div class="item-same">
                    <div class="img-same">
                        <img data-src="holder.js/215x150" alt="215x150" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMDAiIGhlaWdodD0iMjAwIj48cmVjdCB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjE1MCIgeT0iMTAwIiBzdHlsZT0iZmlsbDojYWFhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjE5cHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+MzAweDIwMDwvdGV4dD48L3N2Zz4=" style="width: 100%; height: 150px;">
                    </div>
                    <h2><a href="#">Không có gì hết ngoài test</a></h2>
                    <div class="gia">
                        Giá: 320.000 
                    </div>
                    <div class="giakm">
                        Giá:<span>300.000</span>đ
                    </div>
                </div>
                <div class="item-same">
                    <div class="img-same">
                        <img data-src="holder.js/215x150" alt="215x150" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMDAiIGhlaWdodD0iMjAwIj48cmVjdCB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjE1MCIgeT0iMTAwIiBzdHlsZT0iZmlsbDojYWFhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjE5cHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+MzAweDIwMDwvdGV4dD48L3N2Zz4=" style="width: 100%; height: 150px;">
                    </div>
                    <h2><a href="#">Không có gì hết ngoài test</a></h2>
                    <div class="gia">
                        Giá: 320.000 
                    </div>
                    <div class="giakm">
                        Giá:<span>300.000</span>đ
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection