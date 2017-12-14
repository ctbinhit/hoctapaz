@extends('pi.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left" style="width: 100%;">
            <h3><i class="fa fa-bar-chart-o"></i> Kết quả thi - <small>{{$exam->name}}</small></h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <a href="{{route('admin_index')}}" class="btn btn-app"><i class="fa fa-dashboard"></i> Dashboard</a>
                <a href="{{route('mdle_oc_pi_exam_app_phongthi')}}" class="btn btn-app"><i class="fa fa-arrow-left"></i> Phòng thi</a>
                <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>
            </div>
        </div>

        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-search"></i> Tìm kiếm 
                        @if(Request::has('keyword'))
                        <small>Đang tìm kiếm cho từ khóa <a href="{{url()->current()}}" class="label label-warning">{{Request::get('keyword')}}</a> (Click để xóa )</small>
                        @endif
                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form class="form form-horizontal">
                        <div class="form-group">
                            <label for="keyword" class="control-label col-lg-1 col-md-2 col-sm-3 col-xs-12">Từ khóa:</label>
                            <div class="col-lg-11 col-md-10 col-sm-9 col-xs-12 input-group">
                                <input type="text" name="keyword" id="keyword" value="{{@Request::get('keyword')}}"
                                       class="form-control" placeholder="Từ khóa..." />
                                <span class="input-group-addon">Tìm theo</span>
                                <span class="input-group-btn">
                                    <select name="seb" class="form-control" style="width: 120px;">
                                        @foreach($se['sortBy'] as $v)
                                        @if($v[0] == Request::get('seb'))
                                        <option selected="" value="{{$v[0]}}">{!!@$v[1]!!}</option>
                                        @else
                                        <option value="{{$v[0]}}">{!!@$v[1]!!}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </span>
                                <span class="input-group-addon">Sắp xếp</span>
                                <span class="input-group-btn">
                                    <select name="orn" class="form-control" style="width: 120px;">
                                        @foreach($se['orderBy']['name'] as $v)
                                        @if(@Request::get('orn') == $v[0])
                                        <option selected="" value="{{$v[0]}}">{!!@$v[1]!!}</option>
                                        @else
                                        <option value="{{$v[0]}}">{!!@$v[1]!!}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </span>
                                <span class="input-group-btn">
                                    <select name="orv" class="form-control" style="width: 180px;">
                                        @foreach($se['orderBy']['value'] as $v)
                                        @if(@Request::get('orv') == $v[0])
                                        <option selected="" value="{{$v[0]}}">{!!@$v[1]!!}</option>
                                        @else
                                        <option value="{{$v[0]}}">{!!@$v[1]!!}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </span>
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-bar-chart"></i> Kết quả thi <small>Sắp xếp theo ngày</small></h2><div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table class="table table-bordered">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Họ & Tên</th>
                                <th>Điểm</th>
                                <th style="width: 100px"><i class="fa fa-clock-o"></i></th>
                                <th style="width: 10%;">TG Bắt đầu</th>
                                <th style="width: 10%;">TG Kết thúc</th>
                                <th style="width: 10%;"><i class="fa fa-calendar"></i></th>
                                <th style="width: 15%;"></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($items as $k=>$v)
                            <tr>
                                <td>{{$k+1}}</td>
                                <td>{{$v->fullname}}</td>
                                <td class="text-center"><i class="label label-info">{{$v->score}}</i></td>
                                <td class="text-center"><i class="label label-info">{{number_format($v->time_end/60,2)}} phút</i></td>
                                <td><i class="label label-info">{{$v->time_in}}</i></td>
                                <td><i class="label label-info">{{$v->time_out}}</i></td>
                                <td><i class="label label-info">{{$v->created_at}}</i></td>
                                <td>
                                    <!-- Single button -->
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-sm"><i class="fa fa-eye"></i></button>
                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-server"></i> <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="#"><i class="fa fa-envelope"></i> Gửi tin nhắn</a></li>
                                            <li><a href="#"><i class="fa fa-check-square"></i> Cấp quyền thi lại</a></li>
                                            <li role="separator" class="divider"></li>
                                            <li><a href="#"><i class="fa fa-exclamation-circle"></i> Báo xấu</a></li>
                                            <li><a href="#"><i class="fa fa-trash"></i> Hủy kết quả</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="10">
                                    {{$items->appends($search_append)->links()}}
                                </td>
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('stylesheet')
<style>
    table th{
        text-align: center;
    }
</style>
@endpush