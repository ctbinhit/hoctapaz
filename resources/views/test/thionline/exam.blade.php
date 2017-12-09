<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
<link href="{!! asset('public/admin_assets/vendors/font-awesome/css/font-awesome-animation.min.css')!!}" rel="stylesheet">
 <meta name="csrf-token" content="{{ csrf_token() }}">
<!-- jQuery -->
<script src="{!! asset('public/admin_assets/vendors/jquery/dist/jquery.min.js')!!}"></script>
<script>
    /* =================================================================================================================
     |                                                  ToanNang Framework
     | -----------------------------------------------------------------------------------------------------------------
     |                                          Created by Bình Cao | (+84) 964 247 742
     | =================================================================================================================
     */
    $(document).ready(function () {
        var CEC = {
            timer: null,
            elements: {
                parent: null,
                overflow: '#jquery-cec-overflow',
                exam: {
                    info: {
                        time: {
                            count_down: '.jquery-cec-timecountdown'
                        }
                    },
                    document: '#jquery-cec-document',
                    start: '#jquery-cec-exam-start',
                    body: '#jquery-cec-exam-body',
                    radio: '.jquery-cec-question'
                }
            },
            info:{
                state: 0,
                questions: [],
                timecountdown: null
            },
            init: function ($pParent) {
                this.elements.parent = $pParent;
                this.registerEvent.button();
            },
            checker: {
                check: function () {
                    if (CEC.elements.parent == null) {
                        return false;
                    }
                    return true;
                }
            },
            exam: {
                end: function(){
                    $(CEC.elements.exam.radio).attr('disabled','');
                    var r = [];
                    $.each(CEC.info.questions,function(k,v){
                        var elementVal = $(CEC.elements.parent).find('input[name="'+v+'"]:checked').val();
                        if(typeof(elementVal) == 'undefined')
                            elementVal = -1;
                        r.push([v,elementVal]);
                    });
                    data = {
                        data : r,
                        time : CEC.info.timecountdown
                    };
                    console.log(r);
//                    $.ajax({
//                            url: '{{route("test_ajax")}}',
//                            headers: {
//                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                            },
//                            type: 'POST',
//                            dataType: 'json',
//                            beforeSend: function (xhr) {
//                                
//                            },
//                            data: {
//                                action: 'exam_end',
//                                data: {
//                                    
//                                }
//                            }, success: function (data,status) {
//                                console.log(data);
//                            }, error: function (data) {
//                                console.log(data.responseText);
//                            }, complete: function (jqXHR, textStatus) {
//
//                            }
//                    });
                    // END Exam->start
                },
                start: function ($pId,$pButton) {
                    if (!CEC.checker.check) {
                        return false;
                    }
                    $.ajax({
                            url: '{{route("test_ajax")}}',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                            dataType: 'json',
                            beforeSend: function (xhr) {
                                // Show loading...
                                $($pButton).find('i').removeClass('fa-sign-in')
                                        .addClass('fa-spinner faa-spin animated');
                            },
                            data: {
                                action: 'exam_start',
                                id: {{$item->id}}
                            }, success: function (data,status) {
                                console.log(data);
                                CEC.info.timecountdown = data.exam.time;
                                // SHOW DOCUMENT
                                $(CEC.elements.exam.document).html('<embed src="'+data.exam.file_pdf+'" />');
                                var str = '';
                                $.each(data.exam_detail,function(k,v){
                                    var tmp_c = k+1;
                                    CEC.info.questions.push('jquery-cec-question-'+tmp_c);
                                    str+= '<div class="jquery-cec-question">';
                                    str+= '<span>Câu '+tmp_c+':</span>';
                                    str+= 'A <input type="radio" name="jquery-cec-question-'+tmp_c+'" class="jquery-cec-question" value="1"/>';
                                    str+= 'B <input type="radio" name="jquery-cec-question-'+tmp_c+'" class="jquery-cec-question" value="2"/>';
                                    str+= 'C <input type="radio" name="jquery-cec-question-'+tmp_c+'" class="jquery-cec-question" value="3"/>';
                                    str+= 'D <input type="radio" name="jquery-cec-question-'+tmp_c+'" class="jquery-cec-question" value="4"/>';
                                    str+= '</div>';
                                });
                                $(CEC.elements.exam.body).html(str);
                            }, error: function (data) {
                                console.log(data.responseText);
                            }, complete: function (jqXHR, textStatus) {
                                CEC.display.overflow(false);
                                CEC.info.state = 1;
                                CEC.timer = setInterval(function(){
                                    CEC.listen.running();
                                },1*1000);
                            }
                    });
                    // END Exam->start
                }
            },
            listen: {
                running: function () {
                    console.log(CEC.info.timecountdown);
                    if(CEC.info.state==1 && CEC.info.timecountdown>0){
                        CEC.info.timecountdown--;
                    }
                    $(CEC.elements.exam.info.time.count_down).html(CEC.info.timecountdown);
                    if(CEC.info.timecountdown==0){
                        CEC.exam.end();
                        clearInterval(CEC.timer);
                    }
                }
            },
            display: {
                overflow: function ($pDisplay = true) {
                    if ($pDisplay)
                        $(CEC.elements.overflow).fadeIn();
                    else
                        $(CEC.elements.overflow).fadeOut();
                }
            },
            update:{
                exam:{
                    timecountdown: function(){
                        
                    }
                }
            },
            registerEvent: {
                button: function () {
                    // START
                    $(CEC.elements.exam.start).on('click', function () {
                        console.log('Button start exam clicked');
                        CEC.exam.start(14,this);


                    });


                }
            }
        };

        CEC.init('#jquery-exam-controller');

    });
