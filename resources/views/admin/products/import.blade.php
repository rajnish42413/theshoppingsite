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
        <li><a href="<?php echo env('APP_URL');?>products-list"><?php echo $data['title'];?></a></li>
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
                  <label for="file"><span class="text-danger">*</span> Upload File <span class="text-danger"><small> ( Only CSV, Excel, Zip & GZ Files are acceptable. )</small></span></label>
					<input class="form-control" name="file" id="file" type="file" required />				  
                  
                </div>		
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary" id="sub_btn">Submit</button>
              </div>
			  
              <div class="box-body">
				<div class="row">
					<div class="col-sm-12">	
						<a class="btn btn-warning btn-sm" href="<?php echo env('APP_URL');?>csv/test_file.csv"><i class="fa fa-download"></i> Download Sample File</a>
					</div>
				</div>
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

var surl = '<?php echo route('products-list');?>'; 
$("#addForm").submit(function(e){
$('.wait_loader').show();	
	e.preventDefault();
	$('.admin_errors.alert-danger').hide();
	$('.admin_errors.alert-danger ul').html('');
	$("#sub_btn").html('please wait..'); 
	$('.error').html('');
	$.ajax({
		type: "POST",
		url: '<?php echo route('products-import-save');?>',
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
					  message: '<?php echo $data['title'];?> Imported Successfully!!' 
					 },{ element: 'body', type: "success", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
					 });
				
			window.setTimeout(function() { window.location = surl }, 1000); 			
		}else if(response == '|error'){
					$.notify({
					  message: 'Only CSV, Excel, Zip & GZ Files are acceptable.' 
					 },{ element: 'body', type: "danger", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 500 
					 });			
		}else if(response == '|zip_error'){
					$.notify({
					  message: 'Your Zip file must contains csv/excel files only.' 
					 },{ element: 'body', type: "danger", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 500 
					 });			
		}else if(response == '|gz_error'){
					$.notify({
					  message: 'Your GZ file must contains csv/excel files only.' 
					 },{ element: 'body', type: "danger", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 500 
					 });			
		}else if(response == '|gz_error2'){
					$.notify({
					  message: 'Some Error Occured with your GZ File. Please upload another file.' 
					 },{ element: 'body', type: "danger", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 500 
					 });			
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
	var excelfile = file.type;
	//alert(file.type);
	var match =  ['text/csv','application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/x-zip-compressed','application/x-gzip'];
	 
	if(!(excelfile==match[0] || excelfile==match[1] || excelfile==match[2] || excelfile==match[3] || excelfile==match[4])){
		$.notify({
		  message: 'File format is wrong.' 
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
@endsection
