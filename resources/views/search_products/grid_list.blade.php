@extends('layouts.app')

@section('content')
<!--Main Wrapper Start-->
<div class="sh_main_wrap sh_float_width">
	<!--Breadcurm Start-->
	<div class="sh_breadcurm_wrap sh_float_width">
		<div class="container">
		<?php if($data['cat_breadcrumb'] != ''){?>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="sh_breadcurm sh_float_width">
						<ul>
							<?php echo $data['cat_breadcrumb']; ?>
						</ul>
					</div>
				</div>
			</div>
		<?php } ?>
		</div>	
	</div>	
	<!-- Search Grid Start-->
	<div class="sh_search_grid_wrap sh_float_width">
		<div class="container">
			<div class="row productListing">
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
					<div class="sh_float_width">
						<a href="javascript:void(0)" id="sh_filter_menu">Filter</a>
					</div>
					<div id="sh_filter_menu_wrapper" class="sh_float_width">
						<?php if($products && $products->count() > 0){?>
							<div class="sh_side_bar sh_float_width">
								<div class="sh_side_bar_section sh_float_width">
								<form id="filter_form" action="" method="post">
								{{ csrf_field() }}
									<input type="hidden" id="sorting_type" value="1" name="sorting_type" />
									<input type="hidden" id="showing_result" value="10" name="showing_result" />
									<input type="hidden" id="offset_val" value="" name="offset_val" />
									<input type="hidden" id="parent_cat_id" value="<?php echo $data['parent_cat_id'];?>" name="parent_cat_id" />
									<input type="hidden" id="cat_id" value="<?php echo $data['cat_id'];?>" name="cat_id" />
									<div class="sh_side_widget sh_cat_search_form sh_float_width">
									<h4 class="sh_sidecat_heading">Filter By Name</h4>
											<input type="text" class="form-control" id="pro_name" name="pro_name" placeholder="Search" value="" oninput="get_product_name(this)">
									</div>							

									<div class="sh_side_widget sh_sidear_cat_price_filter sh_float_width">
										<h4 class="sh_sidecat_heading">Filter By Price</h4>
										<div class="wrapper">
											<div class="range-slider">
												
												<input class="form-control" type="hidden" value="<?php echo $data['min_price'];?>" name="dpriceMin" id="dpriceMinVal" placeholder="Min" min="0">
												<input class="form-control" type="hidden" value="<?php echo $data['max_price'];?>" name="dpriceMax" id="dpriceMaxVal" placeholder="Max" min="1">
												<input type="text" class="price-slider" title="price" placeholder="" name="price_range" id="price_range" data-min="0"/>										
											</div>

										</div>
									</div>
									<?php if($brands){?>
									<div class="sh_side_widget sh_sidear_cat_brands sh_float_width">
										<h4 class="sh_sidecat_heading">Filter By Brand</h4>
										<ul class="my-brands">
									<?php foreach($brands as $brand){?>
											<li><input type="checkbox" name="brands[]" class="pro_brands checkmark" value="<?php echo $brand->brand_id;?>" onchange="get_search_data(0)" <?php if($data['brand_id']!= '' && $data['brand_id'] == $brand->brand_id){ echo 'checked'; }?>><?php echo $brand->brand_id;?></li>	
									<?php } ?>
										</ul>
									</div>
									<?php } ?>
									</form>							
								</div>
							</div>
						<?php } ?>
						<?php if($categories){?>
						<div class="sh_side_bar sh_float_width">
							<div class="sh_side_bar_section sh_float_width">
											
								<div class="sh_side_widget sh_sidear_cat_menu sh_float_width">
									<h4 class="sh_sidecat_heading">Categories</h4>
									<ul class="cat-list">								
									<?php foreach($categories as $cat){?>
										<li><a href="<?php echo env('APP_URL')."category/".$cat->slug;?>"><?php echo $cat->categoryName;?></a></li>
									<?php } ?>
									</ul>
								</div>						
							</div>					
						</div>
						<?php } ?>				
					</div>			
				</div>			
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
					<div class="sh_product_grid sh_float_width">
					<?php if($products && $products->count() > 0){?>
						<div class="sh_product_grid_top sh_float_width">
							<div class="col-lg-6 col-md-5 col-sm-4 col-xs-5">
								<div class="sh_search_filter sh_float_width">
									<ul>
										<li>Show Result:</li>
										<li>
											<select id="showing_result_data" onchange="showing_result(this);">
												<option value="10" selected>1 to 10</option>
												<option value="20">1 to 20</option>
												<option value="30">1 to 30</option>
												<option value="40">1 to 40</option>
											</select>
										</li>
									</ul>
								</div>
							</div>
							
							<div class="col-lg-6 col-md-4 col-sm-4 col-xs-7 text-right">
								<div class="sh_search_filter sh_float_width">
									<ul>
										<li>Sort by:</li>
										<li>
											<select id="product_sorting" onchange="product_sorting(this);">
												<option value="1">Price: Low to High</option>
												<option value="2">Price: High to Low</option>
												<option value="3">New</option>
											</select>
										</li>
									</ul>
								</div>
							</div>
						</div>
					<?php } ?>	
							<img id="listLoading" src="<?php echo env('APP_URL')?>assets/images/loading.gif" style="display: table;margin: auto;">
						
						<div id="products-view" class="sh_product_grid_product sh_float_width" style="display:none;">
					<?php if($products && $products->count() > 0){
						
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
									<?php if($product->Quantity == 0){?>
										<div class="out_of_stock">
											<span>Out of Stock</span>
										</div>
									<?php }//elseif($product->Quantity <= 10){?>
										<!--<div class="less_stock">
											<span>Only <?php //echo $product->Quantity;?> Left</span>
										</div>	--->								
									<?php //}?>
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
					<?php } }else{ ?>
							<h3 class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> No Items Found For This Criteria.</h3>					
					<?php } ?>
						
						</div>
						
					<?php if($products && $products->count() >= 10){?>
						<div class="load_more sh_float_width" style="display:none;">
							<div class="col-lg-12 text-center"><button onclick="load_more(this)" class="sh_btn btn btn-block" type="button">Load More <i class="fa fa-spin fa-spinner hide"></i></button></div>
						</div>
					<?php } ?>
					</div>
				</div>
				
			</div>	
		</div>	
	</div>	
	
