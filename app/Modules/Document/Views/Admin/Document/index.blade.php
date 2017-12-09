@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-file-pdf-o"></i> Tài liệu</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="x_panel">
        <div class="x_content">
            <a href="{{route('admin_index')}}" class="btn btn-app"><i class="fa fa-dashboard"></i> Dashboard</a>
            <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>
            <a href="{{route('mdle_admin_doc_tailieudangban',$type)}}" class="btn btn-app"><i class="fa icon-shop"></i> Tài liệu đang bán</a>
            <a href="{{route('mdle_admin_doc_tailieudahuy',$type)}}" class="btn btn-app"><i class="fa fa-warning"></i> Tài liệu bị từ chối</a>
        </div>
    </div>

    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-list"></i> Danh sách tài liệu chờ duyệt <small>Sắp xếp theo ngày đăng</small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <table class="table table-bordered" >

                <thead>
                    <tr>
                        <th><i class="fa fa-clock-o"></i> Ngày đăng</th>
                        <th>Tên tài liệu</th>
                        <th><i class="fa fa-user"></i> Tên GV</th>
                        <th>Giá</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($items as $k=>$v)
                    <tr data-id="{{$v->id}}">
                        <td>{{$v->created_at}}</td>
                        <td>{{$v->name}}</td>
                        <td>GV Trần Văn A</td>
                        <td>{{number_format($v->price,0)}} VNĐ</td>
                        <td>Chờ duyệt</td>
                        <td>
                            <button class="btn btn-default btn-xs jquery-btn-view"><i class="fa fa-eye"></i> Xem chi tiết</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="99">
                            {{$items->links()}}
                        </td>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>


    <!--    <div class="x_panel">
            <div class="x_title">
                <h2>Danh sách tài liệu đang bán</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
    
            </div>
        </div>-->

    <input type="hidden" name="_mdle_admin_doc_ajax" id="_mdle_admin_doc_ajax" 
           value="{{route('_mdle_admin_doc_ajax',$type)}}" />
</div>
@endsection

@push('stylesheet')

<link href="{{asset('public/fonts/entypo/entypo.css')}}" rel="stylesheet" type="text/css"/>

@endpush

@push('scripts')
<script>
    $(document).ready(function () {
        var ADC = {
            action: {
                func_60ffe9ee2b97ce26b86e97f365882ae1: function (id, tr) {
                    $.ajax({
                        url: $('#_mdle_admin_doc_ajax').val(),
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            act: '60ffe9ee2b97ce26b86e97f365882ae1',
                            id: id
                        }, success: function (response) {
                            if (response.response_state) {
                                $(tr).slideUp();
                                $.alert(jquery_alert_options({
                                    title: 'Thông báo!',
                                    content: 'Duyệt đơn thành công.'
                                }));
                            } else {
                                $.alert(jquery_alert_options({
                                    title: 'Thông báo!',
                                    content: response.response_text
                                }));
                            }
                        }, error: function (data) {

                        }
                    });
                },
                func_6bfaf02d9f3b165809fb7f056665a6bd: function (id, tr) {
                    $.ajax({
                        url: $('#_mdle_admin_doc_ajax').val(),
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            act: '6bfaf02d9f3b165809fb7f056665a6bd',
                            id: id
                        }, success: function (response) {
                            if (response.response_state) {
                                $(tr).slideUp();
                            } else {

                            }
                        }, error: function (data) {
                            console.log(data);
                        }
                    });
                }
            }
        };

        $('.jquery-btn-view').on('click', function () {
            var tr = $(this).parents('tr');
            var id = $(this).parents('tr').data('id');

            $.confirm({
                columnClass: 'col-md-10 col-md-offset-1',
                content: function () {
                    var self = this;
                    //self.setContent('Checking callback flow');
                    return $.ajax({
                        url: '{{route("_mdle_admin_doc_ajax",$type)}}',
                        dataType: 'json',
                        data: {
                            act: 'dd',
                            id: id
                        },
                        method: 'POST'
                    }).done(function (response) {
                        //console.log(response);
                        self.setContentAppend(response.view);
                    }).fail(function () {
                        //self.setContentAppend('<div>Fail!</div>');
                    }).always(function () {
                        //self.setContentAppend('<div>Always!</div>');
                    });
                },
                contentLoaded: function (data, status, xhr) {
                    //self.setContentAppend('<div>Content loaded!</div>');
                },
                onContentReady: function () {
                    //this.setContentAppend('<div>Content ready!</div>');
                },
                buttons: {
                    confirm: {
                        text: 'Chấp nhận', btnClass: 'btn btn-success',
                        action: function () {
                            ADC.action.func_60ffe9ee2b97ce26b86e97f365882ae1(id, tr);
                        }
                    },
                    reject: {
                        text: 'Từ chối', btnClass: 'btn btn-warning',
                        action: function () {
                            ADC.action.func_6bfaf02d9f3b165809fb7f056665a6bd(id, tr);
                        }
                    },
                    cancel: {
                        text: 'Để sau', btnClass: 'btn btn-default'
                    }
                }
            });
        });
    });
</script>
@endpush