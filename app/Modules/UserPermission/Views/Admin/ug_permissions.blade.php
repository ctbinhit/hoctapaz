
@extends('admin.layouts.master')
@push('stylesheet')
<style>
    table th,td {
        text-align: center;
    }
</style>
@endpush
@section('content')
<form action="{{route('_mdle_userpermission_ug_permissions_save',@$group_info->id)}}" method="POST" class="form form-horizontal">
    {{csrf_field()}}
    <input type="hidden" name="ipg" value="{{@$group_info->id}}" />
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Phân quyền user group {{@$group_info->name}}</h3>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="x_panel">
            <div class="x_content">
                <a href="{{route('mdle_userpermission_ug')}}" class="btn btn-app"><i class="fa fa-arrow-left"></i> Quay lại</a>
                <button class="btn btn-app"><i class="fa fa-save"></i> Lưu</button>
            </div>
        </div>

        <div class="x_panel">
            <div class="x_content">

                <table class="table table-bordered" >

                    <thead>
                        <tr>
                            <th style="width: 5%;">STT</th>
                            <th style="width: 12%;">Name controller/package</th>
                            <th>Permission list</th>
                            <th>Strict object</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($lst_controllers as $k=>$v)

                        <tr>
                            <td></td>
                            <td>{{$k}}</td>
                            <td>
                                @if(isset($v->permissions))
                                @if(is_object($v->permissions))
                                <ul>
                                    @foreach($v->permissions->admin->per_require as $k1 =>$v1)

                                    @if(!key_exists($v->name,$lst_permissions))
                                    <li style="width: 100%;position:relative;">{{$v1->name}};
                                        <span class="pull-right">
                                            <input type="checkbox" name="pers[{{$k}}][{{$k1}}]" class="jquery-icheck"/>
                                        </span>
                                        <div class="clearfix"></div>
                                    </li>
                                    @else
                                    <li style="width: 100%;position:relative;">{{$v1->name}};
                                        <span class="pull-right">
                                            <input {{isset($lst_permissions[$v->name]->permissions->{$k1})?'checked':''}} type="checkbox" name="pers[{{$k}}][{{$k1}}]" class="jquery-icheck"/>
                                        </span>
                                        <div class="clearfix"></div>
                                    </li>
                                    @endif

                                    @endforeach
                                </ul>
                                @else
                                <p class="label label-warning"><i class="fa fa-warning"></i> Unsupported</p>
                                @endif
                                @endif
                            </td>
                            <td>
                                @if(isset($lst_strict[$v->name]))
                                @if(isset($lst_strict[$v->name]->type))
                                <ul>
                                    @foreach($lst_strict[$v->name]->type as $k_s=>$v_s)
                                    <li style="width: 100%;position:relative;">
                                        {{$v_s->name}}
                                        <span class="pull-right">
                                            <input {{isset($lst_permissions[$v->name]->strict_type->{$k_s})?'checked':''}} type="checkbox" name="stricts[{{$k}}][{{$k_s}}]"  class="jquery-icheck" />
                                        </span>
                                        <div class="clearfix"></div>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                                
                                @else
                                 <p class="label label-warning"><i class="fa fa-warning"></i> Unsupported</p>
                                @endif
                            </td>
                        </tr>

                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="99">

                            </td>
                        </tr>
                    </tfoot>

                </table>

            </div>
        </div>


    </div>
</form>
@endsection