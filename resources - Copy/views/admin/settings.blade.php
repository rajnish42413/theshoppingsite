<?php use \App\Services\HotelApiService; ;?>
@extends('admin.layouts.app')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $data['title'];?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo $data['title'];?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php echo env('APP_URL');?>user_profile_files/<?php echo $row->image;?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo ucwords($row->name);?></h3>

              <p class="text-muted text-center"><?php if($row->role_id == 1){echo 'Administrator';}?></p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">About Me</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-envelope margin-r-5"></i> Email</strong>

              <p class="text-muted">
                <?php echo $row->email;?>
              </p>

              <hr>

              <strong><i class="fa fa-money margin-r-5"></i> Currency</strong>

              <p class="text-muted"><?php $currencyDetail = HotelApiService::get_currencyDetailById($row->currency_id); 
			  echo $currencyDetail->country.' - '.$currencyDetail->currency.' ('.$currencyDetail->code.')';?></p>

              <hr>

			  </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
			  <li><a class="active" href="#editprofile" data-toggle="tab">Edit Profile</a></li>			
              <li ><a href="#changepassword" data-toggle="tab">Change Password</a></li>
			  <li><a href="#changeimage" data-toggle="tab">Profile Image</a></li>
            </ul>
            <div class="tab-content">
              <!-- tab-pane -->
              <div class="tab-pane active" id="editprofile">
                <form class="form-horizontal" id="ProfileEditForm">
				{{csrf_field()}}
                  <div class="form-group">
                    <label for="name" class="col-sm-3 control-label">Name</label>

                    <div class="col-sm-9">
                      <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="<?php if($row){echo $row->name;}?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email</label>

                    <div class="col-sm-9">
                      <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="<?php if($row){echo $row->email;}?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="currency_id" class="col-sm-3 control-label">Currency</label>

                    <div class="col-sm-9">
                      <select name="currency_id" class="form-control" id="currency_id">
						<?php if($currency_codes){
							foreach($currency_codes as $code){?>
							<option value="<?php echo $code->id;?>" <?php if($code->id == $row->currency_id){ echo 'selected';}?>><?php echo $code->country.' - '.$code->currency.' ('.$code->code.')';?></option>
						<?php } } ?>
					  </select>
                    </div>
                  </div>				  
                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                      <button type="submit" class="sub_btn btn btn-primary">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
			  
              <!-- tab-pane -->
              <div class="tab-pane" id="changepassword">
                <form class="form-horizontal" id="ChangePasswordForm">
				{{csrf_field()}}
                  <div class="form-group">
                    <label for="old_password" class="col-sm-3 control-label">Old Password</label>

                    <div class="col-sm-9">
                      <input type="text" name="old_password" class="form-control" id="old_password" placeholder="Old Password" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">New Password</label>

                    <div class="col-sm-9">
                      <input type="password" name="password" class="form-control" id="password" placeholder="New Password" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="cpassword" class="col-sm-3 control-label">Confirm New Password</label>

                    <div class="col-sm-9">
                      <input type="password" name="cpassword" class="form-control" id="cpassword" placeholder="Confirm New Password" required>
                    </div>
                  </div>				  
                 
                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                      <button type="submit" class="sub_btn btn btn-primary">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
			 			  
              <!-- tab-pane -->
              <div class="tab-pane" id="changeimage">
                <form class="form-horizontal" id="ProfileImageForm" enctype="multipart/form-data">
				{{csrf_field()}}
                  <div class="form-group">
                    <label for="file" class="col-sm-3 control-label">Profile Image</label>

                    <div class="col-sm-9">
					<input required type="file" data-id="<?php if($row){echo $row->id;}?>" id="file" class="dropify" <?php if($row && !empty($row->image)){}else{ echo ' ';} ?>  name="file" data-default-file="<?php if($row){if(!empty($row->image)){  echo env("APP_URL").'/user_profile_files/'.$row->image;} }?>" />
                    </div>
                  </div>			  
                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                      <button type="submit" class="sub_btn btn btn-primary">Change</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->			  
			  
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
<script>

$("#ProfileEditForm").submit(function(e){
$('.wait_loader').show();	
	e.preventDefault();
	$("#ProfileEditForm").find('.form-group').removeClass('has-error');
	$("#ProfileEditForm .sub_btn").html('please wait..'); 
	$('.error').html('');
	$.ajax({
		type: "POST",
		url: '<?php echo route('admin-profile-update');?>',
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
					$("#ProfileEditForm .sub_btn").html('Submit'); 

				});
			}else{
					$.notify({
					  message: 'Profile Updated Successfully!!' 
					 },{ element: 'body', type: "success", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
					});
				
				window.setTimeout(function() { location.reload(); }, 1000); 
			}
		}
	});
});

 </script>
 
<script>

$("#ChangePasswordForm").submit(function(e){
$('.wait_loader').show();	
	e.preventDefault();
	$("#ChangePasswordForm").find('.form-group').removeClass('has-error');
	$("#ChangePasswordForm .sub_btn").html('please wait..'); 
	$('.error').html('');
	$.ajax({
		type: "POST",
		url: '<?php echo route('admin-change-password');?>',
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
					$.notify({
					  message: 'Old Password is Incorrect' 
					 },{ element: 'body', type: "danger", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
					});				
			}
			else if(response == 'cpass_no_match'){
					$.notify({
					  message: 'Confirm Password not matched.' 
					 },{ element: 'body', type: "danger", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
					});				
			}			
			else{
				$.notify({
				  message: 'Password Changed Successfully!!' 
				 },{ element: 'body', type: "success", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
				});			
				window.setTimeout(function() { location.reload(); }, 1000); 
			}
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
		url: '<?php echo route('admin-image-update');?>',
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
