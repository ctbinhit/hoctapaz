@extends('pi.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-list"></i> Danh sách bài trắc nghiệm <small> Dữ liệu chung</small></h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">

                    <a href="{{route('mdle_oc_pi_exam_add')}}" class="btn btn-app"><i class="fa fa-plus"></i> {{__('label.them')}}</a>

                    <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>

                    <a href="{{route('mdle_oc_pi_exam_app_phongthi')}}" class="btn btn-app"><i class="fa fa-check-square"></i> Phòng thi</a>
                    
                    <a href="{{route('mdle_oc_pi_exam_dethithu')}}" class="btn btn-app"><i class="fa fa-check-square-o"></i> Đề thi thử</a>
                    
                    <a href="{{route('mdle_oc_pi_exam_app_tracnghiem')}}" class="btn btn-app"><i class="fa fa-check-square-o"></i> Trắc nghiệm</a>

                    <a href="{{route('mdle_oc_pi_exam_reject')}}" class="btn btn-app"><i class="fa fa-trash"></i> Bài thi bị hủy</a>

                    <a href="javascript:void(0)" onclick="PNotify.removeAll();" class="btn btn-app"><i class="fa fa-bell"></i> {{__('label.xoathongbao')}}</a>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-folder"></i> Danh sách bài trắc nghiệm đã tải lên</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <p class="text-muted font-13 m-b-30"></p>
                    @include('OnlineCourse::Pi.exam.parts.datatable')
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


