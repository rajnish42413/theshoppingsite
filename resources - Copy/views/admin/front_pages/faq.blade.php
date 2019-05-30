@extends('admin.layouts.app')

@section('content')
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         <?php echo $data['title'].' - '.$data['sub_title'];?>
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
					  <label for="page_title"><span class="text-danger font_12"> * </span>Page Title</label>
					  <div class="input-group">
						<div class="input-group-addon"><i class="fa fa-edit"></i></div>
						<textarea name="page_title" class="form-control" ><?php if($row){ echo $row->page_title; } ?></textarea>
					  </div>
					  <div class="text-danger error font_12" id="page_title_error"></div>
					</div>
					<div class="form-group">
					  <label for="meta_keywords"><span class="text-danger font_12"> * </span>Meta Keywords</label>
					  <div class="input-group " id="testing">
						<div class="input-group-addon"><i class="fa fa-edit"></i></div>
							<input size="2" type="text" name="meta_keywords[]" class="form-control sugg-input" value="<?php if($row){ if(!empty($row->meta_keywords)){ echo $row->meta_keywords; }}?>" autocomplete="off" >
											
					  </div>
					  <small>(Type a comma to create a new keyword)</small>
					  <div class="text-danger error font_12" id="meta_keywords_error"></div>
					</div>					
					<div class="form-group">
					  <label for="meta_description"><span class="text-danger font_12"> * </span>Meta Description</label>
					  <div class="input-group">
						<div class="input-group-addon"><i class="fa fa-edit"></i></div>
						<textarea name="meta_description" id="meta_description" class="form-control" ><?php if($row){ echo $row->meta_description; } ?></textarea>
					  </div>
					  <div class="text-danger error font_12" id="meta_description_error"></div>
					</div>
					
					
			<hr>
			  <div class="row">
				  <div class="col-lg-12">
				  <h5>Questions-Answers</h5>
					  <div class="table-responsive">
								  <table id="example1" class="table table-bordered table-striped" cellspacing="0" width="100%">
								<thead>
								<tr>
									<th>Question</th>
									<th>Answer</th>
									<th style="width:20px;"></th>
								</tr>
								</thead>
								<tbody>
								<?php if($faqs){
									foreach($faqs as $faq){
									?>
								<tr class="row_class">
									<td>
										<div class="input-group">
											<div class="input-group-addon"><i class="fa fa-question-circle"></i></div>
											<textarea name="question[]" class="form-control question" ><?php echo $faq->question;?></textarea>
										</div>								
									</td>
									<td>
										<div class="input-group">
											<div class="input-group-addon"><i class="fa fa-edit"></i></div>
											<textarea name="answer[]" class="form-control answer" ><?php echo $faq->answer; ?></textarea>
										</div>								
									</td>
									<td>
										<input type="hidden" class="row_id" name="row_id[]" value="<?php echo $faq->id; ?>">
										<button type="button" onclick="remove_row(this);" class="btn btn-danger btn-block waves-effect waves-light m-r-10"><i class="fa fa-remove"></i></button>								
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
			<div class="row">
				<div class="col-lg-2">
					<a href="javascript:void(0)" id="add_row" onclick="add_row();" class="btn btn-default btn-xs waves-effect waves-light m-r-10"><i class="fa fa-plus"></i> Add Row</a>
				</div>
            </div>				
			<hr>
			
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
			  <input type="hidden" name="page_type" value="<?php if($row){ echo $row->page_type; }else{ echo 'faq';} ?>">
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
  
  
   <div id="row_data" style="display:none;">
   <table>
   <tbody>
	<tr class="row_class">
		<td>
			<div class="input-group">
				<div class="input-group-addon"><i class="fa fa-question-circle"></i></div>
				<textarea name="question[]" class="form-control question" ></textarea>
			</div>								
		</td>
		<td>
			<div class="input-group">
				<div class="input-group-addon"><i class="fa fa-edit"></i></div>
				<textarea name="answer[]" class="form-control answer" ></textarea>
			</div>								
		</td>
		<td>
			<input type="hidden" class="row_id" name="row_id[]" value="0">
			<button type="button" onclick="remove_row(this);" class="btn btn-danger btn-block waves-effect waves-light m-r-10"><i class="fa fa-remove"></i></button>								
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
	id = $(e).parent().find('.row_id').val();
	if(id!='0'){
		$.ajax({
			type: "POST",
			headers: {
			  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},			
			url: '<?php echo route('settings-faq-delete');?>',
			data: {'row_id':id},
			success: function(response)
			{ 
				$(e).parent().parent().remove();			
				
			}
		});		
	}else{
		$(e).parent().parent().remove();
	}
	
}

var bodies = [<?php if(!empty($meta_keywords)){ echo $meta_keywords; } ?>];
$('#testing input').suggester({
   data: bodies, 
   minChars: 1
});
</script>
<script>


$("#addForm").submit(function(e){
	$('.wait_loader').show();
	e.preventDefault();
	$('.admin_errors.alert-danger').hide();
	$('.admin_errors.alert-danger ul').html('');
	$("#sub_btn").html('please wait..'); 
	$('.error').html('');
	$.ajax({
		type: "POST",
		url: '<?php echo route('settings-page-save');?>',
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
					  message: '<?php echo $data['title'];?> Content Updated Successfully!!' 
					 },{ element: 'body', type: "success", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
					});
				<?php }else{ ?>
					
					$.notify({
					  message: '<?php echo $data['title'];?> Content Added Successfully!!' 
					 },{ element: 'body', type: "success", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
					 });
				<?php } ?>
				
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


 </script>

@endsection
