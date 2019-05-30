@extends('layouts.app')

@section('content')

<!--Main Wrapper Start-->
<div class="sh_main_wrap sh_float_width">
	<!--FAQ Banner Wrapper Start-->
	<div class="sh_faq_banner_wrap sh_float_width">
		<div class="container">
			<div class="sh_faq_banner sh_float_width" style="background: url({{ env('APP_URL')}}banner_files/<?php echo $banner->display_image;?>) no-repeat;">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="sh_about_banner_text sh_float_width">
							<h1><?php echo $banner->heading_title;?></h1>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--Faq Section Wrapper Start-->
	<div class="sh_faq_section_wrap sh_float_width">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-8 col-sm-12 col-xs-12 col-lg-offset-3 col-md-offset-2">
					<div class="sh_heading">
						<h2>Frequently Asked Questions</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="sh_faq_section sh_float_width">
					<?php if($faqs && $faqs->count() > 0){
						$i = 1;?>
						<div class="content">
							<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
							<?php foreach($faqs as $faq){?>
								<div class="panel panel-default">
									<div class="panel-heading" id="heading<?php echo $i;?>" role="tab">
										<h4 class="panel-title"><a class="<?php if($i != 1){ echo 'collapsed';}?>" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i;?>" aria-expanded="<?php if($i == 1){ echo 'true';}else{ echo 'false';}?>" aria-controls="collapse<?php echo $i;?>"><?php echo $faq->question;?><i class="pull-right fa fa-plus"></i></a></h4>
									</div>
									<div class="panel-collapse collapse <?php if($i == 1){ echo 'in';}?>" id="collapse<?php echo $i;?>" role="tabpanel" aria-labelledby="heading<?php echo $i;?>">
										<div class="panel-body">
											<p><?php echo $faq->answer;?></p>
										</div>
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
	
	
	
</div>

@endsection
