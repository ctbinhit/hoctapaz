<script>
    $('.js-switch-checked').attr('checked', '');

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