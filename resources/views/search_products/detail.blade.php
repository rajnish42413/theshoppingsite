<?php 
use \App\Http\Controllers\DetailController;
$settings = DetailController::get_settings();
?>
@extends('layouts.app')

@section('content')
<?php  
$pic_array  = array();
$single_pic = env('APP_URL')."assets/images/no_image.png";
$PictureDetails = $product->PictureDetails; 
if($PictureDetails != ''){
	$pic_det = json_decode($PictureDetails);
	//echo '<pre>';print_r($pic_det);die;
	if($pic_det && $pic_det->PhotoDisplay == 'PicturePack'){
		$pic_detail = $pic_det->PictureURL;
		if(is_array($pic_detail)){
			$pic_array = $pic_detail;
		}else{
			$single_pic = $pic_detail;
		}
		
	}
}


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
							<li><a href="javacript:void(0)"><?php echo $data['parent_category'];?></a></li>
							<li><a href="javacript:void(0)"><?php echo $data['category'];?></a></li>
						</ul>
					</div>
				</div>
			</div>	
		</div>	
	</div>	
	<!--Product View Start-->
	<div class="sh_product_view_wrap sh_float_width">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
					<div class="sh_product_view_name sh_float_width">
						<h3><?php echo $product->title;?></h3>
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
				<div class="col-lg-4 col-md-4 col-sm-5 col-xs-12 text-right">
					<div class="sh_product_view_name sh_float_width">
						<h6>Updated On: <?php echo date('j F Y',strtotime($product->updated_at));?></h6>
					</div>
				</div>
			</div>	
		</div>	
	</div>
	
	
	<div class="sh_product_view_img_wrap sh_float_width">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="sh_product_view_img sh_float_width">
						<div class="slider-wrapper">
							<div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
							
								<div class="slider-nav">
								<?php 
								if($pic_array){
								foreach($pic_array as $pic){?>
									<div class="slider-nav__item">
										<img src="<?php echo $pic; ?>" alt="" />
									</div>
									
								<?php } }else{?>
									<div class="slider-nav__item">
										<img src="<?php echo $single_pic;?>" alt="" />
									</div>								
								<?php }?>
								
								</div>
							</div>
							
							<div class="col-lg-9 col-md-9 col-sm-8 col-xs-8">
								<div class="slider-for">
								<?php 
								if($pic_array){
								foreach($pic_array as $pic){?>
									<div class="slider-for__item ex1" data-src="<?php echo $pic; ?>">
										<img class="sh_view_img" src="<?php echo $pic; ?>" alt="" />
									</div>
								<?php } }else{?>
									<div class="slider-for__item ex1" data-src="<?php echo $single_pic;?>">
										<img src="<?php echo $single_pic;?>" alt="" />
									</div>							
								<?php }?>							


								</div>
							</div>
							
							
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="sh_product_view_store sh_float_width">
						<h3 class="sh_best_price">Best Price: $<?php echo $product->current_price;?></h3>
						<div class="sh_compare_price sh_float_width">          
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<img src="{{env('APP_URL')}}assets/images/store_ebay.png" alt="ebay">
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<h4 class="sh_store_price">$<?php echo $product->current_price;?></h4>
								<a class="sh_shop_btn" href="<?php echo $product->viewItemURL;?>" target="_blank">Shop Now <i class="icofont-rounded-right"></i></a>
							</div>
						</div>
						<div class="sh_compare_price sh_float_width hide">          
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<img src="{{env('APP_URL')}}assets/images/store_amazon.png" alt="ebay">
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<h4 class="sh_store_price">$1009,99</h4>
								<a class="sh_shop_btn" href="javacript:void(0)">Shop Now <i class="icofont-rounded-right"></i></a>
							</div>
						</div>
						<div class="sh_compare_price sh_float_width hide">          
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<img src="{{env('APP_URL')}}assets/images/store_etsy.png" alt="ebay">
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<h4 class="sh_store_price">$1119,99</h4>
								<a class="sh_shop_btn" href="javacript:void(0)">Shop Now <i class="icofont-rounded-right"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>	
		</div>	
	</div>	
	<!--- Product Sescribtion---->
	<div class="sh_product_describtion_wrap sh_float_width">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
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
														<div class="sh_tab_compare_img">
															<img src="{{env('APP_URL')}}assets/images/comapre_store/ebay.png">
															<p class="hide">1212454 Reviews</p>
														</div>
													</td>
													<td>
														<div class="sh_tab_compare_des">
															<p><?php echo $product->title;?></p>
														</div>
													</td>
													<td>
														<div class="sh_tab_compare_info">
															<p>1-2 Work-day</p>
															<span>New</span>
														</div>
													</td>
													<td>
														<div class="sh_tab_compare_price">
															<h6>$<?php echo $product->current_price;?></h6>
															<p>Price</p>
															<p>Free Delivery</p>
														</div>
													</td>
													<td>
														<div class="sh_tab_compare_total_price">
															<h4>$<?php echo $product->current_price;?></h4>
															<a class="sh_shop_btn" href="<?php echo $product->viewItemURL;?>" target="_blank">Shop Now <i class="icofont-rounded-right"></i></a>
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
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hide">
										<div class="sh_product_description_sec sh_float_width">
											<h4>Apple iPad Air 2 (Wi-Fi/16GB/4G)</h4>
											<p>Apple iPad Air 2 (Wi-Fi/16GB/4G) Specification and features are mentioned below. The specification are from the 7 seller(s) and other reliable sources Apple iPad Air 2 (Wi-Fi/16GB/4G) Specification and features are mentioned below.The specification are from the 7 seller(s) and other reliable sourcesApple iPad Air 2 (Wi-Fi/16GB/4G) Specification and features are mentioned below. The specification are from the 7 seller(s) and other reliable sources.</p>
										</div>
									</div>
									
