
@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3></h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <form class="form-horizontal form-label-left" action="{{route('_mdle_background_index')}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="type" value="{{@$type}}"/>
        <div class="col-md-12 col-xs-12">
            @if(Session::has('html_callback'))
            <div class="alert alert-dismissible alert-{{Session::get('html_callback')->message_type}}" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>{{Session::get('html_callback')->message_title}}: </strong> {{Session::get('html_callback')->message}}!
            </div>
            @endif
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{ __('label.thongtinchung')}} <small>Cập nhật hình nền</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">Chọn hình</label>
                                <div class="col-md-9 col-xs-12">
                                    <input type="file" name="file" id="jquery-input-file" class="form-control jquery-input-file"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Thông tin</label>
                                <div class="col-md-9 col-xs-12">
                                    <div class="jquery-input-file-info">
                                        <p>Vui lòng chọn file hình ảnh.</p>
                                    </div>
                                </div>
                            </div>

                            @if(@$item->background_url!=null)

                            <div class="form-group">
                                <label class="control-label col-md-3">Repeat</label>    
                                <div class="col-md-9 col-xs-12">
                                    <input type="checkbox" name="background_repeat" {{@$item->background_repeat=='unset'?'checked':''}} class="jquery-icheck jquery-app-toolbox-btn-bgr"/> Background repeat (Lặp hình)
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Background size</label>
                                <div class="col-md-2 col-xs-12">
                                    <input type="radio" name="background_size" value="unset" {{@$item->background_size=='unset'?'checked':''}} class="jquery-icheck jquery-app-toolbox-input-bgs"/> Normal
                                </div>
                                <div class="col-md-3 col-xs-12">
                                    <input type="radio" name="background_size" value="100% 100%" {{@$item->background_size=='100% 100%'?'checked':''}} class="jquery-icheck jquery-app-toolbox-input-bgs"/> Fill (100%)
                                </div>
                                <div class="col-md-2 col-xs-12">
                                    <input type="radio" name="background_size" value="contain" {{@$item->background_size=='contain'?'checked':''}} class="jquery-icheck jquery-app-toolbox-input-bgs"/> Contain
                                </div>
                                <div class="col-md-2 col-xs-12">
                                    <input type="radio" name="background_size" value="cover" {{@$item->background_size=='cover'?'checked':''}} class="jquery-icheck jquery-app-toolbox-input-bgs"/> Cover
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Background position</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input type="number" name="background_position_x" class="form-control jquery-app-toolbox-input-bgp-left" value="{{$item->background_position_x}}" placeholder="Position x"/>
                                        <span class="input-group-addon">LEFT</span>
                                        <input type="number" name="background_position_y" class="form-control jquery-app-toolbox-input-bgp-top" value="{{$item->background_position_y}}" placeholder="Position y"/>
                                        <span class="input-group-addon">TOP</span>
                                    </div>

                                    <div class="button-group">
                                        <button type="button" class="btn btn-default jquery-app-toolbox-btn-bgp-left"><i class="fa fa-arrow-left"></i></button>
                                        <button type="button" class="btn btn-default jquery-app-toolbox-btn-bgp-down"><i class="fa fa-arrow-down"></i></button>
                                        <button type="button" class="btn btn-default jquery-app-toolbox-btn-bgp-up"><i class="fa fa-arrow-up"></i></button>
                                        <button type="button" class="btn btn-default jquery-app-toolbox-btn-bgp-right"><i class="fa fa-arrow-right"></i></button>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-9 col-md-offset-3">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Lưu</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 jquery-app-toolbox-imageResize">
                            <div class="panel panel-default">
                                <div class="panel-heading"><i class="fa fa-edit"></i> Công cụ</div>
                                <div class="panel-body"> 
                                    <div class="row">
                                        <div class="col-md-12">
