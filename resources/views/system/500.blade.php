<html>
    <head>
        <title>ERROR 500 | Công Ty TNHH Dịch Vụ Công Nghệ Toàn Năng</title>
        <link href="https://fonts.googleapis.com/css?family=Baloo|Coiny|Pattaya|Roboto" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
        <style>
            .page-wrapper{
                margin: 100px auto;
                padding: 15px;
            }
            h2.page-title{
                font-size: 22pt;
                font-weight: bold;
                text-align: center;
            }
            h1{
                font-size: 25pt;
                color: #F00;
                font-weight: bold;
                text-align: center;
                font-family: 'Baloo', cursive;
            }
            p{
                font-family: 'Coiny', cursive;
                text-align: center;
                font-size: 14pt;
            }
        </style>

    </head>
    <body>
        <div class="page-wrapper container">
            <div class="row">
                <div class="col-xs-12">
                    <h1><i class="fa fa-warning"></i> ERROR 500! </h1>
                    <hr>
                    <p class="alert alert-warning">Có lỗi xảy ra, vui lòng liên hệ quản trị để biết thêm thông tin chi tiết.</p>
                    <p class="alert alert-danger">{{$ex->getMessage()}} !</p>
                </div>
            </div>
        </div>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>
