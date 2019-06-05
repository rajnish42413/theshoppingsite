@extends('admin.layouts.app')

@section('content')
<?php 
use \App\Http\Controllers\DetailController;
$menu_permissions = DetailController::get_menu_permissions();
?>

   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $data['sub_title'].' '.$data['title'];?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo $data['sub_title'];?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-offset-1 col-md-10 col-xs-12">
          <!-- general form elements -->
          <div class="box box-primary">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
			<?php if(Auth::user()->is_super_admin == 1 || in_array('setting_site',$menu_permissions) ){?>			
              <li class="active"><a href="#site-settings" data-toggle="tab">Site</a></li>
			<?php } ?>
			<?php if(Auth::user()->is_super_admin == 1 || in_array('setting_social',$menu_permissions) ){?>
              <li><a href="#social-settings" data-toggle="tab">Social</a></li>
			<?php } ?>
			<?php if(Auth::user()->is_super_admin == 1 || in_array('setting_api',$menu_permissions) ){?>
              <li><a href="#api-settings" data-toggle="tab">API</a></li>
			<?php } ?>			
            </ul>
            <div class="tab-content">
			<?php if(Auth::user()->is_super_admin == 1 || in_array('setting_site',$menu_permissions) ){?>
              <div class="active tab-pane" id="site-settings">
            <!-- form start -->
				<form role="form" id="siteForm" enctype="multipart/form-data">
				 {{csrf_field()}}
				  <div class="box-body">
					<div class="row">
						<div class="col-sm-12">							
							<div class="admin_errors alert alert-danger" style="display:none;">
								<ul class="nav"></ul>
							</div>
						</div>
					</div>
					<div class="form-group">
					  <label for="title"><span class="text-danger font_12"> * </span>Title</label>
					  <div class="input-group">
						<div class="input-group-addon"><i class="fa fa-edit"></i></div>
						<input name="title" id="title" class="form-control" value="<?php if($site){ echo $site->title; } ?>" >
					  </div>
					  <div class="text-danger error font_12" id="title_error"></div>
					</div>					
					<div class="form-group">
					  <label for="description"><span class="text-danger font_12"> * </span>Description</label>
					  <div class="input-group">
						<div class="input-group-addon"><i class="fa fa-edit"></i></div>
						<textarea name="description" id="description" class="form-control" rows="3"><?php if($site){ echo $site->description; } ?></textarea>
					  </div>
					  <div class="text-danger error font_12" id="description_error"></div>
					</div>
					
					<div class="form-group">
					  <label for="file"><span class="text-danger">*</span> Logo</label>
						<input type="file" data-id="<?php if($site){echo $site->id;}?>" id="file" class="dropify" <?php if($site && !empty($site->logo)){}else{ echo ' ';} ?>  name="file" data-default-file="<?php if($site){if(!empty($site->logo)){  echo env("APP_URL").'/assets/images/'.$site->logo;} }?>" />				  
					  <input type="hidden" id="file_name" name="file_name" value="<?php if($site){ echo $site->logo; }?>">
					</div>
					
					<div class="form-group">
					  <label for="google_analytics"><span class="text-danger font_12"> * </span>Google Analytics(Header)</label>
					  <div class="input-group">
						<div class="input-group-addon"><i class="fa fa-edit"></i></div>
						<textarea name="google_analytics" id="google_analytics" class="form-control" rows="8"><?php if($site){ echo $site->google_analytics; } ?></textarea>
					  </div>
					  <div class="text-danger error font_12" id="google_analytics_error"></div>
					</div>

					<div class="form-group">
					  <label for="google_analytics2"><span class="text-danger font_12"> * </span>Google Analytics(Body)</label>
					  <div class="input-group">
						<div class="input-group-addon"><i class="fa fa-edit"></i></div>
						<textarea name="google_analytics2" id="google_analytics2" class="form-control" rows="8"><?php if($site){ echo $site->google_analytics2; } ?></textarea>
					  </div>
					  <div class="text-danger error font_12" id="google_analytics2_error"></div>
					</div>					
										
				  </div>
				  <!-- /.box-body -->

				  <div class="box-footer">
				  <input type="hidden" name="id" value="<?php if($site){ echo $site->id; }?>" >
					<button type="submit" class="btn btn-primary" id="sub_btn">Submit</button>
				  </div>
				</form>

              </div>
              <!-- /.tab-pane -->
			<?php } ?>
			<?php if(Auth::user()->is_super_admin == 1 || in_array('setting_social',$menu_permissions) ){?>			  
              <div class="tab-pane" id="social-settings">
				<form role="form" id="socialForm" enctype="multipart/form-data">
				 {{csrf_field()}}
				  <div class="box-body">
					<div class="row">
						<div class="col-sm-12">							
							<div class="admin_errors alert alert-danger" style="display:none;">
								<ul class="nav"></ul>
							</div>
						</div>
					</div>				  
				<div class="form-group col-md-12">
					<div class="pull-left">
					<label for="type"><span class="text-danger">*</span> Social Links</label>
					</div>
				  <div class="row">
					  <div class="col-lg-12">
						  <div class="">
									  <table id="example1" class="table table-bordered table-striped" cellspacing="0" width="100%">
									<thead>
									<tr>
										<th>Display Name</th>
										<th>Social Icon</th>
										<th>URL</th>
										<th>Status</th>
										<th style="width:20px;"></th>
									</tr>
									</thead>
									<tbody>
									<?php if($social_links){
										foreach($social_links as $social_link){
										?>
									<tr class="row_class">
										<td>
											<input name="display_name[]" class="form-control display_name" value="<?php echo $social_link->display_name;?>">							
										</td>
										<td>
											<input name="social_icon[]" class="form-control social_icon" value="<?php echo $social_link->social_icon;?>">							
										</td>										
										<td>
												<input name="value[]" class="form-control value" value="<?php echo $social_link->value;?>">							
										</td>	
										<td>	
											<select type="text" class=" form-control status"  name="status[]" >
												<option value="1" <?php if($social_link){ if($social_link->status == 1){echo 'selected'; }} ?> >Active</option>
												<option value="0" <?php if($social_link){ if($social_link->status == 0){echo 'selected'; }} ?> >Deactive</option>
											</select>
										</td>
										
										<td>
											<input name="id[]" class="form-control id" type="hidden" value="<?php echo $social_link->id;?>">	
											
											<button type="button" onclick="social_delete_row(this);" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i></button>								
										</td>
									</tr>
									<?php 
										}
									}	
									?>
									</tbody>

								  </table>
						 </div>				  
					</div>
				</div>
						<div class="row margin-bottom">
							<div class="col-lg-3">
								<a href="javascript:void(0)" id="add_row" onclick="add_row();" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add New</a>
							</div>
						</div>				
				</div>					
				  </div>
				  <!-- /.box-body -->

				  <div class="box-footer">
					
					<button type="submit" class="btn btn-primary" id="sub_btn2">Submit</button>
				  </div>
				</form>
              </div>
              <!-- /.tab-pane -->
		<?php } ?>
			<?php if(Auth::user()->is_super_admin == 1 || in_array('setting_api',$menu_permissions) ){?>
              <div class="tab-pane" id="api-settings">
            <!-- form start -->
				<form role="form" id="apiForm" enctype="multipart/form-data">
				 {{csrf_field()}}
				  <div class="box-body">
					<div class="row">
						<div class="col-sm-12">							
							<div class="admin_errors alert alert-danger" style="display:none;">
								<ul class="nav"></ul>
							</div>
						</div>
					</div>
					<div class="form-group">
					 <label for="api_name"><span class="text-danger">*</span> API</label>
						<select type="text" class="form-control " id="api_name" name="api_name" >
							<option value="ebay" <?php if($api_setting){ if($api_setting->api_name == 'ebay'){echo 'selected'; }} ?> >Ebay</option>
					</select>
					</div>
					<div class="form-group">
					 <label for="mode"><span class="text-danger">*</span> Mode</label>
						<select type="text" class="form-control " id="mode" name="mode" >
							<option value="sandbox" <?php if($api_setting){ if($api_setting->mode == 'sandbox'){echo 'selected'; }} ?> >Sandbox</option>
							<option value="production" <?php if($api_setting){ if($api_setting->mode == 'production'){echo 'selected'; }} ?> >Production</option>
					</select>
					</div>					
					<div class="form-group">
					  <label for="app_id"><span class="text-danger font_12"> * </span>App ID</label>
					  <div class="input-group">
						<div class="input-group-addon"><i class="fa fa-edit"></i></div>
						<input name="app_id" id="app_id" class="form-control" value="<?php if($api_setting){ echo $api_setting->app_id; } ?>" >
					  </div>
					  <div class="text-danger error font_12" id="app_id_error"></div>
					</div>
					<div class="form-group">
					  <label for="developer_id"><span class="text-danger font_12"> * </span>Dev ID</label>
					  <div class="input-group">
						<div class="input-group-addon"><i class="fa fa-edit"></i></div>
						<input name="developer_id" id="developer_id" class="form-control" value="<?php if($api_setting){ echo $api_setting->developer_id; } ?>" >
					  </div>
					  <div class="text-danger error font_12" id="developer_id_error"></div>
					</div>
					<div class="form-group">
					  <label for="certificate_id"><span class="text-danger font_12"> * </span>Cert ID</label>
					  <div class="input-group">
						<div class="input-group-addon"><i class="fa fa-edit"></i></div>
						<input name="certificate_id" id="certificate_id" class="form-control" value="<?php if($api_setting){ echo $api_setting->certificate_id; } ?>" >
					  </div>
					  <div class="text-danger error font_12" id="certificate_id_error"></div>
					</div>					
					
					<div class="form-group">
					  <label for="token"><span class="text-danger font_12"> * </span>Token</label>
					  <div class="input-group">
						<div class="input-group-addon"><i class="fa fa-edit"></i></div>
						<textarea name="token" id="token" class="form-control" rows="8"><?php if($api_setting){ echo $api_setting->token; } ?></textarea>
					  </div>
					  <div class="text-danger error font_12" id="token_error"></div>
					</div>					
										
				  </div>
				  <!-- /.box-body -->

				  <div class="box-footer">
				  <input type="hidden" name="id" value="<?php if($api_setting){ echo $api_setting->id; }?>" >
					<button type="submit" class="btn btn-primary" id="sub_btn3">Submit</button>
				  </div>
				</form>

              </div>
              <!-- /.tab-pane -->
			<?php } ?>		
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
		  
          </div>
          <!-- /.box -->

        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  
	<div id="row_data" style="display:none;">
		<table>
		<tbody>
			<tr class="row_class">
				<td>
					<input name="display_name[]" class="form-control display_name" value="">
				</td>	
				<td>
					<input name="social_icon[]" class="form-control social_icon" value="">							
				</td>					
				<td>
						<input name="value[]" class="form-control value" value="">							
				</td>	
				<td>	
					<select type="text" class="form-control status "  name="status[]" >
						<option value="1">Active</option>
						<option value="0">Deactive</option>
					</select>
				</td>
				
				<td>
					<input name="id[]" class="form-control id" type="hidden" value="">	
					<button type="button" onclick="remove_row(this);" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i></button>								
				</td>
			</tr>
			</tbody>
		</table>
	</div>
 	
