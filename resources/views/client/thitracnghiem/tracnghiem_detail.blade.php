
@extends('client.layouts.master')
@include('client.thitracnghiem.jsc.JSExamController')
@section('content')



<div class="examonline">
    <div class="sup-nav">
        <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a> <i class="fa fa-angle-double-right"></i>
        <a href="thi-trac-nghiem.html">Thi online</a> <i class="fa fa-angle-double-right"></i>
        <a href="">{{$item->name}}</a>
    </div>
    <div class="detail-left">
        <div class="content-top">
            <h2>Thi trắc nghiệm trực tuyến {{$item->name}}</h2>
            <p><span>Ngay đăng:</span>{{$item->created_at}}</p>
            <p><span>Thời gian thi:</span>{{number_format($item->time/60,1)}} phút</p>
            <p><span>Số câu:</span>50 câu</p>
            <div class="clear"></div>

            <div id="jquery-app-exam">

                <div class="jquery-cec-doc-viewer" id="jquery-cec-doc-viewer">
                    <!--                    <embed src="http://toannang.dev/doc/eyJpdiI6IitPeWlIM1dMK052WXhwMXFmZjFyOHc9PSIsInZhbHVlIjoidnYyRXRndndTQmdtcUo0ZzAzblwvblNTbjlpT3YyQ2xlc2Y1ZDBEMGhRMUZjc3U0cU0yNFJneTFMMlwvamFIRCtZblpWeGFSMksyVEtBSVV4c2ptZCtodz09IiwibWFjIjoiOGVlNWQwYjMyYmJmYzU0MGQzMGRiMmU0NzFiNzlhM2RjZTkzOWE4NGQwMGZiODM3NTRkYWJmZDNiN2UyYzliOSJ9" />
                    -->
                </div>

                <!-- Button -->
                <div class="jquery-exam-pan-bottom-left">
                    <button id="jquery-cec-exam-end" class="btn btn-success btn-xs"><i class="fa fa-play-circle-o"></i> Nộp bài</button>
                </div>

                <!-- INFO -->
                <div class="jquery-cec-timecountdown-style">
                    Thời gian còn lại <span class="jquery-cec-timecountdown">{{$item->time}}</span>
                </div>

                <!-- Overflow -->
                <div id="jquery-cec-overflow" class="jquery-cec-overflow">
                    <div class="pan">
                        <h2>HOCTAPAZ.COM</h2>
                        <p>{{$item->name}}</p> <br>
                        <p>Thời gian thi: {{number_format($item->time/60,1)}} phút</p>
                        <p><strong>Lưu ý:</strong> Hãy đảm bảo rằng kết nối của bạn ổn định trước khi làm bài để tránh trường hợp đáng tiếc xảy ra trong quá trình thi.</p>
                        <p>Chúc bạn thi tốt <i class="fa fa-thumbs-up"></i></p>
                        <hr>
                        <button type="button" id="jquery-cec-exam-start" class="btn btn-primary">Bắt đầu thi <i class="fa fa-play-circle"></i></button>
                    </div>
                    <div id="license">Developed by ToanNang Co., Ltd</div>
                </div>

                <div class="jquery-cec-overflow-result">

                    <div class="pan">
                        <h3 style="color: #FFF;">Kết quả: 
                            <span class="jquery-cec-socaudung"><i class="fa fa-spinner faa-spin animated"></i></span>/<span class="jquery-cec-tongsocau"><i class="fa fa-spinner faa-spin animated"></i></span> câu</h3>

                        <hr>
                        <p>Họ và tên: <span>{{$user_data->fullname}}</span></p> <br>

                        <p>Số điểm: <span class="jquery-cec-score"><i class="fa fa-spinner faa-spin animated"></i></span></p> <br>

                        <p>Thời gian thi: <span class="jquery-cec-time"><i class="fa fa-spinner faa-spin animated"></i></span>s</p> <br>

                        @if($user_data->address!=null)
                        <p>Địa chỉ: <span>{{$user_data->address}}</span></p> <br>
                        @endif

                        <p>Kết quả của bạn đã được lưu vào hệ thống.</p>

                        <a href="{{route('client_exam_phongthi')}}" class="btn btn-default">
                            <i class="fa fa-arrow-left"></i> Quay lại phòng thi</a>

                    </div>

                </div>


            </div>


            <hr>
            <button type="button" class="btn btn-primary btn-xs">Toán</button>
            <button type="button" class="btn btn-primary btn-xs">Lớp 10</button>


        </div>

        <br>
        <div class="tag">
            <span>Từ khóa:</span>
            @if(count($item->seo_keywords)!=0)
            @foreach($item->seo_keywords as $k => $v)
            <a class="btn btn-default btn-xs" href="javascript:void(0)" role="button">{{$v}}</a>
            @endforeach
            @endif
        </div>
        <br>
        <!--        <div class="other">
                    <h4>Các đề thi khác:</h4>
                    <p><a href="#">Đề thi chính thức môn toán - mã đề 06</a></p>
                    <p><a href="#">Đề thi chính thức môn hóa - mã đề 060</a></p>
                    <p><a href="#">Đề thi chính thức môn lập trình php- mã đề 705</a></p>
                    <p><a href="#">Đề thi chính thức môn toán - mã đề 046</a></p>
                    <p><a href="#">Đề thi chính thức môn toán - mã đề 056</a></p>
                    <p><a href="#">Đề thi chính thức môn toán - mã đề 536</a></p>
                    <p><a href="#">Đề thi chính thức môn toán - mã đề 036</a></p>
        
                </div>-->
    </div>
    <div class="detail-right">
        <h4 style="margin-top: 0px;text-align: center;" class=""><i class="fa fa-check-square-o"></i> Bảng trắc nghiệm</h4>
        <div class="jquery-cec-panCheck" id="jquery-cec-panCheck">
            <p class="alert alert-info"><i class="fa fa-check-square"></i> Bảng trắc nghiệm câu hỏi sẽ được hiển thị tại đây sau khi bạn nhấn nút <b>bắt đầu thi</b>.</p>
            <p class="alert alert-warning"><i class="fa fa-warning"></i> Vui lòng kiểm tra kết nối mạng ổn định trước khi làm bài để tránh những trường hợp đáng tiếc xảy ra.</p>
            <p class="alert alert-success"><i class="fa fa-check"></i> Chúc bạn làm bài tốt.</p>
 <!--           <div class="jquery-cec-question"><span>Câu 1:</span>
                <button class="jquery-cec-radio" data-id="1" type="button" disabled="">A</button>
                <button class="jquery-cec-radio jquery-cec-radio-checked" data-id="1" type="button">B</button>
                <button class="jquery-cec-radio" data-id="1" type="button">C</button>
                <button class="jquery-cec-radio" data-id="1" type="button">D</button>
            </div>-->
        </div>
        
        <div class="exam-top-charts">
            <h4 class="text-center text-success"><i class="fa fa-line-chart"></i> Bảng xếp hạng</h4>
        </div>
    </div>
