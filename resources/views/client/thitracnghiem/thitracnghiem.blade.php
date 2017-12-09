
@extends('client.layouts.master')

@section('content')
<div class="examonline">
    <div class="sup-nav">
        <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a> <i class="fa fa-angle-double-right"></i>
        <a href="thi-trac-nghiem.html">Thi trắc nghiệm trực tuyến</a> 
    </div>
    <div class="exam-left">
        @include('client.layouts.left')
    </div>
    <div class="exam-right">
        <div class="title">Thi trắc nghiệm trực tuyến</div>
        <div class="exem-item">
            <h3>Tài liệu môn lập trình c#</h3>
            <div class="img-item">
                <img data-src="holder.js/300x200" alt="300x200" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMDAiIGhlaWdodD0iMjAwIj48cmVjdCB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjE1MCIgeT0iMTAwIiBzdHlsZT0iZmlsbDojYWFhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjE5cHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+MzAweDIwMDwvdGV4dD48L3N2Zz4=" style="width: 200px; height: 150px;">
            </div>
            <div class="conten">
                <p>22/07/2016</p>
                <p>Tên giao viên: <span>Kim</span></p>
                <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh.</p>
            </div>
            <button type="button" class="btn btn-primary btn-xs">Toán</button>
            <button type="button" class="btn btn-primary btn-xs">Lớp 10</button>
            <div class="clear"></div>
            <span>Thời gian làm bài: 120 Phút</span>
            <div class="xemthem"><a class="btn btn-default" href="#" role="button">Chi tiết</a></div>
        </div>
        <div class="exem-item">
            <h3>Tài liệu môn lập trình php</h3>
            <div class="img-item">
                <img data-src="holder.js/300x200" alt="300x200" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMDAiIGhlaWdodD0iMjAwIj48cmVjdCB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjE1MCIgeT0iMTAwIiBzdHlsZT0iZmlsbDojYWFhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjE5cHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+MzAweDIwMDwvdGV4dD48L3N2Zz4=" style="width: 200px; height: 150px;">
            </div>
            <div class="conten">
                <p>22/07/2016</p>
                <p>Tên giao viên: <span>Kim</span></p>
                <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh.</p>
            </div>
            <button type="button" class="btn btn-primary btn-xs">Toán</button>
            <button type="button" class="btn btn-primary btn-xs">Lớp 10</button>
            <div class="clear"></div>
            <span>Thời gian làm bài: 120 Phút</span>
            <div class="xemthem"><a class="btn btn-default" href="#" role="button">Chi tiết</a></div>
        </div>
        <div class="exem-item">
            <h3>Tài liệu môn lập trình Java</h3>
            <div class="img-item">
                <img data-src="holder.js/300x200" alt="300x200" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMDAiIGhlaWdodD0iMjAwIj48cmVjdCB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjE1MCIgeT0iMTAwIiBzdHlsZT0iZmlsbDojYWFhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjE5cHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+MzAweDIwMDwvdGV4dD48L3N2Zz4=" style="width: 200px; height: 150px;">
            </div>
            <div class="conten">
                <p>22/07/2016</p>
                <p>Tên giao viên: <span>Kim</span></p>
                <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh.</p>
            </div>
            <button type="button" class="btn btn-primary btn-xs">Toán</button>
            <button type="button" class="btn btn-primary btn-xs">Lớp 10</button>
            <div class="clear"></div>
            <span>Thời gian làm bài: 120 Phút</span>
            <div class="xemthem"><a class="btn btn-default" href="#" role="button">Chi tiết</a></div>
        </div>
        <div class="exem-item">
            <h3>Tài liệu môn lập trình .net</h3>
            <div class="img-item">
                <img data-src="holder.js/300x200" alt="300x200" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMDAiIGhlaWdodD0iMjAwIj48cmVjdCB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjE1MCIgeT0iMTAwIiBzdHlsZT0iZmlsbDojYWFhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjE5cHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+MzAweDIwMDwvdGV4dD48L3N2Zz4=" style="width: 200px; height: 150px;">
            </div>
            <div class="conten">
                <p>22/07/2016</p>
                <p>Tên giao viên: <span>Kim</span></p>
                <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh.</p>
            </div>
            <button type="button" class="btn btn-primary btn-xs">Toán</button>
            <button type="button" class="btn btn-primary btn-xs">Lớp 10</button>
            <div class="clear"></div>
            <span>Thời gian làm bài: 120 Phút</span>
            <div class="xemthem"><a class="btn btn-default" href="#" role="button">Chi tiết</a></div>
        </div>
        <div class="exem-item">
            <h3>Tài liệu môn lập trình jquery</h3>
            <div class="img-item">
                <img data-src="holder.js/300x200" alt="300x200" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMDAiIGhlaWdodD0iMjAwIj48cmVjdCB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjE1MCIgeT0iMTAwIiBzdHlsZT0iZmlsbDojYWFhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjE5cHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+MzAweDIwMDwvdGV4dD48L3N2Zz4=" style="width: 200px; height: 150px;">
            </div>
            <div class="conten">
                <p>22/07/2016</p>
                <p>Tên giao viên: <span>Kim</span></p>
                <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh.</p>
            </div>
            <button type="button" class="btn btn-primary btn-xs">Toán</button>
            <button type="button" class="btn btn-primary btn-xs">Lớp 10</button>
            <div class="clear"></div>
            <span>Thời gian làm bài: 120 Phút</span>
            <div class="xemthem"><a class="btn btn-default" href="#" role="button">Chi tiết</a></div>
        </div>
        <div class="exem-item">
            <h3>Tài liệu môn lập trình laravel</h3>
            <div class="img-item">
                <img data-src="holder.js/300x200" alt="300x200" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMDAiIGhlaWdodD0iMjAwIj48cmVjdCB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjE1MCIgeT0iMTAwIiBzdHlsZT0iZmlsbDojYWFhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjE5cHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+MzAweDIwMDwvdGV4dD48L3N2Zz4=" style="width: 200px; height: 150px;">
            </div>
            <div class="conten">
                <p>22/07/2016</p>
                <p>Tên giao viên: <span>Kim</span></p>
                <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh.</p>
            </div>
            <button type="button" class="btn btn-primary btn-xs">Toán</button>
            <button type="button" class="btn btn-primary btn-xs">Lớp 10</button>
            <div class="clear"></div>
            <span>Thời gian làm bài: 120 Phút</span>
            <div class="xemthem"><a class="btn btn-default" href="#" role="button">Chi tiết</a></div>
        </div>
        <ul class="pagination">
                    <li><a href="#">&laquo;</a></li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">&raquo;</a></li>
                </ul>
    </div>
</div>
@endsection