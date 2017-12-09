
@extends('client.layouts.master')

@section('content')
<div class="row user-wall">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('client.user.parts.nav_left')
            </div>

            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12">
                        <ol class="breadcrumb">
                            <li><a href="{{route('client_index')}}"><i class="fa fa-home"></i> Trang chủ</a></li>
                            <li><a href="{{route('client_user_info')}}"> Thông tin cá nhân</a></li>
                            <li><a href="javascript:void(0)">Kết quả thi</a></li>
                        </ol>
                    </div>
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"><i class="fa fa-users"></i> Kết quả thi</div>
                            <div class="panel-body text-center">
                                <div class="row">
                                    @if($exams_user!=null)
                                    <table class="table table-striped">
                                        <tr>
                                            <th>STT</th>
                                            <th>Ngày thi</th>
                                            <th>Tên đề thi</th>
                                            <th><i class="fa fa-user"></i></th>
                                            <th><i class="fa fa-clock-o"></i></th>
                                            <th>Điểm</th>
                                            <th><i class="fa fa-bar-chart"></i></th>
                                            <th>#</th>
                                        </tr>

                                        @if(count($exams_user)!=0)
                                        @foreach($exams_user as $k=>$v)
                                        <tr>
                                            <td>{{$k+1}}</td>
                                            <td>{{$v->time_in}}</td>
                                            <td>{{$v->exam_name}}</td>
                                            <td>{{$v->user_fullname}}</td>
                                            <td>{{$v->exam_time - $v->time_end}}s</td>
                                            <td>{{$v->score}}</td>
                                            <td>#</td>
                                            <td style="width: 20%">
                                                <a href="javascript:void(0)" title="Gửi yêu cầu thi lại" class="btn btn-xs btn-warning">Gửi yêu cầu thi lại</a>
                                                <a href="javascript:void(0)" title="Chia sẻ cho bạn bè" class="btn btn-xs btn-primary"><i class="fa fa-share"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach

                                        @else
                                        <p>Không có dữ liệu...</p>
                                        @endif
                                    </table>
                                    @else
                                    <p>Không có dữ liệu...</p>
                                    @endif
                                </div>
                            </div>
                            <div class="panel-footer text-center">
                                @if($exams_user!=null)
                                @if(count($exams_user)!=0)
                                {{$exams_user->links()}}
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection

@push('stylesheet')
<style>
    .personal-name{font-size: 16pt;text-align:center;color: #001D8D;font-weight:bold;}
    td{
        text-align: center;
    }
    th{
        text-align: center;
    }
</style>
@endpush