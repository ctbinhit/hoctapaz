@if(Session::has('html_popup_normal'))
<script>
    $.alert({
        title: '{{@Session("html_popup")->message_title}}',
        content: '{{@Session("html_popup")->message}}',
    });
</script>
@endif

@if(Session::has('info_callback'))
<script>
    $(document).ready(function () {
        new PNotify({
            title: "{{@Session::get('info_callback')->message_title}}",
            text: "{{@Session::get('info_callback')->message}}",
            type: "{{@Session::get('info_callback')->message_type}}",
            styling: 'bootstrap3'
        });
    });
</script>
@endif


@if(Session::has('html_popup'))
<script>
    $(document).ready(function () {
        $.confirm({
            theme: 'modern',
            title: '{{@Session("html_popup")->message_title}}',
            content: '{{@Session("html_popup")->message}}',
            buttons: {
                hey: {
                    text: 'OK',
                    action: function () {

                    }
                }
            }
        });
    });
</script>
@endif