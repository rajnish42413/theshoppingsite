<?php 
use \App\Http\Controllers\NavigationMenuController;
 ?>
<?php 

$nav_menus = NavigationMenuController::get_main_nav_menus();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Title Start -->
	<title><?php echo $data['meta_title'];?></title>
	<!-- Meta Start -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php echo $data['meta_description'];?>">
	<meta name="keywords" content="<?php echo $data['meta_keywords'];?>">
	<meta name="author" content="<?php echo $data['meta_title'];?>">	
	<meta name="MobileOptimized" content="320">
	<!-- Style CSS -->
	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}assets/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}assets/css/animate.css" />
	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}assets/css/fonts.css" />
	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}assets/css/font-awesome.css" />
	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}assets/css/icofont.min.css" />
	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}assets/css/slider/owl.carousel.css" />
	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}assets/css/slider/owl.theme.css" />
	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}assets/css/product_zoom/slick.css" />
	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}assets/css/slider/index.css" />
	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}assets/css/rang_slider/rang.css" />
	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}assets/css/style.css" />
	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}assets/css/responsive.css" />
	<!-- Favicon Link -->
	<link rel="shortcut icon" type="image/png" href="{{env('APP_URL')}}assets/images/favicon.png" />
	<script src="{{env('APP_URL')}}assets/js/jquery.js"></script>	
</head>
<body>
<!-- Header Start -->
<header>
	<div class="sh_top_header_wrap sh_float_width">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<div class="sh_header_navbar sh_float_width">
						<div class="sh_logo_wrap">
							<a class="sh_logo" href="{{env('APP_URL')}}"><img src="{{env('APP_URL')}}assets/images/logo.png" alt="logo"></a>
						</div>
					</div>
				</div>
				<!-- Search bar -->
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 text-right">
					<div class="sh_Search_bar sh_float_width">
						<form>
							<input type="text" placeholder="Search" value="">
							<button>Search</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="sh_header_wrap sh_float_width">
		<div class="container">
			<div class="row">
				<!-- Collect menu -->
				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 pull-left">
					<div class="sh_main_menu_wrapper sh_float_width">
						<nav class="sh_main_menu sh_float_width" id="menu">
							<ul>                       
								<li><a class="active" href="{{env('APP_URL')}}">Home</a></li>
						<?php if($nav_menus){
								foreach($nav_menus as $menu){?>
								<li><a href="{{env('APP_URL')}}category/<?php echo $menu->slug;?>"><?php echo $menu->categoryName;?></a></li>
								<?php } } ?>
								<li><a class="" href="{{env('APP_URL')}}all-categories">See All Categories</a></li>
							</ul> 
						</nav>
					</div>
				</div>
				<!-- Social -->
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 pull-right">
					<div class="sh_header_social_links sh_float_width text-right">
						<ul>
							<li><a href="javacript:void(0)"><span class="fa fa-facebook"></span></a></li>
							<li><a href="javacript:void(0)"><span class="fa fa-linkedin"></span></a></li>
							<li><a href="javacript:void(0)"><span class="fa fa-google-plus"></span></a></li>
							<li><a href="javacript:void(0)"><span class="fa fa-twitter"></span></a></li>
							<li><a href="javacript:void(0)"><span class="fa fa-behance"></span></a></li>
							<li><a href="javacript:void(0)"><span class="fa fa-pinterest-p"></span></a></li>
						</ul>
						<div class="menu_icon text-right">
							<button class="sh_menu_btn"><span class="fa fa-bars"></span></button>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
</header>

        @yield('content')
		
<!-- Footer Start -->
<footer>
	<div class="sh_footer_wrap sh_float_width">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="sh_widgets sh_float_width">
						<h4>About</h4>
						<p>Connor Turnbull is a part-time writer demmo the technology industry and part-time web designer from the United Kingdom. Connor previously wrote for bellway.</p>
						<ul class="sh_social">
							<li><a href="javacript:void(0)"><span class="fa fa-facebook"></span></a></li>
							<li><a href="javacript:void(0)"><span class="fa fa-linkedin"></span></a></li>
							<li><a href="javacript:void(0)"><span class="fa fa-google-plus"></span></a></li>
							<li><a href="javacript:void(0)"><span class="fa fa-twitter"></span></a></li>
							<li><a href="javacript:void(0)"><span class="fa fa-behance"></span></a></li>
							<li><a href="javacript:void(0)"><span class="fa fa-pinterest-p"></span></a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="sh_widgets sh_widgets_link sh_float_width">
						<h4>useful Links</h4>
						<ul>
							<li><a href="{{env('APP_URL')}}about">About</a></li>
							<li><a href="javacript:void(0)">Affiliates</a></li>
							<li><a href="javacript:void(0)">API</a></li>
							<li><a href="javacript:void(0)">Blog</a></li>
							<li><a href="{{env('APP_URL')}}contact">Contact</a></li>
							<li><a href="{{env('APP_URL')}}faq">FAQ</a></li>
						</ul>
						<ul>
							<li><a href="javacript:void(0)">Jobs</a></li>
							<li><a href="javacript:void(0)">Legal</a></li>
							<li><a href="javacript:void(0)">Partners</a></li>
							<li><a href="javacript:void(0)">Press</a></li>
							<li><a href="javacript:void(0)">Turbo Lister Alternative</a></li>
							<li><a href="javacript:void(0)">Webstores</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="sh_widgets sh_float_width">
						<h4>Other Links</h4>
						<ul>
							<li><a href="javacript:void(0)">Cookies and Tracking</a></li>
							<li><a href="{{env('APP_URL')}}privacy-policy">Privacy Policy</a></li>
							<li><a href="{{env('APP_URL')}}terms-of-use">Terms of Use</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="sh_copyright_wrap sh_float_width">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-right text-right">
					<div class="sh_copyright_section">
						<a href="javacript:void(0)"><img src="{{env('APP_URL')}}assets/images/payment.png"></a>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-left">
					<div class="sh_copyright_section">
						<p>Copyright &copy; 2019 - All Right Reserved.</p>
					</div>
				</div>
			</div>
		</div>
	</div>	
</footer>	
<!--Main js file Style--> 
<script src="{{env('APP_URL')}}assets/js/slider/owl.carousel.js"></script>
<script src="{{env('APP_URL')}}assets/js/slider/index.js"></script>
<script src="{{env('APP_URL')}}assets/js/bootstrap.js"></script>
<script src="{{env('APP_URL')}}assets/js/custom.js"></script> 

<script src="{{env('APP_URL')}}assets/js/product_zoom/jquery.zoom.min.js"></script>
<script src="{{env('APP_URL')}}assets/js/product_zoom/slick.min.js"></script>
<script>

/*-------- Product Zoom and Slider -----------*/
	
		 // SLICK
		 $('.slider-for').slick({
		  slidesToShow: 1,
		  slidesToScroll: 1,
		  arrows: false,
		  fade: true,
		  asNavFor: '.slider-nav'
		});
		$('.slider-nav').slick({
		  slidesToShow: 3,
		  slidesToScroll: 1,
		  asNavFor: '.slider-for',
		  dots: false,
		  focusOnSelect: true
		});
		// ZOOM
		$('.ex1').zoom();

		// STYLE GRAB
		$('.ex2').zoom({ on:'grab' });

		// STYLE CLICK
		$('.ex3').zoom({ on:'click' });	

		// STYLE TOGGLE
		$('.ex4').zoom({ on:'toggle' });
	


</script> 

</body>
</html>