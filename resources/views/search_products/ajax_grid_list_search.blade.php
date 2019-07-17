					<?php if($products){
						
						foreach($products as $key){
							$product = $key['_source'];
							?>
							
							<?php  
							$galleryURL = env('APP_URL')."assets/images/no_image.png"; 
							if($product['product_image'] != ''){
									$galleryURL = $product['product_image'];
							}

							$title = $product['title'];
							
							if(isset($product['merchant_id']) && $product['merchant_id']!=''){
								$merchant_image = $merchantData[$product['merchant_id']];
							}else{
								$merchant_image = 'default.png';
							}

							if($data['Lp'] == '1'){
								$product_url = $product['viewitemurl'];;
							}else{
								$product_url = env('APP_URL')."/product/".$product['slug'];
							}
							
							?>
						
							<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sh_custom_width">
								<a href="<?php echo $product_url;?>" target="_blank">
									<div class="sh_grid_product_section sh_float_width">
								<?php if($product['quantity']== 0){?>
										<div class="out_of_stock">
											<span>Out of Stock</span>
										</div>
									<?php } ?>
										<img class="grid_prd" src="<?php echo $galleryURL;?>">
										<h4 class="sh_prod_name"><?php echo $title;?></h4>
										<div class="sh_about_prod">
											<div class="sh_product_price">$<?php echo $product['current_price'];?></div>
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
												<a href="<?php echo $product['viewitemurl'];?>" target="_blank"><img src="{{env('APP_URL')}}merchant_files/<?php echo $merchant_image;?>"></a>
											</div>
									
										</div>
									</div>
								</a>
							</div>
					<?php } }else{ ?>
							<h3 class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> No Items Found For This Criteria.</h3>					
					<?php } ?>