
@extends('client.layouts.master')

@section('content')
<div class="examonline">
    <div class="sup-nav">
        <a href="{{route('client_index')}}"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a> <i class="fa fa-angle-double-right"></i>
        <a href="{{route('client_exam_phongthi')}}">Phòng thi</a> 
    </div>
    <div class="div">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                @if($redirect->paid==true && $redirect->state)
                <div class="panel panel-success">
                    <div class="panel-heading">Đề thi {{$erm->name}}</div>
                    <div class="panel-body">
                        <form action="" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="erm_id" value="{{$erm->id}}" />
                            <a href="{{route('client_index')}}" class="btn btn-default"><i class="fa fa-home"></i> Trang chủ</a> 
                            <button type="submit" class="btn btn-success"><i class="fa fa-sign-in"></i> Vào phòng thi</button>
                        </form>
                    </div>
                </div>
                @elseif($redirect->state && $redirect->paid==false)
                @include('client.phongthi.parts.erm_detail')
                @else
                <div class="panel panel-info">
                    <div class="panel-heading">{{$redirect->title}}</div>
                    <div class="panel-body">
                        @if($redirect->error_type=='chuadangnhap')
                        <p class="text-warning">Bạn chưa đăng nhập, vui lòng đăng nhập để tiếp tục thao tác.</p>
                        @include('client/components/form/signin',['action'=>route('_client_login_index'),'cwr'=> url()->full()])
                        @elseif($redirect->error_type=='naptien')
                        <p class="text-warning">Số tiền trong tài khoản của bạn không đủ để thực hiện giao dịch, vui lòng nạp thêm để tiếp tục thao tác</p>
                        <a href="{{route('client_index')}}" class="btn btn-default"><i class="fa fa-home"></i> Trang chủ</a>
                        <a href="{{route('mdle_bkp_napthe')}}" class="btn btn-primary"><i class="fa fa-credit-card"></i> <span>Nạp tiền</span></a>
                        @else
                        <p>{{$redirect->message}}</p>
                        @endif


                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>

</div>
@endsection
@push('scripts')
@if($redirect->state)
<script>
    $(document).ready(function () {
        var JEP = {
            debug: true,
            log: function (data) {
                if (JEP.debug) {
                    console.log(data);
                }
            },
            elements: {
                form: '.jquery-exam-payment'
            },
            init: function () {
                JEP.registerEvent();
            },
            state: {
                form_processing: function () {
                    $(JEP.elements.form).find('button[type="submit"]')
                            .find('span')
                            .html('Đang xử lý...')
                            .parent()
                            .find('i')
                            .removeClass('fa-check')
                            .addClass('fa-spinner faa-spin animated')
                            .attr('disabled', '');
                    $(JEP.elements.form).find('a').addClass('disabled');
                },
                form_default: function () {
                    $(JEP.elements.form).find('a').removeClass('disabled');
                    $(JEP.elements.form).find('button[type="submit"]')
                            .find('span')
                            .html('Thanh toán')
                            .parent()
                            .find('i')
                            .addClass('fa-check')
                            .removeClass('fa-spinner faa-spin animated')
                            .removeAttr('disabled');
                }
            },
            action: {
                paying: function () {
                    $.ajax({
                        url: $(JEP.elements.form).attr('action'),
                        type: 'POST',
                        dataType: 'json',
                        beforeSend: function (xhr) {
                            JEP.state.form_processing();
                        },
                        data: {
                            act: 'paying',
                            id_exam: $('#erm_id').val()
                        }, success: function (data) {
                            console.log(data);
                            $.alert({
                                title: 'Thông báo',
                                content: data.message,
                                buttons: {
                                    somethingElse: {
                                        text: 'OK',
                                        btnClass: 'btn btn-primary',
                                        action: function () {
                                            location.reload();
                                        }
                                    }
                                }
                            });
                        }, error: function (data) {
                            JEP.state.form_default();
                        }
                    });
                }
            },
            registerEvent: function () {

                $(JEP.elements.form).find('button[type="submit"]').on('click', function () {
                    JEP.action.paying();
                });

            }
        };
        JEP.init();
    });
</script>
@endif

@endpush
