<!DOCTYPE html>
<html>
<head>
  <link rel="icon" href="{{env('APP_URL')}}/assets/images/favicon.png">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name') }} Admin | <?php echo $data['title'];?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{env('APP_URL')}}admin_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{env('APP_URL')}}admin_assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{env('APP_URL')}}admin_assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{env('APP_URL')}}admin_assets/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{env('APP_URL')}}admin_assets/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{env('APP_URL')}}admin_assets/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{env('APP_URL')}}admin_assets/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{env('APP_URL')}}admin_assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{env('APP_URL')}}admin_assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
   <link rel="stylesheet" href="{{env('APP_URL')}}admin_assets/plugins/iCheck/all.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{env('APP_URL')}}admin_assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
<!-- jQuery 3 -->
<script src="{{env('APP_URL')}}admin_assets/bower_components/jquery/dist/jquery.min.js"></script>
<link href="{{env('APP_URL')}}admin_assets/plugins/select2/select2.min.css" rel="stylesheet" />
<script src="{{env('APP_URL')}}admin_assets/plugins/select2/select2.min.js"></script>

<!-- jQuery UI 1.11.4 -->
<script src="{{env('APP_URL')}}admin_assets/bower_components/jquery-ui/jquery-ui.min.js"></script>



 
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  
	
	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}admin_assets/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">

	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}admin_assets/pages/data-table/css/buttons.dataTables.min.css">

	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}admin_assets/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">  
  
  	 <link rel="stylesheet" href="{{env('APP_URL')}}admin_assets/plugins/dropify/dropify.min.css">
	 
 <link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}admin_assets/plugins/suggester/Suggester.css">
 
 <script src="{{env('APP_URL')}}admin_assets/plugins/suggester/Suggester.js" type="text/javascript" language="javascript"></script>
 
 
	<script type="text/javascript">
	$(document).ready(function() {
		$(".pageloader").fadeOut("slow");
		
	});
	</script> 	
	<style>
	.pageloader, .wait_loader {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		background: url('<?php echo env('APP_URL');?>admin_assets/dist/img/pageLoader.gif') 50% 50% no-repeat #ffffff5e;
		background-size: 15%;
		opacity: 1;
	}
	</style> 

	<style>
	
	.small_loader {
		position: absolute;
		top: 7px;
		z-index: 99999;
		width: 100%;
		left: 0;
		right: 0;
		margin: auto;
		text-align: center;
		color: #fff;
		font-size: 18px;
	}
	</style> 
	
 
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wait_loader" style="display:none;"></div>	
<div class="small_loader" style="display:none;"><i class="fa fa-spin fa-spinner fa-2x"></i></div>	
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="{{env('APP_URL')}}admin" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>SHOP</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>{{ config('app.name') }} </b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{env('APP_URL')}}user_profile_files/{{ Auth::user()->image }}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{env('APP_URL')}}user_profile_files/{{ Auth::user()->image }}" class="img-circle" alt="User Image">

                <p>
                  {{ Auth::user()->name }}
                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Sign out</a>
					   <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>													 
                </div>
              </li>

            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->

      <!-- search form -->

      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>

        <li class="treeview <?php if($data['nav'] == 'menu_banners'){echo 'active';}?>">
          <a href="#">
            <i class="fa fa-tags"></i> <span>Banners</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if($data['sub_nav'] == 'menu_banners_add'){echo 'active';}?>"><a href="{{ route('banners-add') }}"><i class="fa fa-plus"></i> Add</a></li>
            <li class="<?php if($data['sub_nav'] == 'menu_banners_list'){echo 'active';}?>"><a href="{{ route('banners-list') }}"><i class="fa fa-list"></i> List</a></li>
          </ul>
        </li>
		
        <li class="treeview <?php if($data['nav'] == 'menu_navigation_menu'){echo 'active';}?>">
          <a href="#">
            <i class="fa fa-tags"></i> <span>Navigation Menu</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if($data['sub_nav'] == 'menu_navigation_menu_add'){echo 'active';}?>"><a href="{{ route('navigation-menu-add') }}"><i class="fa fa-plus"></i> Add</a></li>
            <li class="<?php if($data['sub_nav'] == 'menu_navigation_menu_list'){echo 'active';}?>"><a href="{{ route('navigation-menu-list') }}"><i class="fa fa-list"></i> List</a></li>
          </ul>
        </li>
		
		
        <li class="treeview <?php if($data['nav'] == 'menu_categories'){echo 'active';}?>">
          <a href="#">
            <i class="fa fa-tags"></i> <span>Categories</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if($data['sub_nav'] == 'menu_parent_categories_list'){echo 'active';}?>"><a href="{{ route('parent-categories-list') }}"><i class="fa fa-list"></i> Parent Categories List</a></li>
            <li class="<?php if($data['sub_nav'] == 'menu_categories_list'){echo 'active';}?>"><a href="{{ route('categories-list') }}"><i class="fa fa-list"></i> All Categories List</a></li>			
          </ul>
        </li>
		
        <li class="treeview <?php if($data['nav'] == 'menu_products'){echo 'active';}?>">
          <a href="#">
            <i class="fa fa-product-hunt"></i> <span>Products</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
			<li class="<?php if($data['sub_nav'] == 'menu_products_list'){echo 'active';}?>"><a href="{{ route('products-list') }}"><i class="fa fa-list"></i> Product List</a></li>		  
            <li class="<?php if($data['sub_nav'] == 'menu_products_import'){echo 'active';}?>"><a href="{{ route('products-import') }}"><i class="fa fa-upload"></i> Import Products</a></li>
          </ul>
        </li>
		
        <li class="treeview <?php if($data['nav'] == 'menu_front_pages'){echo 'active';}?>">
          <a href="#">
            <i class="fa fa-cog"></i> <span>Content Pages</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
		    <li class="<?php if($data['sub_nav'] == 'menu_front_pages_home'){echo 'active';}?>"><a href="{{ route('settings-home') }}"><i class="fa fa-circle"></i> Home</a></li>
            <li class="<?php if($data['sub_nav'] == 'menu_front_pages_about'){echo 'active';}?>"><a href="{{ route('settings-about') }}"><i class="fa fa-circle"></i> About</a></li>
            <li class="<?php if($data['sub_nav'] == 'menu_front_pages_faq'){echo 'active';}?>"><a href="{{ route('settings-faq') }}"><i class="fa fa-circle"></i> FAQ</a></li>
            <li class="<?php if($data['sub_nav'] == 'menu_front_pages_contact'){echo 'active';}?>"><a href="{{ route('settings-contact') }}"><i class="fa fa-circle"></i> Contact</a></li>
            <li class="<?php if($data['sub_nav'] == 'menu_front_pages_terms'){echo 'active';}?>"><a href="{{ route('settings-terms') }}"><i class="fa fa-circle"></i> Terms</a></li>
            <li class="<?php if($data['sub_nav'] == 'menu_front_pages_privacy_policy'){echo 'active';}?>"><a href="{{ route('settings-privacy-policy') }}"><i class="fa fa-circle"></i> Privacy Policy</a></li>
           
          </ul>
        </li>

        <li class="treeview <?php if($data['nav'] == 'menu_enquiries'){echo 'active';}?>">
          <a href="#">
            <i class="fa fa-tags"></i> <span>Contact Enquiries</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if($data['sub_nav'] == 'menu_enquiries_list'){echo 'active';}?>"><a href="{{ route('enquiries-list') }}"><i class="fa fa-list"></i> List</a></li>
          </ul>
        </li>		
		
        <li class="treeview <?php if($data['nav'] == 'menu_settings'){echo 'active';}?>">
          <a href="#">
            <i class="fa fa-cog"></i> <span>Settings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if($data['sub_nav'] == 'menu_settings_add'){echo 'active';}?>"><a href="{{ route('settings-edit') }}"><i class="fa fa-pencil"></i> Edit</a></li>
          </ul>
        </li>         
		
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>	

        @yield('content')
		
 <footer class="main-footer">
    <div class="pull-right hidden-xs hide">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2018 <a href="{{ route('home') }}">{{ config('app.name') }}</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{env('APP_URL')}}admin_assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