<!--                                            <div class="form-group">
                                                <label class="control-label col-md-3">Resize</label>    
                                                <div class="col-md-9 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-md-12 input-group">
                                                            <input type="text" class="form-control"/>
                                                            <span class="input-group-addon">x</span> 
                                                            <input type="text" class="form-control"/>
                                                            <span class="input-group-addon">px</span> 
                                                        </div>
                                                        <div class="col-md-12">
                                                            <p>Hình ảnh mà bạn up lên sẽ resize theo thông số này, nên để kích thước bằng hoặc lớn hơn 10px thành phần div cha để hình ảnh được hiển thị rõ nét nhất.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>-->

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Div size</label>    
                                                <div class="col-md-9 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-md-12 input-group">
                                                            <input type="number" class="form-control jquery-app-toolbox-input-resize-x" value="1024" />
                                                            <span class="input-group-addon">x</span> 
                                                            <input type="number" class="form-control jquery-app-toolbox-input-resize-y" value="400"/>
                                                            <span class="input-group-addon">px</span> 
                                                        </div>
                                                        <div class="col-md-12">
                                                            <p>Kích thước của thành phần bên ngoài (Nên để mặc định)</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Resize mode</label>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-6 col-xs-12">
                                                            <input type="radio" name="resize_mode" class="jquery-icheck"/> Resize image
                                                        </div>
                                                        <div class="col-md-6 col-xs-12">
                                                            <input type="radio" name="resize_mode" checked class="jquery-icheck"/> Resize canvas
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer"><i class="fa fa-copyright"></i> 2017 Created by Bình Cao | Developed by ToanNang Co., Ltd</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-laptop"></i> Hình ảnh <small>Demo</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div style="background: #CCC;border:1px solid #ccc;width: 1024px;height: 365px;{!!@$item->css!!}" class="background-preview jquery-app-toolbox-imagePreview">
                    </div>
                </div>
            </div>

        </div>
    </form>
    <div class="clearfix"></div>
</div>
@endsection

@push('stylesheet')
<!-- iCheck -->
<link href="{!! asset('public/admin_assets/vendors/iCheck/skins/flat/green.css')!!}" rel="stylesheet">
<!-- bootstrap-wysiwyg -->
<!--<link href="public/admin_assets/vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">-->
<!-- Select2 -->
<link href="{!! asset('public/admin_assets/vendors/select2/dist/css/select2.min.css')!!}" rel="stylesheet">
<!-- starrr -->
<!--<link href="public/admin_assets/vendors/starrr/dist/starrr.css" rel="stylesheet">-->
<!-- Cropper -->
<link href="{!! asset('public/admin_assets/js/cropperjs/dist/cropper.min.css') !!}" rel="stylesheet">

@endpush

