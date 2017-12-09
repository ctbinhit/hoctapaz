@extends('client.layouts.master')
@push('stylesheet')

@endpush

@push('scss')
<link href="{{asset('public/client/css/article_detail.min.css')}}" rel="stylesheet" />
@endpush

@push('sscr')
<!-- WOW JS -->
<script src="{{public_bower('wow/dist/wow.min.js')}}"></script>
<script>
    $(document).ready(function () {
        var wow = new WOW(
                {
                    boxClass: 'wow', // animated element css class (default is wow)
                    animateClass: 'animated', // animation css class (default is animated)
                    offset: 100, // distance to the element when triggering the animation (default is 0)
                    mobile: true, // trigger animations on mobile devices (default is true)
                    live: true, // act on asynchronously loaded content (default is true)
                    callback: function (box) {
                        // the callback is fired every time an animation is started
                        // the argument that is passed in is the DOM node being animated
                    },
                    scrollContainer: null // optional scroll container selector, otherwise use window
                }
        );
        wow.init();
    });
</script>
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
                        <p>Không có tin nổi bật nào.</p>
                        @endif
                    </div>
                    <div class="article-related-readmore">
                        <a href="{{route('client_news_highlight')}}" title="Click để xem thêm..."><i class="fa fa-circle"></i><i class="fa fa-circle"></i><i class="fa fa-circle"></i></a>
                    </div>
                </div>  

                <div class="content-left-panel">
                    <h2><i class="fa fa-share-alt"></i> Chia sẻ</h2>
                    <div class="pd-sm">
                        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-59ef1eb4096d3a39"></script> 
                        <div class="addthis_inline_share_toolbox"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-9 article-list-area">
                <div class="row">
                    <div class="col-md-12">
                        <div class="breadcrumbs">
                            <ul>
                                <a title="Trang chủ" href="{{route('client_index')}}"><li><i class="fa fa-home"></i> Trang chủ</li></a>
                                <a title="Tin tức" href="{{route('client_news')}}"><li><i class="fa fa-book"></i> Tin tức</li></a>
                            </ul>
                        </div>

                        <div class="articles">
                            <div class="row">
                                @foreach($db_items as $k=>$v)
                                <div class="col-md-4">
                                    <div class="article">
                                        <div class="article-photo">
                                            <a href="{{route('client_news_detail',$v->name_meta)}}" title="{{$v->name}}"><img title="{{$v->name}}" src="{{html_thumbnail($v->data_photo->url_encode,260,200)}}" /></a>
                                        </div>
                                        <div class="article-info">
                                            <span class="css3-support-border-top"></span>
                                            <div class="article-title"><a href="{{route('client_news_detail',$v->name_meta)}}" title="{{$v->name}}">{{str_limit($v->name,65)}}</a></div>
                                            <div class="article-description">
                                                {{str_limit($v->description,150)}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="clearfix"></div>
                                <div>{{$db_items->links()}}</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection