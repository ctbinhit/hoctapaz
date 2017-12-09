@push('stylesheet')
<!-- 1 Tí hiệu ứng cho các nút thao tác -->
<style>
    .js-datatables-btn{
        overflow: hidden;
        position: relative;
        padding: 2px 15px;
        transition: 0.5s ease;
    }
    .js-datatables-btn p{
        padding: 0px;
        margin: 0px;
        position: absolute;
        top: 2px;
        left: 7px;
        transition: 0.5s ease;
    }
    .js-datatables-btn i{
        position: relative;
        left: -500%;
        transition: 0.5s ease;
    }
    .js-datatables-btn:hover{
        background: #F00;
        border-color: #F00;

    }
    .js-datatables-btn:hover i{
        left: 0%;color: #FFF;
    }
    .js-datatables-btn:hover p{
        left: 100%;
    }
</style>
@endpush