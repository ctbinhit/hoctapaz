@push('stylesheet')
<style type="text/css">
    .JSExamController-question-ul{
        width: 100%;
        height: 500px;
        overflow-y: scroll;
        list-style: none;
        border: 1px solid #333;

    }
    .JSExamController-question-li{
        width: 100%;
    }
    .JSExamController-question-li div{
        margin: 2px 0px;
    }
    .JSExamController-question-li input[type="radio"]{

    }
</style>
@endpush
@push('scripts')
<script>
    // ===== Created By Bình Cao | 0964 247 742 | info@binhcao.com =====================================================
    $(document).ready(function () {
        var JSExamController = {
            QCCreated: {{isset($item)?'true':'false'}},
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
                            title: '{{__("label.canhbao")}}',
                            content: '{{__("schools.thoigianthichiduocnhapsonguyenduong")}}',
                        });
                        return;
                    }

                    if (JSExamController.QCCreated == true) {

                    } else {
                        $.alert({
                            title: '{{__("label.canhbao")}}',
                            content: '{{__("schools.vuilongthietlapdayduthongtintruockhiluu")}}',
                        });
                        e.preventDefault();
                    }
                });

                // Cate1 selected change

                $(JSExamController.elements.select.cate1).on('change', function () {
                    if ($(this).val() != -1) {
                        $.ajax({
                            url: '{{route("pi_exam_ajax")}}',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            beforeSend: function (xhr) {
                                $('#label_id_category_lv2').html('<i class="fa fa-refresh faa-spin animated"></i>');
                            },
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                action: 'loadCate2',
                                id: $(JSExamController.elements.select.cate1).val()
                            }, success: function (data) {
                                if (data.result == true && data.data != null) {
                                    var str = '';
                                    $.each(data.data, function (k, v) {
                                        str += '<option value="' + v.id + '">' + v.name + '</option>';
                                    });
                                    $(JSExamController.elements.select.cate2).html(str);
                                }


                            }
                            , error: function (data) {
                                console.log(data);
                            }, complete: function (jqXHR, textStatus) {
                                $('#label_id_category_lv2').html('');
                            }
                        });
                    } else {
                        $(JSExamController.elements.select.cate2).html('');
                    }
                });


                $(JSExamController.elements.button.qc_add).on('click', function () {

                    $QCV = JSExamController.require.QC();
                    if ($QCV > 0) {
                        if (JSExamController.QCCreated == true) {
                            $.confirm({
                                title: '{{__("label.canhbao")}}!',
                                content: '{{__("schools.bandataodanhsachcauhoitruocdo")}}?',
                                buttons: {
                                    '{{__("label.tieptuc")}}': function () {
                                        JSExamController.create.qc();
                                    },
                                    '{{__("label.huybo")}}': function () {
                                        return;
                                    }
                                }
                            });
                        } else {
                            JSExamController.create.qc();
                        }
                    } else {
                        $.alert({
                            title: '{{__("label.canhbao")}}',
                            content: '{{__("schools.soluongcauhoichiduocnhapsonguyenduongvalonhon0")}}'
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