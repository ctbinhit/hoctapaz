@push('scripts')
<script>
    var packageLang = {
        lengthMenu: "{{__('label.hienthi')}} _MENU_ {{__('message.ketquatrentrang')}}",
        zeroRecords: "{{__('message.khongcodulieu')}}",
        info: "{{__('label.hienthi')}} _PAGE_ {{__('label.tren')}} _PAGES_",
        infoEmpty: "No records available",
        infoFiltered: "(filtered from _MAX_ total records)",
        sInfoPostFix: "",
        sInfoThousands: ",",
        sSearch: "{{__('label.timkiem')}}:",
        sLoadingRecords: "{{__('message.dangtai')}}...",
        sProcessing: "{{__('message.dangxuly')}}...",
        sZeroRecords: "{{__('message.khongtimthayketquanao')}}",
        oPaginate: {
            sFirst: "{{__('label.dau')}}",
            sLast: "{{__('label.cuoi')}}",
            sNext: "{{__('label.ke')}}",
            sPrevious: "{{__('label.lui')}}"
        },
        oAria: {
            sSortAscending: ": activate to sort column ascending",
            sSortDescending: ": activate to sort column descending"
        }
    };
</script>
@endpush