@extends('layouts.app')

@section('content')
<?php
use \App\Http\Controllers\HotelController;
?>
<!--Main Wrapper Start-->
<div class="sh_main_wrap sh_float_width">
	<!--Breadcurm Start-->
	<div class="sh_breadcurm_wrap sh_float_width">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="sh_breadcurm sh_float_width">
						<ul>
							<li><a href="javacript:void(0)">Electronics</a></li>
							<li><a href="javacript:void(0)">computer &amp; Laptops</a></li>
							<li><a href="javacript:void(0)">Hardware</a></li>
							<li><strong>Mackbook</strong></li>
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
								<ul>								
									<li><a href="javacript:void(0)">Office Electronics</a></li>
									<li><a href="javacript:void(0)">Tablet</a></li>
									<li><a href="javacript:void(0)">Computer Components</a></li>
									<li><a href="javacript:void(0)">Tablet Accessories</a></li>
									<li>
										<a href="javacript:void(0)">Computer & Laptop</a>
										<ul class="sh_sub_category">
											<li><a href="javacript:void(0)">Desktop
											</a></li>
											<li><a href="javacript:void(0)">Servers</a></li>
											<li><a href="javacript:void(0)">Macbook</a></li>
											<li><a href="javacript:void(0)">Antivirus</a></li>
											<li><a href="javacript:void(0)">Laptops</a></li>
											<li><a href="javacript:void(0)">Accessories</a></li>
										</ul>
									</li>
									<li><a href="javacript:void(0)">Networking</a></li>
									<li><a href="javacript:void(0)">Memory Cards &amp; SSD</a></li>
									<li><a href="javacript:void(0)">Cables &amp; Connector</a></li>
									<li><a href="javacript:void(0)">Mini PC</a></li>
								</ul>								
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
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
					<div class="sh_product_grid sh_float_width">
						<div class="sh_product_grid_top sh_float_width">
							<div class="col-lg-5 col-md-5 col-sm-4 col-xs-12">
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
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
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
						<div class="sh_product_list_product sh_float_width">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 sh_padding0">
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<div class="sh_list_product_img sh_float_width">
										<img src="images/grid/product12.jpg">
										<a href="javacript:void(0)">Quick View</a>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<div class="sh_list_product_text sh_float_width">
										<p>Phone</p>
										<h4 class="sh_prod_name">Samsung Galaxy S9 Limited</h4>
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
										<h1>$299.00</h1>
										<div class="sh_less_price_store sh_float_width text-left">
											<a href="javacript:void(0)"><img src="images/amazon.png"></a>
										</div>
										<a class="sh_btn" href="javacript:void(0)">View Product</a>
									</div>
								</div>
							</div>
						</div>
						<div class="sh_product_list_product sh_float_width">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 sh_padding0">
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<div class="sh_list_product_img sh_float_width">
										<img src="images/grid/product1.jpg">
										<a href="javacript:void(0)">Quick View</a>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<div class="sh_list_product_text sh_float_width">
										<p>Phone</p>
										<h4 class="sh_prod_name">Samsung Galaxy S9 Limited</h4>
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
										<h1>$299.00</h1>
										<div class="sh_less_price_store sh_float_width text-left">
											<a href="javacript:void(0)"><img src="images/ebay.png"></a>
										</div>
										<a class="sh_btn" href="javacript:void(0)">View Product</a>
									</div>
								</div>
							</div>
						</div>
						<div class="sh_product_list_product sh_float_width">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 sh_padding0">
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<div class="sh_list_product_img sh_float_width">
										<img src="images/grid/product6.jpg">
										<a href="javacript:void(0)">Quick View</a>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<div class="sh_list_product_text sh_float_width">
										<p>Phone</p>
										<h4 class="sh_prod_name">Samsung Galaxy S9 Limited</h4>
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
										<h1>$299.00</h1>
										<div class="sh_less_price_store sh_float_width text-left">
											<a href="javacript:void(0)"><img src="images/amazon.png"></a>
										</div>
										<a class="sh_btn" href="javacript:void(0)">View Product</a>
									</div>
								</div>
							</div>
						</div>
						<div class="sh_product_list_product sh_float_width">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 sh_padding0">
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<div class="sh_list_product_img sh_float_width">
										<img src="images/grid/product8.jpg">
										<a href="javacript:void(0)">Quick View</a>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<div class="sh_list_product_text sh_float_width">
										<p>Phone</p>
										<h4 class="sh_prod_name">Samsung Galaxy S9 Limited</h4>
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
										<h1>$299.00</h1>
										<div class="sh_less_price_store sh_float_width text-left">
											<a href="javacript:void(0)"><img src="images/ebay.png"></a>
										</div>
										<a class="sh_btn" href="javacript:void(0)">View Product</a>
									</div>
								</div>
							</div>
						</div>
						<div class="sh_product_list_product sh_float_width">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 sh_padding0">
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<div class="sh_list_product_img sh_float_width">
										<img src="images/grid/product1.jpg">
										<a href="javacript:void(0)">Quick View</a>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<div class="sh_list_product_text sh_float_width">
										<p>Phone</p>
										<h4 class="sh_prod_name">Samsung Galaxy S9 Limited</h4>
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
										<h1>$299.00</h1>
										<div class="sh_less_price_store sh_float_width text-left">
											<a href="javacript:void(0)"><img src="images/amazon.png"></a>
										</div>
										<a class="sh_btn" href="javacript:void(0)">View Product</a>
									</div>
								</div>
							</div>
						</div>
						
					</div>
				</div>
				
			</div>	
		</div>	
	</div>	
	
</div>	
			
@endsection
