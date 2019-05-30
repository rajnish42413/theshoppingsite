<?php if($cat_data){?>				
	<div class="sub_cate_list" id="cat-<?php echo $cat_data[0]['parent_cat_slug'];?>">
	<div class="row text-center">
		<div class="col-sm-12">
			<a href="{{env('APP_URL')}}category/<?php echo $cat_data[0]['parent_cat_slug'];?>" class="main_title_cat"><?php echo $cat_data[0]['parent_cat_name'];?> </a>
		</div>							
	</div>	
<?php if($cat_data[0]['sub_categories']){
foreach($cat_data[0]['sub_categories'] as $sub_cat){?>	
	<div class="row">				
		<div class="col-sm-12">
			<h5><a href="{{env('APP_URL')}}category/<?php echo $sub_cat['child_cat_slug'];?>"><?php echo $sub_cat['child_cat_name'];?></a></h5>
		<?php if($sub_cat['child_categories']){?>
			<ul class="inner_list_item">
			<?php foreach($sub_cat['child_categories'] as $cc){?>
				<li>
					<a href="{{env('APP_URL')}}category/<?php echo $cc['cc_cat_slug'];?>"><?php echo $cc['cc_cat_name'];?></a>
				</li>
			<?php } ?>
			</ul>
		<?php } ?>
		</div>
	</div>
<?php } } ?>
	</div>
<?php  } ?>
				
				
