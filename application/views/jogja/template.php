<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Jogja Access Panel</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- <link rel="icon" type="image/png" href="<?php echo base_url('assets/logo/logo-oi.jpg');?>"> -->
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
<body class="hold-transition skin-green sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="" class="logo" style="background-color:#01280;">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b>Panel</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" style="background-color:#01280;">
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
				<li><a href="<?php echo site_url('jogja/auth/logout') ;?>">Logout</a></li>
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
				<!-- <li <?php if(strtolower(uri_string())=='jogja/dash'){echo ' class="active" ';}?>><a href="<?php echo site_url('jogja/dash');?>"><i class="fa fa-edit"></i> <span>Dashboard</span></a></li> -->
				<?php if(in_array($this->session->userdata('lvl'),array('ADMIN','STAFF'))){?>
				<!-- <li <?php //if(strtolower(uri_string())=='admin/adm_user'){echo ' class="active" ';}?>><a href="<?php //echo site_url('admin/adm_user');?>"><i class="fa fa-edit"></i> <span>Admin Users </span></a></li>  -->
				<li <?php if(strtolower(uri_string())=='jogja/dash'){echo ' class="active" ';}?>><a href="<?php echo site_url('jogja/dash');?>"><i class="fa fa-edit"></i> Dashboard</a>
				</li>

        <li <?php if(strtolower(uri_string())=='jogja/notifikasi'){echo ' class="active" ';}?>><a href="<?php echo site_url('jogja/notifikasi');?>"><i class="fa fa-edit"></i>Notifikasi</a>
        </li>		

				<li <?php if(strtolower(uri_string())=='jogja/banner'){echo ' class="active" ';}?>><a href="<?php echo site_url('jogja/banner');?>"><i class="fa fa-edit"></i> Banner</a>
				</li>

				<li <?php if(strtolower(uri_string())=='jogja/berita'){echo ' class="active" ';}?>><a href="<?php echo site_url('jogja/berita');?>"><i class="fa fa-edit"></i> Berita</a>
				</li>

        <li <?php if(strtolower(uri_string())=='jogja/event'){echo ' class="active" ';}?>><a href="<?php echo site_url('jogja/event');?>"><i class="fa fa-edit"></i> Event</a>
        </li>

        <li <?php if(strtolower(uri_string())=='jogja/poin_reward'){echo ' class="active" ';}?>><a href="<?php echo site_url('jogja/poin_reward');?>"><i class="fa fa-edit"></i>Poin Reward</a>
        </li>

        <li class="treeview <?php if(strtolower(uri_string())=='jogja/masterusers' || strtolower(uri_string())=='jogja/verified_masterusers'){echo ' active ';}?>">
          <a href="#">
          <i class="fa fa-edit"></i>
          <span>Masterusers</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
          </a>
          <ul class="treeview-menu">
            <!-- <?php //if(in_array($this->session->userdata('lvl'),array('ADMIN','SPV'))){?> -->
            <li <?php if(strtolower(uri_string())=='jogja/masterusers'){echo ' class="active" ';}?>><a href="<?php echo site_url('jogja/masterusers');?>"><i class="fa fa-circle-o"></i> Requested</a></li>
           <!--  <s?php }?> -->
            <li <?php if(strtolower(uri_string())=='jogja/verified_masterusers'){echo ' class="active" ';}?>><a href="<?php echo site_url('jogja/verified_masterusers');?>"><i class="fa fa-circle-o"></i> Verified</a></li>
          </ul>
        </li>

        <!-- <li <?php if(strtolower(uri_string())=='jogja/poin'){echo ' class="active" ';}?>><a href="<?php echo site_url('jogja/poin');?>"><i class="fa fa-edit"></i>Poin</a>
        </li> -->

        <li class="treeview <?php if(strtolower(uri_string())=='jogja/withdraw' || strtolower(uri_string())=='jogja/approve_withdraw'){echo ' active ';}?>">
          <a href="#">
          <i class="fa fa-edit"></i>
          <span>Withdraw</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
          </a>
          <ul class="treeview-menu">
          <!-- <?php //if(in_array($this->session->userdata('lvl'),array('ADMIN','SPV'))){?> -->
          <li <?php if(strtolower(uri_string())=='jogja/withdraw'){echo ' class="active" ';}?>><a href="<?php echo site_url('jogja/withdraw');?>"><i class="fa fa-circle-o"></i> Requested</a></li>
         <!--  <s?php }?> -->
          <li <?php if(strtolower(uri_string())=='jogja/approve_withdraw'){echo ' class="active" ';}?>><a href="<?php echo site_url('jogja/approve_withdraw');?>"><i class="fa fa-circle-o"></i> Approved</a></li>
          
          </ul>
        </li>

        <!-- <li <?php if(strtolower(uri_string())=='jogja/log'){echo ' class="active" ';}?>><a href="<?php echo site_url('jogja/log');?>"><i class="fa fa-edit"></i>Log Request</a>
        </li> -->
        
        <?php }?> 

				 <?php if(in_array($this->session->userdata('lvl'),array('ADMIN'))){?>
				<li <?php if(strtolower(uri_string())=='jogja/adm_user'){echo ' class="active" ';}?>><a href="<?php echo site_url('jogja/adm_user');?>"><i class="fa fa-edit"></i> <span>Admin Users </span></a></li> 

				
				<?php }?> 

				
				
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
