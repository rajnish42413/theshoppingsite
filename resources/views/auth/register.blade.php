<?php 
use \App\Http\Controllers\DetailController;
$settings = DetailController::get_settings();
?>
@extends('auth.layouts.app')

@section('auth_content')
<div class="container">
	<div class="row">
		<div class="col-md-3">
		</div>
		<div class="col-md-6">
		
			<div class="register-form">
				<form class="form" method="POST" action="{{ route('register') }}">
					{{ csrf_field() }}			
					<div class="text-center logo_box">   <a href="{{env('APP_URL')}}" ><img src="{{env('APP_URL')}}assets/images/logo.png" alt="" height="50"></a></div>
							<h3 class="title text-center">
								Sign up
							</h3>
							<!-- /.title -->			
				<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
					<input type="text" class="form-control form-control-lg" id="name" placeholder="Full Name" name="name" value="{{ old('name') }}" required autofocus>
					 @if ($errors->has('name'))
						<span class="help-block">
							<strong>{{ $errors->first('name') }}</strong>
						</span>
					@endif					
					<!-- /.form-control -->
				</div>
				<!-- /.form-group -->

				<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
					<input type="email" class="form-control form-control-lg" id="inputEmail" placeholder="Email Address" name="email" value="{{ old('email') }}" required>
					@if ($errors->has('email'))
						<span class="help-block">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
					@endif					
					<!-- /.form-control -->
				</div>
				<!-- /.form-group -->

				<div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
					<input type="password" class="form-control form-control-lg" id="password" placeholder="Password" name="password" required>
					<!-- /.form-control -->
				</div>
					 @if ($errors->has('password'))
						<span class="help-block">
							<strong>{{ $errors->first('password') }}</strong>
						</span>
					@endif				
				<!-- /.form-group -->
				
				<div class="form-group">
					<input type="password" class="form-control form-control-lg" id="password_confirmation" placeholder="Confirm Password" name="password_confirmation" required>
					<!-- /.form-control -->
				</div>
				<!-- /.form-group -->				

				<div class="mt-3">
					By clicking Sign Up now, you agree to the Shopergy
					<a href="{{ env('APP_URL')}}terms-of-use">Terms of Service</a>, <a href="{{ env('APP_URL')}}privacy-policy">Privacy Policy</a>.

				</div>
				<!-- /.mt-3 -->

				<div class="mt-4">
					<button type="submit" class="btn btn-primary btn-block btn-lg">Sign Up</button>
				</div>
				<!-- /.btn btn-primary -->


				<hr class="mt-4 mb-4">

				<!-- /.mt-2 -->
				<div class="mt-3">
					Already have an <?php if($settings){ echo $settings->title;} ?> account? <a href="{{ route('login') }}">Log in</a>
				</div>
				<!-- /.mt-2 -->
			</div>
		</div>
	</div>
</div>
<script>
$( document ).ready(function() {
$('form').attr('autocomplete','off');
});
</script>		
@endsection
