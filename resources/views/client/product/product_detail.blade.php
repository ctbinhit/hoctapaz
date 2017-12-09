
@extends('client.layouts.master')

@section('content')

<div class="container product-detail-area">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="{{route('client_index')}}"><i class="fa fa-home"></i> Trang chủ</a></li>
                <li><a href="#"> Sản phẩm</a></li>
                <li><a href="javascript:void(0)">{{$item->name}}</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h1 class="product-detail-title">Chi tiết sản phẩm {{$item->name}}</h1>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6" id="jquery-photos-area">
                            <a href="{{Storage::disk('localhost')->url($item->data_photo->url)}}">
                                <img src="{{html_image($item->data_photo->url_encode,300,300,100)}}" class="thumbnail"/>
                            </a>
                            <div class="row">
                                <div class="col-md-12 product-detail-photos">
                                    @if(count($item->data_photos)!=0)
                                    @foreach($item->data_photos as $k=>$v)
                                    <a href="{{Storage::disk('localhost')->url($v->url)}}">
                                        <img class="thumbnail pull-left" src="{{html_image($v->url_encode,50,50,100)}}" />
                                    </a>
                                    @endforeach
                                    @endif
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <ul class="product-detail-info">
                                <li><span class="product-detail-name">{{@$item->name}}</span></li>
                                <li>
                                    @if(@$item->promotion_price!=0)
                                    Giá cũ: <span class="product-detail-price">{{number_format(@$item->price,0)}} VNĐ</span>
                                    @endif
                                    Giá: <span class="product-detail-promotion-price">{{number_format(@$item->promotion_price==0?@$item->price:@$item->promotion_price,0)}} VNĐ</span>

                                </li>
                                <li>
                                    <p class="product-detail-description">{{@$item->description}}</p>
                                </li>
                                <li>
                                    <div class="fb-like" data-href="{{url()->full()}}" data-layout="standard" 
                                         data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
                                </li>
                                <li><div class="fb-save" data-uri="{{url()->full()}}" data-size="small"></div> hoặc 
                                    <div class="fb-send" data-href="{{url()->full()}}"></div> cho bạn bè</li>
                                <li></li>
                                <li style="position: relative;">
                                    <input type="number" class="product-detail-count"
                                           id="jquery-order-item-count" name="item_count" value="1"/>
                                    <button type="button" id="jquery-order-btn" data-id="{{$item->id}}" 
                                            data-name="{{$item->name}}" class="product-detail-btn-order">
                                        <i class="fa fa-shopping-cart"></i> <span>Đặt ngay</span></button>
                                    <script>
                                        $(document).ready(function () {
                                            $('#jquery-order-btn').on('click', function () {
                                                var this_btn = this;
                                                $(this_btn).attr('disabled', '');
                                                $(this_btn).find('i').removeClass('fa-shopping-cart').addClass('fa-spinner animated faa-spin');

                                                var item_count = $('#jquery-order-item-count').val();
                                                var id_product = $(this).data('id');
                                                if (item_count <= 0) {
                                                    $.alert({
                                                        title: '<i class="fa fa-shopping-cart"></i> Oh no, có gì đó sai sai.',
                                                        content: 'Số lượng bạn nhập không hợp lý.'
                                                    });
                                                    return;
                                                }
                                                var item_name = $(this).data('name');


                                                $.ajax({
                                                    url: '{{route("mdle_client_order_ajax")}}',
                                                    type: 'POST',
                                                    dataType: 'json',
                                                    data: {
                                                        act: '34ec78fcc91ffb1e54cd85e4a0924332',
                                                        id_product: id_product,
                                                        count: item_count,
                                                        color: '',
                                                        size: ''
                                                    }, success: function (data) {
                                                        console.log(data);
                                                        $('#jquery-cart-badge').html(data.count);
                                                        if (data.state) {
                                                            $.alert({
                                                                title: '<i class="fa fa-shopping-cart"></i> Thông báo',
                                                                content: 'Đã thêm ' + item_count + ' <strong>' + item_name + '</strong> vào giỏ hàng.'
                                                            });
                                                        } else {
                                                            $.alert({
                                                                title: '<i class="fa fa-shopping-cart"></i> Thông báo',
                                                                content: 'Server quá tải, thao tác thất bại, vui lòng thử lại sau.'
                                                            });
                                                        }
                                                        $(this_btn).removeAttr('disabled');
                                                        $(this_btn).find('i').removeClass('fa-spinner animated faa-spin').addClass('fa-shopping-cart');
                                                    }, error: function (data) {
                                                        console.log(data);
                                                    }
                                                });

                                            });
                                        });
                                    </script>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="product-detail-content">
                        {{$item->content}}
                    </div>
                </div>
                <div class="col-md-12 product-detail-keywords">
                    <i class="fa fa-tags"></i>
                    <div class="label label-info">{{$item->seo_keywords}}</div>
                </div>

                <div class="col-md-12 product-detail-keywords">
                    <div data-width="100%" class="fb-comments" data-href="{{url()->full()}}" data-numposts="5"></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">

        </div>
    </div>


</div>

@endsection

@push('stylesheet')
<link href="{{asset('public/bower_components/photobox/photobox/photobox.css')}}" rel="stylesheet" />
@endpush

@push('scripts')
<script src="{{asset('public/bower_components/photobox/photobox/jquery.photobox.js')}}" ></script>
<script>
                                        $(document).ready(function () {
                                            $('#jquery-photos-area').photobox('a', {time: 0});
                                        });
</script>
@endpush