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
							<?php foreach($banners as $banner){
								
								?>
								<li class="bookmark<?php echo $no;?> active" data="<?php echo $no-1;?>">
									<div class="nav_text">
										<h4><?php echo $banner->heading_title;?></h4>
										<p><?php echo $banner->description;?></p>
										<?php if($banner->url_link != ''){?><a href="javascript:void(0)" class="btn see_all_list" onclick="goToUrl('<?php echo $banner->url_link;?>')" target="_blank">See All</a>
										<?php  } ?>
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

<?php if($top_categories && $top_categories->count() > 0){?>
	<!-- Top Category -->
	<div class="sh_category_wrapper sh_float_width top_categories">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-8 col-sm-12 col-xs-12 col-lg-offset-3 col-md-offset-2">
					<div class="sh_heading">
						<h2>Top Categories</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="sh_top_prod owl-carousel sh_float_width">
					<?php foreach($top_categories as $tc){
						$cat_img = env('APP_URL')."assets/images/no_image.png";
						if($tc->image!=''){
							$cat_img = env('APP_URL')."category_files/".$tc->image;
						}
						?>
						<div class="item">
							<div class="sh_top_category_section sh_float_width">
								<div class="sh_top_cat_img sh_float_width">
									<a href="<?php echo env('APP_URL')."category/".$tc->slug;?>"><img src="<?php echo $cat_img;?>"></a>
								</div>
								<div class="sh_cat_name sh_float_width">
									<a href="<?php echo env('APP_URL')."category/".$tc->slug;?>"><h4><?php echo $tc->categoryName;?></h4></a>
								</div>
							</div>
						</div>
					<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>

<?php if($top_products && $top_products->count() > 0){?>
	<!-- Top Product -->
	<div class="sh_product_wrapper sh_float_width top_products">
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
					<?php foreach($top_products as $tp){?>
					
						<?php  
						$galleryURL = env('APP_URL')."assets/images/no_image.png";
						$PictureDetails = $tp->PictureDetails; 
						if($PictureDetails != ''){
							$pic_det = json_decode($PictureDetails);
							if($pic_det && isset($pic_det->GalleryURL) && $pic_det->GalleryURL != ''){
								$galleryURL = $pic_det->GalleryURL;
							}
						}
						?>
					
						<div class="item">
							<div class="sh_top_product_section sh_float_width">
								<a href="<?php echo env('APP_URL')."product/".$tp->slug;?>"><img src="<?php echo $galleryURL;?>"></a>
								<div class="sh_top_prod_name">
									<h2><span>From</span>$<?php echo $tp->current_price;?></h2>
									
									<h6><?php echo $tp->title;?></h6>
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
					<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<?php if($deals && $deals->count() > 0){?>
	<!-- Top Deals -->
	<div class="sh_deals_wrapper sh_float_width deals">
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
					<?php foreach($deals as $d){?>
					
						<?php  
						$dealgalleryURL = env('APP_URL')."assets/images/no_image.png";
						$dealPictureDetails = $d->PictureDetails; 
						if($dealPictureDetails != ''){
							$dealpic_det = json_decode($dealPictureDetails);
							if($dealpic_det && isset($dealpic_det->GalleryURL) && $dealpic_det->GalleryURL != ''){
								$dealgalleryURL = $dealpic_det->GalleryURL;
							}
						}
						?>					
						<div class="item">
							<div class="sh_top_deals_section sh_float_width">
								<div class="sh_deal_offer">
									<span>-<?php echo rand(5,30);?>%</span>
								</div>
								<a href="<?php echo env('APP_URL')."product/".$d->slug;?>">
								<img src="<?php echo $dealgalleryURL;?>">
								</a>
								<div class="sh_top_deals_name">
									<h2><span>From</span>$<?php echo $d->current_price;?></h2>
									<h6><?php echo $d->title;?></h6>
								</div>
							</div>
						</div>
					<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>	

<div class="sh_deals_wrapper sh_float_width " id="BlogPage">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-8 col-sm-12 col-xs-12 col-lg-offset-3 col-md-offset-2">
					<div class="sh_heading">
						<h2>Blog</h2>
						<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="sh_top_deals_wrap owl-carousel sh_float_width">
						<div class="item">
						<a href="<?php echo env('APP_URL')?>blog_detail">
							<div class="sh_top_deals_section sh_float_width">
								<!-- <div class="sh_deal_offer">
									<span>-28%</span>
								</div> -->
								<img src="<?php echo env('APP_URL')?>assets/top_prod/5.jpg">
								<div class="sh_top_deals_name">
									<h2><span>From</span>$199.00</h2>
									<h4>Nike Blazer Mid '77 Vintage</h4>
									<h6>Retro Trainers</h6>
								</div>
							</div>
							</a>
						</div>
						<div class="item">
						<a href="<?php echo env('APP_URL')?>blog_detail">
							<div class="sh_top_deals_section sh_float_width">
								<!-- <div class="sh_deal_offer">
									<span>-24%</span>
								</div> -->
								<img src="<?php echo env('APP_URL')?>assets/top_prod/6.jpg">
								<div class="sh_top_deals_name">
									<h2><span>From</span>$199.00</h2>
									<h4>Nike Blazer Mid '77 Vintage</h4>
									<h6>Retro Trainers</h6>
								</div>
							</div>
							</a>
						</div>
						<div class="item">
						<a href="<?php echo env('APP_URL')?>blog_detail">
							<div class="sh_top_deals_section sh_float_width">
								<!-- <div class="sh_deal_offer">
									<span>-22%</span>
								</div> -->
								<img src="<?php echo env('APP_URL')?>assets/top_prod/7.jpg">
								<div class="sh_top_deals_name">
									<h2><span>From</span>$199.00</h2>
									<h4>Nike Blazer Mid '77 Vintage</h4>
									<h6>Retro Trainers</h6>
								</div>
							</div>
							</a>
						</div>
						<div class="item">
						<a href="<?php echo env('APP_URL')?>blog_detail">
							<div class="sh_top_deals_section sh_float_width">
								<!-- <div class="sh_deal_offer">
									<span>-18%</span>
								</div> -->
								<img src="<?php echo env('APP_URL')?>assets/top_prod/8.jpg">
								<div class="sh_top_deals_name">
									<h2><span>From</span>$199.00</h2>
									<h4>Nike Blazer Mid '77 Vintage</h4>
									<h6>Retro Trainers</h6>
								</div>
							</div>
							</a>
						</div>
						<div class="item">
						<a href="<?php echo env('APP_URL')?>blog_detail">
							<div class="sh_top_deals_section sh_float_width">
								<!-- <div class="sh_deal_offer">
									<span>-5%</span>
								</div> -->
								<img src="<?php echo env('APP_URL')?>assets/top_prod/shoe.jpg">
								<div class="sh_top_deals_name">
									<h2><span>From</span>$199.00</h2>
									<h4>Nike Blazer Mid '77 Vintage</h4>
									<h6>Retro Trainers</h6>
								</div>
							</div>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	
	<!-- Home Add Section -->
	<div class="clearfix"></div>
	<div class="sh_add_wrapper sh_float_width">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="sh_add_section sh_float_width">
					<!--	<img src="{{env('APP_URL')}}assets/images/ad.png">-->
						<div class="alignleft">
							<script type="text/javascript">
								amzn_assoc_ad_type = "banner";
								amzn_assoc_marketplace = "amazon";
								amzn_assoc_region = "US";
								amzn_assoc_placement = "assoc_banner_placement_default";
								amzn_assoc_campaigns = "amazonhomepage";
								amzn_assoc_banner_type = "rotating";
								amzn_assoc_p = "48";
								amzn_assoc_width = "728";
								amzn_assoc_height = "90";
								amzn_assoc_tracking_id = "theshoppi0545-20";
								amzn_assoc_linkid = "c6ae37b4687fae96f4e68aeabde17faf";
							</script>
							<script src="//z-na.amazon-adsystem.com/widgets/q?ServiceVersion=20070822&Operation=GetScript&ID=OneJS&WS=1"></script>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>	
 <script>
 function goToUrl(url){
	window.open(url, '_blank');
 }
 </script>
@endsection