<script>
function add_row(){
	var row = $("#row_data tbody").html();
	$("#example1 tbody").append(row);
	
}

function remove_row(e){
	id = $(e).parent().find('.id').val();
		$(e).parent().parent().remove();
}

function social_delete_row(e){
	id = $(e).parent().find('.id').val();
	$.ajax({
		type: "POST",
		headers: {
		  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},		
		url: '<?php echo route('social-settings-delete');?>',
		data:  {'id':id},	
		success: function(response)
		{
			$(e).parent().parent().remove();
		}
	});		
		
}

var surl = '<?php echo route('settings-edit');?>'; 
//Site Settings
$("#siteForm").submit(function(e){
	$('.wait_loader').show();	
	$('.admin_errors.alert-danger').hide();
	$('.admin_errors.alert-danger ul').html('');
	e.preventDefault();
	$("#sub_btn").html('please wait..'); 
	$('.error').html('');
	$.ajax({
		type: "POST",
		url: '<?php echo route('settings-save');?>',
		data:  new FormData(this),
		processData:false,
		contentType:false,
		cache:false,
		datatype:"json",	
		success: function(response)
		{
			$("#sub_btn").html('Submit'); 
			$('.wait_loader').hide();	
			var result = response.split("|"); 
			 if(result[0].length != 0){
				var err = JSON.parse(result[0]);
				var er = '';
				$.each(err, function(k, v) {
					if(k == 'file'){ 
						$('.admin_errors.alert-danger').show();
						$('.admin_errors.alert-danger ul').append('<li>'+v+'</li>');			 
					} 
				});
			}
			 
			else if(response == '|success'){
					
					$.notify({
					  message: 'Data Updated Successfully!!' 
					 },{ element: 'body', type: "success", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
					});
				
				
			window.setTimeout(function() { location.reload(); }, 1000); 			
		}

		},
		error: function(data){
			$("#sub_btn").html('Submit');
			var errors = data.responseJSON;
			$(".wait_loader").hide();
			console.log(errors.errors);
			$.each(errors.errors, function(key, value){
				$('.admin_errors.alert-danger').show();
				$('.admin_errors.alert-danger ul').append('<li>'+value+'</li>');
			});
		}
	});
});


