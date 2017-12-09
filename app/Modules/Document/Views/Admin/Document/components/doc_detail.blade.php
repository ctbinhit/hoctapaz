<h3>Thông tin tài liệu {{$item->name}}</h3>
<div>
    <p>Tên tài liệu: <span>{{$item->name}}</span></p>
    <p>Kích thướt: <span>{{$item->size}}</span></p>
    <p>Định dạng: <span>{{$item->mimetype}}</span></p>
    <p>Giá: <span>{{number_format($item->price,0)}}</span> VNĐ</p>
    <p>Số ngày bán: <span> 15 (Mặc định)</span></p>
    <div>
        <iframe style="width: 100%;height: 450px;" src="{{Storage::disk('localhost')->url($item->url)}}"></iframe>
    </div>
</div>