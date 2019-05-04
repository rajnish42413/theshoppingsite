@extends('auth.layouts.app')

@section('auth_content')
<div class="container">
	<div class="row">
		<div class="col-md-3">
		</div>
		<div class="col-md-6">
		
			<div class="reset-password-form">
				<form class="form" method="POST" action="{{ route('password.request') }}">
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
								<input type="email" class="form-control form-control-lg" placeholder="Email Address" id="email" name="email" value="{{ old('email') }}" autofocus required>
							@if ($errors->has('email'))
								<span class="help-block">
									<strong><sup>*</sup>{{ $errors->first('email') }}</strong>
								</span>
							@endif									
								<!-- /.form-control -->
							</div>
							<!-- /.form-group -->
							
							<div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
								<input type="password" class="form-control form-control-lg" placeholder="Password" name="password" id="password" required>
							@if ($errors->has('password'))
								<span class="help-block">
									<strong><sup>*</sup>{{ $errors->first('password') }}</strong>
								</span>
							@endif									
								<!-- /.form-control -->
							</div>
							<!-- /.form-group -->

							<div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
								<input type="password" class="form-control form-control-lg" placeholder="Confirm Password" name="password_confirmation" id="password_confirmation" required>
							@if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                            @endif								
								<!-- /.form-control -->
							</div>
							<!-- /.form-group -->							

							<div class="mt-4">
								<button type="submit" class="btn btn-primary btn-block btn-lg">Reset Password</button>
							</div>
							<!-- /.btn btn-primary -->
				</form>
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