</div>
@endsection

@push('stylesheet')
<style>
    #jquery-app-exam{
        width: 100%;height:450px;
        position:relative;
        background: #CCC;
        overflow: hidden;
    }

    #jquery-app-exam .jquery-exam-pan-bottom-left{
        position: absolute;bottom: 5px;left: 5px;
        padding: 5px;font-size: 8pt;color:#FFF;
    }

    #jquery-app-exam .jquery-exam-pan-bottom-left button{
        font-size: 20pt;
        padding: 5px 20px;
    }

    #jquery-app-exam .jquery-cec-timecountdown-style{
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: #0082ac;
            padding: 5px 10px;
            font-size: 13pt;
            color: #FFF;
    }
    #jquery-app-exam .jquery-cec-timecountdown-style span{
        font-weight: bold;color: #FFF;
    }

    #jquery-app-exam .jquery-cec-overflow-result{
        width: 100%;height: 100%;background: #0082ac;
        position: absolute;top: -100%;left: 0px; z-index: 100;
    }
    #jquery-app-exam .jquery-cec-overflow-result .pan{
        width: 440px;height: 300px;margin: 100px auto;position: relative;text-align: center;
    }
    #jquery-app-exam .jquery-cec-overflow-result .pan p{color:#FFF;}


    #jquery-app-exam .jquery-cec-overflow{
        width: 100%;height: 100%;background: #0082ac;
        position: absolute;top: 0px;left: 0px;
        background: #0b8342;
    }
    #jquery-app-exam .jquery-cec-overflow #license{position: absolute;bottom: 5px;left: 5px;color:#FFF;font-size: 7pt;}
    #jquery-app-exam .jquery-cec-overflow .pan strong{color:#c9302c;font-weight: bold;}
    #jquery-app-exam .jquery-cec-overflow .pan{
        width: 440px;height: 300px;margin: 40px auto;position: relative;text-align: center;
    }
    #jquery-app-exam .jquery-cec-overflow .pan h2{
        font-size: 20pt;color:#CCC;
    }
    #jquery-app-exam .jquery-cec-overflow .pan p{color:#FFF;}
    #jquery-app-exam .jquery-cec-overflow .jquery-cec-btn-start{

    }

    #jquery-app-exam .jquery-cec-doc-viewer{
        width: 100%;
    }
    #jquery-app-exam .jquery-cec-doc-viewer embed{
        width: 100%;
        height: 410px;
    }

    .jquery-cec-question{
        margin: 4px 0px;
    }

    .jquery-cec-radio-checked{
        background: #FF0 !important;
    }

    .jquery-cec-radio{
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background:#FFF;
        border: 1px solid #CCC;
        transition: 0.6s ease;
        margin: 0px 2px;
    }
    .jquery-cec-radio:hover{
        background: #FF0;
    }

    .jquery-cec-panCheck{
        max-height: 500px;
        overflow-x: scroll;
    }
</style>
@endpush

