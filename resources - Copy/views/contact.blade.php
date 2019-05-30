@extends('layouts.app')

@section('content')
<!--Main Wrapper Start-->
<div class="sh_main_wrap sh_float_width">
	<!--Contact Banner Start-->
	<div class="sh_contact_banner_wrap sh_float_width">
		<div class="container">
			<div class="sh_contact_banner sh_float_width" style="background: url({{ env('APP_URL')}}banner_files/<?php echo $banner->display_image;?>) no-repeat;">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="sh_contact_banner_text sh_float_width">
							<h1><?php echo $banner->heading_title;?></h1>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--Contact Section Start-->
	<div class="sh_contact_section_wrap sh_float_width">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-12">
				  <div class="sh_contact_section sh_float_width">
					<div class="sh_sub_heading">
						<h2>Get in Touch</h2>
					</div>
					<div class="row">
						<div class="col-lg-12">
							@if (!empty($errors) && $errors->any())
								<div class="alert alert-danger">
									<ul style="margin-bottom: 0px;">
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
							@endif
							@if(!empty($success) && $success->count())
								<div class="alert alert-success" id="successmsg">
									<ul style="margin-bottom: 0px;">
										@foreach ($success->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
								<?php session()->forget('successmessage'); ?>
							@endif						
						</div>
					</div>
					
					<form class="sh_float_width" action="" method="post" >
					 {{ csrf_field() }}
					  <div class="row">
						<div class="col-lg-6 col-md-6 col-sm-12">
						  <div class="sh_input_wrap sh_float_width">
							<input type="text" placeholder="Name" id="name" name="name" value="{{ old('name') }}" required>
						  </div>                                 
						</div>
						<div class="col-lg-6 col-md-6 col-sm-12">
						  <div class="sh_input_wrap sh_float_width">
							<input type="email" placeholder="Email" name="email" id="email" value="{{ old('email') }}" required>
						  </div> 
						</div>
						<div class="col-lg-6 col-md-6 col-sm-12">
						  <div class="sh_input_wrap sh_float_width">
							<input type="text" id="subject" name="subject" placeholder="Subject" value="{{ old('subject') }}" required>
						  </div> 
						</div>
						<div class="col-lg-6 col-md-6 col-sm-12">
						  <div class="sh_input_wrap sh_float_width">
							<input type="text" id="contact_no" name="contact_no" placeholder="Contact No." value="{{ old('contact_no') }}" required>
						  </div> 
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
						  <div class="sh_input_wrap sh_float_width"> 
							<textarea name="message" class="form-control" id="message" cols="30" rows="10" placeholder="Drop Your Message" value="{{ old('message') }}" required></textarea>
						  </div>
						  <div class="sh_float_width">
							
							<input class="sh_btn" type="submit" value="Submit"/>
						  </div>
						</div>
					  </div>            
					</form>
				  </div>
				</div>
			<?php if($contact_info && $contact_info->count() > 0){?>
				<div class="col-lg-6 col-md-6 col-sm-12">
					<div class="sh_contact_section sh_float_width">
						<div class="sh_sub_heading">
							<h2>Contact Info</h2>
						</div>
						<div class="sh_info_text">
							<p><?php echo $contact_info->contact_text;?></p>
						</div>
						<div class="sh_contact_info sh_float_width">
							<p><span class="icofont-email"></span><a href="mailto:<?php echo $contact_info->contact_email;?>"><?php echo $contact_info->contact_email;?></a></p>
						</div>
						<div class="sh_contact_info sh_float_width">
							<p><span class="icofont-map-pins"></span><a href="javascript:void(0);"><?php echo $contact_info->contact_address;?></a></p>
						</div>
						<div class="sh_contact_info sh_float_width">
							<p><span class="icofont-ui-contact-list"></span><a href="tel:<?php echo $contact_info->contact_no;?>">
							<?php echo $contact_info->contact_no;?></a></p>
						</div>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12">
				  <div class="sh_map_wrap sh_float_width">
					 <iframe src="<?php echo $contact_info->google_map_src_code;?>" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
					 
				  </div>
				</div>
			<?php } ?>
			</div>
		</div>
	</div>
	
	
	
</div>	

@endsection