@push('scripts')
<script>
    $(document).ready(function () {
        TRI = {
            elements: {
                toolbox_form: '.jquery-app-toolbox-imageResize',
                image_preview: '.jquery-app-toolbox-imagePreview',
                inputs: {
                    toolbox: {
                        input_resize_x: '.jquery-app-toolbox-input-resize-x',
                        input_resize_y: '.jquery-app-toolbox-input-resize-y',
                        input_background_position_top: '.jquery-app-toolbox-input-bgp-top',
                        input_background_position_left: '.jquery-app-toolbox-input-bgp-left',
                        input_background_size: '.jquery-app-toolbox-input-bgs',
                        input_background_repeat: '.jquery-app-toolbox-btn-bgr',
                    }
                },
                control: {
                    background_position: {
                        btn_arrow_up: '.jquery-app-toolbox-btn-bgp-up',
                        btn_arrow_down: '.jquery-app-toolbox-btn-bgp-down',
                        btn_arrow_left: '.jquery-app-toolbox-btn-bgp-left',
                        btn_arrow_right: '.jquery-app-toolbox-btn-bgp-right'
                    }
                }
            },
            init: function () {
                TRI.registerEvent.change.resizeImagePreview();
            },
            set: {
                image_preview: function (object) {
                    //console.log(object);
                    $(TRI.elements.image_preview).css('background', 'url("' + object + '")');
                }
            },
            event: {
                update_bgp: function (x = null, y = null) {
                    $(TRI.elements.image_preview).css('background-position-x', $(TRI.elements.inputs.toolbox.input_background_position_left).val() + 'px');
                    $(TRI.elements.image_preview).css('background-position-y', $(TRI.elements.inputs.toolbox.input_background_position_top).val() + 'px');
                },
            },
            registerEvent: {
                change: {
                    resizeImagePreview: function () {
                        $(TRI.elements.inputs.toolbox.input_background_position_left).on('change', function () {
                            TRI.event.update_bgp();
                        });
                        $(TRI.elements.inputs.toolbox.input_background_position_top).on('change', function () {
                            TRI.event.update_bgp();
                        });


                        $(TRI.elements.control.background_position.btn_arrow_left).on('click', function () {
                            var val = $(TRI.elements.inputs.toolbox.input_background_position_left).val();
                            $(TRI.elements.inputs.toolbox.input_background_position_left).val(parseInt(val) - 5);
                            TRI.event.update_bgp();
                        });
                        $(TRI.elements.control.background_position.btn_arrow_right).on('click', function () {
                            var val = $(TRI.elements.inputs.toolbox.input_background_position_left).val();
                            $(TRI.elements.inputs.toolbox.input_background_position_left).val(parseInt(val) + 5);
                            TRI.event.update_bgp();
                        });
                        $(TRI.elements.control.background_position.btn_arrow_up).on('click', function () {
                            var val = $(TRI.elements.inputs.toolbox.input_background_position_top).val();
                            $(TRI.elements.inputs.toolbox.input_background_position_top).val(parseInt(val) + 5);
                            TRI.event.update_bgp();
                        });
                        $(TRI.elements.control.background_position.btn_arrow_down).on('click', function () {
                            var val = $(TRI.elements.inputs.toolbox.input_background_position_top).val();
                            $(TRI.elements.inputs.toolbox.input_background_position_top).val(parseInt(val) - 5);
                            TRI.event.update_bgp();
                        });

                        $(TRI.elements.inputs.toolbox.input_background_size).on('ifChecked', function () {
                            $(TRI.elements.image_preview).css('background-size', $(this).val());
                        });

                        $(TRI.elements.inputs.toolbox.input_background_repeat).on('ifChanged', function () {
                            if ($(this).prop('checked') == true) {
                                $(TRI.elements.image_preview).css('background-repeat', 'unset');
                            } else {
                                $(TRI.elements.image_preview).css('background-repeat', 'no-repeat');
                            }

                        });



                        // Listen events
                        $(TRI.elements.inputs.toolbox.input_resize_x).on('change', function () {
                            //console.log('b');
                            $(TRI.elements.image_preview).css('width', $(this).val());
                        });
                        $(TRI.elements.inputs.toolbox.input_resize_y).on('change', function () {
                            // console.log('b');
                            $(TRI.elements.image_preview).css('height', $(this).val());
                        });

                    }
                }
            }
        };
        TRI.init();
    });

    /**
     * Number.prototype.format(n, x)
     * 
     * @param integer n: length of decimal
     * @param integer x: length of sections
     */
    Number.prototype.format = function (n, x) {
        var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
        return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
    };

    $(document).ready(function () {
        $('#jquery-input-file').on('change', function (evt) {
            var infoString = '';
            $('.jquery-input-file-info').html('Loading...');
            if (this.value !== '') {
                var file = evt.target.files[0];
                infoString += "<p>File name: " + file.name + "</p>";
                infoString += "<p>File size: " + (file.size / 1024 / 1024).format(2) + "MB</p>";
                infoString += "<p>File type: " + file.type + "</p>";
                // console.log(file);
                TRI.set.image_preview(URL.createObjectURL(file));
            } else {

            }



            $('.jquery-input-file-info').html(infoString);
        });

    });
</script>

<!-- bootstrap-progressbar -->
<script src="{!! asset('public/admin_assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')!!}"></script>
<!-- iCheck -->
<script src="{!! asset('public/admin_assets/vendors/iCheck/icheck.min.js')!!}"></script>

<!--<script src="public/admin_assets/vendors/jquery.hotkeys/jquery.hotkeys.js"></script>-->
<!-- jQuery Tags Input -->
<script src="{!! asset('public/admin_assets/vendors/jquery.tagsinput/src/jquery.tagsinput.js')!!}"></script>
<!-- Switchery -->
<script src="{!! asset('public/admin_assets/vendors/switchery/dist/switchery.min.js')!!}"></script>
<!-- Select2 -->
<!--<script src="public/admin_assets/vendors/select2/dist/js/select2.full.min.js"></script>-->
<!-- Parsley -->
<!--<script src="public/admin_assets/vendors/parsleyjs/dist/parsley.min.js"></script>-->
<!-- Autosize -->
<!--<script src="public/admin_assets/vendors/autosize/dist/autosize.min.js"></script>-->
<!-- jQuery autocomplete -->
<!--<script src="public/admin_assets/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>-->
<!-- starrr -->
<!--<script src="public/admin_assets/vendors/starrr/dist/starrr.js"></script>-->

<!-- Cropper -->
<script src="{!! asset('public/admin_assets/js/cropperjs/dist/cropper.min.js') !!}"></script>

@endpush


