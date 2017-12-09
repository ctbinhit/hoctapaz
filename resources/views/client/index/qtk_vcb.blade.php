<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>{{$TNSITE->seo_title}}</title>
        <meta charset="UTF-8">

        <!-- LARAVEL TOKEN -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- VIEWPORT --> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{asset('public/client_assets/assets/bootstrap-3.3.7-dist/css/bootstrap.min.css')}}" rel="stylesheet" />
        <link href="{{asset('public/client_assets/assets/font-awesome-4.7.0/css/font-awesome.min.css')}}" rel="stylesheet" />
        <link href="{{asset('public/client_assets/assets/font-awesome-4.7.0/css/font-awesome-animation.min.css')}}" rel="stylesheet" />
        <link href="{{asset('public/client_assets/assets/PaymentFont-1.2.5/css/paymentfont.min.css')}}" rel="stylesheet" />

        <link href="{{asset('public/client_assets/assets/wowjs/css/libs/animate.css')}}" rel="stylesheet" />

        <!-- Jquery Confirm -->
        <link href="{{asset('public/client_assets/assets/jquery-confirm/jquery-confirm.min.css')}}" rel="stylesheet" />


        <script src="{{asset('public/client_assets/assets/jquery-3.2.1.min.js')}}"></script>
        <script src="{{asset('public/client_assets/assets/jquery-migrate-3.0.0.js')}}"></script>
        <script src="{{asset('public/js/jquery.pjax.min.js')}}"></script>

        <script>
            $(document).ready(function(){
                var c = 0;
                var t = 0;
                
                function timer(){
                    
                    var a = setInterval(function(){
                         t++;
                         $('#tg').html(t);
                    },1000);
                    
                }
                
                var jquery_id=null;
                
                function sendId(id){
                     $.ajax({
                        url: '{{route("_client_quet_vcb")}}',
                                type: 'POST',
                                dataType: 'json',
                                headers: {
                                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') 
                                },
                                data: {
                                        id : id
                                }, success: function (data) {
                                    console.log(data);
                                    $('#jquery-app-sotk').val(data.id);
                                    jquery_id = data.data.account_id;
                                    if(data.act=='next'){
                                        $('#jquery-app-name').val(data.data.account_name);
                                        c++;
                                        $('#usercount').html(c);
                                        jquery_id-=1;
                                            sendId(data.id);
                                           
                                    }else if(data.act=='resend'){
                                         setTimeout(function(){
                                              sendId(data.id);
                                         },200);
                                    }else{
                                          jquery_id-=1;
                                            sendId(data.id);
                                    }
                        }, error: function (data) {
                    
                        }, complete: function(){
                             
                        }
                    });
                }
                
                $('#jquery-app-start-scan').on('click', function(){
                    $(this).html('<i class="fa fa-spinner faa-spin animated"></i> Đang tìm');
                    sendId($('#jquery-app-sotk').val());
                    jquery_id = parseInt($('#jquery-app-sotk').val());
                    timer();
                })
            });
        </script>

    </head>
    <body id="body">
        <div id="page" class="container">

            <div class="row">
                <div class="col-md-6 col-md-offset-3">

                    <div class="panel panel-primary" style="margin-top: 100px;">

                        <div class="panel-heading"><i class="fa fa-search"></i> Quét thông tin tài khoản VCB</div>

                        <div class="panel-body">

                            <form class="form form-horizontal">
                                
                                 <div class="form-group">
                                    <label for="nameOfTheInput" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Tên TK:</label>
                                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                        <input type="text" name="ma_tk" disabled="" id="jquery-app-name" class="form-control" placeholder="..." />
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="nameOfTheInput" class="control-label col-lg-2 col-md-2 col-sm-3 col-xs-12">Số TK:</label>
                                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                        <input type="text" name="ma_tk" id="jquery-app-sotk" class="form-control" placeholder="..." />
                                    </div>
                                </div>
                                
                            </form>

                        </div>

                        <div class="panel-footer">
                            <button type="button" id="jquery-app-start-scan" class="btn btn-primary"><i class="fa fa-play-circle"></i> Bắt đầu quét</button>

                            <div class="label label-info">Số người đã tìm thấy: <span id="usercount">0</span> <i class="fa fa-users"></i> </div> 
                            <div class="label label-info">Thời gian: <span id="tg">0</span> giây</div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </body>
</html>