<!-- Bootstrap 3.3.7 -->
<script src="{{env('APP_URL')}}admin_assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="{{env('APP_URL')}}admin_assets/bower_components/raphael/raphael.min.js"></script>
<!--script src="{{env('APP_URL')}}admin_assets/bower_components/morris.js/morris.min.js"></script-->
<!-- Sparkline -->
<script src="{{env('APP_URL')}}admin_assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="{{env('APP_URL')}}admin_assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="{{env('APP_URL')}}admin_assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="{{env('APP_URL')}}admin_assets/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="{{env('APP_URL')}}admin_assets/bower_components/moment/min/moment.min.js"></script>
<script src="{{env('APP_URL')}}admin_assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="{{env('APP_URL')}}admin_assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{env('APP_URL')}}admin_assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="{{env('APP_URL')}}admin_assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="{{env('APP_URL')}}admin_assets/bower_components/fastclick/lib/fastclick.js"></script>
<script src="{{env('APP_URL')}}admin_assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="{{env('APP_URL')}}admin_assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--script src="{{env('APP_URL')}}admin_assets/dist/js/pages/dashboard.js"></script-->
<!-- AdminLTE for demo purposes -->
<script src="{{env('APP_URL')}}admin_assets/dist/js/demo.js"></script>

<script src="{{env('APP_URL')}}admin_assets/plugins/notify/bootstrap-notify.js"></script> 

<!-- data-table js -->
<script src="{{env('APP_URL')}}admin_assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{env('APP_URL')}}admin_assets/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{env('APP_URL')}}admin_assets/pages/data-table/js/jszip.min.js"></script>
<script src="{{env('APP_URL')}}admin_assets/pages/data-table/js/pdfmake.min.js"></script>
<script src="{{env('APP_URL')}}admin_assets/pages/data-table/js/vfs_fonts.js"></script>
<script src="{{env('APP_URL')}}admin_assets/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="{{env('APP_URL')}}admin_assets/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="{{env('APP_URL')}}admin_assets/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{env('APP_URL')}}admin_assets/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{env('APP_URL')}}admin_assets/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

<script src="{{env('APP_URL')}}admin_assets/plugins/dropify/dropify.min.js"></script> 
<script src="{{env('APP_URL')}}admin_assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="{{env('APP_URL')}}js/admin/admin-tables.js"></script> 

</body>
</html>



