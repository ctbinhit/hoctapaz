@extends('client.layouts.master')

@section('content')
@php
$items_paginate = $items->appends([
'k'=>Request::get('k')
])->links();
@endphp

<div class="container-fluid qao-area">
    <div class="row">
        <div class="container">
            <!-- PAGE TITLE AREA -->
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1><i class="fa fa-question"></i> <small>Hỏi đáp online</small></h1>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb">
                        <li><a href="{{route('client_index')}}"><i class="fa fa-home"></i> Trang chủ</a></li>
                        <li class=""><a href="{{route('mdle_client_qa_index')}}"><i class="fa fa-question"></i> Hỏi đáp online</a></li>
                        @if(Route::currentRouteName() == 'mdle_client_qa_category')
                        <li class="active"><i class="fa fa-book"></i> {{$seo_title}}</li>
                        @endif
                    </ol>
                </div>
            </div>

            <!-- CONTENT AREA -->
            <div class="row">
                <div class="col-md-3">
                    @include('QA::Client.qaonline.parts.navbar_left')
                </div>
                <div class="col-md-9">
                    <div class="r-panel">
                        <div class="r-title"><i class="fa fa-bar-chart faa-ring animated"></i> Mới nhất</div>
                        <div class="r-content">
                            <div class="qao-items">
                                <div>
                                    {{$items_paginate}}
                                </div>
                                @if(count($items)!=0)
                                @foreach($items as $k=>$v)
                                <div class="qao-item">
                                    <div class="qao-state-bars">
                                        <ul>
                                            <li><i class="fa fa-list-ul"></i> {{$v->category_name}}</li>
                                            <li><i class="fa fa-calendar"></i><span> {{$v->created_at}}</span></li>
                                            <li><i class="fa fa-clock-o"></i> {{diffInNow($v->created_at)}}</li>
                                            <li><i class="fa fa-comment"></i> {{$v->answer_count==0?'Chưa có câu trả lời':'Có '.$v->answer_count . ' câu trả lời'}}</li>
                                        </ul>
                                    </div>
                                    <div class="qao-wrapper">
                                        <div class="qao-item-photo">
                                            <img src="{{$v->user_photo}}" />
                                        </div>
                                        <div class="qao-item-info">
                                            <h4 class="qao-item-title">{{$v->title}}</h4>
                                            {!!$v->content!!}

                                            <div class="qao-item-readmore">
                                                <a href="{{route('mdle_client_qa_detail',$v->id)}}">Xem thêm <i class="fa fa-angle-double-right"></i></a>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <p class="text-warning">Không tìm thấy kết quả nào.</p>
                                @endif
                                <div class="clearfix"></div>
                                <div class="text-center">
                                    {{$items_paginate}}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scss')
<link rel="stylesheet" href="{{asset('public/client/css/qao.css')}}"/>
@endpush

@push('scripts')

@endpush

