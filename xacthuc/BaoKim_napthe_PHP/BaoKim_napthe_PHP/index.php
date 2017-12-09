<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<link rel="stylesheet" style="text/css" href ="css/bootstrap.min.css">
<link href="css/baokim.css" rel="stylesheet">
<script src="js/jsmin.js"></script>
<script src="js/bootstrap.js"></script>
<script>
	$(document).ready(function(){
    $(".form-control").tooltip({ placement: 'right'});
});
</script>
</head>
<body>
<div class="container"> 
	<form class="form-horizontal form-bk" role="form" method="post" action="transaction.php">
	<h2 class="form-control-heading">NẠP THẺ CÀO</h2>
<div class="form-group">
    <label for="txtpin" class="col-lg-2 control-label">Loại thẻ</label>
    <div class="col-lg-10">
      <select class="form-control" name="chonmang">
		  <option value="VIETEL">Viettel</option>
		  <option value="MOBI">Mobifone</option>
		  <option value="VINA">Vinaphone</option>
		  <option value="GATE">Gate</option>
		  <option value="VTC">VTC</option>
		</select>
    </div>
  </div>
  <div class="form-group">
    <label for="txtpin" class="col-lg-2 control-label">Tài khoản</label>
    <div class="col-lg-10">
      <input type="text" class="form-control" id="txtuser" name="txtuser" />
    </div>
  </div>
  <div class="form-group">
    <label for="txtpin" class="col-lg-2 control-label">Mã thẻ</label>
    <div class="col-lg-10">
      <input type="text" class="form-control" id="txtpin" name="txtpin" placeholder="Mã thẻ" data-toggle="tooltip" data-title="Mã số sau lớp bạc mỏng"/>
    </div>
  </div>
  <div class="form-group">
    <label for="txtseri" class="col-lg-2 control-label">Số seri</label>
    <div class="col-lg-10">
      <input type="text" class="form-control" id="txtseri" name="txtseri" placeholder="Số seri" data-toggle="tooltip" data-title="Mã seri nằm sau thẻ">
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <button type="submit" class="btn btn-primary" name="napthe">Nạp thẻ</button>
    </div>
  </div>
</div>  
</form>
</body>