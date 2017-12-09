<script>
    $(document).ready(function () {
        $('.jquery-input-file').on('click', function () {
            var that = this;
            $('#' + $(this).data('input')).click();
            $('#' + $(this).data('input')).on('change', function (evt) {
                if (this.value == '') {

                } else {
                    $('.jquery-input-file-remove[data-input="photo"]').removeAttr('disabled');
                    $('#photo_preview').attr('src', URL.createObjectURL(evt.target.files[0]));
                    $(that).text(this.value);
                }
            });
        });
        $('.jquery-input-file-remove').on('click', function () {
            $('#' + $(this).data('input'))[0].value = null;
            $('.jquery-input-file[data-input="photo"]').text('Chọn file...');
            $(this).attr('disabled', 'disabled');
        });
    });
</script>
<script>
    $(function () {
        var $image = $('#hinhanh');
        var $previews = $('.preview');
        var $download = $('#download');
        function init_scopper() {
            $($image).cropper({
                ready: function (e) {
                    var $clone = $(this).clone().removeClass('cropper-hidden');
                    $clone.css({
                        display: 'block',
                        width: '100%',
                        minWidth: 0,
                        minHeight: 0,
                        maxWidth: 'none',
                        maxHeight: 'none'
                    });
                    $previews.css({
                        width: '100%',
                        overflow: 'hidden'
                    }).html($clone);
                },
                crop: function (e) {
                    var imageData = $(this).cropper('getImageData');
                    var previewAspectRatio = e.width / e.height;
                    $previews.each(function () {
                        var $preview = $(this);
                        var previewWidth = $preview.width();
                        var previewHeight = previewWidth / previewAspectRatio;
                        var imageScaledRatio = e.width / previewWidth;
                        $preview.height(previewHeight).find('img').css({
                            width: imageData.naturalWidth / imageScaledRatio,
                            height: imageData.naturalHeight / imageScaledRatio,
                            marginLeft: -e.x / imageScaledRatio,
                            marginTop: -e.y / imageScaledRatio
                        });
                    });
                }
            });
        }

        // Tooltip
        $('[data-toggle="tooltip"]').tooltip();
        // Buttons
        if (!$.isFunction(document.createElement('canvas').getContext)) {
            $('button[data-method="getCroppedCanvas"]').prop('disabled', true);
        }

        if (typeof document.createElement('cropper').style.transition === 'undefined') {
            $('button[data-method="rotate"]').prop('disabled', true);
            $('button[data-method="scale"]').prop('disabled', true);
        }

        //    // Download
        //    if (typeof $download[0].download === 'undefined') {
        //        $download.addClass('disabled');
        //    }

        // Methods
        $('.docs-buttons').on('click', '[data-method]', function () {
            var $this = $(this);
            var data = $this.data();
            var $target;
            var result;
            if ($this.prop('disabled') || $this.hasClass('disabled')) {
                return;
            }

            if ($image.data('cropper') && data.method) {
                data = $.extend({}, data); // Clone a new one

                if (typeof data.target !== 'undefined') {
                    $target = $(data.target);
                    if (typeof data.option === 'undefined') {
                        try {
                            data.option = JSON.parse($target.val());
                        } catch (e) {
                            console.log(e.message);
                        }
                    }
                }

                result = $image.cropper(data.method, data.option, data.secondOption);
                switch (data.method) {
                    case 'scaleX':
                    case 'scaleY':
                        $(this).data('option', -data.option);
                        break;
                    case 'getCroppedCanvas':
                        if (result) {
                            // Bootstrap's Modal
                            $('#getCroppedCanvasModal').modal().find('.modal-body').html(result);
                            if (!$download.hasClass('disabled')) {
                                $download.attr('href', result.toDataURL());
                            }
                        }

                        break;
                }

                if ($.isPlainObject(result) && $target) {
                    try {
                        $target.val(JSON.stringify(result));
                    } catch (e) {
                        console.log(e.message);
                    }
                }

            }
        });
        // Keyboard
        $(document.body).on('keydown', function (e) {
            if (!$image.data('cropper') || this.scrollTop > 300) {
                return;
            }

            switch (e.which) {
                case 37:
                    e.preventDefault();
                    $image.cropper('move', -1, 0);
                    break;
                case 38:
                    e.preventDefault();
                    $image.cropper('move', 0, -1);
                    break;
                case 39:
                    e.preventDefault();
                    $image.cropper('move', 1, 0);
                    break;
                case 40:
                    e.preventDefault();
                    $image.cropper('move', 0, 1);
                    break;
            }
        });
        // Import image
        var $inputImage = $('#inputImage');
        var URL = window.URL || window.webkitURL;
        var blobURL;
        if (URL) {
            $inputImage.change(function () {
                init_scopper();
                var files = this.files;
                var file;
                if (!$image.data('cropper')) {
                    return;
                }

                if (files && files.length) {
                    file = files[0];
                    if (/^image\/\w+$/.test(file.type)) {
                        blobURL = URL.createObjectURL(file);
                        $image.one('built.cropper', function () {

                            // Revoke when load complete
                            URL.revokeObjectURL(blobURL);
                        }).cropper('reset').cropper('replace', blobURL);
                        $inputImage.val('');
                    } else {
                        window.alert('Please choose an image file.');
                    }
                }
            });
        } else {
            $inputImage.prop('disabled', true).parent().addClass('disabled');
        }

    });
</script>
