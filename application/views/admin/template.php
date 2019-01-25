<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin Panel</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/template/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/template/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/template/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/template/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/template/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"> 
  <!-- <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.css"> -->

  <!-- <script src='<?php echo base_url(); ?>assets/template/ckeditor/ckeditor.js'></script> -->
  <script src="<?php echo base_url();?>assets/template/bower_components/jquery/dist/jquery.min.js"></script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>-->
  <!-- <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script> -->
  <!--<![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/template/plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/template/bower_components/select2/dist/css/select2.min.css">
  
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/template/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	

  <!-- jQuery 3 -->
  	
	<script src="<?php echo base_url();?>assets/loading_overlay/loadingoverlay.js"></script>
	<script src="<?php echo base_url();?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
	<script src="<?php echo base_url();?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js"></script>
	
	
	<!-- DataTables -->
	<script src="<?php echo base_url();?>assets/template/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url();?>assets/template/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

	<link href="<?php echo base_url();?>assets/template/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />

	<script src="<?php echo base_url();?>assets/template/plugins/datepicker/bootstrap-datepicker.min.js"></script>
	<script src="<?php echo base_url();?>assets/template/plugins/datepicker/locales/bootstrap-datepicker.id.js"></script>
	

	<style type="text/css"> 
		.align-right{text-align:right} 
		.align-left{text-align:left} 
		.align-center{text-align:center} 
	</style>
		
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="../../index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b>Panel</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          
		  <!-- Log Out -->
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;<?php echo $this->session->userdata('fullname').' ('.$this->session->userdata('uname').')';?> <span class="caret"></span></a>
			 <ul class="dropdown-menu" role="menu">
				<!--
				<li><a href="javascript:void(0)" onclick="showModalChangePassword()">Change Password</a></li>
				-->
				<li><a href="<?php echo site_url('admin/auth/logout') ;?>">Logout</a></li>
			</ul>
		</li>
		  
          
		</ul>
      </div>
    </nav>
  </header>
  
  <!-- =============================================== -->
  
	
	<!-- Left side column. contains the sidebar -->
	<aside class="main-sidebar">
		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">
		<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu" data-widget="tree">
				<li class="header">MAIN NAVIGATION</li>
				<li <?php if(strtolower(uri_string())=='admin/dash'){echo ' class="active" ';}?>><a href="<?php echo site_url('admin/dash');?>"><i class="fa fa-edit"></i> <span>Dashboard</span></a></li>
				<li <?php if(strtolower(uri_string())=='admin/customer'){echo ' class="active" ';}?>><a href="<?php echo site_url('admin/customer');?>"><i class="fa fa-edit"></i> <span>Customer</span></a></li>
				<li <?php if(strtolower(uri_string())=='admin/ma_trx'){echo ' class="active" ';}?>><a href="<?php echo site_url('admin/ma_trx');?>"><i class="fa fa-edit"></i> <span>Wallet Trx </span></a></li>
				<li <?php if(strtolower(uri_string())=='admin/ppob_trx'){echo ' class="active" ';}?>><a href="<?php echo site_url('admin/ppob_trx');?>"><i class="fa fa-edit"></i> <span>PPOB Trx </span></a></li>
				<li <?php if(strtolower(uri_string())=='admin/ppob_harga'){echo ' class="active" ';}?>><a href="<?php echo site_url('admin/ppob_harga');?>"><i class="fa fa-edit"></i> <span>PPOB Harga </span></a></li>
				<li <?php if(strtolower(uri_string())=='admin/idbiller_trx'){echo ' class="active" ';}?>><a href="<?php echo site_url('admin/idbiller_trx');?>"><i class="fa fa-edit"></i> <span>PPOB Trx </span></a></li>
				<?php if(in_array($this->session->userdata('lvl'),array('ADMIN'))){?>
				<li <?php if(strtolower(uri_string())=='admin/adm_user'){echo ' class="active" ';}?>><a href="<?php echo site_url('admin/adm_user');?>"><i class="fa fa-edit"></i> <span>Admin Users </span></a></li>

				
				<?php }?>

				<li class="treeview <?php if(strtolower(uri_string())=='admin/refund_request' || strtolower(uri_string())=='admin/refund_approve'){echo ' active ';}?>">
				  <a href="#">
					<i class="fa fa-laptop"></i>
					<span>Refund</span>
					<span class="pull-right-container">
					  <i class="fa fa-angle-left pull-right"></i>
					</span>
				  </a>
				  <ul class="treeview-menu">
					<?php if(in_array($this->session->userdata('lvl'),array('ADMIN','SPV'))){?>
					<li <?php if(strtolower(uri_string())=='admin/refund_request'){echo ' class="active" ';}?>><a href="<?php echo site_url('admin/refund_request');?>"><i class="fa fa-circle-o"></i> Requested</a></li>
					<?php }?>
					<li <?php if(strtolower(uri_string())=='admin/refund_approve'){echo ' class="active" ';}?>><a href="<?php echo site_url('admin/refund_approve');?>"><i class="fa fa-circle-o"></i> Approved</a></li>
					
				  </ul>
				</li>
			</ul>
		</section>
		<!-- /.sidebar -->
	</aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $top_title;?>
      </h1>
		
    </section>

    <!-- Main content -->
    <section class="content">

      <?php $this->load->view($content);?>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2018  </strong>All rights
    reserved.
  </footer>

</div>
<!-- ./wrapper -->

<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url();?>assets/template/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url();?>assets/template/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url();?>assets/template/bower_components/fastclick/lib/fastclick.js"></script>
<!-- bootstrap time picker -->
<script src="<?php echo base_url();?>assets/template/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url();?>assets/template/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
 -->

<!-- AdminLTE App -->
<script src="<?php echo base_url();?>assets/template/dist/js/adminlte.min.js"></script>
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
	$('[data-toggle="tooltip"]').tooltip()
	//Initialize Select2 Elements
    $('.select2').select2()
	
	
	
  })
  
</script>

<script>
	$(document).ready(function (){
		$('body').on('focus',".tanggal", function(){                     
			  $(this).datepicker({
					format: "yyyy-mm-dd",
					viewMode: "year",
					autoclose:true,
					todayHighlight:true,
					calendarWeeks:false,
					startView:0,
					todayBtn: "linked"
			});
		}); 
        
        
	});
	</script>


	
		<?php //$this->output->enable_profiler(TRUE);?>
		
		
</body>
</html>
