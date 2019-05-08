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
            <form role="form" id="addForm">
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
				 <label for="is_deal_of_the_day"><span class="text-danger">*</span> Add On Deal Of The Day</label>
				<select type="text" class="form-control" id="is_deal_of_the_day" name="is_deal_of_the_day" >
					<option value="0" <?php if($row){ if($row->is_deal_of_the_day == 0){echo 'selected'; }} ?> >No</option>
					<option value="1" <?php if($row){ if($row->is_deal_of_the_day == 1){echo 'selected'; }} ?> >Yes</option>
				</select>
                </div>
				
                <div class="form-group">
				 <label for="is_top_product"><span class="text-danger">*</span> Top Product</label>
				<select type="text" class="form-control" id="is_top_product" name="is_top_product" >
					<option value="0" <?php if($row){ if($row->is_top_product == 0){echo 'selected'; }} ?> >No</option>
					<option value="1" <?php if($row){ if($row->is_top_product == 1){echo 'selected'; }} ?> >Yes</option>
				</select>
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
		url: '<?php echo route('products-save');?>',
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
					  message: '<?php echo $data['title'];?> Updated Successfully!!' 
					 },{ element: 'body', type: "success", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
					});
				<?php }else{ ?>
					
					$.notify({
					  message: '<?php echo $data['title'];?> Added Successfully!!' 
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

 
@endsection