<?php 

if($product->ItemSpecifics!=''){
	$item_specifics = array();
	$item_specifics = json_decode($product->ItemSpecifics);
	if($item_specifics){
?>									
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="sh_product_description_sec sh_float_width">
											<h4>Item Specifications</h4>
											<div class="table-responsive">          
												<table class="table">
													<tbody>
													<?php 
													$item_sp_list = $item_specifics->NameValueList;
													//echo '<pre>'; print_R($item_sp_list);die;
													if(is_array($item_sp_list)){
														foreach($item_sp_list as $isl){
													?>
														<tr>
															<td><b><?php echo $isl->Name;?>:</b></td>
															<td>
														<?php 
												 		if(is_array($isl->Value)){
															$value = implode(', ',$isl->Value);
															echo $value;
														}else{
															echo $isl->Value;
														} 															
														?>
															</td>
														</tr>
														<?php } } else{?>
														<tr>
															<td><b><?php echo $item_sp_list->Name;?>:</b></td>
															<td>
														<?php 
												 		if(is_array($item_sp_list->Value)){
															$ivalue = implode(', ',$item_sp_list->Value);
															echo $ivalue;
														}else{
															echo $item_sp_list->Value;
														} 															
														?>
															</td>
														</tr>													
													<?php }?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
<?php } }?>	

