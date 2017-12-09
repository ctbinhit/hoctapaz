<script>
    PNotify.prototype.options.styling = "bootstrap3";
</script>
@if(Session::has('message'))
<script>
    $(document).ready(function () {
        new PNotify({
            title: "{{@Session::get('message_title',__('label.thongbao'))}}",
            text: "{{@Session::get('message')}}",
            type: "{{@Session::get('message_type','success')}}",
        });
    });
</script>
@endif

@if(Session::has('info_callback'))
<script>
    $(document).ready(function () {
        new PNotify({
            title: "{{Session::get('info_callback')->message_title}}",
            text: "{{@Session::get('info_callback')->message}}",
            type: "{{@Session::get('info_callback')->message_type}}",
            animate: {
                animate: true,
                in_class: 'bounceInRight',
                out_class: 'bounceOutRight'
            }
        });
    });
</script>
@endif