@push('scripts')
<script>
    $(document).ready(function () {
        $('#jquery-bootstrap-drp-exam-date-range').daterangepicker({
            "showDropdowns": true,
            "timePicker": true,
            "timePicker24Hour": true,
            "alwaysShowCalendars": true,
            "startDate": "{{Carbon\Carbon::now()->format('m/d/Y')}}",
            "endDate": "{{Carbon\Carbon::now()->addDays(15)->format('m/d/Y')}}",
            "minDate": "{{Carbon\Carbon::now()->format('m/d/Y')}}"
        }, function (start, end, label) {
            $('#time_start').val(start.format('YYYY-MM-DD H:m:s'));
            $('#time_end').val(end.format('YYYY-MM-DD H:m:s'));
            $('#jquery-info-drp-exam-data-range').html("Thời gian bắt đầu: " + start.format('DD-MM-YYYY H:m:s') + " Thời gian kết thúc: " + end.format('DD-MM-YYYY H:m:s'));
        });
    });
</script>
<script>
    // ===== Created By Bình Cao | 0964 247 742 | info@binhcao.com =====================================================
    $(document).ready(function () {
        var JSExamController = {
            QCCreated: $('#QCCreated').val(),
            elements: {
                mainForm: null,
                select: {
                    cate1: '#id_category_lv1',
                    cate2: '#id_category_lv2'
                },
                input: {
                    qc: '#JSExamController-input-QC',
                    h: '#JSExamController-input-timeh',
                    m: '#JSExamController-input-timem',
                    s: '#JSExamController-input-times'
                },
                button: {
                    qc_add: '#JSExamController-button-QC-add'
                },
                pan: {
                    qc: '#JSExamController-pan-qc'
                }
            },
            init: function ($form) {
                JSExamController.elements.mainForm = $form;
                this.registerEvent();
                $('.qc_radio').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                    increaseArea: '20%' // optional
                });
            },
            require: {
                QC: function () {
                    $QCV = $(JSExamController.elements.input.qc).val();
                    if (parseInt($QCV) > 0) {
                        return parseInt($QCV);
                    } else {
                        return false;
                    }
                }
            },
            exists: {

            },
            create: {
                qc: function () {
                    $(JSExamController.elements.button.qc_add).html('<i class="fa fa-refresh faa-spin animated"></i> Đang tạo...');
                    $(JSExamController.elements.button.qc_add).attr('disabled', '');
                    var ul = '<ul class="JSExamController-question-ul">';
                    for (i = 1; i <= $QCV; i++) {
                        var li = "<li class='JSExamController-question-li'>Câu " + i + ": ";
                        li += '<div> A <input type="radio" class="qc_radio" name="question' + i + '" value="1" checked/></div>';
                        li += '<div> B <input type="radio" class="qc_radio" name="question' + i + '" value="2" /></div>';
                        li += '<div> C <input type="radio" class="qc_radio" name="question' + i + '" value="3" /></div>';
                        li += '<div> D <input type="radio" class="qc_radio" name="question' + i + '" value="4" /></div>';
                        li += '</li>';
                        ul += li;
                    }
                    ul += '</ul>';
                    setTimeout(function () {
                        $(JSExamController.elements.pan.qc).html('');
                        $(JSExamController.elements.pan.qc).append(ul);
                        $('.qc_radio').iCheck({
                            checkboxClass: 'icheckbox_square-green',
                            radioClass: 'iradio_square-green',
                            increaseArea: '20%' // optional
                        });
                        $(JSExamController.elements.button.qc_add).html('Tạo');
                        $(JSExamController.elements.button.qc_add).removeAttr('disabled');
                        JSExamController.QCCreated = true;
                    }, 1 * 1000);
                }
            },
            registerEvent: function () {
                // FORM SUBMIT
                $(JSExamController.elements.mainForm).on('submit', function (e) {
                    var h, m, s;
                    h = parseInt($(JSExamController.elements.input.h).val());
                    m = parseInt($(JSExamController.elements.input.m).val());
                    s = parseInt($(JSExamController.elements.input.s).val());
                    if (h < 0 || m < 0 || s < 0) {
                        e.preventDefault();
                        $.alert({
                            title: 'Lưu ý!',
                            content: 'Thời gian chỉ được nhập số nguyên dương!'
                        });
                        return;
                    }

                    if ($('#id_category').val() === -1) {
                        e.preventDefault();
                        $.alert({
                            title: 'Lưu ý!',
                            content: 'Vui lòng chọn danh mục cấp 1!'
                        });
                        $('#id_category_lv1').parents('.form-group').addClass('has-warning');
                        return;
                    } else {
                        $('#id_category_lv1').parents('.form-group').removeClass('has-warning');
                    }

                    var time_start = $('#time_start').val();
                    var time_end = $('#time_end').val();
                    if (time_start == '' || time_end === '') {
                        e.preventDefault();
                        $.alert({
                            title: 'Cảnh báo',
                            content: 'Vui lòng chọn thời gian diễn ra để xác định được ngày bắt đầu và ngày kết thúc.',
                        });
                        $('#jquery-bootstrap-drp-exam-date-range').click();
                        $('#jquery-bootstrap-drp-exam-date-range').parents('.form-group').addClass('has-warning');
                        return;
                    } else {
                        $('#jquery-bootstrap-drp-exam-date-range').parents('.form-group').removeClass('has-warning');
                    }

                    if (JSExamController.QCCreated == true) {

                    } else {
                        $.alert({
                            title: 'Lưu ý.',
                            content: 'Vui lòng thiết lập đầy đủ thông tin trước khi lưu.',
                        });
                        e.preventDefault();
                    }
                });

                $(JSExamController.elements.button.qc_add).on('click', function () {

                    $QCV = JSExamController.require.QC();
                    if ($QCV > 0) {
                        if (JSExamController.QCCreated == true) {
                            $.confirm({
                                title: 'Lưu ý!',
                                content: 'Bạn đã tạo danh sách câu hỏi trước đó?',
                                buttons: {
                                    'Tiếp tục': function () {
                                        JSExamController.create.qc();
                                    },
                                    'Hủy bỏ': function () {
                                        return;
                                    }
                                }
                            });
                        } else {
                            JSExamController.create.qc();
                        }
                    } else {
                        $.alert({
                            title: 'Lưu ý!',
                            content: 'Số lượng câu hỏi chỉ được nhập số nguyên dương và lớn hơn 0.'
                        });
                        $(JSExamController.elements.input.qc).val(10);
                    }
                });
            }


        };
        JSExamController.init('#frm_exam_add');
    });
</script>

@endpush