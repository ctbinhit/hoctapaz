@if($current_route == 'mdle_client_doc_index' || $current_route == 'mdle_client_doc_type')
<ul class="r_tabs">
    <li class="{{$mime_type==null?'active':''}}">
        <a href="{!! route('mdle_client_doc_index','tai-lieu-hoc') !!}"><i class="fa fa-list-ul"></i> Tất cả</a></li>
    <li class="{{$mime_type=='pdf'?'active':''}}">
        <a href="{!! route('mdle_client_doc_type',['tai-lieu-hoc','pdf']) !!}"><i class="fa fa-file-pdf-o"></i> PDF</a></li>
    <li class="{{$mime_type=='word'?'active':''}}">
        <a href="{!! route('mdle_client_doc_type',['tai-lieu-hoc','word']) !!}"><i class="fa fa-file-word-o"></i> Word</a></li>
    <li class="{{$mime_type=='pdf-tinh-phi'?'active':''}}">
        <a href="{!! route('mdle_client_doc_type',['tai-lieu-hoc','pdf-tinh-phi']) !!}"><i class="fa fa-file-pdf-o"></i> PDF tính phí</a></li>
    <li class="{{$mime_type=='word-tinh-phi'?'active':''}}">
        <a href="{!! route('mdle_client_doc_type',['tai-lieu-hoc','word-tinh-phi']) !!}"><i class="fa fa-file-word-o"></i> Word tính phí</a></li>
</ul>
@else
<ul class="r_tabs">
    <li class="{{$mime_type==null?'active':''}}">
        <a href="{{route('mdle_client_doc_category', [$type,$cate_meta])}}"><i class="fa fa-list-ul"></i> Tất cả</a></li>
    <li class="{{$mime_type=='pdf'?'active':''}}">
        <a href="{!! route('mdle_client_doc_category_mime',['tai-lieu-hoc',$cate_meta,'pdf']) !!}"><i class="fa fa-file-pdf-o"></i> PDF</a></li>
    <li class="{{$mime_type=='word'?'active':''}}">
        <a href="{!! route('mdle_client_doc_category_mime',['tai-lieu-hoc',$cate_meta,'word']) !!}"><i class="fa fa-file-word-o"></i> Word</a></li>
    <li class="{{$mime_type=='pdf-tinh-phi'?'active':''}}">
        <a href="{!! route('mdle_client_doc_category_mime',['tai-lieu-hoc',$cate_meta,'pdf-tinh-phi']) !!}"><i class="fa fa-file-pdf-o"></i> PDF tính phí</a></li>
    <li class="{{$mime_type=='word-tinh-phi'?'active':''}}">
        <a href="{!! route('mdle_client_doc_category_mime',['tai-lieu-hoc',$cate_meta,'word-tinh-phi']) !!}"><i class="fa fa-file-word-o"></i> Word tính phí</a></li>
</ul>
@endif