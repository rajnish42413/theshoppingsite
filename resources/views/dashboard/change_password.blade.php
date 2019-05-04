@extends('dashboard.dashboard_layouts.app')

@section('dashboard_content')

                        <!-- /.col-gl-3 col-md-3 col-sm-12 -->
                        <div class="col-gl-9 col-md-9 col-sm-12">
                            <h3 class="mb-4">Change Password</h3>
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12">
									<div class="widget">
										<div class="header">
											<div class="changepass_errors mt-2 alert alert-danger" style="display:none;">
												<ul class="nav"></ul>
											</div>										
										</div>
										<div class="body">
										<form id="ChangePasswordForm">
												{{csrf_field()}}
											<div class="form-group">
												<label for="old_password">Old Password</label>
												<!-- /.fa fa-user input-icon -->
											   <input type="password" name="old_password" class="form-control" id="old_password" placeholder="Old Password" required>
												<!-- /.form-control -->
											</div>
											<!-- /.form-group -->

											<div class="form-group">
												<label for="password">New Password</label>
												<!-- /.fa fa-user input-icon -->
											   <input type="password" name="password" class="form-control" id="password" placeholder="New Password" required>
												<!-- /.form-control -->
											</div>
											<!-- /.form-group -->
											<div class="form-group">
												<label for="password_confirmation">Confirm New Password</label>
												<!-- /.fa fa-user input-icon -->
											   <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirm New Password" required>
												<!-- /.form-control -->
											</div>
											<!-- /.form-group -->
		
											<button type="submit" class="btn btn-primary mt-2 sub_btn">Submit</button>
											<!-- /.btn btn-primary mt-2 -->
										</form>
										</div>
										<!-- /.body -->
									</div>
									<!-- /.widget -->
								</div>						
							</div>
                        </div>
                        <!-- /.col-gl-9 col-md-9 col-sm-12 -->
<script>
$("#ChangePasswordForm").submit(function(e){
$('.wait_loader').show();	
	e.preventDefault();
	$('.changepass_errors.alert-danger').hide();
	$('.changepass_errors.alert-danger ul').html('');
	$("#ChangePasswordForm .sub_btn").html('please wait..'); 
	$('.error').html('');
	$.ajax({
		type: "POST",
		url: '<?php echo route('password-update');?>',
		data:  new FormData(this),
		processData:false,
		contentType:false,
		cache:false,
		datatype:"json",	
		success: function(response)
		{
			$("#ChangePasswordForm .sub_btn").html('Submit'); 
			$('.wait_loader').hide();
			
			if(response == 'old_pass_error'){
				//$('.changepass_errors.alert-danger').show();
				//$('.changepass_errors.alert-danger ul').append('<li>old password is incorrect.</li>');
				$.notify({
				  message: 'old password is incorrect!!' 
				 },{ element: 'body', type: "danger", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
				});					
			}else{
				$.notify({
				  message: 'Password Changed Successfully!!' 
				 },{ element: 'body', type: "success", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
				});	
					window.setTimeout(function() { location.reload(); }, 1000); 
			}
			
		},
		error: function(data){
			$("#ChangePasswordForm .sub_btn").html('Submit'); 
			var errors = data.responseJSON;
			$(".wait_loader").hide();
			console.log(errors.errors);
			$.each(errors.errors, function(key, value){
				$.notify({
				  message: value 
				 },{ element: 'body', type: "danger", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
				});	
			});
		}
	});
});

 </script>
 

@endsection
