@extends('admin.layouts.master')

@section('content')
<style>
    table th,td{text-align: center;}
</style>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-exchange"></i> Danh sách yêu cầu nạp/rút</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_content">
                    <a href="{{route('admin_index')}}" class="btn btn-app"><i class="fa fa-dashboard"></i> Dashboard</a>
                    <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-search"></i> Tìm kiếm</h2><div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form class="form form-horizontal">
                        <div class="form-group">
                            <label for="keywords" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-12">Từ khóa:</label>
                            <div class="col-lg-11 col-md-10 col-sm-10 col-xs-12 input-group">
                                <input type="text" name="keywords" id="keywords" 
                                       class="form-control" placeholder="Tìm kiếm..." />

                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-11 col-lg-offset-1 col-md-10 col-sm-10 col-xs-12 input-group">
                                <span class="input-group-addon">Loại</span>
                                <select name="filterType" style="" class="form-control">
                                    @foreach($filter_data['filterType'] as $k => $v)
                                    <option {{$v==Request::get('filterType')?'selected':''}} value="{{$v}}">{{$k}}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-addon">Trạng thái</span>
                                <select name="filterState" style="" class="form-control">
                                    @foreach($filter_data['filterState'] as $k => $v)
                                    <option {{$v===(int)Request::get('filterState')?'selected':''}} value="{{$v}}">{{$k}}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-addon">Sắp xếp</span>
                                <select name="filterSortBy" style="" class="form-control">
                                    @foreach($filter_data['filterSortBy'] as $k => $v)
                                    <option {{$v==Request::get('filterSortBy')?'selected':''}} value="{{$v}}">{{$k}}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-addon"><i class="fa fa-sort-amount-asc"></i></span>
                                <select name="filterSortVal" style="" class="form-control">
                                    @foreach($filter_data['filterSortVal'] as $k => $v)
                                    <option {{$v==Request::get('filterSortVal')?'selected':''}} value="{{$v}}">{{$k}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-list"></i> Danh sách yêu cầu nạp/rút <small> Mới nhất</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table class="table table-bordered" >
                        <thead>
                            <tr>
                                <th data-toggle="tooltip" data-placement="top" title="Ngày đăng"><i class="fa fa-calendar"></i></th>
                                <th data-toggle="tooltip" data-placement="top" title="Họ & Tên"><i class="fa fa-user"></i></th>
                                <th data-toggle="tooltip" data-placement="top" title="Email"><i class="fa fa-envelope"></i></th>
                                <th data-toggle="tooltip" data-placement="top" title="Số tiền yêu cầu rút"><i class="fa fa-money"></i></th>
                                <th data-toggle="tooltip" data-placement="top" title="Trạng thái"><i class="fa fa-steam"></i></th>
                                <th width="20%" data-toggle="tooltip" data-placement="top" title="Thao tác">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $k=>$v)
                            <tr data-id="{{$v->id}}">
                                <td>{{$v->created_at}}</td>
                                <td>{{$v->user_fullname}} <a href=""></a></td>
                                <td>{{$v->user_email}}</td>
                                <td>{{number_format($v->amount,0)}} VNĐ</td>
                                <td class="tr_state">
                                    @if($v->state==1)
                                    <i class="label label-success">Success</i>
                                    @else
                                    <i class="label label-warning">Pending</i>
                                    @endif
                                </td>
                                <td>
                                    <select class="form-control frm_state">
                                        @foreach($stateList as $v1)
                                        <option {{$v->state == $v1[1] ? 'selected':''}} value="{{$v1[1]}}" >{{$v1[0]}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="99">
                                    {{$items_links}}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="mdle_admin_collaborator_ajax" value="{{route('_mdle_admin_collaborator_ajax')}}"  />
@endsection

@push('scripts')
<script>
    $('.frm_state').on('change', function () {
        var tr = $(this).parents('tr');
        var this_select = this;
        $.ajax({
            url: $('#mdle_admin_collaborator_ajax').val(),
            beforeSend: function () {
                $(tr).find('.tr_state').html('<i class="fa fa-spinner faa-spin animated"></i>');
            },
            type: 'POST',
            dataType: 'json',
            data: {
                act: 'cs',
                id: $(tr).data('id'),
                state: $(this_select).val()
            }, success: function (data) {
                if (data.state) {
                    var str = '';
                    console.log($(this_select).val());
                    switch (parseInt($(this_select).val())) {
                        case 1:
                            str = '<i class="label label-success">Success</i>';
                            break;
                        case 0:
                            str = '<i class="label label-warning">Pending</i>';
                            break;
                        case 2:
                            str = '<i class="label label-warning">Pending</i>';
                            break;
                        default:
                            str = '<i class="label label-danger">Undefined</i>';
                    }
                    $(tr).find('.tr_state').html(str);
                } else {
                    $(tr).find('.tr_state').html('<i class="fa fa-warning"></i>');
                }
            }, error: function (data) {
                console.log(data);
            }
        });
    });
</script>
@endpush