<?php 
if($product->Variations != ''){
	$p_variations = json_decode($product->Variations);
	$variations = $p_variations->Variation;
	if($variations){
		//echo '<pre>'; print_R($variations); '</pre>';
?>								
									
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="sh_product_description_sec sh_float_width">
											<h4>Variations</h4>
											     

											<?php foreach($variations as $vc){?>
											<div class="table-responsive">     
												<table class="table">
													<tbody>	
														<?php if(isset($vc->SKU)){?>
														<tr>
															<td><b>SKU:</b></td>
															<td><?php echo $vc->SKU;?></td>
														</tr>
														<?php } ?>
														<?php if(isset($vc->StartPrice)){?>
														<tr>
															<td><b>Start Price:</b></td>
															<td><?php echo $vc->StartPrice;?></td>
														</tr>	
														<?php }?>
														<?php if(isset($vc->Quantity)){?>
														<tr>
															<td><b>Quantity:</b></td>
															<td><?php echo $vc->Quantity;?></td>
														</tr>										<?php } ?>				
													</tbody>
												</table>
											</div>												
										
										<?php 
										
										if(isset($vc->VariationSpecifics)){
											//echo '<pre>'; print_r($vc->VariationSpecifics);echo '</pre>';
										$vspecs = $vc->VariationSpecifics->NameValueList;
										//echo '<pre>'; var_dump($vspecs); echo '</pre>';
										//echo $vspecs->Name;
										?>
											<h5><b>Variation Specifications</b></h5>
											<div class="table-responsive">     
												<table class="table">
													<tbody>	
													<?php
													if(is_array($vspecs)){
													foreach($vspecs as $vs){?>
														<tr>
															<td><?php echo $vs->Name;?>:</td>
															<td><?php echo $vs->Value;?></td>
														</tr>
													<?php } }else{?>
														<tr>
															<td><?php echo $vspecs->Name;?>:</td>
															<td><?php echo $vspecs->Value;?></td>
														</tr>													
													<?php } ?>
													</tbody>
												</table>
											</div>												
										<?php } ?>
											
											
											<hr>
									<?php } ?>
										</div>
									</div>
<?php } } ?>									
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hide">
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
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hide">
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
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hide">
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
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hide">
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
	<div class="sh_rated_product sh_float_width">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="sh_rated_product_sec sh_float_width">
						<img src="{{env('APP_URL')}}assets/images/product_view/shopergy.png">
						<div class="sh_rated_product_text sh_float_width">
							<h4><?php if($settings){ echo $settings->title;} ?></h4>
							<ul>
								<li><span class="fa fa-star"></span></li>
								<li><span class="fa fa-star"></span></li>
								<li><span class="fa fa-star"></span></li>
								<li><span class="fa fa-star"></span></li>
								<li><span class="fa fa-star-o"></span></li>
							</ul>
							<a href="javacript:void(0)">Reviews <span class="icofont-bubble-right"></span></a>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="sh_rated_product_sec sh_float_width">
						<img src="{{env('APP_URL')}}assets/images/product_view/ebay.png">
						<div class="sh_rated_product_text sh_float_width">
							<h4>ebay</h4>
							<ul>
								<li><span class="fa fa-star"></span></li>
								<li><span class="fa fa-star"></span></li>
								<li><span class="fa fa-star"></span></li>
								<li><span class="fa fa-star"></span></li>
								<li><span class="fa fa-star-o"></span></li>
							</ul>
							<a href="javacript:void(0)">Reviews <span class="icofont-bubble-right"></span></a>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="sh_rated_product_sec sh_float_width">
						<img src="{{env('APP_URL')}}assets/images/product_view/amazon.png">
						<div class="sh_rated_product_text sh_float_width">
							<h4>amazon</h4>
							<ul>
								<li><span class="fa fa-star"></span></li>
								<li><span class="fa fa-star"></span></li>
								<li><span class="fa fa-star"></span></li>
								<li><span class="fa fa-star"></span></li>
								<li><span class="fa fa-star-o"></span></li>
							</ul>
							<a href="javacript:void(0)">Reviews <span class="icofont-bubble-right"></span></a>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="sh_rated_product_sec sh_float_width">
						<img src="{{env('APP_URL')}}assets/images/product_view/etsy.png">
						<div class="sh_rated_product_text sh_float_width">
							<h4>Esty</h4>
							<ul>
								<li><span class="fa fa-star"></span></li>
								<li><span class="fa fa-star"></span></li>
								<li><span class="fa fa-star"></span></li>
								<li><span class="fa fa-star"></span></li>
								<li><span class="fa fa-star-o"></span></li>
							</ul>
							<a href="javacript:void(0)">Reviews <span class="icofont-bubble-right"></span></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!------Related Product -------->
	<div class="sh_related_product sh_category_wrapper sh_float_width">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-8 col-sm-12 col-xs-12 col-lg-offset-3 col-md-offset-2">
					<div class="sh_heading">
						<h2>You May Also Love</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="sh_top_category_section sh_float_width">
						<img src="{{env('APP_URL')}}assets/images/grid/product2.jpg">
						<div class="sh_cat_name">
							<h4>Mackbook 9.2</h4>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="sh_top_category_section sh_float_width">
						<img src="{{env('APP_URL')}}assets/images/grid/product6.jpg">
						<div class="sh_cat_name">
							<h4>Samsung galaxy</h4>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="sh_top_category_section sh_float_width">
						<img src="{{env('APP_URL')}}assets/images/grid/product5.jpg">
						<div class="sh_cat_name">
							<h4>Mackbook Note</h4>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="sh_top_category_section sh_float_width">
						<img src="{{env('APP_URL')}}assets/images/grid/product1.jpg">
						<div class="sh_cat_name">
							<h4>IPAD</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	
	
	
	
</div>	

@endsection