</div>	
<script src="{{env('APP_URL')}}assets/js/rang_slider/rang.js"  charset="UTF-8"></script>
<script>

$(window).on('load', function(){
     $('#listLoading').hide();
     $('#products-view').show();
     $('.load_more').show();
});

function product_sorting(e){
	var x = e.value;
	$("#filter_form #sorting_type").val(x);
	$("#filter_form #offset_val").val('');
	get_search_data(0);
}

function showing_result(e){
	var y = e.value;
	$("#filter_form #showing_result").val(y);
	$("#filter_form #offset_val").val('');
	get_search_data(0);
}

function get_search_data(x){
	$('#listLoading').show();
	 $('#products-view').hide();
	$.ajax({
			type: "POST",	 			
			url: '<?php echo env('APP_URL') ?>get-products-ajax',
			data:$( "#filter_form" ).serialize(),	
			success: function(res)
			{ 
				$('.load_more').show();
				$('#listLoading').hide();
				$('.load_more i').addClass('hide');
				if(res != '0'){
					if(x ==0){
						$('#products-view').html(res);
					}else{
						$('#products-view').append(res);
					}
					
				}else{
					$('.load_more').hide();
					$('#products-view').html('<h3 class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> No Items Found For This Criteria.</h3>');
				}
				$('#products-view').show();					
			}
		});	
}

 if ($('.price-slider').length) {
            priceSlider();
        }
    // Price Silder //
    function priceSlider() {
        $(".price-slider").ionRangeSlider({
            min:0,
            from: <?php if($data['min_price'] != ''){echo $data['min_price'];}else{ echo '0';}?>,
            max: <?php if($data['max_price'] != ''){echo $data['max_price'];} else{ echo '10000';}?>,
            to: <?php if($data['max_price'] != ''){echo $data['max_price'];} else{ echo '10000';}?>,
            type: 'double',
            prefix: '$',
			grid: true,
			onFinish: function (data) {
				var priceMin = data.from;
				var priceMax = data.to;
				$("#dpriceMinVal").val(priceMin);
				$("#dpriceMaxVal").val(priceMax);		
				setTimeout(function(){ $("#filter_form #offset_val").val(''); get_search_data(0); }, 500);
			},
        });
    }
	 

function get_product_name(e){
	setTimeout(function(){ $("#filter_form #offset_val").val(''); get_search_data(0); }, 500);
}

function load_more(e){
	$('.load_more i').removeClass('hide');
	
	if($("#filter_form #offset_val").val() == ''){
		var y = 0;
	}else{
		var y = parseInt($("#filter_form #offset_val").val());
	}	
	
	var z = parseInt($("#filter_form #showing_result").val());
	y = z + y;	
	$("#filter_form #offset_val").val(y);
	setTimeout(function(){ get_search_data(1); }, 500);
}
	
</script>	
@endsection
