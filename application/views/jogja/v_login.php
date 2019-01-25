<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Halaman Login</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- <link rel="icon" type="image/png" href="<?php //echo base_url('assets/logo/logo-oi.png');?>"> -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/cms/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/cms/dist/css/style.css">
	<script src="<?php echo base_url();?>assets/cms/plugins/jQuery/jQuery-2.1.4.min.js"></script>
  </head>
  <body class="hold-transition login-page" style="background:#006400">
    <div class="login-box">
      <div class="login-logo" style="color:#ffd700;">
        JOGJA@CCESS
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg"><b>Login</b></p>
		
          <div class="form-group has-feedback">
            <input type="text" id="uname" class="form-control" placeholder="Username">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
           
          </div>
          
          <div class="form-group has-feedback">
            <input type="password" id="pass" class="form-control" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <font color="#c40000"><?php echo form_error('pass');?></font>
           
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <!--<a href="#">Lupa password</a><br>
        		<a href="<?php echo site_url('register') ;?>" class="text-center">Daftar Member Baru</a>-->
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <a href="javascript:void(0)" class="btn btn-primary btn-block btn-flat" onclick="login()">Masuk</a>
            </div><!-- /.col -->
          </div>
     

     
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

	<script>     
	    $(document).ready(function(){
	         $(".alert").delay(4000).addClass("in").fadeOut("slow");
	    });
		
		function login(){
			$.ajax({
			url: '<?php echo base_url();?>jogja/auth/login',
			type: 'POST',
			data: {uname:$('#uname').val(),
					pass:$('#pass').val(),
					},
			dataType: 'json',
				beforeSend: function() {
					//$.LoadingOverlay("show");
					
				},
				complete: function() {
					//$.LoadingOverlay("hide");
					
				},
				success: function(json) {
					if(json['status']=='sukses'){
						//alert(json['data']);
						window.location.href="<?php echo site_url();?>jogja/notifikasi";
						
					}else{
						alert(json['data']);
					}
					
				},
				error: function() {
					alert("Error occured. Please try again or contact administrator");
					
				}
			});
		}
		
    </script>
  </body>
</html>
