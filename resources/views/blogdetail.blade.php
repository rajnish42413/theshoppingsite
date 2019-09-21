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
							<?php echo $data['cat_breadcrumb']; ?>
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
								<div class="slider-for__item ex1" data-src="<?php echo env("APP_URL").'/trending_products_files/'.$data['detail']['image'];?>">
									<img src="<?php echo env("APP_URL").'/trending_products_files/'.$data['detail']['image'];?>" alt="" />
								</div>

							</div>
							
						</div>
					</div>
					<div class="sh_product_describtion_wrap sh_float_width">
		<div class="">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="sh_product_tab_view sh_float_width">
						
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane fade in active" id="sh_comapre_price">
								<div class="sh_tab_compare_wrap">
									<div class="table-responsive">          
										<table class="table">
											<thead>
												<tr>
													<th>Shops</th>
													<th >Price</th>
													<th >&nbsp;</th>
												</tr>
											</thead>
											<tbody>
												<?php if($data['detail']['merchant1'] !=''){ ?>
												<tr>
													<td>
														<div class="sh_tab_compare_img sh_tab_compare_info">
															<b><?php echo $data['detail']['merchant1'];?></b>
														</div>
													</td>
													<td><h4>$<?php echo $data['detail']['price1'];?></h4></td>
													
													<td class="text-right">
														<div class="sh_tab_compare_total_price">
															
															<a target="_blank" class="sh_shop_btn" href="<?php echo $data['detail']['link1'];?>">Shop Now <i class="icofont-rounded-right"></i></a>
														</div>
													</td>
												</tr>
												<?php } ?>
												<?php if($data['detail']['merchant2'] !=''){ ?>
												<tr>
													<td >
														<div class="sh_tab_compare_img sh_tab_compare_info">
															<b><?php echo $data['detail']['merchant2'];?></b>
														</div>
													</td>
													<td><h4>$<?php echo $data['detail']['price2'];?></h4></td>
													<td class="text-right">
														<div class="sh_tab_compare_total_price">
															
															<a target="_blank" class="sh_shop_btn" href="<?php echo $data['detail']['link2'];?>">Shop Now <i class="icofont-rounded-right"></i></a>
														</div>
													</td>
												</tr>
												<?php } ?>
												<?php if($data['detail']['merchant3'] !=''){ ?>
												<tr>
													<td>
														<div class="sh_tab_compare_img sh_tab_compare_info">
															<b><?php echo $data['detail']['merchant3'];?></b>
														</div>
													</td>
													<td><h4>$<?php echo $data['detail']['price3'];?></h4></td>
													<td class="text-right">
														<div class="sh_tab_compare_total_price">
															
															<a target="_blank" class="sh_shop_btn" href="<?php echo $data['detail']['link3'];?>">Shop Now <i class="icofont-rounded-right"></i></a>
														</div>
													</td>
												</tr>
												<?php } ?>
												
											</tbody>
										</table>
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
				</div>
				<div class="col-lg-7 col-md-7 col-sm-6 col-xs-12">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="sh_product_view_name sh_float_width">
						<h2 style="font-size: 26px;margin-bottom: 10px !important;"><?php echo $data['detail']['title'];?></h2>
						<div class="sh_product_view_rating sh_float_width" style="display:none;">
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
				
				<div class="col-sm-12 SocialShareIcon" >
				<div class="">
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12" style="display:none;">
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
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
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
	<div class="sh_product_describtion_wrap sh_float_width" style="display:none;">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="sh_product_tab_view sh_float_width">
						<div class="row">
							<ul id="myTabs" class="nav nav-pills nav-justified" role="tablist" data-tabs="tabs">
								<li class="active"><a href="#sh_comapre_price" data-toggle="tab">Comapre Price</a></li>
								
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
													<th class="text-right">Total Price</th>
												</tr>
											</thead>
											<tbody>
												
												<tr>
													<td>
														<div class="sh_tab_compare_img sh_tab_compare_info">
															<b><?php echo $data['detail']['merchant1'];?></b>
														</div>
													</td>
													
													<td class="text-right">
														<div class="sh_tab_compare_total_price">
															<h4>$ <?php echo $data['detail']['price1'];?></h4>
															<a target="_blank" class="sh_shop_btn" href="<?php echo $data['detail']['link1'];?>">Shop Now <i class="icofont-rounded-right"></i></a>
														</div>
													</td>
												</tr>
												<tr>
													<td >
														<div class="sh_tab_compare_img sh_tab_compare_info">
															<b><?php echo $data['detail']['merchant2'];?></b>
														</div>
													</td>
													
													<td class="text-right">
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
													
													<td class="text-right">
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
