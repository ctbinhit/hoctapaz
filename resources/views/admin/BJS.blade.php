<style>
    .js-switch-checked{}
</style>
<script>
    $('.js-switch-checked').attr('checked', '');

    function to_slug(str)
    {
        str = str.toLowerCase();
        str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, 'a');
        str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, 'e');
        str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, 'i');
        str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, 'o');
        str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, 'u');
        str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, 'y');
        str = str.replace(/(đ)/g, 'd');
        str = str.replace(/([^0-9a-z-\s])/g, '');
        str = str.replace(/(\s+)/g, '-');
        str = str.replace(/^-+/g, '');
        str = str.replace(/-+$/g, '');
        return str;
    }

    var bstring = {
        fillSlugValue: function (element) {
            var input = $(element).data('fill');
            $(element).on('keyup', function () {
                $('#' + input).val(bstring.func.toSlug($(this).val()));
            });
        },
        func: {
            toSlug: function (str) {
                str = str.toLowerCase();
                str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, 'a');
                str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, 'e');
                str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, 'i');
                str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, 'o');
                str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, 'u');
                str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, 'y');
                str = str.replace(/(đ)/g, 'd');
                str = str.replace(/([^0-9a-z-\s])/g, '');
                str = str.replace(/(\s+)/g, '-');
                str = str.replace(/^-+/g, '');
                str = str.replace(/-+$/g, '');
                return str;
            }
        }
    };

    var bcore_metaname = {
        registerEvent: function (pInputVal) {
            var _this = pInputVal;
            var inputMeta = $(_this).data('listen');
            $('#' + inputMeta).val(to_slug($(_this).val()));
            $(pInputVal).on('keyup', function () {
                var inputMeta = $(this).data('listen');
                $('#' + inputMeta).val(to_slug($(this).val()));
                $('#suggestion-' + inputMeta).val(to_slug($(this).val()));
            });
        }
    };
</script>
<script>
    $.fn.ajaxSwitch = function (options) {
        var settings = $.extend({
            debug: false,
            on: 'blur',
            route: $('meta[name="ajax-request"]').attr('content'),
            field: null,
            action: 'us',
            dataType: 'json',
            method: 'post',
            table: null
        }, options);
        var ajaxSwitchHelper = {
            log: function (data) {
                if (settings.debug)
                    console.log(data);
            }
        };
        return this.each(function () {
            $(this).on(settings.on, function () {
                var table = $(this).data('tbl');
                var id = $(this).data('id');
                var field_name = $(this).attr('name');
                var field_val = $(this).prop('checked');
                $.ajax({
                    url: settings.route,
                    type: settings.method,
                    dataType: settings.dataType,
                    data: {
                        act: settings.action,
                        tbl: table,
                        fieldName: field_name,
                        fieldVal: field_val,
                        id: id
                    }, success: function (data) {
                        ajaxSwitchHelper.log(data);
                    }, error: function (data) {
                        ajaxSwitchHelper.log(data);
                    }
                });

            });
        });
    };

    $.fn.ajaxField = function (options) {
        var settings = $.extend({
            on: 'blur',
            route: $('meta[name="ajax-request"]').attr('content'),
            field: null,
            action: 'uf',
            dataType: 'json',
            method: 'post',
            table: null
        }, options);
        var ajaxFieldHelper = {
            log: function (data) {
                if (settings.debug)
                    console.log(data);
            }
        };
        return this.each(function () {
            $(this).on(settings.on, function () {
                var field_name = $(this).attr('name');
                var field_val = $(this).val();
                $.ajax({
                    url: settings.route,
                    type: settings.method,
                    dataType: settings.dataType,
                    data: {
                        act: settings.action,
                        tbl: settings.table,
                        fieldName: field_name,
                        fieldVal: field_val,
                        id: $(this).data('id')
                    }, success: function (data) {
                        ajaxFieldHelper.log(data);
                    }, error: function (data) {
                        ajaxFieldHelper.log(data);
                    }
                });
            });
        });
    };


</script>
<script>
    $(document).ready(function () {
        $('.jquery-dangcapnhat').on('click', function () {
            $.alert(jquery_alert_options({
                title: 'Thông báo', icon: 'fa fa-warning', content: 'Chức năng này đang tạm khóa để cập nhật, vui lòng quay lại sau!', type: 'blue',
                buttons: {confirmAction: {text: 'OK', btnClass: 'btn btn-info'}}
            }));
        });
        $('a[href="#"]').css('color', '#F00');
        $('a[href="#"]').on('click', function (e) {
            e.preventDefault();
            $.alert(jquery_alert_options({
                title: 'Thông báo', icon: 'fa fa-warning', content: 'Chức năng này đang tạm khóa để cập nhật, vui lòng quay lại sau!', type: 'blue',
                buttons: {confirmAction: {text: 'OK', btnClass: 'btn btn-info'}}
            }));
        });
    });
</script>

<script>
    function jquery_confirm_options(options) {
        return $.extend({
            icon: 'fa fa-warning', animation: 'RotateY', closeAnimation: 'RotateY', animationBounce: 0,
            theme: 'material', type: 'blue', animationSpeed: 500, backgroundDismiss: false
        }, options);
    }
    function jquery_alert_options(options) {
        return $.extend({
            icon: 'fa fa-warning', animation: 'RotateY', closeAnimation: 'RotateY', animationBounce: 0,
            theme: 'material', type: 'blue', animationSpeed: 400, backgroundDismiss: false
        }, options);
    }
    function jao(data) {
        return jquery_alert_options(data);
    }
    function jco(data) {
        return jquery_confirm_options(data);
    }
</script>