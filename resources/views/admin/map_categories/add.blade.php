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
        <li><a href="<?php echo env('APP_URL');?>map-categories-list"><?php echo $data['title'];?></a></li>
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
				<h4>Merchants</h4>
                				
				<?php if($merchants && $merchants->count() > 0){
					foreach($merchants as $merchant){?>

					<div class="row m-t-1 merchant<?php echo $merchant->id;?>">
						<div class="col-md-4">
						  <input type="hidden" class="merchant_ids"  name="merchant_ids[]" value="<?php echo $merchant->id;?>" >
						   <label> <?php echo $merchant->name;?></label>				
						</div>
						<div class="col-md-8">
							<input type="text" placeholder="Categroy Name" class="form-control merchant_category_name merchant<?php echo $merchant->id;?>" name="merchant_category_name[]" value="" oninput="get_category_by_merchant(this,<?php echo $merchant->id;?>);">
							<input type="hidden" name="merchant_category_id[]" value="" class="merchant_category_id merchant<?php echo $merchant->id;?>">						
							
							
							<div class="search_results merchant<?php echo $merchant->id;?>">
							</div>							
						</div>
					</div>

                 
			
					<?php } } ?>
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

var getSearch = null;
function get_category_by_merchant(e,mid){
	if(e.value != ''){
		var keyword = e.value;
		
		if(keyword.length > 2){	
			$('.search_results.merchant'+mid).hide();		
			$(".searchLoader").show();
	getSearch = $.ajax({
				type: "POST",
				headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
				url: '<?php echo env('APP_URL') ?>get-category-by-merchant',
				data:{'keyword':keyword,'merchant_id':mid},	
				beforeSend : function()    {           
					if(getSearch != null) {
						getSearch.abort();
					}
				},				
				success: function(res)
				{ 
					$(".searchLoader").hide();
					if(res != ''){
						$('.search_results.merchant'+mid).html(res);
					}else{
					
						$('.search_results.merchant'+mid).html('<div class="row no-item"><div class="col-md-12"><span class="alert alert-danger">No Results Found.</span></div></div>');
					}
					$('.search_results.merchant'+mid).show();					
				}
			});
		}		
	}else{
		$('.search_results.merchant'+mid).html('');
		$('.search_results.merchant'+mid).hide();
		return false;		
	}
}

function selectCategory(e,mid,cid,name) {

$('.merchant_category_name.merchant'+mid).val(name);
$('.merchant_category_id.merchant'+mid).val(cid);
$('.search_results.merchant'+mid).html('');
$('.search_results.merchant'+mid).hide();
}

</script> 
<script>

var surl = '<?php echo route('map-categories-list');?>'; 
$("#addForm").submit(function(e){
	$('.wait_loader').show();	
	$('.admin_errors.alert-danger').hide();
	$('.admin_errors.alert-danger ul').html('');
	e.preventDefault();
	$("#sub_btn").html('please wait..'); 
	$('.error').html('');
	$.ajax({
		type: "POST",
		url: '<?php echo route('map-categories-save');?>',
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
 
@endsection
