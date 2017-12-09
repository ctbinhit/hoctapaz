@extends('client.layouts.master')
@push('stylesheet')

@endpush
@push('scss')
<link href="{{asset('public/client/css/article_detail.min.css')}}" rel="stylesheet" />
@endpush
@section('content')

<div class="row" style="margin: 50px 0px 250px 0px">
    <div class="container">
        <div class="row">
            <div class="col-md-3 content-left-area">

                <div class="article-related-area content-left-panel">
                    <h2><i class="fa fa-star"></i> Tin nổi bật</h2>
                    <div class="articles articles-horizontal">
                        @if(count($db_tinnoibat)!=0)
                        @foreach($db_tinnoibat as $k=>$v)
                        <div class="article">
                            <div class="article-photo">
                                <img title="{{$v->description}}" src="{{html_thumbnail($v->data_photo->url_encode,79,78)}}" />
                            </div>
                            <a href="{{route('client_news_detail',$v->name_meta)}}" title="{{$v->name}}">
                                <div class="article-info">
                                    <div class="article-title">{{$v->name}}</div>
                                    <div class="article-description">
                                        {{str_limit($v->description,60)}}
                                    </div>
                                </div>
                            </a>
                            <div class="clearfix"></div>
                        </div>
                        @endforeach
                        @else
                        <p>Không có tin liên quan nào.</p>
                        @endif
                    </div>
                    <div class="article-related-readmore">
                        <a href="{{route('client_news_highlight')}}" title="Click để xem thêm..."><i class="fa fa-circle"></i><i class="fa fa-circle"></i><i class="fa fa-circle"></i></a>
                    </div>
                </div>  

                <div class="article-related-area content-left-panel">
                    <h2><i class="fa fa-bookmark"></i> Tin liên quan</h2>
                    <div class="articles articles-horizontal">
                        @if(count($db_tinlienquan)!=0)
                        @foreach($db_tinlienquan as $k=>$v)
                        <div class="article">
                            <div class="article-photo">
                                <img title="{{$v->description}}" src="{{html_thumbnail($v->data_photo->url_encode,79,78)}}" />
                            </div>
                            <a href="{{route('client_news_detail',$v->name_meta)}}" title="{{$v->name}}">
                                <div class="article-info">
                                    <div class="article-title">{{$v->name}}</div>
                                    <div class="article-description">
                                        {{str_limit($v->description,60)}}
                                    </div>
                                </div>
                            </a>
                            <div class="clearfix"></div>
                        </div>
                        @endforeach
                        @else
                        <p>Không có tin liên quan nào.</p>
                        @endif
                    </div>
                    <div class="article-related-readmore">
                        <a href="{{route('client_news')}}" title="Click để xem thêm..."><i class="fa fa-circle"></i><i class="fa fa-circle"></i><i class="fa fa-circle"></i></a>
                    </div>
                </div>

                <div class="content-left-panel">
                    <h2><i class="fa fa-share-alt"></i> Chia sẻ</h2>
                    <div class="pd-sm">
                        <div class="addthis_inline_share_toolbox"></div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-9 article-detail-area">
                <div class="breadcrumbs">
                    <ul>
                        <a title="Trang chủ" href="{{route('client_index')}}"><li><i class="fa fa-home"></i> Trang chủ</li></a>
                        <a title="Tin tức" href="{{route('client_news')}}"><li><i class="fa fa-book"></i> Tin tức</li></a>
                        <a title="{{$art_lang->name}}" href="{{url()->full()}}"><li><i class="fa fa-book"></i> {{$art_lang->name}}</li></a>
                    </ul>
                </div>

                <div class="page-header">
                    <h1><i class="fa fa-edit"></i> {{$art_lang->name}}</h1>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="article-detail-description">
                            {{$art_lang->description}}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="fb-like" data-href="{{url()->full()}}" data-layout="standard" 
                             data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
                    </div>

                    <div class="col-md-12">
                        <div class="article-detail-content">
                           {!! @$art_lang->content!!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="article-detail-share-social">
                            <h4><i class="fa fa-share"></i> Chia sẻ cho bạn bè</h4>
<!--                            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-59ef1eb4096d3a39"></script> -->
                            <div class="addthis_inline_share_toolbox"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div data-width="100%" class="fb-comments" data-href="{{url()->full()}}" data-numposts="5"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection