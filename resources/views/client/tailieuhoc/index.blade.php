
@extends('client.layouts.master')

@section('content')
<div class="examonline">
    <div class="sup-nav">
        <a href="{{route('client_index')}}"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a>
        <a href="{{route('mdle_client_doc_index','tai-lieu-hoc')}}">
            <i class="fa fa-angle-double-right"></i> {{$type=='tai-lieu-hoc'?'Tài liệu học':'Đề thi thử'}}</a> 
        @isset($this_cate)
        <a href="{{url()->full()}}"><i class="fa fa-angle-double-right"></i> {!!$this_cate->name!!}</a> 
        @endif
    </div>
    <div class="exam-left">

        <div class="l_panel">
            <div class="l-title"><i class="fa fa-search faa-ring animated"></i> Tìm kiếm</div>
            <div class="l-content">
                <form action="" class="">
                    <div class="form-group">
                        <div class="col-xs-12 input-group">
                            <input type="text" name="keywords" id="keywords" 
                                   class="form-control" placeholder="Từ khóa..." value="{{Request::get('keywords')}}"/>
                            <span class="input-group-btn">
                                <button class="btn btn-default"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="l_panel">
            <div class="l-title"><i class="fa fa-list-ul"></i> Danh mục</div>
            <div class="l-content">
                <ul class="list-simple">
                    @foreach($categories_hoctap as $k=>$v)
                    <li><a class="faa-parent animated-hover" href="javascript:;" data-src="{{route('mdle_client_doc_category',[$type,$v->name_meta])}}">
                            <i class="fa fa-plus faa-spin"></i> {!! $v->name !!}</a>
                        @php
                        $sub_cate = CategoryService::get_childCateByIdParent($v->id);
                        @endphp
                        @if(count($sub_cate)>0)
                        <ul class="list-simple-sub">
                            @foreach($sub_cate as $k1 => $v1)
                            <li><a href="{{route('mdle_client_doc_category',[$type,$v1->name_meta])}}"><i class="fa fa-book"></i> {{$v1->name}}</a></li>
                            @endforeach
                        </ul>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('.list-simple').children('li').children('a').on('click', function () {
                    $(this).parents('li').find('i:first').toggleClass('fa-minus', 'fa-plus');
                    $(this).parents('li').find('.list-simple-sub').slideToggle();
                });
            });
        </script>

        <div class="l_panel">
            <div class="l-content">
                <img style="width: 100%;" src="data:image/png;base64,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" />

            </div>
        </div>
    </div>
    <div class="exam-right">
        <div class="alert alert-info">
            <p><strong>Thông báo.</strong> Không giới hạn số lần download và thanh toán.</p>
        </div>
        @if(Request::has('keywords'))
        <div class="alert alert-info">
            <p>Kết quả tìm kiếm cho từ khóa: <a href="{{url()->current()}}" class="btn btn-warning btn-xs"><i class="fa fa-remove"></i> {{Request::get('keywords')}}</a></p>
        </div>
        @endif
        <div class="r-panel">
            <div class="r-title"><i class="fa fa-file-pdf-o"></i> Tài liệu học</div>
            <div class="r-content">
                @include('client.tailieuhoc.components.file_filter')
                <div class="documents">
                    <div id="data-items">
                        @include('client.tailieuhoc.parts.items')
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="route_88139f72e980bea9f07063f743ca523c" value="{{route('_mdle_client_doc_ajax')}}" />
<input type="hidden" id="route_2b6d400505e8748c2023d88237027ce0" value="{{route('client_login_index')}}" />
<input type="hidden" id="route_c435030c8b679bd6112cb53d9b275cd1" value="{{route('mdle_bkp_napthe')}}" />
<input type="hidden" id="route_client_user_tailieudamua" value="{{route('client_user_tailieudamua')}}" />
@endsection

@push('scss')

<link href="{{asset('public/client/css/tailieuhoc.css')}}" rel="stylesheet" />
@endpush

@push('sscr')
<script>

    $(document).ready(function () {
        $(document).on('click', '.pagination a', function (e) {
            $(this).html('<i class="fa fa-spinner faa-spin animated"></i>');
            $(this).parents('ul').find('a').off('click');
            var url = $(this).attr('href');
            $.ajax({
                url: url,
                type: 'ajax_view',
                dataType: 'json',
            }).done(function (data) {
                $('#data-items').html(data);
                //location.hash = page;
            }).fail(function () {
                //alert('Posts could not be loaded.');
            });
            e.preventDefault();
        });
    });

</script>

@endpush