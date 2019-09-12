@extends('layouts.app')

@section('content')
 <style>
 .ProductDetails a,.ProductDetails  a:hover,.ProductDetails  a:focus {
    color: #ff0000;
 }
 </style>
<div class="sh_main_wrap sh_float_width">
	<!--Breadcurm Start-->
	<div class="sh_breadcurm_wrap sh_float_width">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="sh_breadcurm sh_float_width">
						<ul>
							<li><a href="javacript:void(0)">Cell Phones & Accessories</a></li>
							<li><a href="javacript:void(0)">Smart Watches</a></li>
							<li><strong><?php echo $data['detail']['title'];?></strong></li>
						</ul>
					</div>
				</div>
			</div>	
		</div>	
	</div>	

	<div class="sh_product_view_img_wrap sh_float_width">
		<div class="container">
			<div class="row">
				<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
					<div class="sh_product_view_img sh_float_width">
						<div class="slider-wrapper">
							<div class="slider-for">
								<div class="slider-for__item ex1" data-src="<?php echo $data['detail']['image'];?>">
									<img src="<?php echo $data['detail']['image'];?>" alt="" />
								</div>

							</div>
							
						</div>
					</div>
				</div>
				<div class="col-lg-7 col-md-7 col-sm-6 col-xs-12">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="sh_product_view_name sh_float_width">
						<h2 style="font-size: 26px;margin-bottom: 10px !important;"><?php echo $data['detail']['title'];?></h2>
						<div class="sh_product_view_rating sh_float_width">
							<ul class="list-inline">
								<li><span>Rating :</span></li>
								<li><span class="fa fa-star"></span></li>
								<li><span class="fa fa-star"></span></li>
								<li><span class="fa fa-star"></span></li>
								<li><span class="fa fa-star"></span></li>
								<li><span class="fa fa-star-o"></span></li>
								<li><span>(786876)</span></li>
							</ul>
						</div>
					</div>
				</div>
				
				<div class="col-sm-12 SocialShareIcon">
				<div class="">
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
					<div class="sh_header_social_links sh_float_width">
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
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right">
					<div class="sh_product_view_name sh_float_width">
						<h6>Updated On: <?php echo date('j M Y',strtotime($data['detail']['updated_at']));?></h6>
					</div>
				</div>
				</div>
				</div>
				<div class="ProductDetails">
				<?php echo $data['detail']['description'];?>
				</div>
				</div>
			</div>	
		</div>	
	</div>	
	<!--- Product Sescribtion---->
	<div class="sh_product_describtion_wrap sh_float_width">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="sh_product_tab_view sh_float_width">
						<div class="row">
							<ul id="myTabs" class="nav nav-pills nav-justified" role="tablist" data-tabs="tabs">
								<li class="active"><a href="#sh_comapre_price" data-toggle="tab">Comapre Price</a></li>
								<li><a href="#sh_product_deatail" data-toggle="tab">Product Detail</a></li>
								<li><a href="#sh_riview" data-toggle="tab">Reviews</a></li>
								<li><a href="#sh_faq" data-toggle="tab">FAQ's</a></li>
							</ul>
						</div>
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane fade in active" id="sh_comapre_price">
								<div class="sh_tab_compare_wrap">
									<div class="table-responsive">          
										<table class="table">
											<thead>
												<tr>
													<th>Shops</th>
													<th>Description</th>
													<th>Info/ Delivery Time</th>
													<th>Price</th>
													<th>Total Price</th>
												</tr>
											</thead>
											<tbody>
												
												<tr>
													<td>
														<div class="sh_tab_compare_img sh_tab_compare_info">
															<b><?php echo $data['detail']['merchant1'];?></b>
														</div>
													</td>
													<td>
														<div class="sh_tab_compare_des">
															<p>-</p>
														</div>
													</td>
													<td>
														<div class="sh_tab_compare_info">
															<span>New</span>
														</div>
													</td>
													<td>
														<div class="sh_tab_compare_price">
															<h6>$ <?php echo $data['detail']['price1'];?></h6>
															<p>Price</p>
															<p>Free Delivery</p>
														</div>
													</td>
													<td>
														<div class="sh_tab_compare_total_price">
															<h4>$ <?php echo $data['detail']['price1'];?></h4>
															<a target="_blank" class="sh_shop_btn" href="<?php echo $data['detail']['link1'];?>">Shop Now <i class="icofont-rounded-right"></i></a>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<div class="sh_tab_compare_img sh_tab_compare_info">
															<b><?php echo $data['detail']['merchant2'];?></b>
														</div>
													</td>
													<td>
														<div class="sh_tab_compare_des">
															<p>-</p>
														</div>
													</td>
													<td>
														<div class="sh_tab_compare_info">
															<span>New</span>
														</div>
													</td>
													<td>
														<div class="sh_tab_compare_price">
															<h6>$ <?php echo $data['detail']['price2'];?></h6>
															<p>Price</p>
															<p>Free Delivery</p>
														</div>
													</td>
													<td>
														<div class="sh_tab_compare_total_price">
															<h4>$ <?php echo $data['detail']['price2'];?></h4>
															<a target="_blank" class="sh_shop_btn" href="<?php echo $data['detail']['link2'];?>">Shop Now <i class="icofont-rounded-right"></i></a>
														</div>
													</td>
												</tr>
												
												<tr>
													<td>
														<div class="sh_tab_compare_img sh_tab_compare_info">
															<b><?php echo $data['detail']['merchant3'];?></b>
														</div>
													</td>
													<td>
														<div class="sh_tab_compare_des">
															<p>-</p>
														</div>
													</td>
													<td>
														<div class="sh_tab_compare_info">
															<span>New</span>
														</div>
													</td>
													<td>
														<div class="sh_tab_compare_price">
															<h6>$ <?php echo $data['detail']['price3'];?></h6>
															<p>Price</p>
															<p>Free Delivery</p>
														</div>
													</td>
													<td>
														<div class="sh_tab_compare_total_price">
															<h4>$ <?php echo $data['detail']['price3'];?></h4>
															<a target="_blank" class="sh_shop_btn" href="<?php echo $data['detail']['link3'];?>">Shop Now <i class="icofont-rounded-right"></i></a>
														</div>
													</td>
												</tr>
												
											</tbody>
										</table>
									</div>

								</div>
							</div>
							<div role="tabpanel" class="tab-pane fade" id="sh_product_deatail">
								<div class="sh_product_description_wrap sh_float_width">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="sh_product_description_sec sh_float_width">
											<h4>Apple iPad Air 2 (Wi-Fi/16GB/4G)</h4>
											<p>Apple iPad Air 2 (Wi-Fi/16GB/4G) Specification and features are mentioned below. The specification are from the 7 seller(s) and other reliable sources Apple iPad Air 2 (Wi-Fi/16GB/4G) Specification and features are mentioned below.The specification are from the 7 seller(s) and other reliable sourcesApple iPad Air 2 (Wi-Fi/16GB/4G) Specification and features are mentioned below. The specification are from the 7 seller(s) and other reliable sources.</p>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="sh_product_description_sec sh_float_width">
											<h4>General Features</h4>
											<div class="table-responsive">          
												<table class="table">
													<tbody>
														<tr>
															<td><b>Sim Support:</b></td>
															<td>Single Sim, NaNo-SIM, GSM</td>
														</tr>
														<tr>
															<td><b>Voice Calling:</b></td>
															<td>X</td>
														</tr>
														<tr>
															<td><b>Tablet Dimensions:</b></td>
															<td>240 x 169.5 x 6.1 mm</td>
														</tr>
														<tr>
															<td><b>Tablet Weight:</b></td>
															<td>444 grams</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="sh_product_description_sec sh_float_width">
											<h4>Display</h4>
											<div class="table-responsive">          
												<table class="table">
													<tbody>
														<tr>
															<td><b>Screen Size:</b></td>
															<td>9.7 inches</td>
														</tr>
														<tr>
															<td><b>Screen Resolution:</b></td>
															<td>2048 x 1536 Pixels, 264 ppi</td>
														</tr>
														<tr>
															<td><b>Screen Type:</b></td>
															<td>Capacitive With Multitouch</td>
														</tr>
														<tr>
															<td><b>Screen Protection:</b></td>
															<td>Fingerprint-Resistant Oleophobic Coating, Fully Laminated, Antireflective Coating</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="sh_product_description_sec sh_float_width">
											<h4>Technical</h4>
											<div class="table-responsive">          
												<table class="table">
													<tbody>
														<tr>
															<td><b>Operating System:</b></td>
															<td>iOS 8</td>
														</tr>
														<tr>
															<td><b>Processor:</b></td>
															<td>1.5 GHz Dual Core + M8 motion coprocessor Processor</td>
														</tr>
														<tr>
															<td><b>Processor Chipset:</b></td>
															<td>Apple A8X</td>
														</tr>
														<tr>
															<td><b>RAM:</b></td>
															<td>2 GB</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="sh_product_description_sec sh_float_width">
											<h4>Memory</h4>
											<div class="table-responsive">          
												<table class="table">
													<tbody>
														<tr>
															<td><b>Phonebook Memory:</b></td>
															<td>Practically Unlimited Contacts</td>
														</tr>
														<tr>
															<td><b>Internal Memory:</b></td>
															<td>16 GB</td>
														</tr>
														<tr>
															<td><b>Expendable memory:</b></td>
															<td>X</td>
														</tr>
														<tr>
															<td><b>Tablet Weight:</b></td>
															<td>444 grams</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="sh_product_description_sec sh_float_width">
											<h4>Multimedia</h4>
											<div class="table-responsive">          
												<table class="table">
													<tbody>
														<tr>
															<td><b>E-mail:</b></td>
															<td>Push E-mail</td>
														</tr>
														<tr>
															<td><b>Music Player:</b></td>
															<td>Supports AAC, Protected AAC, HE-AAC, MP3, MP3 VBR, Audible, Apple Lossless, AIFF, WAV</td>
														</tr>
														<tr>
															<td><b>Video Player:</b></td>
															<td>Supports H.264, AAC-LC, M4V, MP4, MOV, MPEG-4, Motion JPEG, AVI</td>
														</tr>
														<tr>
															<td><b>PDF &amp; PDF reader:</b></td>
															<td>Available</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="sh_product_description_sec sh_float_width">
											<h4>Other Features</h4>
											<div class="table-responsive">          
												<table class="table">
													<tbody>
														<tr>
															<td><b>Sensors:</b></td>
															<td>Accelerometer, Barometer, Touch ID, Ambient Light Sensor</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>										
									</div>										
								</div>
							</div>
							<div role="tabpanel" class="tab-pane fade" id="sh_riview">
								<div class="sh_product_rate_wrap sh_float_width">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="sh_prod_old_rate sh_float_width">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<h4 class="sh_reviewd_pro">Apple iPad Air 2</h4>
												<h6>4 Reviews For this Product</h6>
												<div class="sh_pro_rating">
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
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
											<div class="sh_review_tab sh_float_width">
												<ul id="rating" class="nav nav-pills nav-justified" role="tablist" data-tabs="tabs">
													<li class="active"><a href="#5review" data-toggle="tab">
														5 Reviews <span>(487875)</span>
													</a></li>
													<li><a href="#4review" data-toggle="tab">4 Reviews <span>(487875)</span></a></li>
													<li><a href="#3review" data-toggle="tab">3 Reviews <span>(487875)</span></a></li>
													<li><a href="#2review" data-toggle="tab">2 Reviews <span>(487875)</span></a></li>
													<li><a href="#1review" data-toggle="tab">1 Reviews <span>(487875)</span></a></li>
												</ul>
											</div>
										</div>
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
											<div class="tab-content">
												<div role="tabpanel" class="tab-pane fade in active" id="5review">
													<div class="sh_prod_old_rat sh_float_width">
														<div class="sh_media_wrap sh_float_width">
															<div class="sh_reviewer_review sh_float_width">
																<h4>Jon Smith</h4>
																<h5>on jan 22, 2018</h5>
																<ul class="sh_review_color">
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star-half-o"></span></a></li>
																</ul>
																<p>You can enjoy a luxary vacation on this tight badget. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusab. I am too happy.</p>
															</div>
														</div>
													</div>
													<div class="sh_prod_old_rat sh_float_width">
														<div class="sh_media_wrap sh_float_width">
															<div class="sh_reviewer_review sh_float_width">
																<h4>Jon Smith</h4>
																<h5>on jan 22, 2018</h5>
																<ul class="sh_review_color">
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star-half-o"></span></a></li>
																</ul>
																<p>You can enjoy a luxary vacation on this tight badget. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusab. I am too happy.</p>
															</div>
														</div>
													</div>
													<div class="sh_prod_old_rat sh_float_width">
														<div class="sh_media_wrap sh_float_width">
															<div class="sh_reviewer_review sh_float_width">
																<h4>Jon Smith</h4>
																<h5>on jan 22, 2018</h5>
																<ul class="sh_review_color">
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star-half-o"></span></a></li>
																</ul>
																<p>You can enjoy a luxary vacation on this tight badget. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusab. I am too happy.</p>
															</div>
														</div>
													</div>
												</div>
												<div role="tabpanel" class="tab-pane fade" id="4review">
													<div class="sh_prod_old_rat sh_float_width">
														<div class="sh_media_wrap sh_float_width">
															<div class="sh_reviewer_review sh_float_width">
																<h4>Jon Smith</h4>
																<h5>on jan 22, 2018</h5>
																<ul class="sh_review_color">
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star-half-o"></span></a></li>
																</ul>
																<p>You can enjoy a luxary vacation on this tight badget. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusab. I am too happy.</p>
															</div>
														</div>
													</div>
													<div class="sh_prod_old_rat sh_float_width">
														<div class="sh_media_wrap sh_float_width">
															<div class="sh_reviewer_review sh_float_width">
																<h4>Jon Smith</h4>
																<h5>on jan 22, 2018</h5>
																<ul class="sh_review_color">
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star-half-o"></span></a></li>
																</ul>
																<p>You can enjoy a luxary vacation on this tight badget. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusab. I am too happy.</p>
															</div>
														</div>
													</div>
													<div class="sh_prod_old_rat sh_float_width">
														<div class="sh_media_wrap sh_float_width">
															<div class="sh_reviewer_review sh_float_width">
																<h4>Jon Smith</h4>
																<h5>on jan 22, 2018</h5>
																<ul class="sh_review_color">
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star-half-o"></span></a></li>
																</ul>
																<p>You can enjoy a luxary vacation on this tight badget. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusab. I am too happy.</p>
															</div>
														</div>
													</div>
												</div>
												<div role="tabpanel" class="tab-pane fade" id="3review">
													<div class="sh_prod_old_rat sh_float_width">
														<div class="sh_media_wrap sh_float_width">
															<div class="sh_reviewer_review sh_float_width">
																<h4>Jon Smith</h4>
																<h5>on jan 22, 2018</h5>
																<ul class="sh_review_color">
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star-half-o"></span></a></li>
																</ul>
																<p>You can enjoy a luxary vacation on this tight badget. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusab. I am too happy.</p>
															</div>
														</div>
													</div>
													<div class="sh_prod_old_rat sh_float_width">
														<div class="sh_media_wrap sh_float_width">
															<div class="sh_reviewer_review sh_float_width">
																<h4>Jon Smith</h4>
																<h5>on jan 22, 2018</h5>
																<ul class="sh_review_color">
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star-half-o"></span></a></li>
																</ul>
																<p>You can enjoy a luxary vacation on this tight badget. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusab. I am too happy.</p>
															</div>
														</div>
													</div>
													<div class="sh_prod_old_rat sh_float_width">
														<div class="sh_media_wrap sh_float_width">
															<div class="sh_reviewer_review sh_float_width">
																<h4>Jon Smith</h4>
																<h5>on jan 22, 2018</h5>
																<ul class="sh_review_color">
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star-half-o"></span></a></li>
																</ul>
																<p>You can enjoy a luxary vacation on this tight badget. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusab. I am too happy.</p>
															</div>
														</div>
													</div>
												</div>
												<div role="tabpanel" class="tab-pane fade" id="2review">
													<div class="sh_prod_old_rat sh_float_width">
														<div class="sh_media_wrap sh_float_width">
															<div class="sh_reviewer_review sh_float_width">
																<h4>Jon Smith</h4>
																<h5>on jan 22, 2018</h5>
																<ul class="sh_review_color">
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star-half-o"></span></a></li>
																</ul>
																<p>You can enjoy a luxary vacation on this tight badget. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusab. I am too happy.</p>
															</div>
														</div>
													</div>
													<div class="sh_prod_old_rat sh_float_width">
														<div class="sh_media_wrap sh_float_width">
															<div class="sh_reviewer_review sh_float_width">
																<h4>Jon Smith</h4>
																<h5>on jan 22, 2018</h5>
																<ul class="sh_review_color">
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star-half-o"></span></a></li>
																</ul>
																<p>You can enjoy a luxary vacation on this tight badget. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusab. I am too happy.</p>
															</div>
														</div>
													</div>
													<div class="sh_prod_old_rat sh_float_width">
														<div class="sh_media_wrap sh_float_width">
															<div class="sh_reviewer_review sh_float_width">
																<h4>Jon Smith</h4>
																<h5>on jan 22, 2018</h5>
																<ul class="sh_review_color">
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star-half-o"></span></a></li>
																</ul>
																<p>You can enjoy a luxary vacation on this tight badget. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusab. I am too happy.</p>
															</div>
														</div>
													</div>
												</div>
												<div role="tabpanel" class="tab-pane fade" id="1review">
													<div class="sh_prod_old_rat sh_float_width">
														<div class="sh_media_wrap sh_float_width">
															<div class="sh_reviewer_review sh_float_width">
																<h4>Jon Smith</h4>
																<h5>on jan 22, 2018</h5>
																<ul class="sh_review_color">
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star-half-o"></span></a></li>
																</ul>
																<p>You can enjoy a luxary vacation on this tight badget. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusab. I am too happy.</p>
															</div>
														</div>
													</div>
													<div class="sh_prod_old_rat sh_float_width">
														<div class="sh_media_wrap sh_float_width">
															<div class="sh_reviewer_review sh_float_width">
																<h4>Jon Smith</h4>
																<h5>on jan 22, 2018</h5>
																<ul class="sh_review_color">
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star-half-o"></span></a></li>
																</ul>
																<p>You can enjoy a luxary vacation on this tight badget. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusab. I am too happy.</p>
															</div>
														</div>
													</div>
													<div class="sh_prod_old_rat sh_float_width">
														<div class="sh_media_wrap sh_float_width">
															<div class="sh_reviewer_review sh_float_width">
																<h4>Jon Smith</h4>
																<h5>on jan 22, 2018</h5>
																<ul class="sh_review_color">
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star"></span></a></li>
																	<li><a href="javacript:void(0)"><span class="fa fa-star-half-o"></span></a></li>
																</ul>
																<p>You can enjoy a luxary vacation on this tight badget. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusab. I am too happy.</p>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<form class="sh_review_from">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<label>Rating</label>
												<div class="rating">
													<i class="fa fa-star-o"></i>
													<i class="fa fa-star-o"></i>
													<i class="fa fa-star-o"></i>
													<i class="fa fa-star-o"></i>
													<i class="fa fa-star-o"></i>
												</div>
											</div>
											<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
												<label for="name">Name</label>
												<input type="text" class="form-control" placeholder="Your name" required="">
											</div>
											<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
												<label for="email">Email</label>
												<input type="text" class="form-control" placeholder="Email" required="">
											</div>
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<label for="review">Review Title</label>
												<textarea class="form-control" placeholder="Wrire Your Review Here"></textarea>
												<a href="javacript:void(0)" class="sh_btn">Submit Your Review</a>
											</div>
										</form>
									</div>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane fade" id="sh_faq">
								<div class="sh_product_ques_ans_wrap sh_float_width">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="sh_qa_heading sh_float_width">
											<h4>Question And Answer</h4>
											<form>
												<input type="text" placeholder="Ask or search Question">
												<button>Search</button>
											</form>
										</div>
										<div class="sh_qa_wrapper sh_float_width">
											<div class="sh_voted_qa_icon">
												<span class="icofont-dotted-up"></span>
												<p>15</p>
											</div>
											<div class="sh_voted_qa">
												<h5 class="sh_question">Does it have a portrait mode?</h5>
												<h6 class="sh_persion_name">persion1</h6>
												<p class="sh_answer">It doesn't have a portrait mode in the rear camera but it comes with front camera portrait mode.</p>
												<h6 class="sh_persion_name">persion2</h6>
												<div class="sh_user_qa sh_float_width">
													<ul>
														<li><i class="icofont-pen-alt-1"></i><a href="javacript:void(0)">Write Answer</a></li>
														<li><i class="icofont-hand-up"></i><a href="javacript:void(0)">Request Answer</a></li>
													</ul>
												</div>
											</div>
										</div>
										<div class="sh_qa_wrapper sh_float_width">
											<div class="sh_voted_qa_icon">
												<span class="icofont-dotted-up"></span>
												<p>18</p>
											</div>
											<div class="sh_voted_qa">
												<h5 class="sh_question">Does it have a portrait mode?</h5>
												<h6 class="sh_persion_name">persion1</h6>
												<p class="sh_answer">It doesn't have a portrait mode in the rear camera but it comes with front camera portrait mode.</p>
												<h6 class="sh_persion_name">persion2</h6>
												<div class="sh_user_qa sh_float_width">
													<ul>
														<li><i class="icofont-pen-alt-1"></i><a href="javacript:void(0)">Write Answer</a></li>
														<li><i class="icofont-hand-up"></i><a href="javacript:void(0)">Request Answer</a></li>
													</ul>
												</div>
											</div>
										</div>
										<div class="sh_qa_wrapper sh_float_width">
											<div class="sh_voted_qa_icon">
												<span class="icofont-dotted-up"></span>
												<p>20</p>
											</div>
											<div class="sh_voted_qa">
												<h5 class="sh_question">Does it have a portrait mode?</h5>
												<h6 class="sh_persion_name">persion1</h6>
												<p class="sh_answer">It doesn't have a portrait mode in the rear camera but it comes with front camera portrait mode.</p>
												<h6 class="sh_persion_name">persion2</h6>
												<div class="sh_user_qa sh_float_width">
													<ul>
														<li><i class="icofont-pen-alt-1"></i><a href="javacript:void(0)">Write Answer</a></li>
														<li><i class="icofont-hand-up"></i><a href="javacript:void(0)">Request Answer</a></li>
													</ul>
												</div>
											</div>
										</div>
										<div class="sh_qa_wrapper sh_float_width">
											<div class="sh_voted_qa_icon">
												<span class="icofont-dotted-up"></span>
												<p>28</p>
											</div>
											<div class="sh_voted_qa">
												<h5 class="sh_question">Does it have a portrait mode?</h5>
												<h6 class="sh_persion_name">persion1</h6>
												<p class="sh_answer">It doesn't have a portrait mode in the rear camera but it comes with front camera portrait mode.</p>
												<h6 class="sh_persion_name">persion2</h6>
												<div class="sh_user_qa sh_float_width">
													<ul>
														<li><i class="icofont-pen-alt-1"></i><a href="javacript:void(0)">Write Answer</a></li>
														<li><i class="icofont-hand-up"></i><a href="javacript:void(0)">Request Answer</a></li>
													</ul>
												</div>
											</div>
										</div>
										<div class="sh_qa_wrapper sh_float_width">
											<div class="sh_voted_qa_icon">
												<span class="icofont-dotted-up"></span>
												<p>24</p>
											</div>
											<div class="sh_voted_qa">
												<h5 class="sh_question">Does it have a portrait mode?</h5>
												<h6 class="sh_persion_name">persion1</h6>
												<p class="sh_answer">It doesn't have a portrait mode in the rear camera but it comes with front camera portrait mode.</p>
												<h6 class="sh_persion_name">persion2</h6>
												<div class="sh_user_qa sh_float_width">
													<ul>
														<li><i class="icofont-pen-alt-1"></i><a href="javacript:void(0)">Write Answer</a></li>
														<li><i class="icofont-hand-up"></i><a href="javacript:void(0)">Request Answer</a></li>
													</ul>
												</div>
											</div>
										</div>
										<div class="sh_qa_wrapper sh_float_width">
											<div class="sh_voted_qa_icon">
												<span class="icofont-dotted-up"></span>
												<p>22</p>
											</div>
											<div class="sh_voted_qa">
												<h5 class="sh_question">Does it have a portrait mode?</h5>
												<h6 class="sh_persion_name">persion1</h6>
												<p class="sh_answer">It doesn't have a portrait mode in the rear camera but it comes with front camera portrait mode.</p>
												<h6 class="sh_persion_name">persion2</h6>
												<div class="sh_user_qa sh_float_width">
													<ul>
														<li><i class="icofont-pen-alt-1"></i><a href="javacript:void(0)">Write Answer</a></li>
														<li><i class="icofont-hand-up"></i><a href="javacript:void(0)">Request Answer</a></li>
													</ul>
												</div>
											</div>
										</div>
										<div class="text-center">
											<a class="sh_btn" href="javacript:void(0)">View All Question</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
					
				</div>	
			</div>	
		</div>	
	</div>	
	<!------Best Rated Product -------->
	<!------Related Product -------->
	
	
	
	
</div>	
@endsection
