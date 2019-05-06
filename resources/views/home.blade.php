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
					<?php if($banners && $banners->count() > 0){
						$no = 1;?>
						<div class="bookmarks">
							<ul class="test">
							<?php foreach($banners as $banner){?>
								<li class="bookmark<?php echo $no;?> active" data="<?php echo $no-1;?>">
									<div class="nav_text">
										<h4><?php echo $banner->heading_title;?></h4>
										<p><?php echo $banner->description;?></p>
									</div>
								</li>
							<?php $no++; } ?>
							</ul>
						</div>
					<?php } ?>
					</div>
				</div>
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-8 padder_left">
					<div class="sh_float_width">
					<?php if($banners && $banners->count() > 0){
						$no = 1;?>
						<div class="owl-carousel owlExample">
						<?php foreach($banners as $banner){?>
							<div class="item" id="bookmark<?php echo $no;?>">
								<div class="sh_slide_content">
									<img src="{{env('APP_URL')}}banner_files/<?php echo $banner->display_image;?>" alt="<?php echo $banner->name;?>">
								</div>
							</div>
						<?php $no++; } ?>
						</div>
					<?php } ?>
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
