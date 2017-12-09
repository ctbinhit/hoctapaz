@extends('admin.layouts.master')

@section('content')

<!-- Datatables -->
<link href="public/admin_assets//vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="public/admin_assets//vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="public/admin_assets//vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="public/admin_assets//vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="public/admin_assets//vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Upload to google drive <small>Some examples to get you started</small></h3>
        </div>

        <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <form class="form-horizontal" method="POST" action="{{Route('post_upload')}}">
                <div class="form-group">
                    <input id="token" name="_token" value="{!! csrf_token() !!}" type="hidden">
                    <input type='text' name="name" class="form-control">
                    <input type='file' name="file" class="form-control">
                </div>
                <button type='submit'>SEND</button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('header_css')



@endsection

@section('footer_js')

@endsection