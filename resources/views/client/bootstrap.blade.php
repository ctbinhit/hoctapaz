<script>
    $(document).ready(function () {
        $('.jquery-dangcapnhat').on('click', function (e) {
            e.preventDefault();
            $.alert(jquery_alert_options({
                title: 'Thông báo', icon: 'fa fa-warning', content: 'Chức năng này đang tạm khóa để cập nhật, vui lòng quay lại sau!', type: 'blue',
                buttons: {confirmAction: {text: 'OK', btnClass: 'btn btn-info'}}
            }));
        });
        $('a[href="#"]').on('click', function (e) {
            e.preventDefault();
            $.alert(jquery_alert_options({
                title: 'Thông báo', icon: 'fa fa-warning', content: 'Chức năng này đang tạm khóa để cập nhật, vui lòng quay lại sau!', type: 'blue',
                buttons: {confirmAction: {text: 'OK', btnClass: 'btn btn-info'}}
            }));
        });
    });
</script>