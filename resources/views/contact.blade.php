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
				<div class="col-lg-6 col-md-6 col-sm-12">
					<div class="sh_contact_section sh_float_width">
						<div class="sh_sub_heading">
							<h2>Contact Info</h2>
						</div>
						<div class="sh_info_text">
							<p>Connor Turnbull is a part-time writer demmo the technology industry and part-time web designer from the United Kingdom. Connor previously wrote for bellway.</p>
						</div>
						<div class="sh_contact_info sh_float_width">
							<p><span class="icofont-email"></span><a href="javacript:void(0);">contact@example.com</a></p>
						</div>
						<div class="sh_contact_info sh_float_width">
							<p><span class="icofont-map-pins"></span><a href="javascript:void(0);">shopergy contact address</a></p>
						</div>
						<div class="sh_contact_info sh_float_width">
							<p><span class="icofont-ui-contact-list"></span><a href="javascript:void(0);">
							+91 99999-66666</a></p>
						</div>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12">
				  <div class="sh_map_wrap sh_float_width">
					 <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d30711137.27491417!2d64.44494055238786!3d20.011950756648737!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30635ff06b92b791%3A0xd78c4fa1854213a6!2sIndia!5e0!3m2!1sen!2sin!4v1556881953906!5m2!1sen!2sin" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
				  </div>
				</div>
			</div>
		</div>
	</div>
	
	
	
</div>	

@endsection
