
@extends('client.layouts.master')

@section('content')
<div class="examonline">
    <div class="sup-nav">
        <a href="{{route('client_index')}}"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a> <i class="fa fa-angle-double-right"></i>
        <a href="{{route('client_exam_phongthi')}}">Phòng thi</a> <i class="fa fa-angle-double-right"></i>
        <a href="javascript:;">{{$redirect->exam_data->name or 'undefined'}}</a>
    </div>
    <div class="div">
        <div class="row">
            <div class="col-md-8">
                <div class="page-header">
                    <h1 class="text-info"><i class="fa fa-check-square-o"></i> Đề thi <small>{{$redirect->exam_data->name}}</small></h1>
                    <h6 class="text-info"><i class="fa fa-calendar"></i> Thời gian diễn ra: 
                        <b>{{(new Carbon\Carbon($redirect->exam_data->start_date))->format('d-m-Y h:i:s A')}}</b> đến 
                        <b>{{(new Carbon\Carbon($redirect->exam_data->expiry_date))->format('d-m-Y h:i:s A')}}</b>
                    </h6>
                </div>

                <div>
                    {!!$redirect->exam_data->description!!}
                </div>
                <div>
                    <div data-width="100%" class="fb-comments" data-href="{{url()->full()}}" data-numposts="5"></div>
                </div>
            </div>
            <div class="col-md-4">
                <form onsubmit="return false;" action="{{route('client_exam_ajaxV2')}}" class="jquery-exam-payment">
                    <table class="table table-hover">
                        {{ csrf_field() }}
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center text-info">Thông tin thanh toán</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-success">
                                <td>Thí sinh:</td>
                                <td><b>{{$redirect->user_data->fullname}}</b></td>
                            </tr>
                            <tr>
                                <td>Phí dự thi:</td>
                                <td>{{number_format($redirect->exam_data->price,0)}} VNĐ</td>
                            </tr>
                            <tr>
                                <td>Số dư</td>
                                <td>{{number_format($redirect->user_data->coin,0)}} VNĐ</td>
                            </tr>
                            <tr>
                                <td>Số dư còn lại</td>
                                <td>{{number_format($redirect->user_data->coin - $redirect->exam_data->price,0)}} VNĐ</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">
                                    @if($redirect->user_data->lock_date==null)
                                    <a href="{{route('client_index')}}" class="btn btn-default"><i class="fa fa-home"></i> Trang chủ</a>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> <span>Thanh toán</span></button>
                                    @else
                                    <p class="alert alert-warning"><i class="fa fa-warning"></i> Tài khoản của bạn đang tạm khóa, không thể tham gia dự thi.</p>
                                    @endif
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </form>

                <div class="panel panel-success hidden">
                    <div class="panel-heading">Khởi tạo dữ liệu bài thi</div>
                    <div class="panel-body">
                        <form onsubmit="return false;" action="{{route('client_exam_ajaxV2')}}" class="jquery-exam-payment">
                            {{ csrf_field() }}
                            <input type="hidden" name="erm_id" id="erm_id" value="{{$erm->id}}" />
                            <p>Đề thi: <strong>{{$redirect->exam_data->name}}</strong></p>
                            <p>Số dư: <strong>{{number_format($redirect->user_data->coin,0)}}</strong> VNĐ</p>
                            <p>Số tiền cần thanh toán: <strong>{{number_format($redirect->exam_data->price,0)}}</strong> VNĐ</p> <hr>
                            <p>Số dư còn lại sau thanh toán: <strong>{{number_format($redirect->user_data->coin - $redirect->exam_data->price,0)}}</strong> VNĐ</p>
                            <a href="{{route('client_index')}}" class="btn btn-default"><i class="fa fa-home"></i> Trang chủ</a>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> <span>Thanh toán</span></button>
                        </form>
                    </div>
                    <div class="panel-footer">
                        <h6 class="text-info">Sản phẩm của ToanNang Co., Ltd</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection