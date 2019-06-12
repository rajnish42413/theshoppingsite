					<?php if($products){
						//echo '<pre>';print_r($products); die;
						foreach($products as $product){?>
					
							<?php  
							$galleryURL = env('APP_URL')."assets/images/no_image.png"; 
							if($product->product_image != ''){
									$galleryURL = $product->product_image;
							}
							if($product->merchant_image!=''){
								$merchant_image = $product->merchant_image;
							}else{
								$merchant_image = 'default.png';
							}							
							?>
						
							<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sh_custom_width">
								<a href="{{ env('APP_URL')}}product/<?php echo $product->slug;?>">
									<div class="sh_grid_product_section sh_float_width">
										<span class="hide sh_new_prod">New</span>
										<img class="grid_prd" src="<?php echo $galleryURL;?>">
										<h4 class="sh_prod_name"><?php echo $product->title;?></h4>
										<div class="sh_about_prod">
											<div class="sh_product_price">$<?php echo $product->current_price;?></div>
											<div class="sh_product_review">
												<ul>
													<li><span class="fa fa-star"></span></li>
													<li><span class="fa fa-star"></span></li>
													<li><span class="fa fa-star"></span></li>
													<li><span class="fa fa-star"></span></li>
													<li><span class="fa fa-star-o"></span></li>
												</ul>
											</div>
											<div class="sh_less_price_store sh_float_width text-left">
												<a href="<?php echo $product->viewItemURL;?>" target="_blank"><img src="{{env('APP_URL')}}merchant_files/<?php echo $merchant_image;?>"></a>
											</div>
									
										</div>
									</div>
								</a>
							</div>
					<?php } } ?>