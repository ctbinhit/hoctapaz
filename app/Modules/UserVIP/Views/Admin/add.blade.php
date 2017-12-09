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
            <h3>Thêm VIP</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="x_panel">

        <form method="post" action="{{route('_mdle_uservip_save')}}" class="form form-horizontal" name="form-uservip-add">
            {{csrf_field()}}
            <input type="hidden" name="id" value="{{@$item->id}}" />
            
            <div class="form-group">
                <label for="name" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Tên VIP:</label>
                <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                    <input type="text" name="name" id="name" class="form-control" value="{{@$item->name}}" 
                           placeholder="Tên vip..." />
                </div>
            </div>

            <div class="form-group">
                <label for="discount" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Chiết khấu:</label>
                <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                    <input type="number" name="discount" id="discount" class="form-control" value="{{@$item->discount}}" 
                           placeholder="% chiết khấu..." />
                </div>
            </div>

            <div class="form-group">
                <label for="sum" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Điều kiện:</label>
                <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                    <input type="number" name="sum" id="sum" class="form-control" value="{{@$item->sum}}" 
                           placeholder="Điều kiện để lên vip" />
                </div>
            </div>

            <div class="form-group">
                <label for="note" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Ghi chú (admin):</label>
                <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                    <textarea rows="5" class="form-control" name="note" id="note">{{@$item->note}}</textarea>
                </div>
            </div>

            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 col-md-offset-2">
                    <a href="{{url()->previous()}}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Quay lại</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Lưu</button>
                </div>
            </div>



        </form>

    </div> 
</div>

@endsection