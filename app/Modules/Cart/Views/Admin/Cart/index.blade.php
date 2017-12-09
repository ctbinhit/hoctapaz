
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
                    <label for="txt_search" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Từ khóa:</label>
                    <div class="col-lg-8 col-md-10 col-sm-9 col-xs-12 input-group">
                        <input type="text" name="keywords" id="txt_search" class="form-control"
                               value="{{Request::get('keywords')}}" placeholder="Nhập từ khóa... ( Mã đơn hàng, SĐT... )" />
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            <a href="{{url()->current()}}" class="btn btn-danger"><i class="fa fa-remove"></i></a>
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

        </div>



    </div>

</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        var ADCC = {
            debug: true,
            route: '{{route("_mdle_admin_cart_ajax")}}',
            log: function (data) {
                if (ADCC.debug) {
                    console.log(data);
                }
            },
            table: {
                stateText: function (data, type = 'info') {
                    $(ADCC.elements.table).html('<div class="text-' + type + ' text-center">' + data + '</div>');
                }
            },
            elements: {
                table: null,
                paginate: '#jquery-adcc-paginate'
            },
            components: {
                loading: '<i class="fa fa-spinner faa-spin animated"></i> Đang tính toán...',
                hasError: '<i class="fa fa-warning"></i> Có lỗi xảy ra...',
            },
            init: function (table) {
                ADCC.elements.table = table;
                ADCC.action.loadHtml();
                ADCC.registerEvent.hashchange();

            },
            registerEvent: {
                hashchange: function () {
                    $(window).on('hashchange', function () {
                        if (window.location.hash) {
                            var page = window.location.hash.replace('#', '');
                            if (page == Number.NaN || page <= 0) {
                                return false;
                            } else {
                                ADCC.action.loadHtml(page);
                            }
                        }
                    });
                    $(document).on('click', '.pagination a', function (e) {
                        ADCC.action.loadHtml($(this).attr('href').split('page=')[1]);
                        e.preventDefault();
                    });
                }

            },
            action: {
                loadHtml: function (page) {
                    $.ajax({
                        url: '{{route("mdle_admin_cart_index")}}?page=' + page +
                                '&keywords={{Request::input("keywords")}}',
                        dataType: 'json',
                        beforeSend: function (xhr) {
                            ADCC.table.stateText(ADCC.components.loading);
                        }, success: function (data) {
                            if (data.state) {
                                $(ADCC.elements.table).html(data.html);
                                location.hash = page;
                            }

                        }, error: function (data) {
                            ADCC.table.stateText(ADCC.components.hasError, 'danger');
                        }
                    });
                }
            }
        };
        ADCC.init('.jquery-adcc-table');
    });
</script>
@endpush