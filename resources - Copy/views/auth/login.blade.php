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
			
			<div class="login-form">
				<form class="form" method="POST" action="{{ route('login') }}">
					{{ csrf_field() }}
					<div class="text-center logo_box">   <a href="{{env('APP_URL')}}" ><img src="{{env('APP_URL')}}assets/images/<?php if($settings){echo $settings->logo;}?>" alt="" height="50"></a></div>
							<h3 class="title text-center">
								Log in
							</h3>
							<!-- /.title -->

							<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
								<input type="email" class="form-control form-control-lg" placeholder="Email Address" id="inputEmail" name="email" value="{{ old('email') }}" autofocus required>
							@if ($errors->has('email'))
								<span class="help-block">
									<strong><sup>*</sup>{{ $errors->first('email') }}</strong>
								</span>
							@endif									
								<!-- /.form-control -->
							</div>
							<!-- /.form-group -->

							<div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
								<input type="password" class="form-control form-control-lg" placeholder="Password" name="password" id="inputPassword" required>
							@if ($errors->has('password'))
								<span class="help-block">
									<strong><sup>*</sup>{{ $errors->first('password') }}</strong>
								</span>
							@endif									
								<!-- /.form-control -->
							</div>
							<!-- /.form-group -->

							<div class="mt-4">
								<button type="submit" class="btn btn-primary btn-block btn-lg">Login</button>
							</div>
							<!-- /.btn btn-primary -->
				</form>
				<div class="mt-3 text-center text-capitalize">
					<a href="{{ route('password.request') }}">forgot password?</a>
				</div>
				<!-- /.mt-3 text-center text-capitalize -->


				<hr class="mt-4 mb-4">

				<!-- /.mt-2 -->
				<div class="mt-3">
					Don’t have an account? <a href="{{ route('register') }}"> Sign up</a>
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
