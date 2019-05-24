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
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo env('APP_URL');?>categories-list"><?php echo $data['title'];?></a></li>
        <li class="active"><?php echo $data['sub_title'];?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	<div class="box">
		<div class="box-body">
      <!-- Small boxes (Stat box) -->
    <form action="searchajaxcategories" method="post" id="categoriesfrm">
      {{csrf_field()}}
	<div class="row margin">
	   <div class="col-lg-2 col-xs-6">
            <input id="name" name="name" value="" placeholder="Title" data-column="6" class="form-control"/>
        </div>
	   <div class="col-lg-3 col-xs-6">
			<select class="form-control js-example-basic-single" id="parent_id" name="parent_id" onchange="get_categories(this);">
				<option value="">--Select Parent Category--</option>
		<?php if($categories){
				foreach($categories as $category){?>
					<option value="<?php echo $category->categoryId;?>"><?php echo $category->categoryName;?></option>
		<?php } } ?>
			</select>
        </div> 	
	   <div class="col-lg-3 col-xs-6">
			<select  class="form-control js-example-basic-single" id="cat_id" name="cat_id" onchange="get_sub_categories(this);">
				<option value="">--Select Category--</option>
			</select>
        </div>

	   <div class="col-lg-3 col-xs-6">
			<select  class="form-control js-example-basic-single" id="sub_cat_id" name="sub_cat_id">
				<option value="">--Select Category Level 3--</option>
			</select>
        </div>	
	
        <div class="col-lg-1 col-xs-6">
		<button type="button" id="filter_submit" name="filter_submit" class="btn btn-info btn-block">Filter</button>
        </div>
    </div>
    </form>	  
      <div class="row">
        <div class="col-lg-2 col-lg-offset-9 col-xs-6 text-center">
		<span class="badge label label-primary" id="selected_count" style="display:none;"></span>		
		</div>
        <div class="col-lg-1 col-xs-6 text-center">
		<a id="categories_delete_btn" class="btn btn-danger btn-sm"  onclick="delete_row('categoriesTable','categories-delete')" ><i class="fa fa-trash"></i> Delete</a>			
		</div>		
	  </div>
	  <div class="row">
        <div class="col-lg-12">
        <div class="dt-responsive table-responsive">
            <input type="text" value="" id="checked_ids" style="display:none">
                <table id="categoriesTable" class="table table-striped table-bordered display nowrap" >
                    <thead>
                        <tr>
                            <th style="width:50px"><input name="select_all" value="1" id="example-select-all" type="checkbox" /></th>
                            <th>Category Name</th>
                            <th>Parent Category</th>
                            <th>Cat Level 3</th>
                            <th>Cat Level 4</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
					<tbody>
					</tbody>
                </table>
            
        </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
	</div>
	</div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
    $('.js-example-basic-single').select2();
</script>
<script>
function get_categories(e){
	var ct = e.value;
	if(ct =="" || ct == null){
		$("#cat_id").html('<option value="">--Select Category--</option>');
		$("#sub_cat_id").html('<option value="">--Select Category Level 3--</option>');
		$("#sub2_cat_id").html('<option value="">--Select Category Level 4--</option>');
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
				$("#cat_id").html(response);										
				$("#sub_cat_id").html('<option value="">--Select Category Level 3--</option>');								
				$("#sub2_cat_id").html('<option value="">--Select Category Level 4--</option>');								
			}
		});
	}
}


function get_sub_categories(e){
	var ct = e.value;
	if(ct =="" || ct == null){
		$("#sub_cat_id").html('<option value="">--Select Category Level 3--</option>');
		$("#sub2_cat_id").html('<option value="">--Select Category Level 4--</option>');
	}else{
		$(".small_loader").show();
		$.ajax({
			type: "POST",
			headers: {
			  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},			
			url: '<?php echo route('get-sub-categories-by-parent');?>',
			data: {'parent_id':ct}, // serializes the form's elements.
			success: function(response)
			{ 
				$('.small_loader').hide();
				$("#sub_cat_id").html(response);
				$("#sub2_cat_id").html('<option value="">--Select Category Level 4--</option>');				
			}
		});
	}
}

</script>

@endsection
