
@extends('client.layouts.master')
@include('client.thitracnghiem.jsc.JSExamController')
@section('content')
<input type="hidden" id="erm_id" name="erm_id" value="{{$item->id}}" />
<input type="hidden" id="client_exam_ajaxV2" name="client_exam_ajaxV2" value="{{route('client_exam_ajaxV2')}}" />
<div class="examonline">
    <div class="sup-nav">
        <a href="{{route('client_index')}}"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a> <i class="fa fa-angle-double-right"></i>
        <a href="javascript:;">Phòng thi</a> <i class="fa fa-angle-double-right"></i>
        <a href="javascript:;">{{$item->name}}</a>
    </div>
    <div class="detail-left">
        <div class="content-top">
            <h2>Thi trắc nghiệm trực tuyến {{$item->name}}</h2>
            <p><span>Ngay đăng:</span>{{$item->created_at}}</p>
            <p><span>Thời gian thi:</span>{{number_format($item->time/60,1)}} phút</p>
            <p><span>Số câu:</span>{{count($app_data->data)}} câu</p>
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
                        <p>Họ và tên: <span>{{$item->user_fullname}}</span></p> <br>

                        <p>Số điểm: <span class="jquery-cec-score"><i class="fa fa-spinner faa-spin animated"></i></span></p> <br>

                        <p>Thời gian thi: <span class="jquery-cec-time"><i class="fa fa-spinner faa-spin animated"></i></span>s</p> <br>

                        @if(@$item->address!=null)
                        <p>Địa chỉ: <span>{{$user_data->address}}</span></p> <br>
                        @endif

                        <p>Kết quả của bạn đã được lưu vào hệ thống.</p>

                        <a href="{{route('client_exam_phongthi')}}" class="btn btn-default">
                            <i class="fa fa-arrow-left"></i> Quay lại phòng thi</a>

                    </div>

                </div>


            </div>




        </div>

        <br>
        <div class="tag">
            <span>Từ khóa:</span>
            <i class="label label-info">{{$item->seo_keywords}}</i>
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
            <div class="pan-exam-top-score">
                @foreach($chart_top_score as $k=>$v)
                <div class="ets-item">
                    <div class="ets-item-photo">
                        <img src="data:image/jpeg;base64,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" />
                    </div>
                    <div class="ets-item-detail">
                        <ul>
                            <li><i class="fa fa-star faa-flash animated"></i> {{@$v->fullname}}</li>
                            <li><i class="fa fa-check-square-o"></i>: <span>{{$v->score}} Điểm</span></li>
                            <li><i class="fa fa-clock-o"></i>: <span>{{number_format(($v->time-$v->time_end)/60,2)}} phút</span></li>
                        </ul>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(window).bind('beforeunload', function () {
        alert(123);
        return 'Đảm bảo mọi thứ đã được lưu trước khi rời khỏi trang này!';
    });
</script>
@endpush

@push('stylesheet')
<link rel="stylesheet" href="{{asset('public/client/css/app.phongthi.css')}}"/>
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

