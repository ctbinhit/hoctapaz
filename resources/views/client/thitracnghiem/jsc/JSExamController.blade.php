@php

$TMP_EXAM_ID = $item->id;

@endphp
@push('scripts')
<script>
    function secondsTimeSpanToHMS(s) {
    var h = Math.floor(s/3600); //Get whole hours
    s -= h*3600;
    var m = Math.floor(s/60); //Get remaining minutes
    s -= m*60;
    return h+":"+(m < 10 ? '0'+m : m)+":"+(s < 10 ? '0'+s : s); //zero padding on minutes and seconds
}
    $(document).ready(function () {
        var CEC = {
            error: {
                status: false,
                message: null
            },
            timer: null,
            elements: {
                parent: null,
                overflow: '#jquery-cec-overflow',
                overflow_result: '.jquery-cec-overflow-result',
                exam: {
                    info: {
                        time: {
                            count_down: '.jquery-cec-timecountdown'
                        }
                    },
                    pan_check: '#jquery-cec-panCheck',
                    document: '#jquery-cec-doc-viewer',
                    start: '#jquery-cec-exam-start',
                    end: '#jquery-cec-exam-end',
                    body: '#jquery-cec-exam-body',
                    radio: '.jquery-cec-radio',
                    radio_checked : '.jquery-cec-radio-checked',
                    result: {
                        socaudung: '.jquery-cec-socaudung',
                        tongsocau: '.jquery-cec-tongsocau',
                        diem: '.jquery-cec-score',
                        tgthi: '.jquery-cec-time'
                    }
                }
            },
            info: {
                state: 0,
                questions: [],
                exam_code : null,
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
                end: function () {
                    // Che 
                    $(CEC.elements.overflow_result).animate({
                        top: 0
                    }, 500, function () {
                        // Animation complete
                    });
                    // Tắt timer
                    clearInterval(CEC.timer);
                    // Off sự kiện click tất cả radio button
                    CEC.deactiveEvent.radio();
                    var qchecked = [];
                    var radio_checked = $(CEC.elements.exam.radio+'.jquery-cec-radio-checked');
                     $.each(radio_checked, function (k, v) {
                         var qc = $(v).data('id');
                         var qv = $(v).data('val');
                         qchecked.push([qc,qv]);
                     });
                    data = {
                        action: 'exam_end',
                        data: qchecked,
                        time: CEC.info.timecountdown,
                        exam_code: CEC.info.exam_code,
                        
                    };
                    //console.log(r);
                    $.ajax({
                        url: '{!!$client_exam_ajax!!}',
                        type: 'POST',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function (xhr) {
                            
                        },
                        data: data, 
                        success: function (data) {
                            console.log(data);
                            console.log(data.status);
                            setTimeout(function(){
                                if(data.status==true){
                                    $(CEC.elements.exam.result.socaudung).html(data.data.socaudung);
                                    $(CEC.elements.exam.result.tongsocau).html(data.data.tongsocau);
                                    $(CEC.elements.exam.result.diem).html(data.data.score);
                                    $(CEC.elements.exam.result.tgthi).html(data.data.tongthoigianlambai);
                                }
                            },0);
                        }, error: function (data) {
                            console.log(data);
                        }
                    });
                },
                start: function ($pId, $pButton) {
                    if (!CEC.checker.check) {
                        return false;
                    }
                    $.ajax({
                        url: '{!!$client_exam_ajax!!}',
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
                            id: {{$TMP_EXAM_ID}}
                        }, success: function (data, status) {
                            console.log(data);
                            if (data.status == false) {
                                CEC.error.message = "Có lỗi xảy ra trong quá trình tải dữ liệu.";
                            } else {
                                if(data.exam_code!=null){
                                      CEC.info.exam_code = data.exam_code;
                                      CEC.error.status = true;
                                        CEC.info.timecountdown = data.exam.time;
                                        // SHOW DOCUMENT
                                        $(CEC.elements.exam.document).html('<embed src="' + data.exam.file_pdf + '" />');
                                        var str = '';
                                        $.each(data.exam_detail,function(k,v){
                                            var tmp_c = k+1;
                                            CEC.info.questions.push('jquery-cec-question-'+tmp_c);
                                            str+= '<div class="jquery-cec-question">';
                                            str+= '<span>Câu '+tmp_c+':</span>';
                                            str+= '<button class="jquery-cec-radio" data-id="'+ tmp_c +'" data-val="1" type="button">A</button>';
                                            str+= '<button class="jquery-cec-radio" data-id="'+ tmp_c +'" data-val="2" type="button">B</button>';
                                            str+= '<button class="jquery-cec-radio" data-id="'+ tmp_c +'" data-val="3" type="button">C</button>';
                                            str+= '<button class="jquery-cec-radio" data-id="'+ tmp_c +'" data-val="4" type="button">D</button>';
                                            str+= '</div>';
                                        });
                                        $(CEC.elements.exam.pan_check).html(str);
                                        CEC.registerEvent.radio();
                                }else{
                                    CEC.error.message = "Có lỗi xảy ra trong quá trình tải dữ liệu.";
                                }
                              
                            }


                        }, error: function (data) {
                            //console.log(data.responseText);
                        }, complete: function (jqXHR, textStatus) {
                            // Nếu error = false => run
                            if (CEC.error.status==true) {
                                CEC.display.overflow(false);
                                CEC.info.state = 1;
                                CEC.timer = setInterval(function () {
                                    CEC.listen.running();
                                }, 1 * 1000);
                            } else {
                                
                            }
                        }
                    });
                    // END Exam->start
                }
            },
            
            listen: {
                running: function () {
                    console.log(CEC.info.timecountdown);
                    if (CEC.info.state == 1 && CEC.info.timecountdown > 0) {
                        CEC.info.timecountdown--;
                    }
                  
                    
                    $(CEC.elements.exam.info.time.count_down).html(secondsTimeSpanToHMS(CEC.info.timecountdown));
                    if (CEC.info.timecountdown == 0) {
                        CEC.exam.end();

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
            update: {
                exam: {
                    timecountdown: function () {

                    }
                }
            },
            registerEvent: {
                button: function () {
                    // START
                    $(CEC.elements.exam.start).on('click', function () {
                        console.log('Button start exam clicked');
                        CEC.exam.start({{$TMP_EXAM_ID}}, this);
                    });

                    $(CEC.elements.exam.end).on('click', function () {
                        console.log('Button end exam clicked');
                        var tongcau = $('.jquery-cec-question').length;
                        var radio_checked = $(CEC.elements.exam.radio+'.jquery-cec-radio-checked').length;
                        if(radio_checked<tongcau){
                            $.confirm({
                                title: 'Lưu ý!',
                                content: 'Tổng số câu hỏi là ' + tongcau + ', số câu chọn là ' + radio_checked + '! Bạn có muốn kết thúc bài thi?',
                                buttons: {
                                    confirm: {
                                        text: 'Nộp bài ngay',
                                        btnClass: 'btn btn-warning',
                                        action: function(){
                                            CEC.exam.end();
                                        }
                                    },
                                    cancel: {
                                        text: 'Tiếp tục bài thi',
                                        btnClass: 'btn btn-default',
                                        action: function(){
                                        }
                                    }
                                }
                            });
                        }else{
                            $.confirm({
                                title: 'Thông báo',
                                content: 'Bạn có chắc là muốn kết thúc bài thi?',
                                buttons: {
                                    confirm: {
                                        text: 'Có, tôi đã làm xong',
                                        btnClass: 'btn btn-warning',
                                        action: function(){
                                            CEC.exam.end();
                                        }
                                    },
                                    cancel: {
                                        text: 'Tiếp tục bài thi',
                                        btnClass: 'btn btn-default',
                                        action: function(){
                                        }
                                    }
                                }
                            });
                        }
                        return;
                        
                    });
                    
                    
                },
                radio: function(){
                    $(CEC.elements.exam.radio).on('click',function(){
                        $(this).parents('.jquery-cec-question')
                                .find('button').removeClass('jquery-cec-radio-checked');
                        $(this).addClass('jquery-cec-radio-checked');
                    });
                }
            },
            deactiveEvent: {
                radio: function(){
                    $(CEC.elements.exam.radio).off('click');
                }
            }
        };

        CEC.init('#jquery-app-exam');
    });
</script>
@endpush