//Social Settings
var surl = '<?php echo route('settings-edit');?>'; 
$("#socialForm").submit(function(e){
	$('.wait_loader').show();	
	$('.admin_errors.alert-danger').hide();
	$('.admin_errors.alert-danger ul').html('');
	e.preventDefault();
	$("#sub_btn2").html('please wait..'); 
	$('.error').html('');
	$.ajax({
		type: "POST",
		url: '<?php echo route('social-settings-save');?>',
		data:  new FormData(this),
		processData:false,
		contentType:false,
		cache:false,
		datatype:"json",	
		success: function(response)
		{
			$("#sub_btn2").html('Submit'); 
			$('.wait_loader').hide();	
			var result = response.split("|"); 
			 if(result[0].length != 0){
				var err = JSON.parse(result[0]);
				var er = '';
				$.each(err, function(k, v) {
					if(k == 'file'){ 
						$('.admin_errors.alert-danger').show();
						$('.admin_errors.alert-danger ul').append('<li>'+v+'</li>');			 
					} 
				});
			}
			 
			else if(response == '|success'){
					
					$.notify({
					  message: 'Data Updated Successfully!!' 
					 },{ element: 'body', type: "success", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
					});
				
				
			window.setTimeout(function() { location.reload(); }, 1000); 			
		}

		},
		error: function(data){
			$("#sub_btn2").html('Submit');
			var errors = data.responseJSON;
			$(".wait_loader").hide();
			console.log(errors.errors);
			$.each(errors.errors, function(key, value){
				$('.admin_errors.alert-danger').show();
				$('.admin_errors.alert-danger ul').append('<li>'+value+'</li>');
			});
		}
	});
});

//Api Settings
$("#apiForm").submit(function(e){
	$('.wait_loader').show();	
	$('.admin_errors.alert-danger').hide();
	$('.admin_errors.alert-danger ul').html('');
	e.preventDefault();
	$("#sub_btn3").html('please wait..'); 
	$('.error').html('');
	$.ajax({
		type: "POST",
		url: '<?php echo route('api-settings-save');?>',
		data:  new FormData(this),
		processData:false,
		contentType:false,
		cache:false,
		datatype:"json",	
		success: function(response)
		{
			$("#sub_btn3").html('Submit'); 
			$('.wait_loader').hide();	
			var result = response.split("|"); 
			 if(result[0].length != 0){
				var err = JSON.parse(result[0]);
				var er = '';
				$.each(err, function(k, v) {
					if(k == 'file'){ 
						$('.admin_errors.alert-danger').show();
						$('.admin_errors.alert-danger ul').append('<li>'+v+'</li>');			 
					} 
				});
			}
			 
			else if(response == '|success'){
					
					$.notify({
					  message: 'Data Updated Successfully!!' 
					 },{ element: 'body', type: "success", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
					});
				
				
			window.setTimeout(function() { location.reload(); }, 1000); 			
		}

		},
		error: function(data){
			$("#sub_btn3").html('Submit');
			var errors = data.responseJSON;
			$(".wait_loader").hide();
			console.log(errors.errors);
			$.each(errors.errors, function(key, value){
				$('.admin_errors.alert-danger').show();
				$('.admin_errors.alert-danger ul').append('<li>'+value+'</li>');
			});
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
