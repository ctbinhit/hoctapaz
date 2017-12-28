
@extends('admin.layouts.master')

@push('stylesheet')
<style>
    table th,td{
        text-align: center;
    }
    table img{
        margin: 0 auto;
    }
</style>
@endpush

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-edit"></i> Kết quả thi</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-bar-chart-o"></i> Danh sách thi</h2><div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table class="table table-bordered" name="frm_exam_chart">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Họ & tên</th>
                                <th><i class="fa fa-calendar"></i></th>
                                <th>Điểm số</th>
                                <th><i class="fa fa-clock-o"></i></th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($items as $k=>$v)
                            <tr>
                                <td>{{$k+1}}</td>
                                <td>{{$v->fullname}}</td>
                                <td>{{$v->created_at}}</td>
                                <td>{{$v->score}}</td>
                                <td>{{number_format($v->time_end/60,2)}} phút</td>
                                <td></td>
                            </tr>
                            @endforeach
                        </tbody>
                        
                        <tfoot>
                            <tr>
                                <td colspan="10">{{$items->links()}}</td>
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection