<div class="product-area">
    <div class="product-area-title">Sản phẩm mới
        <small><a href="{{route('client_product_new')}}" title="Click vào đây để xem thêm...">Xem thêm</a></small></div>
    <div class="product-items">
        @foreach($sanphammoi as $k=>$v)
        <div class="product-item col-md-3 col-lg-3 col-sm-3 col-xs-3">

            <div class="product-photo thumbnail">
                <a title="{{$v->description}}" href="{{route('client_product_detail',$v->name_meta)}}"><img src="{{html_image($v->data_photo->url_encode,220,220,100)}}" /></a>
            </div>
            <div class="product-title"><a title="{{$v->description}}" href="{{route('client_product_detail',$v->name_meta)}}">{{$v->name}}</a></div>
            <div class="product-pp">
                @if($v->promotion_price!=0)
                <span class="price">{{number_format($v->price,0)}} VNĐ</span>
                @endif
                <span class="promotion-price">{{number_format($v->promotion_price==0?$v->price:$v->promotion_price,0)}} VNĐ</span>
            </div>
        </div>
        @endforeach
        <div class="clearfix"></div>
    </div>
</div>