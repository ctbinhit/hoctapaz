
@extends('client.layouts.master')

@section('content')

<div class="examonline">
    <div class="sup-nav">
        <a href="{{route('client_index')}}"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a> <i class="fa fa-angle-double-right"></i>
        <a href="javascript:void(0)">Nạp thẻ</a> 
    </div>
    <div class="exam-left">
        @include('client.layouts.left')
    </div>
    <div class="exam-right">
        @if(!Session::has('cart_success'))
        <form class="form form-horizontal" action="" method="POST">
            <div class="panel panel-info">
                <div class="panel-heading"><i class="fa fa-credit-card"></i> Nạp thẻ cào</div>
                <div class="panel-body">

                    {{csrf_field()}}

                    <div class="form-group">
                        <label for="txtpin" class="col-lg-2 control-label">Mã thẻ</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="txtpin" name="txtpin" placeholder="Mã thẻ" data-toggle="tooltip" data-title="Mã số sau lớp bạc mỏng"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="txtseri" class="col-lg-2 control-label">Số seri</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="txtseri" name="txtseri" placeholder="Số seri" data-toggle="tooltip" data-title="Mã seri nằm sau thẻ">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Chọn nhà mạng:</label>
                        <div class="col-md-10">
                            <select class="form-control" name="chonmang">
                                <option value="VIETEL">Viettel</option>
                                <option value="MOBI">Mobifone</option>
                                <option value="VINA">Vinaphone</option>
                                <option value="GATE">Gate</option>
                                <option value="VTC">VTC</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="panel-footer">
                    <div class="form-group">
                        <div class="col-md-10 col-md-offset-2">
                            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Nạp</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
        @else
        <div class="panel panel-info">
            <div class="panel-heading"><i class="fa fa-credit-card"></i> Nạp thẻ cào</div>
            <div class="panel-body">
                <p><strong>Thông báo</strong> Bạn vừa nạp thành công {{Session('card_success')['card']}} vào tài khoản.</p>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection