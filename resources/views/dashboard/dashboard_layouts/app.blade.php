<?php 
use \App\Http\Controllers\NavigationMenuController;
use \App\Http\Controllers\CartController;

 ?>
<?php 
use \App\TripLinks;
use \App\CartData;
use \App\CartItems;

$nav_menus = NavigationMenuController::get_nav_menus();
$meta_title=config('app.name', 'maged-hotels');
$meta_keywords = 'Top Hotels, Recommended Destinations, Top Deal';
$meta_description = 'Top Hotels, Recommended Destinations, Top Deal';
if(isset($data['meta_title']) AND !empty($data['meta_title'])){
//$meta_title=$data['meta_title'];
}

if(isset($data['meta_keywords']) AND !empty($data['meta_keywords'])){
//$meta_keywords=$data['meta_keywords'];
}

if(isset($data['meta_desicription']) AND !empty($data['meta_desicription'])){
//$meta_description=$data['meta_desicription'];
}
?>


<!DOCTYPE HTML>
<html lang="zxx">

<head>
    <!-- REQUIRED meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Fav icon tag -->
    <link rel="shortcut icon" href="{{env('APP_URL')}}favicon.ico" type="image/x-icon">
    <link rel="icon" href="{{env('APP_URL')}}favicon.ico" type="image/x-icon">
	<meta name="google-site-verification" content="oOj0Uq8jKllW-z9a4yZRXhchxlxXmZ-uF15kHEOYDjc" />
	<meta name="csrf-token" content="{{ csrf_token() }}">	
    <!-- SEO meta tags -->
    <meta name="keywords" content="<?php echo $meta_keywords; ?>" />
    <meta name="description" content="<?php echo $meta_description; ?>" />
    <meta name="author" content="Shopergy" />
    <!-- Page title -->
    <title><?php echo $meta_title; ?></title>
    <!-- :::::-[ Vendors StyleSheets ]-:::::: -->
    <link rel="stylesheet" href="{{env('APP_URL')}}assets/vendors/bootstrap.4.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{env('APP_URL')}}assets/vendors/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="{{env('APP_URL')}}assets/vendors/animate.css/animate.css" />
    <link rel="stylesheet" href="{{env('APP_URL')}}assets/vendors/owl-carousel/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="{{env('APP_URL')}}assets/vendors/owl-carousel/assets/owl.theme.default.min.css" />
    <link rel="stylesheet" href="{{env('APP_URL')}}assets/vendors/flag-icon-css/css/flag-icon.min.css" />
    <link rel="stylesheet" href="{{env('APP_URL')}}assets/vendors/flaticon/flaticon.css" />
    <link rel="stylesheet" href="{{env('APP_URL')}}assets/vendors/hover-effects/effects.min.css" />
    <link rel="stylesheet" href="{{env('APP_URL')}}assets/vendors/ion.rangeslider/css/ion.rangeSlider.css" />
    <link rel="stylesheet" href="{{env('APP_URL')}}assets/vendors/ion.rangeslider/css/ion.rangeSlider.skinFlat.css" />
    <link rel="stylesheet" href="{{env('APP_URL')}}assets/vendors/icheck/skins/square/aero.css" />

    <!-- :::::-[ Travelgo - Travel and Tours listings HTML template StyleSheet ]-:::::: -->
    <link rel="stylesheet" href="{{env('APP_URL')}}assets/css/style.css" />
    <link rel="stylesheet" href="{{env('APP_URL')}}assets/plugins/css/daterangepicker.css" />
    <script src="{{env('APP_URL')}}assets/vendors/jquery/jquery.3.3.1.js"></script>	
	<script src="{{env('APP_URL')}}admin_assets/plugins/notify/bootstrap-notify.js"></script>	
<link rel="stylesheet" href="{{env('APP_URL')}}admin_assets/plugins/dropify/dropify.min.css">		
<script src="{{env('APP_URL')}}admin_assets/plugins/dropify/dropify.min.js"></script>

	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}admin_assets/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}admin_assets/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css"> 
	
	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}admin_assets/pages/data-table/css/buttons.dataTables.min.css">	

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
		background: url('<?php echo env('APP_URL');?>admin_assets/dist/img/pageLoader.gif') 50% 50% no-repeat rgb(249,249,249);
		background-size: 50%;
		opacity: 0.8;
	}		
	</style>	
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-133866398-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-133866398-1');
</script>		
</head>
<!-- START-OF Home Page Body Tag -->

<body>
<div class="wait_loader" style="display:none;"></div>
    <!-- ::::::-[ START PAGE MAIN HEADER ]-:::::: -->
    <header>

        <nav class="navbar navbar-light navbar-expand-md py-md-2 fixed-top">
            <div class="container">
                <a href="{{env('APP_URL')}}" class="navbar-brand">
                    <img src="{{env('APP_URL')}}assets/images/logo.png" height="30" alt="logo" class="brand-logo" /> </a>
                <!-- /.navbar-brand -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    <!-- /.navbar-toggler-icon -->
                </button>
                <!-- /.navbar-toggler -->
                <div class="navbar-collapse collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
					<?php 
						if($nav_menus){
							foreach($nav_menus as $nav_menu){
								if($nav_menu->is_child == 0){
									if($nav_menu->has_child == 0){
					?>
				<?php if($nav_menu->is_public == 1 || Auth::check() ){
							?>					
                        <li class="nav-item  py-md-2 <?php if($data['nav'] == $nav_menu->slug){echo 'active';}?>">
                            <a href="<?php if($nav_menu->link_name == '#'){echo $nav_menu->link_name;}else{ echo env('APP_URL').$nav_menu->link_name;}?>" class="nav-link "><?php echo ucwords($nav_menu->name)?></a>
                            <!-- /.nav-link -->
                        </li>
						<?php } ?>
						<?php } else{?>						
                        <!-- /.nav-item py-md-2 -->
                            <li class="nav-item dropdown py-md-2">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><?php echo ucwords($nav_menu->name);?></a>
                                <!-- /.nav-link -->
                                <div class="dropdown-menu">
							<?php $nav_menus2 = NavigationMenuController::get_nav_menus($nav_menu->id);
								if($nav_menus2){
									foreach($nav_menus2 as $nav_menu2){?>
									<?php if($nav_menu->is_public == 1 || Auth::check()){?>								
                                    <a class="dropdown-item" href="<?php if($nav_menu2->link_name == '#'){echo env('APP_URL').$nav_menu2->link_name;}else{ echo $nav_menu2->link_name;}?>"><?php echo ucwords($nav_menu2->name);?></a>
									<?php } } }?>
                                </div>
                                <!-- /.dropdown-menu -->
                            </li>
						<?php  } ?>
						
						<?php } } }?>							
						
						<?php 
						if(Auth::check()){
						if(Auth::user()->role_id == 1){ ?>
						
						
                        <li class="nav-item  py-md-2">
                            <a href="{{ route('admin-login') }}" class="nav-link">Dashboard</a>
                            
                        </li>
						<?php }}?>
                    </ul>
                    <!-- /.navbar-nav -->
					@guest
					<ul class="navbar-nav">
                        <li class="nav-item  py-md-2">
                            <a href="{{ route('login') }}" class="nav-link">Login</a>
                            <!-- /.nav-link -->
                        </li>	
                        <li class="nav-item  py-md-2">
                            <a href="{{ route('register') }}" class="nav-link">Sign Up</a>
                            <!-- /.nav-link -->
                        </li>							
					</ul>
					@endguest
					
					<ul class="navbar-nav">
						@guest
						@else	
                            <li class="nav-item dropdown py-md-2">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">{{ Auth::user()->name }}
                                    <img src="<?php echo env('APP_URL');?>user_profile_files/<?php echo Auth::user()->image;?>" alt="user profile img" class="user-profile-img"/></a>
                                <!-- /.nav-link -->
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('profile') }}">Edit Profile</a>
                                    <!-- /.dropdown-item -->
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
									
                                    <!-- /.dropdown-item -->
                                </div>
                                <!-- /.dropdown-menu -->
                            </li>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
						@endguest	
					</ul>
					
					
                </div>
	@if(Session::has('message'))
		<p class="notification-message alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></p>
	@endif					
                <!-- /#navbarNav.navbar-collapse collapse -->
            </div>
            <!-- /.container -->
        </nav>
        <!-- /.navbar navbar-dark bg-primary navbar-expand-md py-md-2 -->
    </header>
    <!-- ::::::-[ END-OF PAGE MAIN HEADER ]-:::::: -->	

        <main>
            <div class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-gl-3 col-md-3 col-sm-12">
                            <div class="sticky-sidebar">
                                <div class="text-center d-flex flex-column align-items-center justify-content-center mb-3">
                                    <div class="edit-profile-img">
                                        <img src="<?php echo env('APP_URL');?>user_profile_files/<?php echo Auth::user()->image;?>" alt="profile img" class="profile-img"/>
                                        <!-- /.profile-img -->
                                    </div>
                                    <!-- /.edit-profile-img -->
                                    <div class="mt-3">
                                        <h5 class="mb-2">
                                            {{ Auth::user()->name }}</h5>
                                        <div class="small">
                                         <i class="fa fa-envelope"></i>    {{ Auth::user()->email }}
                                        </div>
                                        <!-- /.small -->
										<?php if(Auth::user()->phone){ ?>
                                        <div class="small">
                                         <i class="fa fa-phone"></i>    {{ Auth::user()->phone }}
                                        </div>
										<?php } ?>
                                        <!-- /.small -->
                                    </div>
                                    <!-- /.mt-3 -->
                                </div>
                                <div class="list-group">
                                    <a href="{{ route('profile') }}" class="list-group-item list-group-item-action <?php if($data['nav'] == 'menu_user_profile'){echo 'active';}?>">My Profile</a>
                                    <!-- /.list-group-item list-group-item-action -->
                                    
                                    <!-- /.list-group-item list-group-item-action -->
                                    <a href="{{ route('change-password') }}" class="list-group-item list-group-item-action <?php if($data['nav'] == 'menu_user_change_password'){echo 'active';}?>">Change Password</a>
                                    <!-- /.list-group-item list-group-item-action -->
									
									<a class="list-group-item list-group-item-action" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form2').submit();">
									Logout</a>
									
										<form id="logout-form2" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>									
                                </div>
                                <!-- /.list-group -->
                            </div>
                            <!-- /.sticky-sidebar -->
                        </div>
						
						
					@yield('dashboard_content')
					
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container -->
            </div>
            <!-- /.section -->
		</main>
		
    
		
    <!-- ::::::-[ START PAGE FOOTER ]-:::::: -->
    <footer>
        <div class="container md">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <div class="btn-group btn-group-sm ">
                        <button type="button" class="hide btn btn-default btn-outline-secondary  no-round  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            English
                        </button>
                        <!-- /.btn btn-danger dropdown-toggle -->
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href=""><span class="flag-icon flag-icon-us flag-icon-squared mr-2"></span> English</a>
                            <!-- /.dropdown-item -->
                            <a class="dropdown-item" href=""><span class="flag-icon flag-icon-fr flag-icon-squared mr-2"></span> Français</a>
                            <!-- /.dropdown-item -->
                            <a class="dropdown-item" href=""><span class="flag-icon flag-icon-sa flag-icon-squared mr-2"></span> عربية</a>
                            <!-- /.dropdown-item -->
                            <a class="dropdown-item" href=""><span class="flag-icon flag-icon-tr flag-icon-squared mr-2"></span> Türkçe</a>
                            <!-- /.dropdown-item -->
                            <a class="dropdown-item" href=""><span class="flag-icon flag-icon-it flag-icon-squared mr-2"></span> Italiano</a>
                            <!-- /.dropdown-item -->
                            <a class="dropdown-item" href=""><span class="flag-icon flag-icon-es flag-icon-squared mr-2"></span> Español</a>
                            <!-- /.dropdown-item -->
                            <a class="dropdown-item" href=""><span class="flag-icon flag-icon-de flag-icon-squared mr-2"></span> Deutsch</a>
                            <!-- /.dropdown-item -->
                            <a class="dropdown-item" href=""><span class="flag-icon flag-icon-ru flag-icon-squared mr-2"></span> Русский</a>
                            <!-- /.dropdown-item -->
                            <a class="dropdown-item" href=""><span class="flag-icon flag-icon-pl flag-icon-squared mr-2"></span> Polski</a>
                            <!-- /.dropdown-item -->
                            <a class="dropdown-item" href=""><span class="flag-icon flag-icon-sv flag-icon-squared mr-2"></span> Svenska</a>
                            <!-- /.dropdown-item -->
                        </div>
                        <!-- /.dropdown-menu  -->
                    </div>
                    <!-- /.btn-group -->
                    <div class="btn-group btn-group-sm mt-2 d-block mb-4">
                        <button type="button" class="hide btn btn-default btn-outline-secondary  no-round  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            United States Dollar
                        </button>
                        <!-- /.btn btn-danger dropdown-toggle -->
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#"><span class="font-weight-bold">USD</span> - United States Dollar</a>
                            <!-- /.dropdown-item -->
                            <a class="dropdown-item" href="#"><span class="font-weight-bold">AED</span> - Emirati Dirham</a>
                            <!-- /.dropdown-item -->
                            <a class="dropdown-item" href="#"><span class="font-weight-bold">AUD</span> - Australian Dollar</a>
                            <!-- /.dropdown-item -->
                            <a class="dropdown-item" href="#"><span class="font-weight-bold">AZN</span> - Azerbaijani Manat</a>
                            <!-- /.dropdown-item -->
                            <a class="dropdown-item" href="#"><span class="font-weight-bold">BGN</span> - Bulgarian Lev</a>
                            <!-- /.dropdown-item -->
                            <a class="dropdown-item" href="#"><span class="font-weight-bold">BHD</span> - Bahraini Dinar</a>
                            <!-- /.dropdown-item -->
                            <a class="dropdown-item" href="#"><span class="font-weight-bold">CHF</span> - Swiss Franc</a>
                            <!-- /.dropdown-item -->
                            <a class="dropdown-item" href="#"><span class="font-weight-bold">GBP</span> - British Pound</a>
                            <!-- /.dropdown-item -->
                        </div>
                        <!-- /.dropdown-menu mt-2 d-block mb-4 -->
                    </div>
                    <!-- /.btn-group -->

                    <div class="small mb-1">Stay Tuned</div>
                    <ul class="social-network">
                        <li>
                            <a href="#"><i class="fa fa-facebook"></i></a>
                        </li>
                        <!-- /li -->
                        <li>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                        </li>
                        <!-- /li -->
                        <li>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                        </li>
                        <!-- /li -->
                        <li>
                            <a href="#"><i class="fa fa-google-plus"></i></a>
                        </li>
                        <!-- /li -->
                        <li>
                            <a href="#"><i class="fa fa-youtube-play"></i></a>
                        </li>
                        <!-- /li -->
                        <li>
                            <a href="#"><i class="fa fa-pinterest-p"></i></a>
                        </li>
                        <!-- /li -->
                    </ul>
                    <!-- /.social-network -->

                    <div class="small mb-2 mt-2">
                       
                    </div>
                    <!-- /.small mb-1 -->
                    <img src="{{env('APP_URL')}}assets/images/logo.png" alt="" height="50">

                </div>
                <!-- /.col-lg-3 col-md-3 col-sm-12 -->
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <div class="footer-title mt-4 mt-lg-0 mt-md-0">
                        Shopergy
                    </div>
                    <!-- /.footer-title -->
                    <ul class="footer-nav">
                        <li class="footer-nav-item">
                            <a href="{{ env('APP_URL') }}about" class="footer-link">About Shopergy</a>
                            <!-- /.footer-link -->
                        </li>
                        <!-- /.footer-nav-item -->
                        <li class="footer-nav-item">
                            <a href="{{ env('APP_URL') }}contact" class="footer-link">Contact Us</a>
                            <!-- /.footer-link -->
                        </li>
                        <!-- /.footer-nav-item -->
                        <li class="footer-nav-item">
                            <a href="{{ env('APP_URL') }}terms-of-use" class="footer-link">Terms Of Use</a>
                            <!-- /.footer-link -->
                        </li>
                        <!-- /.footer-nav-item -->
                        <li class="footer-nav-item">
                            <a href="{{ env('APP_URL') }}privacy-policy" class="footer-link">Privacy Policy</a>
                            <!-- /.footer-link -->
                        </li>
                        <!-- /.footer-nav-item -->
                    </ul>
                    <!-- /.footer-nav -->
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 mt-3 mt-lg-0 mt-md-0">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="footer-download-app">
                                <div class="title">
                                    Download Our App On
                                </div>
                                <!-- /.title -->
                                <div class="stores">
                                    <div class="store">
                                        <img src="{{env('APP_URL')}}assets/icons/apple-icon.svg" alt="image alt" />
                                    </div>
                                    <!-- /.store -->
                                    <div class="store">
                                        <img src="{{env('APP_URL')}}assets/icons/google-play.svg" alt="image alt" />
                                    </div>
                                    <!-- /.store -->
                                    <div class="store">
                                        <img src="{{env('APP_URL')}}assets/icons/window.svg" alt="image alt" />
                                    </div>
                                    <!-- /.store -->
                                </div>
                                <!-- /.stores -->
                            </div>
                            <!-- /.footer-download-app -->
                        </div>
                        <!-- /.col-lg-6 col-md-6 col-sm-12 -->
                        <div class="col-lg-6 col-md-6 col-sm-12 mt-3 mt-lg-0 mt-md-0">
                            <div class="footer-payment-methods">
                                <div class="title">
                                    We Accept Payment
                                </div>
                                <!-- /.title -->
                                <div class="payments">
                                    <div class="payment">
                                        <img src="{{env('APP_URL')}}assets/icons/payment-visa.svg" alt="payment icon" />
                                    </div>
                                    <!-- /.payment -->
                                    <div class="payment">
                                        <img src="{{env('APP_URL')}}assets/icons/payment-mastercard.svg" alt="payment icon" />
                                    </div>
                                    <!-- /.payment -->
                                </div>
                                <!-- /.payments -->
                            </div>
                            <!-- /.footer-payment-methods -->
                        </div>
                        <!-- /.col-lg-6 col-md-6 col-sm-12 -->
                    </div>
                    <!-- /.row -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="small text-uppercase font-weight-bold">
                                Note
                            </div>
                            <div class="small mt-2">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </div>
                            <!-- /.small -->
                        </div>
                        <!-- /.col-12 -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.col-lg-6 col-md-6 col-sm-12 -->
            </div>
            <!-- /.row -->
            <div class="row mt-5">
                <div class="col-12 ">
                    <div class="small text-muted">
                       © Copyright 2018 Shopergy
                    </div>
                    <!-- /.small -->
                </div>
                <!-- /.col-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->

    </footer>
    <!-- ::::::-[ END-OF PAGE FOOTER ]-:::::: -->
    <!-- ::::::-[ Load Javascript Vendors ]-:::::: -->

    <script src="{{env('APP_URL')}}assets/vendors/popper.js/popperjs.min.js"></script>
    <script src="{{env('APP_URL')}}assets/vendors/bootstrap.4.1/js/bootstrap.min.js"></script>
    <script src="{{env('APP_URL')}}assets/vendors/owl-carousel/owl.carousel.min.js"></script>
    <script src="{{env('APP_URL')}}assets/vendors/parallax/parallax-scroll.js"></script>
    <script src="{{env('APP_URL')}}assets/vendors/sticky/jquery.sticky-sidebar.js"></script>
    <script src="{{env('APP_URL')}}assets/vendors/sticky-kit/sticky-kit.js"></script>
    <script src="{{env('APP_URL')}}assets/vendors/ion.rangeslider/js/ion.rangeSlider.js"></script>
    <script src="{{env('APP_URL')}}assets/vendors/icheck/icheck.min.js"></script>
    <script src="{{env('APP_URL')}}assets/vendors/countdown/jquery.countdown.min.js"></script>
   
    <!-- ::::::-[ Travelgo - Travel and Tours listings HTML template Javascript ]-::::::   -->
    <script src="{{env('APP_URL')}}assets/js/main.js"></script>
	<script src="{{env('APP_URL')}}assets/plugins/js/moment.min.js"></script>
	<script src="{{env('APP_URL')}}assets/plugins/js/daterangepicker.js"></script>	
	
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
	
	<script src="{{env('APP_URL')}}js/admin/maged-hotels.js"></script> 		
<script>
			$(function() {
			var now=new Date();
			
			var start_date =now.setDate(now.getDate()+2);
			start_date = new Date(start_date);
			

			  $('input[name="book-date"]').daterangepicker({
				  autoUpdateInput: false,
				  minDate: start_date,
				  locale: {
					  cancelLabel: 'Clear'
				  }
			  });

			  $('input[name="book-date"]').on('apply.daterangepicker', function(ev, picker) {
				  if(picker.startDate.format('MM/DD/YYYY') == picker.endDate.format('MM/DD/YYYY')){
					 $(this).val('');
				  }else{
					$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
				  }	
				  
			  });

			  $('input[name="book-date"]').on('cancel.daterangepicker', function(ev, picker) {
				  $(this).val('');
			  });
			  	
			});
</script>		

<script>
		
$(document).ready(function(){
    $( 'form' ).attr( 'autocomplete', 'off' );
    });
	</script>	
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-133866398-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-133866398-1');
</script>		
</body>
<!-- END-OF Home Page Body Tag -->


</html>