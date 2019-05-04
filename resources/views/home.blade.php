@extends('layouts.app')

@section('content')
 
 <!--Main Wrapper Start-->
<div class="sh_main_wrap sh_float_width">
	<!--Slider Start-->
	<div class="sh_slider_wrapper sh_float_width">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 padder_right">
					<div class="sh_float_width">
						<div class="bookmarks">
							<ul class="test">
								<li class="bookmark1 active" data="0">
									<div class="nav_text">
										<h4>Explore More</h4>
										<h6 href="javacript:void(0)">shopergy.com</h6>
										<p>Find the best price on thousands of products.</p>
									</div>
								</li>
								<li class="bookmark2" data="1">
									<div class="nav_text">
										<h4>Shop By Category</h4>
										<p>Find the best price on thousands of products.</p>
									</div>
								</li>
								<li class="bookmark3" data="2">
									<div class="nav_text">
										<h4>Top Brands</h4>
										<p>Find the best price on thousands of products.</p>
									</div>
								</li>
								<li class="bookmark4" data="3">
									<div class="nav_text">
										<h4>Top  Product</h4>
										<p>Find the best price on thousands of products.</p>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-8 padder_left">
					<div class="sh_float_width">
						<div class="owl-carousel owlExample">
							<div class="item" id="bookmark1">
								<div class="sh_slide_content">
									<img src="{{env('APP_URL')}}assets/images/slide1.jpg" alt="">
								</div>
							</div>
							<div class="item" id="bookmark2">
								<div class="sh_slide_content">
									<img src="{{env('APP_URL')}}assets/images/slide2.jpg" alt="">
								</div>
							</div>
							<div class="item" id="bookmark3">
								<div class="sh_slide_content">
									<img src="{{env('APP_URL')}}assets/images/slide3.jpg" alt="">
								</div>
							</div>
							<div class="item" id="bookmark4">
								<div class="sh_slide_content">
									<img src="{{env('APP_URL')}}assets/images/slide4.jpg" alt="">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Top Categories -->
	<div class="sh_category_wrapper sh_float_width">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-8 col-sm-12 col-xs-12 col-lg-offset-3 col-md-offset-2">
					<div class="sh_heading">
						<h2>Top categories</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="sh_top_category_section sh_float_width">
						<div class="sh_top_cat_img sh_float_width">
							<a href="javascript:void(0);"><img src="{{env('APP_URL')}}assets/images/cat1.jpg"></a>
						</div>
						<div class="sh_cat_name sh_float_width">
							<a href="javascript:void(0);"><h4>Dresses</h4></a>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="sh_top_category_section sh_float_width">
						<div class="sh_top_cat_img sh_float_width">
							<a href="javascript:void(0);"><img src="{{env('APP_URL')}}assets/images/cat2.jpg"></a>
						</div>
						<div class="sh_cat_name sh_float_width">
							<a href="javascript:void(0);"><h4>Laptop Bag</h4></a>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="sh_top_category_section sh_float_width">
						<div class="sh_top_cat_img sh_float_width">
							<a href="javascript:void(0);"><img src="{{env('APP_URL')}}assets/images/cat3.jpg"></a>
						</div>
						<div class="sh_cat_name sh_float_width">
							<a href="javascript:void(0);"><h4>Watches</h4></a>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="sh_top_category_section sh_float_width">
						<div class="sh_top_cat_img sh_float_width">
							<a href="javascript:void(0);"><img src="{{env('APP_URL')}}assets/images/cat4.jpg"></a>
						</div>
						<div class="sh_cat_name sh_float_width">
							<a href="javascript:void(0);"><h4>Laptop</h4></a>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="sh_top_category_section sh_float_width">
						<div class="sh_top_cat_img sh_float_width">
							<a href="javascript:void(0);"><img src="{{env('APP_URL')}}assets/images/cat5.jpg"></a>
						</div>
						<div class="sh_cat_name sh_float_width">
							<a href="javascript:void(0);"><h4>Jackets</h4></a>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="sh_top_category_section sh_float_width">
						<div class="sh_top_cat_img sh_float_width">
							<a href="javascript:void(0);"><img src="{{env('APP_URL')}}assets/images/cat6.jpg"></a>
						</div>
						<div class="sh_cat_name sh_float_width">
							<a href="javascript:void(0);"><h4>Lamps</h4></a>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="sh_top_category_section sh_float_width">
						<div class="sh_top_cat_img sh_float_width">
							<a href="javascript:void(0);"><img src="{{env('APP_URL')}}assets/images/cat7.jpg"></a>
						</div>
						<div class="sh_cat_name sh_float_width">
							<a href="javascript:void(0);"><h4>Clocks</h4></a>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="sh_top_category_section sh_float_width">
						<div class="sh_top_cat_img sh_float_width">
							<a href="javascript:void(0);"><img src="{{env('APP_URL')}}assets/images/cat8.jpg"></a>
						</div>
						<div class="sh_cat_name sh_float_width">
							<a href="javascript:void(0);"><h4>Chairs</h4></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Top Product -->
	<div class="sh_product_wrapper sh_float_width">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-8 col-sm-12 col-xs-12 col-lg-offset-3 col-md-offset-2">
					<div class="sh_heading">
						<h2>Top Products</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="sh_top_prod owl-carousel sh_float_width">
						<div class="item">
							<div class="sh_top_product_section sh_float_width">
								<img src="{{env('APP_URL')}}assets/images/top_prod/shoe.jpg">
								<div class="sh_top_prod_name">
									<h2><span>From</span>$199.00</h2>
									<h4>Nike Blazer Mid '77 Vintage</h4>
									<h6>Retro Trainers</h6>
									<ul class="sh_review_color">
										<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
										<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
										<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
										<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
										<li><a href="javacript:void(0)"><span class="fa fa-star-half-o"></span></a></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="item">
							<div class="sh_top_product_section sh_float_width">
								<img src="{{env('APP_URL')}}assets/images/top_prod/1.jpg">
								<div class="sh_top_prod_name">
									<h2><span>From</span>$199.00</h2>
									<h4>Nike Blazer Mid '77 Vintage</h4>
									<h6>Retro Trainers</h6>
									<ul class="sh_review_color">
										<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
										<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
										<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
										<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
										<li><a href="javacript:void(0)"><span class="fa fa-star-half-o"></span></a></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="item">
							<div class="sh_top_product_section sh_float_width">
								<img src="{{env('APP_URL')}}assets/images/top_prod/2.jpg">
								<div class="sh_top_prod_name">
									<h2><span>From</span>$199.00</h2>
									<h4>Nike Blazer Mid '77 Vintage</h4>
									<h6>Retro Trainers</h6>
									<ul class="sh_review_color">
										<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
										<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
										<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
										<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
										<li><a href="javacript:void(0)"><span class="fa fa-star-half-o"></span></a></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="item">
							<div class="sh_top_product_section sh_float_width">
								<img src="{{env('APP_URL')}}assets/images/top_prod/3.jpg">
								<div class="sh_top_prod_name">
									<h2><span>From</span>$199.00</h2>
									<h4>Nike Blazer Mid '77 Vintage</h4>
									<h6>Retro Trainers</h6>
									<ul class="sh_review_color">
										<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
										<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
										<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
										<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
										<li><a href="javacript:void(0)"><span class="fa fa-star-half-o"></span></a></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="item">
							<div class="sh_top_product_section sh_float_width">
								<img src="{{env('APP_URL')}}assets/images/top_prod/4.jpg">
								<div class="sh_top_prod_name">
									<h2><span>From</span>$199.00</h2>
									<h4>Nike Blazer Mid '77 Vintage</h4>
									<h6>Retro Trainers</h6>
									<ul class="sh_review_color">
										<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
										<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
										<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
										<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
										<li><a href="javacript:void(0)"><span class="fa fa-star-half-o"></span></a></li>
									</ul>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Top Deals -->
	<div class="sh_deals_wrapper sh_float_width">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-8 col-sm-12 col-xs-12 col-lg-offset-3 col-md-offset-2">
					<div class="sh_heading">
						<h2>Deal of the day</h2>
						<p>% = saving compared to the average Price of the last 90days</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="sh_top_deals_wrap owl-carousel sh_float_width">
						<div class="item">
							<div class="sh_top_deals_section sh_float_width">
								<div class="sh_deal_offer">
									<span>-28%</span>
								</div>
								<img src="{{env('APP_URL')}}assets/images/top_prod/5.jpg">
								<div class="sh_top_deals_name">
									<h2><span>From</span>$199.00</h2>
									<h4>Nike Blazer Mid '77 Vintage</h4>
									<h6>Retro Trainers</h6>
								</div>
							</div>
						</div>
						<div class="item">
							<div class="sh_top_deals_section sh_float_width">
								<div class="sh_deal_offer">
									<span>-24%</span>
								</div>
								<img src="{{env('APP_URL')}}assets/images/top_prod/6.jpg">
								<div class="sh_top_deals_name">
									<h2><span>From</span>$199.00</h2>
									<h4>Nike Blazer Mid '77 Vintage</h4>
									<h6>Retro Trainers</h6>
								</div>
							</div>
						</div>
						<div class="item">
							<div class="sh_top_deals_section sh_float_width">
								<div class="sh_deal_offer">
									<span>-22%</span>
								</div>
								<img src="{{env('APP_URL')}}assets/images/top_prod/7.jpg">
								<div class="sh_top_deals_name">
									<h2><span>From</span>$199.00</h2>
									<h4>Nike Blazer Mid '77 Vintage</h4>
									<h6>Retro Trainers</h6>
								</div>
							</div>
						</div>
						<div class="item">
							<div class="sh_top_deals_section sh_float_width">
								<div class="sh_deal_offer">
									<span>-18%</span>
								</div>
								<img src="{{env('APP_URL')}}assets/images/top_prod/8.jpg">
								<div class="sh_top_deals_name">
									<h2><span>From</span>$199.00</h2>
									<h4>Nike Blazer Mid '77 Vintage</h4>
									<h6>Retro Trainers</h6>
								</div>
							</div>
						</div>
						<div class="item">
							<div class="sh_top_deals_section sh_float_width">
								<div class="sh_deal_offer">
									<span>-5%</span>
								</div>
								<img src="{{env('APP_URL')}}assets/images/top_prod/shoe.jpg">
								<div class="sh_top_deals_name">
									<h2><span>From</span>$199.00</h2>
									<h4>Nike Blazer Mid '77 Vintage</h4>
									<h6>Retro Trainers</h6>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Home Add Section -->
	<div class="sh_add_wrapper sh_float_width">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="sh_add_section sh_float_width">
						<img src="{{env('APP_URL')}}assets/images/ad.png">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>	
 
@endsection
