@if(count($items)!=0)
<div class="exams">
    @foreach($items as $k=>$v)
    <div class="exam">
        <div class="exam-photo">
            <img data-src="holder.js/300x200" alt="300x200" src="{{$v->avatar}}" style="width: 100%; height: 100%">
        </div>
        <div class="exam-info">
            <h6>{{$v->name}}</h6>
            <ul>
                <li><i class="fa fa-clock-o"></i> <strong>{{ number_format($v->time/60,1)}}</strong> Phút</li>  
                <li><i class="fa fa-calendar"></i> {{$v->created_at}}</li>
                <li><i class="fa fa-user"></i> <span>{{$v->fullname}}</span></li>
                <li>Giá: {{number_format($v->price,0)}} VNĐ</li>
                <li><div class="label label-info">{{CategoryService::getNameById($v->id_category)}}</div></li>
            </ul>
            <div class="exam-info-bottom-right">
                <a href="{{route('client_exam_phongthi_redirect',$v->name_meta)}}" class="btn btn-default">Thi ngay <i class="fa fa-sign-in"></i></a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<p>Chưa có dữ liệu.</p>
@endif