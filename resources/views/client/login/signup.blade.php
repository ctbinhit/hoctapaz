
@extends('client.layouts.master')

@section('content')
<style>
    .panel{
        margin-bottom: 10px !important;
    }
    .form{
        margin-bottom: 10px !important;
    }
    .form-horizontal .from-group{
        margin-bottom: 10px !important;
    }
</style>
<div class="clearfix"></div>
<div class="row">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2">
                <form class="form form-horizontal" name="frm_login" action="{{route('_client_login_signup')}}" method="POST">
                    {{ csrf_field() }}
                    <div class="panel panel-success">
                        <div class="panel-heading"><i class="fa fa-user"></i> Đăng ký</div>
                        <div class="panel-body">
                            
                           @include('client.login.parts.form_signup')
                            
                        </div>
                        <div class="panel-footer">
                            <p>Đăng nhập vào hệ thống hoctapaz.com.vn</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

