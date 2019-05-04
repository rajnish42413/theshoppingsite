@extends('dashboard.dashboard_layouts.app')

@section('dashboard_content')

                        <!-- /.col-gl-3 col-md-3 col-sm-12 -->
                        <div class="col-gl-9 col-md-9 col-sm-12">
                            <h3 class="mb-4">Edit Profile</h3>
							<div class="row">
								<div class="col-lg-7 col-md-7 col-sm-12">
									<div class="widget">
										<div class="header">
											<div class="title">
												Personal Infomation
												
											</div>
											<!-- /.title -->
											<div class="profile_errors mt-2 alert alert-danger" style="display:none;">
												<ul class="nav"></ul>
											</div>										
											

										</div>
										<!-- /.header -->
										<div class="body">
										<form id="ProfileEditForm">
												{{csrf_field()}}
											<div class="form-group">
												<label for="name">Full Name</label>
												<!-- /.fa fa-user input-icon -->
											   <input type="text" id="name" class="form-control" value="<?php if($row){echo ucwords($row->name);}?>" name="name" required>
												<!-- /.form-control -->
											</div>
											<!-- /.form-group -->

											<div class="form-group">
												<label for="email">Email address</label>
												<!-- /.fa fa-user input-icon -->
											   <input type="email" id="email" class="form-control" value="<?php if($row){echo $row->email;}?>" name="email" required>
												<!-- /.form-control -->
											</div>
											<!-- /.form-group -->
											<div class="form-group">
												<label for="phone">Phone number</label>
												<!-- /.fa fa-user input-icon -->
												<input type="text" id="phone" class="form-control" value="<?php if($row){echo $row->phone;}?>" name="phone" required>
												<!-- /.form-control -->
											   
											</div>
											<!-- /.form-group -->
											<div class="form-group">
												<label for="address">Address</label>
												<!-- /.fa fa-user input-icon -->
											   <input type="address" id="address" class="form-control" value="<?php if($row){echo $row->address;}?>" name="address" required>
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
								
								<div class="col-lg-5 col-md-5 col-sm-12">
									<div class="widget">
										<div class="header">
											<div class="title">
												Profile Image
											</div>
											<!-- /.title -->
										</div>
										<!-- /.header -->
										<div class="body">
										<form id="ProfileImageForm" enctype="multipart/form-data">
											{{csrf_field()}}
											<div class="form-group">
											<input required type="file" data-id="<?php if($row){echo $row->id;}?>" id="file" class="dropify" <?php if($row && !empty($row->image)){}else{ echo ' ';} ?>  name="file" data-default-file="<?php if($row){if(!empty($row->image)){  echo env("APP_URL").'/user_profile_files/'.$row->image;} }?>" />
											</div>
											<!-- /.form-group -->
																				
											
											<button type="submit" class="sub_btn btn btn-info mt-2"><?php if($row && !empty($row->image)){ echo 'Change';}else{ echo 'Upload';}?></button>
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

$("#ProfileEditForm").submit(function(e){
$('.wait_loader').show();	
	e.preventDefault();
	$('.profile_errors.alert-danger').hide();
	$('.profile_errors.alert-danger ul').html('');
	$("#ProfileEditForm .sub_btn").html('please wait..'); 
	$('.error').html('');
	$.ajax({
		type: "POST",
		url: '<?php echo route('profile-update');?>',
		data:  new FormData(this),
		processData:false,
		contentType:false,
		cache:false,
		datatype:"json",	
		success: function(response)
		{ 
			$("#ProfileEditForm .sub_btn").html('Submit'); 
			$('.wait_loader').hide();
			$.notify({
			  message: 'Profile Updated Successfully!!' 
			 },{ element: 'body', type: "success", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
			});
			window.setTimeout(function() { location.reload(); }, 1000); 
		},
		error: function(data){
			$("#ProfileEditForm .sub_btn").html('Submit'); 
			var errors = data.responseJSON;
			$(".wait_loader").hide();
			console.log(errors.errors);
			$.each(errors.errors, function(key, value){
				$('.profile_errors.alert-danger').show();
				$('.profile_errors.alert-danger ul').append('<li>'+value+'</li>');
			});
		}
	});
});

 </script>


<script>

$("#ProfileImageForm").submit(function(e){
$('.wait_loader').show();	
	e.preventDefault();
	$("#ProfileImageForm").find('.form-group').removeClass('has-error');
	$("#ProfileImageForm .sub_btn").html('please wait..'); 
	$('.error').html('');
	$.ajax({
		type: "POST",
		url: '<?php echo route('image-update');?>',
		data:  new FormData(this),
		processData:false,
		contentType:false,
		cache:false,
		datatype:"json",	
		success: function(response)
		{ 
			$('.wait_loader').hide();
			
			var result = response.split("|"); 
			 if(result[0].length != 0){
				var err = JSON.parse(result[0]);
				var er = '';
				$.each(err, function(k, v) {
				er = ' * ' + v; 
				$("#"+k+"_error").parent().addClass('has-error');
					$.notify({
					  message: v 
					 },{ element: 'body', type: "success", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
					});				
					$("#ProfileImageForm .sub_btn").html('Change'); 

				});
			}else{
					$.notify({
					  message: 'Image Changed Successfully!!' 
					 },{ element: 'body', type: "success", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
					});
				
				window.setTimeout(function() { location.reload(); }, 1000); 
			}
		}
	});
});

 </script>
 
 <script>
 function readURL(input) {

  if (input.files && input.files[0]) {
	var file = input.files[0];
	var imagefile = file.type;
	var match =  ["image/jpeg","image/png","image/jpg"];
	if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]))){
		$.notify({
		  message: 'Image format is wrong. Only JPG/PNG formats are allowed.' 
		 },{ element: 'body', type: "danger", allow_dismiss: true, offset: { x: 20, y: 60 }, delay: 500 
		 });
		$("#file").val('');
		return false;
	}
	var imagesize = file.size;
	if(imagesize > 2097152){ //2MB
		$.notify({
		  message: 'Image size bigger than 2 MB are not allowed.' 
		 },{ element: 'body', type: "danger", allow_dismiss: true, offset: { x: 20, y: 60 }, delay: 500 
		 });
		$("#file").val('');	
		return false;
	}
	
    var reader = new FileReader();
    reader.onload = function(e) {
    }

    reader.readAsDataURL(input.files[0]);
  }
}

$("#file").change(function() {
	
  readURL(this);
});
 </script>	

<script>
	$(document).ready(function(){

		// Used events
		var drEvent = $('#file').dropify();

		drEvent.on('dropify.beforeClear', function(event, element){
			return confirm("Do you really want to remove this image?");
			//element.file.name
		});

		drEvent.on('dropify.afterClear', function(event, element){
			var row_id = $('#file').attr('data-id');
			if(row_id!=''){
				$('#file_name').val('');						
			}
		
			
		});

		drEvent.on('dropify.errors', function(event, element){
			console.log('Has Errors');
		});

	});

</script>
@endsection
