@extends('admin.layouts.master')

@section('content')
<!--<link rel="stylesheet" href="{{asset('public/admin/plugins/prism-gh-pages/themes/prism.css')}}">
<link rel="stylesheet" href="{{asset('public/admin/plugins/CodeFlask.js-master/src/codeflask.css')}}">
<script src="{{asset('public/admin/plugins/prism-gh-pages/prism.js')}}" async></script>
<script src="{{asset('public/admin/plugins/CodeFlask.js-master/src/codeflask.js')}}" async></script>
<script src="{{asset('public/admin/plugins/CodeFlask.js-master/src/codeflask-editor.js')}}" async></script>-->

<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Google analytics</h3>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="x_panel">
        <div class="x_content">
            <a href="{{route('admin_index')}}" class="btn btn-app"><i class="fa fa-dashboard"></i> Dashboard</a>
            <a class="btn btn-app" href="https://www.google.com.vn/url?sa=t&rct=j&q=&esrc=s&source=web&cd=1&cad=rja&uact=8&ved=0ahUKEwjkyf6iqLPXAhVLf7wKHeJCCCIQFggjMAA&url=https%3A%2F%2Fanalytics.google.com%2F&usg=AOvVaw1Jx9i6a4S_nl7I67YnB98r"><i class="fa fa-google"></i> Site google analytics</a>
        </div>
    </div>

    <div class="x_panel">
        <div class="x_title">
            <h2>Google <small> Analytics (vd: UA-109519405-1)</small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <form action="" method="POST" class="form form-horizontal">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="google_analytics" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Code google analytics:</label>
                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                        <input type="text" name="google_analytics" id="google_analytics" value="{{@$item->google_analytics}}"
                               class="form-control" placeholder="Dán mã google analytics của bạn vào đây..." />
                    </div>
                </div>

                <div class="form-group">
                    <label for="google_analytics_structure" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Dữ liệu:</label>
                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                        <input type="text" name="google_analytics_structure" id="google_analytics_structure" value="$google_analytics"
                               class="form-control" placeholder="Dán mã google analytics của bạn vào đây..." />
                    </div>
                </div>

                <div class="form-group">
                    <label for="code" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Cấu trúc:</label>
                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                        <textarea class="form-control" rows="10" name="google_analytics_structure">{{@$item->google_analytics_structure}}</textarea>
                        <br>
                        <div class="alert alert-warning">
                            <p><i class="fa fa-warning"></i> Việc cập nhật dữ liệu cấu trúc không đúng cách có thể làm trang web bị hỏng.</p>
                        </div>
                    </div>
                </div>

                <div class="ln_solid"></div>

                <div class="form-group">
                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 col-md-offset-2">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Lưu</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection