@extends('layouts.app')

@section('content')

	<!--Faq Section Wrapper Start-->
	<div class="sh_faq_section_wrap sh_float_width">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-8 col-sm-12 col-xs-12 col-lg-offset-3 col-md-offset-2">
					<div class="sh_heading">
						<h2>All Categories</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="sh_faq_section sh_float_width">
					<?php if($cat_data){
						$i = 1;?>
						<div class="content">
							<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
							<?php foreach($cat_data as $cat){?>
								<div class="panel panel-default">
									<div class="panel-heading" id="heading<?php echo $i;?>" role="tab">
										<h4 class="panel-title">
											<a class="<?php if($i != 1){ echo 'collapsed';}?>" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i;?>" aria-expanded="<?php if($i == 1){ echo 'true';}else{ echo 'false';}?>" aria-controls="collapse<?php echo $i;?>"><?php echo $cat['parent_cat_name'];?><i class="pull-right fa fa-plus"></i></a>
										</h4>
									</div>
									<div class="panel-collapse collapse <?php if($i == 1){ echo 'in';}?>" id="collapse<?php echo $i;?>" role="tabpanel" aria-labelledby="heading<?php echo $i;?>">
										<?php if($cat['sub_categories']){
											foreach($cat['sub_categories'] as $sub_cat){?>
										<div class="panel-body">
											<a href="{{env('APP_URL')}}category/<?php echo $sub_cat['child_cat_slug'];?>" class="btn-link"><?php echo $sub_cat['child_cat_name'];?></a>
										</div>	
									<?php } } ?>
									</div>
								</div>
							<?php  $i++; } ?>								
							</div>
						</div>
					<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>

<script>
/* function getcat(id){
	$('.wait_loader').show();
		$.ajax({
			type: "POST",
			headers: {
			  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},	 			
			url: '<?php echo env('APP_URL') ?>get-sub-categories',
			data:  {'id':id},	
			success: function(res)
			{ 
				$('.wait_loader').hide();			
				if(res == 'error'){
					alert('Error Occured.');
				}else{
					$()
				}
			}
		});		
} */
</script>
@endsection
