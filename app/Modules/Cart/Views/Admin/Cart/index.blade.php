
@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-shopping-cart"></i> Đơn hàng </h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="x_panel">
        <div class="x_content">
            <a href="{{route('admin_index')}}" class="btn btn-app"><i class="fa fa-dashboard"></i> Dashboard</a>
            <a href="{{url()->full()}}" class="btn btn-app"><i class="fa fa-refresh"></i> Tải lại</a>
        </div>
    </div>

    <div class="x_panel">
        <div class="x_title"> <h2><i class="fa fa-search"></i> Lọc</h2><div class="clearfix"></div></div>
        <div class="x_content">
            <form class="form form-horizontal" name="frm_cart_search" method="get" action="">
                <div class="form-group">
                    <label for="txt_search" class="control-label col-lg-1 col-md-2 col-sm-3 col-xs-12">Từ khóa:</label>
                    <div class="col-lg-11 col-md-10 col-sm-9 col-xs-12 input-group">
                        <input type="text" name="keywords" id="txt_search" class="form-control"
                               value="{{Request::get('keywords')}}" placeholder="Nhập từ khóa... ( Mã đơn hàng, SĐT... )" />
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            @if(Request::has('keywords'))
                            <a href="{{url()->current()}}" class="btn btn-danger"><i class="fa fa-remove"></i></a>
                            @endif
                        </span>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <div class="x_panel">
        <div class="x_title">
            <h2>Danh sách <small>danh sách đơn hàng mới nhất</small></h2> <div class="clearfix"></div>
        </div>
        <div class="x_content jquery-adcc-table">
            @include('Cart::Admin.Cart.parts.component_carts')
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
   
</script>
@endpush