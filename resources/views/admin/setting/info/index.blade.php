@extends('admin.layouts.master')
@section('content')
<form class="form form-horizontal form-label-left" action="{{route('_admin_setting_info')}}" method="POST">
    {{ csrf_field() }}
    
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3><i class="fa fa-gear"></i> {{__('label.caidat') }}</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <a href="{{route('admin_setting_index')}}" class="btn btn-app"><i class="fa fa-arrow-left"></i> {{__('label.caidat')}}</a>
                <a href="{{url()->current()}}" class="btn btn-app"><i class="fa fa-refresh"></i> {{__('label.tailai')}}</a>
                <button type="submit" class="btn btn-app"><i class="fa fa-save"></i> Lưu</button>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-edit"></i> Thông tin cơ bản</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        @foreach($_LISTLANG as $k => $v)
                        <li role="presentation" class="{{$k==0?'active':''}}">
                            <a href="#tab_content{{$k+1}}" id="home-tab" role="tab" data-toggle="tab" 
                               aria-expanded="false">{{ $v->name}}</a>
                        </li>
                        @endforeach
                    </ul>
                    
                    <div id="myTabContent" class="tab-content">
                        @foreach($_LISTLANG as $k => $v)
                        <div role="tabpanel" class="tab-pane fade {{$k==0?'active in':''}}" id="tab_content{{$k+1}}" aria-labelledby="home-tab">
                            @include('admin.setting.info.parts.form_info')
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-share-alt-square"></i> Thông tin seo</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        @foreach($_LISTLANG as $k => $v)
                        <li role="presentation" class="{{$k==0?'active':''}}">
                            <a href="#tab_seo_content{{$k+1}}" id="home-tab" role="tab" data-toggle="tab" 
                               aria-expanded="false">{{ $v->name}}</a>
                        </li>
                        @endforeach
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        @foreach($_LISTLANG as $k => $v)
                        <div role="tabpanel" class="tab-pane fade {{$k==0?'active in':''}}" id="tab_seo_content{{$k+1}}" aria-labelledby="home-tab">
                            @include('admin.setting.info.parts.form_seo')
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<!-- jQuery Tags Input -->
<script src="{!! asset('public/admin/bower_components/jquery.tagsinput/src/jquery.tagsinput.js')!!}"></script>
@endpush