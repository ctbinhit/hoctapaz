
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
                            <li><a href="javascript:void(0)">Nâng cấp VIP</a></li>
                        </ol>
                    </div>
                    <div class="col-md-12">
                        <h3 class="text-warning">Nâng cấp <i class="label label-warning faa-ring animated">VIP!</i> nhận nhiều ưu đãi!</h3>
                        <div class="alert alert-info"><i class="fa fa-info"></i> <strong>Có thể bạn biết rồi?</strong> Nâng cấp VIP để có thể tải được những tài liệu có cấp bậc vip tương ứng.</div>

                    </div>
                    <div class="col-md-6">

                        <div class="panel panel-warning">
                            <div class="panel-heading"><i class="fa fa-star"></i> Nâng cấp VIP</div>
                            @if($next_package!=null)
                            <ul class="list-group">
                                <li class="list-group-item">Gói: <span class="label label-warning">{{$next_package->name or 'Không xác định'}}</span></li>
                                <li class="list-group-item">Lợi ích: <span>{{$next_package->note or 'Không xác định'}}</span></li>
                                <li class="list-group-item">Khuyến mãi: <span>giảm {{$next_package->discount or 'NaN'}}% khi mua <i class="label label-info">tài liệu</i></span></li>
                                <li class="list-group-item">Giá: <span>{{number_format($next_package->sum,0)}}</span></li>
                            </ul>
                            <div class="panel-footer">
                                <button data-id="{{$next_package->id}}" class="btn btn-warning js-btn-upgrade">
                                    <i class="fa fa-arrow-right faa-passing animated"></i> Nâng cấp ngay</button>
                                    <i class="label label-info"> hoặc</i>
                                    <a href="{{route('client_user_donate')}}" class="btn btn-default">Nạp ngay</a>
                            </div>
                            @else
                            <p>Không khả dụng.</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">

                        <ul class="list-group">
                            @foreach($packages as $k=>$v)
                            <li class="list-group-item"><span class="label label-warning">{{$v->name or ''}}</span> {{$v->note}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="client_user_ajax" value="{{route('client_user_ajax')}}" />

@endsection
@push('stylesheet')

@endpush
@push('scripts')

<script>
    $(document).ready(function () {
        $('.js-btn-upgrade').on('click', function () {
            var this_btn = this;
            var id = $(this_btn).data('id');
            $.confirm(jquery_confirm_options({
                text: 'Nâng cấp VIP', type: 'green',
                content: 'Bạn có muốn nâng cấp VIP?',
                buttons: {
                    confirm: {
                        text: 'Nâng cấp ngay!', btnClass: 'btn btn-success',
                        action: function () {
                            $.ajax({
                                url: $('#client_user_ajax').val(),
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    act: 'uv',
                                    id: id
                                }, success: function (data) {
                                    console.log(data);
                                }, error: function (data) {
                                    console.log(data);
                                }
                            });
                        }
                    }
                }
            }));



        });

    });
</script>
@endpush