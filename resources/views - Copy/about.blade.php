@extends('layouts.app')

@section('content')

<!--Main Wrapper Start-->
<div class="sh_main_wrap sh_float_width">
	<!--About Banner Wrapper Start-->
	<div class="sh_about_banner_wrap sh_float_width">
		<div class="container">
			<div class="sh_about_banner sh_float_width" style="background: url({{ env('APP_URL')}}banner_files/<?php echo $banner->display_image;?>) no-repeat;">
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
	<!--About Section Wrapper Start-->
	<div class="sh_about_section_wrap sh_float_width">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<?php echo $row->page_content;?>
				</div>
			</div>
		</div>
	</div>
	
	
	
</div>	

@endsection
