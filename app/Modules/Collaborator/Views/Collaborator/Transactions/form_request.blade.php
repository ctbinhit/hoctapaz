@extends('pi.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-edit"></i> Yêu cầu nạp/rút</h3>
        </div>
    </div>
    <div class="clearfix"></div

    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_content">
                    <a href="{{route('mdle_pi_collaborator_transactions')}}" class="btn btn-app"><i class="fa fa-arrow-left"></i> Quay lại</a>
                    <a href="{{route('admin_index')}}" class="btn btn-app"><i class="fa fa-dashboard"></i> Dashboard</a>
                    <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            @if(Session::has('html_callback'))
            <div class="alert alert-{{session('html_callback')['type']}}">
                <p><i class="fa fa-info"></i> {{session('html_callback')['message']}}</p>
            </div>
            @endif
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-edit"></i> Yêu cầu nạp rút <small> Tạo đơn yêu cầu nạp/rút số dư trong tài khoản.</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-md-10 col-md-offset-2">
                        <div class="alert alert-info">
                            <p>Chỉ có thể yêu cầu rút tiền khi tài khoản đã cập nhật số TK ngân hàng, những đơn yêu cầu của những tài khoản chưa 
                                cập nhật số TK ngân hàng sẽ được đưa vào trạng thái <i class="label label-warning">Pending</i></p>
                        </div>
                    </div>
                    <form action="" method="post" class="form form-horizontal">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="nameOfTheInput" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Loại yêu cầu:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                <select name="request_type" class="form-control">
                                    <option value="ycr">Rút</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nameOfTheInput" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Số dư khả dụng:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                <input type="text" 
                                       class="form-control" placeholder="Số dư khả dụng" value="{{number_format($sodukhadung,0)}} VNĐ" disabled=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="amount" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Số lượng rút:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">    
                                <input type="number" name="amount" id="amount" 
                                       class="form-control" placeholder="Số lượng rút" />
                                <p class="text-warning" style="margin-top: 5px;">Tối đa {{number_format($sodukhadung,0)}} VNĐ</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="note" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Ghi chú:</label>
                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                <textarea style="height: 200px;" id="note" name="note" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-10 col-ld-offset-2 col-md-10 col-md-offset-2 col-sm-9 col-xs-12">
                                <a href="{{url()->previous()}}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Quay lại</a>
                                <button class="btn btn-success"><i class="fa fa-save"></i> Gửi</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection