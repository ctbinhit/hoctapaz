@extends('pi.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>{{@$title}} <small> ToanNang Co., Ltd</small></h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('label.thaotac')}} {{@$title}}</small></h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <a href="{{route('mdle_oc_pi_exam_index')}}" class="btn btn-app"><i class="fa fa-arrow-left"></i> Quay lại</a>

                    <a href="{{route('mdle_oc_pi_exam_index')}}" class="btn btn-app"><i class="fa fa-refresh"></i> {{__('label.tailai')}}</a>

                    <a href="javascript:void(0)" onclick="PNotify.removeAll();" class="btn btn-app"><i class="fa fa-bell"></i> {{__('label.xoathongbao')}}</a>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('label.danhsach')}} <small>đã bị từ chối</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table id="jquery-datatable-default" class="table table-hover table-effect">
                        <thead>
                            <tr>
                                <td>#</td>
                                <th>{{__('label.stt')}}</th>
                                <th>{{__('label.ten')}}</th>
                                <th><i class="fa fa-eye"></i></th>
                                <th>{{__('schools.tgthi')}}</th>
                                <th>{{__('schools.luotthi')}}</th>
                                <th>{{__('label.ngaytao')}}</th>
                                <th>{{__('label.trangthai')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($items)!=0)
                            @foreach($items as $k=>$v)
                            <tr id="jquery-icheck-{{$v->id}}">
                                <td style="text-align: center;">
                                    {{$v->id}}
                                </td>
                                <td style="width:2%">
                                    {{$v->ordinal_number}}
                                </td>
                                <td style="width: 30%;">
                                    {{$v->name}}
                                </td>
                                <td>{{$v->views}}</td>
                                <td>{{$v->time/60}} {{__('schools.phut')}}</td>
                                <td>0</td>
                                <td>{{diffInNow($v->created_at)}} <br>{{ Carbon\Carbon::parse($v->created_at)->format('d-m-Y h:i:s') }}</td>
                                <td style="width: 10%;">
                                    <div class="label label-danger">Đã bị từ chối</div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="10">{{__('message.khongcodulieu')}}</td>
                            </tr>
                            @endif

                        </tbody> 
                        @if(count($items)!=0)
                        <tfoot>
                            <tr>
                                <td colspan="99">
                                    <div class="col-md-3">
                                        {{$items->links()}}
                                    </div>
                                </td>

                            </tr>
                        </tfoot>
                        @endif

                        </tbody> 

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


