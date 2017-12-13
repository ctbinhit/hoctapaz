
@extends('client.layouts.master')

@section('content')
<div class="row user-wall">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('client.user.parts.nav_left')
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12">
                        <ol class="breadcrumb">
                            <li><a href="{{route('client_index')}}"><i class="fa fa-home"></i> Trang chủ</a></li>
                            <li><a href="{{route('client_user_info')}}"> Thông tin cá nhân</a></li>
                            <li><a href="javascript:void(0)">Nạp tiền</a></li>
                        </ol>
                    </div>

                    <div class="col-md-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">Nạp tiền bằng thẻ cào</div>
                            <div class="panel-body">
                                <form class="form form-horizontal" method="post" action="{{route('_client_user_donate')}}">
                                    {{csrf_field()}}
                                    @if(Session::has('page-callback'))
                                    @php
                                        $bkr = Session::get('page-callback');
                                    @endphp
                                    <div class="alert alert-{{$bkr->type}}">
                                        <p><strong><i class="fa fa-info"></i> {{$bkr->title}}</strong> {{$bkr->message}}</p>
                                    </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="card_seri" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Seri:</label>
                                        <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                            <input type="text" name="card_seri" id="card_seri" 
                                                   class="form-control" placeholder="Card seri..." />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="card_pin" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Code:</label>
                                        <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                            <input type="text" name="card_pin" id="card_pin" 
                                                   class="form-control" placeholder="Card pin..." />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="card_type" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Loại thẻ:</label>
                                        <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                            <select class="form-control" name="card_type" id="card_type">
                                                <option value="VMS">Mobifone</option>
                                                <option value="VNP">Vinaphone</option>
                                                <option value="VIETTEL">Viettel</option>
                                                <option value="VCOIN">VTC</option>
                                                <option value="GATE">GATE</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 col-md-offset-2">
                                            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Xác nhận</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection