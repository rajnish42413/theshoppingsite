
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
     <title>{{ config('app.name') }}</title>
	<meta name="keywords" content="{{ config('app.name') }}" />
    <meta name="description" content="{{ config('app.name') }}" />
    <meta name="author" content="{{ config('app.name') }}" />
    <!-- Page title -->
 
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
    <script src="{{env('APP_URL')}}assets/vendors/jquery/jquery.3.3.1.js"></script>	
</head>
<!-- START-OF Home Page Body Tag -->

<body>
	
	 @yield('auth_content')
		 
    <script src="{{env('APP_URL')}}assets/vendors/popper.js/popperjs.min.js"></script>
    <script src="{{env('APP_URL')}}assets/vendors/bootstrap.4.1/js/bootstrap.min.js"></script>
    <script src="{{env('APP_URL')}}assets/vendors/owl-carousel/owl.carousel.min.js"></script>
    <script src="{{env('APP_URL')}}assets/vendors/parallax/parallax-scroll.js"></script>
    <script src="{{env('APP_URL')}}assets/vendors/sticky/jquery.sticky-sidebar.js"></script>
    <script src="{{env('APP_URL')}}assets/vendors/sticky-kit/sticky-kit.js"></script>
    <script src="{{env('APP_URL')}}assets/vendors/ion.rangeslider/js/ion.rangeSlider.js"></script>
    <script src="{{env('APP_URL')}}assets/vendors/icheck/icheck.min.js"></script>
    <script src="{{env('APP_URL')}}assets/vendors/countdown/jquery.countdown.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <!-- ::::::-[ Travelgo - Travel and Tours listings HTML template Javascript ]-::::::   -->
    <script src="{{env('APP_URL')}}assets/js/main.js"></script>

	

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