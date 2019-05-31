@extends('auth.layouts.app')

@section('auth_content')
<div class="container">
	<div class="row">
		<div class="col-md-3">
		</div>
		<div class="col-md-6">
		
			<div class="reset-password-form">
				<form class="form" method="POST" action="{{ route('password.email') }}">
					{{ csrf_field() }}
							<h3 class="title text-center">
								Reset Password
							</h3>
							@if (session('status'))
								<div class="alert alert-success">
									{{ session('status') }}
								</div>
							@endif							
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

							<div class="mt-4">
								<button type="submit" class="btn btn-primary btn-block btn-lg">Send Password Reset Link</button>
							</div>
							<!-- /.btn btn-primary -->
				</form>
				<div class="mt-3 text-center text-capitalize">
					<a href="{{ route('login') }}">Remember the password?</a>
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
		
<script>
$( document ).ready(function() {
   if($('.alert').length == 1){
	   setTimeout(function(){ $('.alert').fadeOut(); }, 3000);
   }
});
</script>
@endsection
