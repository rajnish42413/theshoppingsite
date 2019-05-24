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
        <li><a href="<?php echo env('APP_URL');?>navigation-menu-list"><?php echo $data['title'];?></a></li>
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
                  <label for="parent_id"><span class="text-danger">*</span> Parent</label>
				
                  <select onchange="get_link(this);" class="form-control js-example-basic-single" id="parent_id" name="parent_id" placeholder="Parent" >
					<option value="0" <?php if($row){ if($row->parent_id == 0){ echo 'selected';} }?>>No Parent</option>				  
				    <?php if($parents->count() > 0){
						foreach($parents as $parent){?>
					<option value="<?php echo $parent->id;?>" <?php if($row){ if($row->parent_id == $parent->id){ echo 'selected';} }?>><?php echo $parent->name;?>
					</option>
					<?php } } ?>
				  </select>

                </div>	
                <div class="form-group link_name" >
                  <label for="link_name"><span class="text-danger">*</span> Link</label>
                  <input type="text" class="form-control" id="link_name" name="link_name" placeholder="Enter Link" value="<?php if($row){ echo $row->link_name; }?>">
                </div>				
                <div class="form-group is_public" >
               
                  <input type="checkbox" class="" id="is_public"   onchange="change_is_public(this);"  <?php if($row){ if($row->is_public == '1'){ echo 'checked'; } }?>>
				  <input type="hidden" value="<?php if($row){ echo $row->is_public; }else{ echo '0';}?>" name="is_public" id="isPublic">
				     <label for="is_public" >Show to Non-Logged Users?</label>
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
function change_is_public(e){
	if(e.checked == true){
		$("#isPublic").val(1);
	}else{
		$("#isPublic").val(0);
	}
}
var surl = '<?php echo route('navigation-menu-list');?>'; 
$("#addForm").submit(function(e){
	$('.wait_loader').show();	
	$('.admin_errors.alert-danger').hide();
	$('.admin_errors.alert-danger ul').html('');
	e.preventDefault();
	$("#sub_btn").html('please wait..'); 
	$('.error').html('');
	$.ajax({
		type: "POST",
		url: '<?php echo route('navigation-menu-save');?>',
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


function get_link(e){
	var x = e.value;
	if(x!= 0){
		$(".is_public").show();
		$("#is_public").val('');
	}else{
		$(".is_public").hide();
		$("#is_public").val('#');
	}
}

    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
 </script>
 
@endsection
