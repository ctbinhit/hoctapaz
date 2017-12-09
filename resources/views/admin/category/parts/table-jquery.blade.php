<table id="jquery-datatable-default" class="table table-striped table-bordered bulk_action jquery-datatable">
    <thead>
        <tr>
            <th></th>
            <th>{{__('label.stt')}}</th>
            <th>{{__('label.ten')}}</th>
            <th>{{__('label.hinhanh')}}</th>
            <th>{{__('label.luotxem')}}</th>
            <th>{{__('label.ngaytao')}}</th>
            <th>{{__('label.noibat')}}</th>
            <th>{{__('label.hienthi')}}</th>
            <th>{{__('label.thaotac')}}</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th></th>
            <th>{{__('label.stt')}}</th>
            <th>{{__('label.ten')}}</th>
            <th>{{__('label.hinhanh')}}</th>
            <th>{{__('label.luotxem')}}</th>
            <th>{{__('label.ngaytao')}}</th>
            <th>{{__('label.noibat')}}</th>
            <th>{{__('label.hienthi')}}</th>
            <th>{{__('label.thaotac')}}</th>
        </tr>
    </tfoot>
    <tbody>
    </tbody>
</table>

@push('stylesheet')
<!-- Datatables -->
<link href="{!! asset('public/plugins/Datatables/DataTables-1.10.15/css/dataTables.bootstrap.min.css')!!}" rel="stylesheet">
<link href="{!! asset('public/plugins/Datatables/Buttons-1.4.0/css/buttons.bootstrap.min.css')!!}" rel="stylesheet">

<link href="{!! asset('public/plugins/Datatables/KeyTable-2.3.0/css/keyTable.bootstrap.min.css')!!}" rel="stylesheet">
<!-- Datatables Select -->
<link href="{!! asset('public/plugins/Datatables/Select-1.2.2/css/select.bootstrap.min.css')!!}" rel="stylesheet">
<!-- Datatables Editor -->
<link href="{!! asset('public/plugins/Datatables/Editor-PHP-1.6.4/css/editor.bootstrap.min.css')!!}" rel="stylesheet">
@endpush

@push('scripts')
<!-- Datatables -->
<script src="{!! asset('public/plugins/Datatables/DataTables-1.10.15/js/jquery.dataTables.min.js')!!}"></script>
<script src="{!! asset('public/plugins/Datatables/DataTables-1.10.15/js/dataTables.bootstrap.min.js')!!}"></script>

<script src="{!! asset('public/plugins/Datatables/Buttons-1.4.0/js/dataTables.buttons.min.js')!!}"></script>
<script src="{!! asset('public/plugins/Datatables/Buttons-1.4.0/js/buttons.bootstrap.min.js')!!}"></script>
<script src="{!! asset('public/plugins/Datatables/Buttons-1.4.0/js/buttons.flash.min.js')!!}"></script>
<script src="{!! asset('public/plugins/Datatables/Buttons-1.4.0/js/buttons.html5.min.js')!!}"></script>
<script src="{!! asset('public/plugins/Datatables/Buttons-1.4.0/js/buttons.print.min.js')!!}"></script>

<script src="{!! asset('public/plugins/Datatables/pdfmake-0.1.27/build/pdfmake.min.js')!!}"></script>
<script src="{!! asset('public/plugins/Datatables/pdfmake-0.1.27/build/vfs_fonts.js')!!}"></script>

<script src="{!! asset('public/plugins/Datatables/KeyTable-2.3.0/js/dataTables.keyTable.min.js')!!}"></script>

<script src="{!! asset('public/plugins/Datatables/Select-1.2.2/js/dataTables.select.min.js')!!}"></script>

<script src="{!! asset('public/plugins/Datatables/Editor-PHP-1.6.4/js/dataTables.editor.min.js')!!}"></script>
<script src="{!! asset('public/plugins/Datatables/Editor-PHP-1.6.4/js/editor.bootstrap.min.js')!!}"></script>

@include('admin.category.jsc.JSCategoryController')
@endpush