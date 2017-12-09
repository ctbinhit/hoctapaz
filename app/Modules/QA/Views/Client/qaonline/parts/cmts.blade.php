@if(count($item_cmt)!=0)
@foreach($item_cmt as $k=>$v)
<div class="js-cmt" style="display: none;">
    <div class="js-cmt-header">
        <div class="js-cmt-header-photo">
            <img src="{{$v->user_photo}}" />
        </div>
        <div class="js-cmt-header-info">
            <h6 class="cmt-user">{{$v->fullname}}</h6>
            <div class="cmt-date">{{diffInNow($v->created_at)}}</div>
        </div>
    </div>
    <div class="js-cmt-body"> {!!$v->content!!}</div>
</div>
<div>
    {!!$item_cmt->links() !!}
</div>
@endforeach
@else
<div class="alert alert-warning">
    <p><i class="fa fa-info"></i> Chưa có câu trả lời nào.</p>
</div>
@endif
<script>
    $(document).ready(function () {
        $('.js-cmt').slideDown();
    });
</script>