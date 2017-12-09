
@extends('admin.layouts.master')
@push('stylesheet')
<style>
    table th,td {
        text-align: center;
    }
</style>
@endpush
@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Danh sách controllers</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="x_panel">
        <div class="x_content">
            <a href="{{route('mdle_userpermission_index')}}" class="btn btn-app"><i class="fa fa-arrow-left"></i> Quay lại</a>
            <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>
            <a href="{{route('mdle_userpermission_package_update')}}" class="btn btn-app"><i class="fa fa-database"></i> Cập nhật CSDL</a>
        </div>
    </div>

    <div class="x_panel">
        <div class="x_title">
            <h2>Danh sách controllers khả dụng.</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <form class="form form-horizontal" action="{{route('_mdle_userpermission_sc_save')}}" method="POST">
                {{csrf_field()}}

                <div class="form-group">
                    <label for="controller_name" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Tên:</label>
                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                        <input type="text" name="controller_name" id="controller_name" class="form-control" placeholder="Tên controller" required=""/>
                    </div>

                </div>

                <div class="form-group">
                    <label for="id" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Controller:</label>
                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                        <select class="form-control" name="id" id="id">
                            @foreach($controllers as $k=>$v)
                            <option>{{$v}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="type" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Type:</label>
                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                        <select class="form-control" name="type" id="type">
                            <option value="admin" selected="">Admin</option>
                            <option value="client">Client</option>
                            <option value="pi">Pi</option>
                        </select>
                    </div>
                </div>

                <div class="ln_solid"></div>

                <div class="form-group">
                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 col-md-offset-2">
                        <button class="btn btn-success"><i class="fa fa-save"></i> Đăng ký</button>
                    </div>

                </div>

            </form>
        </div>
    </div>

    <div class="x_panel">
        <div class="x_title">
            <h2>Controllers đã đăng ký</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <table class="table table-bordered" >
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Name</th>
                        <th>Trạng thái</th>
                        <th>Type</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($db_controllers as $k=>$v)
                    <tr>
                        <td>{{$k+1}}</td>
                        <td>{{$v->name}}</td>
                        <td><i class="fa fa-check-circle"></i> </td>
                        <td>{{$v->type}}</td>
                        <td>
                            <a href="#" class="btn btn-default btn-xs"><i class="fa fa-edit"></i></a>
                            <a href="#" class="btn btn-primary btn-xs"><i class="fa fa-gear faa-spin animated"></i> Log</a>
                            <a href="javascript:;" data-id="{{$v->id}}" class="btn btn-danger btn-xs jquery-btn-remove"><i class="fa fa-remove"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="99">
                            <p><i class="fa icon-toannang"></i> Developed by ToanNang Co., Ltd</p>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <input type="hidden" name="_mdle_userpermission_sc_ajax" id="_mdle_userpermission_sc_ajax" value="{{route('_mdle_userpermission_sc_ajax')}}" />
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('.jquery-btn-remove').on('click', function (e) {
            var this_tr = $(this).parents('tr');
            var id_controller = $(this).data('id');
            e.preventDefault();
            $.confirm({
                title: 'Xóa controller!', type: 'red', autoClose: 'cancel|10000', icon: 'fa fa-warning',
                content: 'Lưu ý! nếu bạn không phải là nhà cung cấp, vui lòng đừng tự ý xóa những khóa của hệ thống website, việc này có thể dẫn đến website bị ngưng hoạt động!',
                buttons: {
                    confirm: {
                        text: 'Chấp nhận xóa, chịu mọi rủi ro.', btnClass: 'btn btn-danger',
                        action: function () {
                            $.ajax({
                                url: $('#_mdle_userpermission_sc_ajax').val(),
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    act: 'rc',
                                    id: id_controller
                                }, success: function (data) {
                                    if(data.response_state){
                                        $(this_tr).slideUp();
                                    }else{
                                        $.alert(jquery_alert_options({
                                            title: 'Lỗi',
                                            content: 'Xóa thất bại, vui lòng thử lại sau ít phút.'
                                        }));
                                    }
                                }, error: function (data) {
                                    console.log(data);
                                }
                            });
                        }
                    },
                    cancel: {
                        text: 'Quay lại'
                    },
                }
            });
        });
    });
</script>
@endpush