@extends('layouts.app')

@section('content')

<!--Main Wrapper Start-->
<div class="sh_float_width">
	<!--Slider Start-->
	<div class="sh_float_width">
		<div class="container-fluid">
			<div class="row_counter ">
            	<div id="menu_header" class="maincate_list">
                    <div class="filter_flight">
                        
                    </div>
				<?php if($cat_data){
					$i = 1;?>					
                    <div class="pn-ProductNav_Wrapper">
                        <nav id="pnProductNav" class="pn-ProductNav">
                            <div id="pnProductNavContents" class="pn-ProductNav_Contents">
							<?php foreach($cat_data as $cat){?>
								<?php if($i == 1){?>
								 <a href="#cat-<?php echo $cat['parent_cat_slug'];?>" class="pn-ProductNav_Link" aria-selected="true"><?php echo $cat['parent_cat_name'];?></a>
								<?php }else{?>
									<a href="#cat-<?php echo $cat['parent_cat_slug'];?>" class="pn-ProductNav_Link"><?php echo $cat['parent_cat_name'];?></a>
								<?php } ?>
							<?php $i++;} ?>
                            <span id="pnIndicator" class="pn-ProductNav_Indicator"></span>
                            </div>
                        </nav>
						<button id="pnAdvancerLeft" class="pn-Advancer pn-Advancer_Left" type="button">
							<svg class="pn-Advancer_Icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 551 1024"><path d="M445.44 38.183L-2.53 512l447.97 473.817 85.857-81.173-409.6-433.23v81.172l409.6-433.23L445.44 38.18z"/></svg>
						</button>
						<button id="pnAdvancerRight" class="pn-Advancer pn-Advancer_Right" type="button">
							<svg class="pn-Advancer_Icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 551 1024"><path d="M105.56 985.817L553.53 512 105.56 38.183l-85.857 81.173 409.6 433.23v-81.172l-409.6 433.23 85.856 81.174z"/></svg>
						</button>
					</div>
				<?php } ?>
                </div>
				
				<div class="width_allCategory">
					<?php if($cat_data){

					?>				
						<div class="sub_cate_list" id="cat-<?php echo $cat_data[0]['parent_cat_slug'];?>">
					<?php if($cat_data[0]['sub_categories']){
					foreach($cat_data[0]['sub_categories'] as $sub_cat){?>	
							<div class="col-sm-3">
								<a href="{{env('APP_URL')}}category/<?php echo $cat_data[0]['parent_cat_slug'];?>" class="main_title_cat"><?php echo $cat_data[0]['parent_cat_name'];?> </a>
							</div>					
							<div class="col-sm-2">
								<img class="img-responsive" src="{{env('APP_URL')}}category_files/<?php echo $sub_cat['child_cat_image'];?>"/>
							</div>
							<div class="col-sm-7">
								<h5><a href="{{env('APP_URL')}}category/<?php echo $sub_cat['child_cat_slug'];?>"><?php echo $sub_cat['child_cat_name'];?></a></h5>
								<ul class="inner_list_item">
									<li><a href="#">List </a></li>
									<li><a href="#">List </a></li>
									<li><a href="#">List </a></li>
									<li><a href="#">List </a></li>
									<li><a href="#">List </a></li>
									<li><a href="#">List </a></li>
									<li><a href="#">List </a></li>
									<li><a href="#">List </a></li>
									<li><a href="#">List </a></li>
									<li><a href="#">List </a></li>
									<li><a href="#">List </a></li>
									<li><a href="#">List </a></li>
									<li><a href="#">List </a></li>
									<li><a href="#">List </a></li>
									<li><a href="#">List </a></li>
									<li><a href="#">List </a></li>
									<li><a href="#">List </a></li>
									<li><a href="#">List </a></li>
									<li><a href="#">List </a></li>
								</ul>
							</div>
					<?php } } ?>
						</div>
				<?php  } ?>
				
				</div>
			</div>
		</div>
	</div>

</div>	
@endsection
