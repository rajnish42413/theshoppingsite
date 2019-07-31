@extends('admin.layouts.app')

@section('content')
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $data['sub_title'].' '.$data['title'];?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo env('APP_URL');?>banners-list"><?php echo $data['title'];?></a></li>
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
            <!-- form start -->
            <form role="form" id="addForm" enctype="multipart/form-data">
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
                  <label for="name"><span class="text-danger">*</span> Name</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="<?php if($row){ echo $row->name; }?>" >
                </div>
                <div class="form-group">
                  <label for="heading_title"><span class="text-danger">*</span> Heading</label>
                  <input type="text" class="form-control" id="heading_title" name="heading_title" placeholder="Heading" value="<?php if($row){ echo $row->heading_title; }?>" >
                </div>
                <div class="form-group">
                  <label for="description"><span class="text-danger">*</span> Description</label>
                  <textarea rows="4" class="form-control" id="description" name="description"><?php if($row){ echo $row->description; }?></textarea>
                </div>	
                <div class="form-group">
                  <label for="section_name"><span class="text-danger">*</span> Section</label>
                  <select class="form-control js-example-basic-single" id="section_name" name="section_name">
				<?php foreach($section_names as $sn){?>
					<option value="<?php echo $sn->value;?>" <?php if($row){ if($row->section_name == $sn->value){ echo 'selected';} }?> ><?php echo ucwords($sn->label);?></option>
				<?php } ?>
				  </select>
                </div>				
                <div class="form-group">
                  <label for="file"><span class="text-danger">*</span> Image</label>
					<input type="file" data-id="<?php if($row){echo $row->id;}?>" id="file" class="dropify" <?php if($row && !empty($row->display_image)){}else{ echo ' ';} ?>  name="file" data-default-file="<?php if($row){if(!empty($row->display_image)){  echo env("APP_URL").'/banner_files/'.$row->display_image;} }?>" />				  
                  <input type="hidden" id="file_name" name="file_name" value="<?php if($row){ echo $row->display_image; }?>">
                </div>
                <div class="form-group">
                  <label for="url_link">URL</label>
                  <input type="text" class="form-control" id="url_link" name="url_link" placeholder="URL" value="<?php if($row){ echo $row->url_link; }?>" >
                </div>				
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
				<input type="hidden" name="id" id="id" value="<?php if($row){ echo $row->id; }?>" >
                <button type="submit" class="btn btn-primary" id="sub_btn">Submit</button>
              </div>
            </form>
          </div>
          <!-- /.box -->

        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  
<script>
    $('.js-example-basic-single').select2();
</script>  
<script>

var surl = '<?php echo route('banners-list');?>'; 
$("#addForm").submit(function(e){
	$('.wait_loader').show();	
	$('.admin_errors.alert-danger').hide();
	$('.admin_errors.alert-danger ul').html('');	
	e.preventDefault();
	$("#sub_btn").html('please wait..'); 
	$('.error').html('');
	$.ajax({
		type: "POST",
		url: '<?php echo route('banners-save');?>',
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

				<?php if($row){ ?>
					
					$.notify({
					  message: 'Data Updated Successfully!!' 
					 },{ element: 'body', type: "success", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
					});
				<?php }else{ ?>
					
					$.notify({
					  message: 'Data Added Successfully!!' 
					 },{ element: 'body', type: "success", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
					 });
				<?php } ?>
				
			window.setTimeout(function() { window.location = surl }, 1000); 			
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
