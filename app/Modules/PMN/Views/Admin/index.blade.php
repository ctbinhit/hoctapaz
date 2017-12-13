
@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-info"></i> Thông báo trang</h3>
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
    </div>

    <div class="x_panel">
        <div class="x_title">
            <h2>Chạy thông báo</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <form class="form-horizontal form-label-left" action="" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="hidden" name="type" value="{{$type}}" />

                <div class="form-group">
                    <label class="control-label col-md-2">Nội dung:</label>
                    <div class="col-md-10 col-xs-12">
                        <input type="text" name="content" class="form-control" value="{{$item->content}}"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Hiển thị:</label>
                    <div class="col-md-1 col-xs-12">
                        <input type="checkbox" name="display" class="form-control jquery-icheck"
                               {{$item->display?'checked':''}}/>
                    </div>
                    <div class="col-md-3 col-xs-12">
                        <select name="scrollamount" class="form-control">
                            <option value="5">Chậm</option>
                            <option value="10">Bình thường</option>
                            <option value="15">Bình thường+</option>
                            <option value="20">Nhanh</option>
                            <option value="25">Nhanh+</option>
                        </select>
                    </div>
                </div>

                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-10 col-md-offset-2">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Lưu</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $('.jquery-dtp-custom-time').datetimepicker({
            language: 'en',
            pick12HourFormat: true
        });
    });
</script>
@endpush