</script>
<style>
    #jquery-cec-bg{
        position: relative;
    }
    #jquery-cec-bg #jquery-cec-overflow{
        position: absolute;width: calc(100% + 30px);height: 100%;background: #333;color:#FFF; z-index: 9999;
        text-align: center;
    }
    #jquery-cec-document embed{
        width: 100%;height: 100%;
    }
</style>

<div id="jquery-exam-controller" style="width: 1349px;margin: 0 auto;text-align: center;">
    <h2>{{$item->name}}</h2>
    <div class="panel panel-info">
        <div class="panel-heading"><b>{{$item->name}}</b></div>
        <div class="panel-body">
            <div id="jquery-cec-bg">
                <div class="row" style="height: 500px;">
                    <!-- OVERFLOW -->
                    <div id="jquery-cec-overflow">
                        <h1>{{$item->name}}</h1>
                        <h2>Giáo viên: {{$item->professor_name}}</h2>
                        <h3>Thời gian: {{$item->time / 60}} phút</h3>
                        <h3>Số câu hỏi: {{$item->qc}} câu</h3>
                        <button class="btn btn-info" id="jquery-cec-exam-start">Thi ngay <i class="fa fa-sign-in"></i></button>
                    </div>
                    <!-- END OVERFLOW -->
                    <div class="col-md-6">
                        <div id="jquery-cec-document" style="width: 100%;height: 100%;">
                            
                        </div>
                    </div>
                    <div class="col-md-6" style="border: 1px solid #000;height: 100%;">
                        <div style="width: calc(100 + 30px);background:#222;color:#FFF;padding: 10px 0px;margin: 0px -15px;">Phần trắc nghiệm</div>
                        <div id="jquery-cec-exam-body" style="overflow-y: scroll;height: 450px;">
                            <div class="jquery-cec-question">
                                <span>Câu 1:</span>
                                A <input type="radio" name="jquery-cec-question-1" class="jquery-cec-question" value="1"/>
                                B <input type="radio" name="jquery-cec-question-1" class="jquery-cec-question" value="2"/>
                                C <input type="radio" name="jquery-cec-question-1" class="jquery-cec-question" value="3"/>
                                D <input type="radio" name="jquery-cec-question-1" class="jquery-cec-question" value="4"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-md-1">
                    Thời gian: {{$item->time / 60}} phút
                </div>
                <div class="col-md-2">
                    Giáo viên: {{$item->professor_name}}
                </div>
                <div class="col-md-1">
                    Lượt xem: {{$item->views}}
                </div>
                <div class="col-md-3">
                    Từ khóa:
                    @foreach($item->seo_keywords as $k => $v)
                    <span style="background:#333;padding:2px 5px;border-radius: 4px;color:#FFF;">{{$v}}</span>
                    @endforeach
                </div>
                <div class="col-md-2">
                    Thời gian còn lại: <span class="jquery-cec-timecountdown">0</span> giây
                </div>
                <div class="col-md-1">
                    <a href="javascript:void(0)" class="btn btn-primary jquery-cec-exam-start">Nộp bài <i class="fa fa-sign-in"></i></a> 
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>