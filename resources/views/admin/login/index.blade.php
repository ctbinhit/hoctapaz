<!DOCTYPE html>
<html >
    <head>
        <meta charset="UTF-8">
        <title>Toàn Năng | Quản trị website</title>
        <style>
            /* NOTE: The styles were added inline because Prefixfree needs access to your styles and they must be inlined if they are on local disk! */
            @import url(https://fonts.googleapis.com/css?family=Exo:100,200,400);
            @import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro:700,400,300);
            body{
                margin: 0;
                padding: 0;
                background: #fff;
                color: #fff;
                font-family: Arial;
                font-size: 12px;
                overflow: hidden;
            }
            .body{
                position: absolute;
                top: -20px;
                left: -20px;
                right: -40px;
                bottom: -40px;
                width: auto;
                height: auto;
                background-image: url(http://ginva.com/wp-content/uploads/2012/07/city-skyline-wallpapers-008.jpg);
                background-size: cover;
                -webkit-filter: blur(5px);
                z-index: 0;
            }
            .grad{
                position: absolute;
                top: -20px;
                left: -20px;
                right: -40px;
                bottom: -40px;
                width: auto;
                height: auto;
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,0)), color-stop(100%,rgba(0,0,0,0.65))); /* Chrome,Safari4+ */
                z-index: 1;
                opacity: 0.7;
            }

            .header{
                position: absolute;
                top: calc(50% - 35px);
                left: calc(43% - 255px);
                z-index: 2;
            }

            .header div{
                float: left;
                color: #fff;
                font-family: 'Exo', sans-serif;
                font-size: 35px;
                font-weight: 200;
            }

            .header div span{
                color: #5379fa !important;
            }

            .login{
                position: absolute;
                top: calc(50% - 75px);
                left: calc(50% - 50px);
                height: 150px;
                width: 350px;
                padding: 10px;
                z-index: 2;
            }

            .login input[type=text]{
                width: 250px;
                height: 30px;
                background: transparent;
                border: 1px solid rgba(255,255,255,0.6);
                border-radius: 2px;
                color: #fff;
                font-family: 'Exo', sans-serif;
                font-size: 16px;
                font-weight: 400;
                padding: 4px;
            }

            .login input[type=password]{
                width: 250px;
                height: 30px;
                background: transparent;
                border: 1px solid rgba(255,255,255,0.6);
                border-radius: 2px;
                color: #fff;
                font-family: 'Exo', sans-serif;
                font-size: 16px;
                font-weight: 400;
                padding: 4px;
                margin-top: 10px;
            }

            .login input[type=submit]{
                width: 260px;
                height: 35px;
                background: #fff;
                border: 1px solid #fff;
                cursor: pointer;
                border-radius: 2px;
                color: #a18d6c;
                font-family: 'Exo', sans-serif;
                font-size: 16px;
                font-weight: 400;
                padding: 6px;
                margin-top: 10px;
            }

            .login input[type=submit]:hover{
                opacity: 0.8;
            }

            .login input[type=submit]:active{
                opacity: 0.6;
            }

            .login input[type=text]:focus{
                outline: none;
                border: 1px solid rgba(255,255,255,0.9);
            }

            .login input[type=password]:focus{
                outline: none;
                border: 1px solid rgba(255,255,255,0.9);
            }

            .login input[type=submit]:focus{
                outline: none;
            }

            ::-webkit-input-placeholder{
                color: rgba(255,255,255,0.6);
            }

            ::-moz-input-placeholder{
                color: rgba(255,255,255,0.6);
            }
        </style>
        <script src="https://sdk.accountkit.com/en_US/sdk.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>


        <script>
            // initialize Account Kit with CSRF protection
            AccountKit_OnInteractive = function () {
                AccountKit.init(
                        {
                            appId: "552682171742827",
                            state: "{{csrf_token()}}",
                            version: "v1.1",
                            fbAppEventsEnabled: true,
                            redirect: "https://hoctapaz.dev/facebook/accountkit_callback"
                        }
                );
            };

            // login callback
            function loginCallback(response) {
                console.log(response);
                if (response.status === "PARTIALLY_AUTHENTICATED") {
                    var code = response.code;
                    var csrf = response.state;
                    // Send code to server to exchange for access token
                } else if (response.status === "NOT_AUTHENTICATED") {
                    // handle authentication failure
                } else if (response.status === "BAD_PARAMS") {
                    // handle bad parameters
                }
            }

            // phone form submission handler
            function smsLogin() {
                var countryCode = '+84';
                var phoneNumber = '964247742';
                AccountKit.login(
                        'PHONE',
                        {countryCode: countryCode, phoneNumber: phoneNumber}, // will use default values if not specified
                        loginCallback
                        );
            }


            // email form submission handler
            function emailLogin() {
                var emailAddress = document.getElementById("email").value;
                AccountKit.login(
                        'EMAIL',
                        {emailAddress: emailAddress},
                        loginCallback
                        );
            }
        </script>


    </head>

    <body>
        <div class="body"></div>
        <div class="grad"></div>
        <div class="header">
            <div>ToanNang<span> Co., Ltd</span></div>
        </div>
        <br>
        <div class="login">
            <form name="frm_login" action="{{route('admin_login_signin')}}" method="POST">
                {{ csrf_field() }}
                <input type="text" placeholder="username" name="username"><br>
                <input type="password" placeholder="password" name="password"><br>

                @if(Session::has('message'))
                <p style="color:#F00;font-weight: bold;">{{Session::get('message')}}</p>
                @endif
                <input type="submit" value="Login">

            </form>
<!--            <form action="https://www.accountkit.com/v1.0/basic/dialog/sms_login/">
                <input type="hidden" name="app_id" value="552682171742827">
                <input type="hidden" name="redirect" value="https://hoctapaz.dev/">
                <input type="hidden" name="state" value="{{csrf_token()}}">
                <input type="hidden" name="fbAppEventsEnabled" value=true>
                <input type="hidden" name="phone_number" value="964247742">
                <button type="submit">Đăng nhập bằng tin nhắn</button>
            </form>-->
        </div>



        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>


    </body>
</html>
