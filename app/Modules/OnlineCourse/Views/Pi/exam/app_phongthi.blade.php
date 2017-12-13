@extends('pi.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-check-square-o"></i> Trắc nghiệm Online <small> Phòng thi online</small></h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">

                    <a href="{{route('mdle_oc_pi_exam_index')}}" class="btn btn-app"><i class="fa fa-arrow-left"></i> App đã tải lên</a>

                    <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>

                    <a href="javascript:void(0)" onclick="PNotify.removeAll();" class="btn btn-app"><i class="fa fa-bell"></i> {{__('label.xoathongbao')}}</a>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-folder"></i> Danh sách các bài thi đang diễn ra</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <p class="text-muted font-13 m-b-30"></p>
                    @include('OnlineCourse::Pi.exam.parts.datatable_phongthi')
                </div>
            </div>
        </div>
    </div>
</div>

@endsection



