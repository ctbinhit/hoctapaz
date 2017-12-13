@if($user->coin-$file->price>=0)
<h2>Thông tin thanh toán</h2>

<div>
    <i class="fa fa-user"></i> {{$user->fullname or 'Không xác định'}}
</div>
<div>
    Tài liệu: {{$file->name}}
</div>
<div>
    Giá: <strong>{{number_format($file->price,0)}}</strong> VNĐ
</div>
<div>
    Số dư TK: <strong>{{number_format($user->coin,0)}}</strong> VNĐ
</div>
<div>
    Số dư sau thanh toán: <strong>{{number_format(($user->coin - $file->price),0)}}</strong> VNĐ
</div>
@else
<div class="alert alert-warning">
    <p><i class="fa fa-warning"></i> Số dư không đủ để thực hiện giao dịch, vui lòng nạp thêm.</p>
</div>
@endif