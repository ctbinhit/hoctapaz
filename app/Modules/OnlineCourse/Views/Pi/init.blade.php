
@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3></h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="x_panel">
        <div class="x_title">
            <h2>Cài đặt module <small>Online course</small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <div class="panel panel-primary">
                <div class="panel-heading"><i class="fa fa-database"></i> Cấu hình database</div>
                <div class="panel-body">
                    <div class="alert alert-info">
                        <p>Module khóa học online:</p>
                        <p>
                            Yêu cầu:
                        <ul>
                            <li>Storage & Storage Service (Google Drive, Local)</li>
                            <li>Photo model & Image Service</li>
                            <li>Package Service Admin</li>
                            <li>Package Service Client</li>
                            <li>Package Service Pi</li>
                            <li>Session Service</li>
                        </ul>
                        </p>
                    </div>
                    <div class="alert alert-warning">
                        <p>Không được tắt trình duyệt cho tới khi tiến trình hoàn tất để đảm bảo mọi thứ
                            đã được cài đặt hoàn tất và tránh xảy ra lỗi hệ thống !</p>
                    </div>

                </div>
                <div class="panel-footer">
                    <button class="btn btn-primary pull-right">Cài đặt</button>
                    <div class="clearfix"></div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection