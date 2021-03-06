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
        <li><a href="<?php echo env('APP_URL');?>trending-products-list"><?php echo $data['title'];?></a></li>
        <li class="active"><?php echo $data['sub_title'];?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
       <div class="col-md-offset-1 col-md-10 col-xs-12">
          <!-- general form elements -->
          <div class="box box-primary" id="form_box">
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
                  <label for="heading_title"><span class="text-danger">*</span> Title</label>
                  <input type="text" class="form-control" id="pro_title" name="pro_title" placeholder="Title" value="<?php if($row){ echo $row->title; }?>" >
                </div>
                 <div class="form-group">
                  <label for="categories"><span class="text-danger">*</span> Category </label>
                  <select class="form-control js-example-basic-single" id="category" name="category" >
                  	<option value="">--Select Category--</option>
				<?php foreach($categories as $category){?>
					<option value="<?php echo $category->categoryId;?>" <?php if($row){ if($row->category_id == $category->categoryId){ echo 'selected';} }?> ><?php echo ucwords($category->categoryName);?></option>
				<?php } ?>
				  </select>
                </div>	
                
                			
                <div class="form-group">
                  <label for="file"><span class="text-danger">*</span> Image</label>
					<input type="file" data-id="<?php if($row){echo $row->id;}?>" id="file" class="dropify" <?php if($row && !empty($row->image)){}else{ echo ' ';} ?>  name="file" data-default-file="<?php if($row){if(!empty($row->image)){  echo env("APP_URL").'/trending_products_files/'.$row->image;} }?>" />				  
                  <input type="hidden" id="file_name" name="file_name" value="<?php if($row){ echo $row->image; }?>">
                </div>
              	
               
                <div class="form-group">
                  <div class="">
				  <div class="row">
                  <div class="col-md-4">
				  <label for="url_link">Merchant1</label>
				  
				  <input type="text" class="form-control" id="merchant_name1" name="merchant_name1" placeholder="Name" value="<?php if($row){ echo $row->merchant1; }?>" >
				  </div>
				   <div class="col-md-4">
				  <label for="url_link">Price</label>
				   <input type="text" class="form-control" id="merchant_price1" name="merchant_price1" placeholder="Price" value="<?php if($row){ echo $row->price1; }?>" >
				  </div>
				  <div class="col-md-4">
				  <label for="url_link">Merchant1 link</label>
				   <input type="text" class="form-control" id="merchant_link1" name="merchant_link1" placeholder="URL" value="<?php if($row){ echo $row->link1; }?>" >
				  </div>
				  </div>
				  </div>
                </div>	
                
				 <div class="form-group">
                  <div class="">
				  <div class="row">
                  <div class="col-md-4">
				  <label for="url_link">Merchant2</label>
				  
				  <input type="text" class="form-control" id="merchant_name2" name="merchant_name2" placeholder="Name" value="<?php if($row){ echo $row->merchant2; }?>" >
				  </div>
				   <div class="col-md-4">
				  <label for="url_link">Merchant2 Price</label>
				   <input type="text" class="form-control" id="merchant_price2" name="merchant_price2" placeholder="Price" value="<?php if($row){ echo $row->price2; }?>" >
				  </div>
				  <div class="col-md-4">
				  <label for="url_link">Merchant2 link</label>
				   <input type="text" class="form-control" id="merchant_link2" name="merchant_link2" placeholder="URL" value="<?php if($row){ echo $row->link2; }?>" >
				  </div>
				  </div>
				  </div>
                </div>
				
				 <div class="form-group">
                  <div class="">
				  <div class="row">
                  <div class="col-md-4">
				  <label for="url_link">Merchant3</label>
				  
				  <input type="text" class="form-control" id="merchant_name3" name="merchant_name3" placeholder="Name" value="<?php if($row){ echo $row->merchant3; }?>" >
				  </div>
				   <div class="col-md-4">
				  <label for="url_link">Merchant3 Price</label>
				   <input type="text" class="form-control" id="merchant_price3" name="merchant_price3" placeholder="Price" value="<?php if($row){ echo $row->price3; }?>" >
				  </div>
				  <div class="col-md-4">
				  <label for="url_link">Merchant3 link</label>
				   <input type="text" class="form-control" id="merchant_link3" name="merchant_link3" placeholder="URL" value="<?php if($row){ echo $row->link3; }?>" >
				  </div>
				  </div>
				  </div>
                </div>
				
				
				
              <div class="form-group">
                  <label for="description"><span class="text-danger">*</span> Description</label>
                  <textarea rows="4" class="form-control" id="ckeditor1" name="description" ><?php if($row){ echo $row->description; }?></textarea>
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
 <script src="{{env('APP_URL')}}admin_assets/ckeditor/ckeditor.js"></script>
<script>
    $('.js-example-basic-single').select2();
</script>  
<script>
 $(function () {

       // Replace the <textarea id="ckeditor"> with a CKEditor
       	CKEDITOR.replace('ckeditor1');
       	//CKEDITOR.replace('new_desc');
       
       $("#sub_btn").click(function(){
           for (var i in CKEDITOR.instances){
   	        CKEDITOR.instances[i].updateElement();
   	      }
   	});
  });


function get_sub_categories(e){
	var ct = e.value;
	if(ct =="" || ct == null){
		$("#category").html('<option value="">--Select Category --</option>');
		
	}else{
		$(".small_loader").show();
		$.ajax({
			type: "POST",
			headers: {
			  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},			
			url: '<?php echo route('get-categories-by-parent');?>',
			data: {'parent_id':ct}, // serializes the form's elements.
			success: function(response)
			{ 
				$('.small_loader').hide();
				$("#sub_category").html(response);
								
			}
		});
	}
}



var surl = '<?php echo route('trending-products-list');?>'; 
$("#addForm").submit(function(e){
	$('.wait_loader').show();	
	$('.admin_errors.alert-danger').hide();
	$('.admin_errors.alert-danger ul').html('');	
	e.preventDefault();
	$("#sub_btn").html('please wait..'); 
	$('.error').html('');
	$.ajax({
		type: "POST",
		url: '<?php echo route('trending-products-save');?>',
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
			 $("html, body").animate({ scrollTop: 0 }, "slow");
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
