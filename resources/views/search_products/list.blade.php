@extends('layouts.app')

@section('content')
<!--Main Wrapper Start-->
<div class="sh_main_wrap sh_float_width">
	<!--Breadcurm Start-->
	<div class="sh_breadcurm_wrap sh_float_width">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="sh_breadcurm sh_float_width">
						<ul>
							<?php if($data['parent_category'] != ''){?>
							<li><a href="javacript:void(0)"><?php echo $data['parent_category'];?></a></li>
							<?php } ?>
							<?php if($data['category'] != ''){?>
								<li><a href="javacript:void(0)"><?php echo $data['category'];?></a></li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>	
		</div>	
	</div>	
	<!-- Search Grid Start-->
	<div class="sh_search_grid_wrap sh_float_width">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
					<div class="sh_float_width">
						<a href="javascript:void(0)" id="sh_filter_menu">Filter</a>
					</div>
					<div id="sh_filter_menu_wrapper" class="sh_float_width">
						<div class="sh_side_bar sh_float_width">
							<div class="sh_side_bar_section sh_float_width">
								<h4 class="sh_nav_title">Categories</h4>
								<div class="sh_side_widget sh_cat_search_form sh_float_width">
									<form>
										<input type="text" placeholder="Search" value="">
										<button><span class="icofont-search-2"></span></button>
									</form>
								</div>
								<div class="sh_side_widget sh_sidear_cat_menu sh_float_width">
								<?php if($categories){?>
									<ul>								
									<?php foreach($categories as $cat){?>
										<li><a href="<?php echo env('APP_URL')."category/".$cat->slug;?>"><?php echo $cat->categoryName;?></a></li>
									<?php } ?>
									</ul>
								<?php } ?>
								</div>
								<div class="sh_side_widget sh_sidear_cat_price_filter sh_float_width">
									<h4 class="sh_sidecat_heading">Filter By Price</h4>
									<div class="wrapper">
										<div class="range-slider">
											<input type="text" class="js-range-slider" value="" />
										</div>
										<div class="extra-controls form-inline">
											<div class="form-group">
												<input type="text" class="js-input-from form-control" value="0" />
												<input type="text" class="js-input-to form-control" value="0" />
											</div>
										</div>
										<div class="sh_filter_pri">
											<a class="sh_btn" href="javacript:void(0)">Filter</a>
										</div>
									</div>
								</div>
								<div class="sh_side_widget sh_sidear_cat_brands sh_float_width">
									<h4 class="sh_sidecat_heading">Brand</h4>
									<ul>
										<li><a href="javacript:void(0)">Philips</a></li>
										<li><a href="javacript:void(0)">Acer</a></li>
										<li><a href="javacript:void(0)">Canon</a></li>
										<li><a href="javacript:void(0)">Hitichi</a></li>	
										<li><a href="javacript:void(0)">Toshiba</a></li>	
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
					<div class="sh_product_grid sh_float_width">
						<div class="sh_product_grid_top sh_float_width">
							<div class="col-lg-5 col-md-5 col-sm-4 col-xs-6">
								<div class="sh_search_filter sh_float_width">
									<ul>
										<li>Show Result:</li>
										<li>
											<select>
												<option>1 to 10</option>
												<option>1 to 20</option>
												<option>1 to 30</option>
												<option>1 to 40</option>
											</select>
										</li>
									</ul>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
								<div class="sh_search_filter sh_float_width">
									<ul>
										<li>Sort by:</li>
										<li>
											<select>
												<option>Price: Low to High</option>
												<option>Price: High to Low</option>
												<option>Price: Low to High</option>
												<option>Price: Low to High</option>
											</select>
										</li>
									</ul>
								</div>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 text-right">
								<div class="sh_search_filter sh_float_width">
									<ul>
										<li>View:</li>
										<li><a href="javacript:void(0)" class="active"><span class="icofont-listine-dots"></span></a></li>
										<li><a href="javacript:void(0)"><span class="icofont-transparent"></span></a></li>
									</ul>
								</div>
							</div>
						</div>
				<?php if($products){
					foreach($products as $product){?>
					
						<?php  
						$galleryURL = env('APP_URL')."assets/images/no_image.png";
						$PictureDetails = $product->PictureDetails; 
						if($PictureDetails != ''){
							$pic_det = json_decode($PictureDetails);
							if($pic_det && isset($pic_det->GalleryURL) && $pic_det->GalleryURL != ''){
								$galleryURL = $pic_det->GalleryURL;
							}
						}
						?>
					
						<div class="sh_product_list_product sh_float_width">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 sh_padding0">
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<div class="sh_list_product_img sh_float_width">
										<img src="<?php echo $galleryURL;?>">
										<a href="javacript:void(0)">Quick View</a>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<div class="sh_list_product_text sh_float_width">
										<p><?php echo $product->categoryName;?></p>
										<h4 class="sh_prod_name"><?php echo $product->title;?></h4>
										<div class="sh_about_prod sh_float_width">
											<div class="sh_product_review sh_float_width">
												<ul>
													<li><span class="fa fa-star"></span></li>
													<li><span class="fa fa-star"></span></li>
													<li><span class="fa fa-star"></span></li>
													<li><span class="fa fa-star"></span></li>
													<li><span class="fa fa-star-o"></span></li>
													<li> (299)</li>
												</ul>
											</div>
											<div class="sh_product_features sh_float_width">
												<ul>
													<li>Display: 6.1-inch Liquid</li>
													<li>Store: 64GB, 128GB, 256GB</li>
													<li>Metarial: All-glass</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<div class="sh_list_product_price_wrap sh_float_width">
										<h1>$<?php echo $product->current_price;?></h1>
										<div class="sh_less_price_store sh_float_width text-left">
											<a href="javacript:void(0)"><img src="{{env('APP_URL')}}assets/images/ebay.png"></a>
										</div>
										<a class="sh_btn" href="{{ env('APP_URL')}}product/<?php echo $product->itemId;?>">View Product</a>
									</div>
								</div>
							</div>
						</div>
				<?php } } ?>
						</div>
						
					</div>
				</div>
				
			</div>	
		</div>	
	</div>	
	
</div>	
			
@endsection
