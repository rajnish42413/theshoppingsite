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
        <li><a href="<?php echo env('APP_URL');?>products-list"><?php echo $data['title'];?></a></li>
        <li class="active"><?php echo $data['sub_title'];?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	<div class="box">
		<div class="box-body">
      <!-- Small boxes (Stat box) -->
    <form action="searchajaxproducts" method="post" id="productsfrm">
      {{csrf_field()}}
	<div class="row margin">
	   <div class="col-lg-3 col-xs-6">
            <input id="name" name="name" value="" placeholder="Title" data-column="6" class="form-control"/>
        </div>
	   <div class="col-lg-3 col-xs-6">
			<select type="text" class="form-control" id="parent_id" name="parent_id" onchange="get_categories(this);">
				<option value="">--Select Parent Category--</option>
		<?php if($categories){
				foreach($categories as $category){?>
					<option value="<?php echo $category->categoryId;?>"><?php echo $category->categoryName;?></option>
		<?php } } ?>
			</select>
        </div> 	
	   <div class="col-lg-3 col-xs-6">
			<select type="text" class="form-control" id="cat_id" name="cat_id" onchange="get_excel_btn(this);">
				<option value="">--Select Category--</option>
			</select>
        </div>		
        <div class="col-lg-3 col-xs-6">
		<button type="button" id="filter_submit" name="filter_submit" class="btn btn-info btn-block">Filter</button>
        </div>
    </div>
    </form>
	<div class="row text-left margin" id="exportBtnDiv" style="display:none">
	<hr>
		<div class="col-lg-12 col-xs-12">
		<a href="#" id="exportBtn" class="btn btn-success btn-sm" target="_blank"><i class="fa fa-file-excel-o"></i> Export Products</a>
		</div>
	</div>
			
      <div class="row">
        <div class="col-lg-2 col-lg-offset-9 col-xs-6 text-center">
		<span class="badge label label-primary" id="selected_count" style="display:none;"></span>		
		</div>
        <div class="col-lg-1 col-xs-6 text-center">
		<a id="products_delete_btn" class="btn btn-danger btn-sm"  onclick="delete_row('productsTable','products-delete')" ><i class="fa fa-trash"></i> Delete</a>			
		</div>		
	  </div>
	  <div class="row">
        <div class="col-lg-12">
        <div class="dt-responsive table-responsive">
            <input type="text" value="" id="checked_ids" style="display:none">
                <table id="productsTable" class="table table-striped table-bordered display nowrap" >
                    <thead>
                        <tr>
                            <th style="width:50px"><input name="select_all" value="1" id="example-select-all" type="checkbox" /></th>
                            <th>Title</th>
                            <th>Parent Category</th>							
                            <th>Category</th>
                            <th>Price</th>
                            <th>Currency</th>
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
function get_categories(e){
	var ct = e.value;
	if(ct =="" || ct == null){
		$("#cat_id").html('<option value="">--Select Category--</option>');
	}else{
		$(".wait_loader").show();
		$.ajax({
			type: "POST",
			headers: {
			  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},			
			url: '<?php echo route('get-categories-by-parent');?>',
			data: {'parent_id':ct}, // serializes the form's elements.
			success: function(response)
			{ 
				$('.wait_loader').hide();
				$("#cat_id").html(response);										
			}
		});
	}
}

function get_excel_btn(e){
	var x = e.value;
	if(x != ''){
		$("#exportBtnDiv").show();
		get_export();
	}else{
		$("#exportBtnDiv").hide();
		}
}

function get_export(){
		var parent_id = $('#parent_id').val();
		var cat_id =  $('#cat_id').val();
	
		var url = '<?php echo env('APP_URL');?>excel-generate?parent_id='+parent_id+'&cat_id='+cat_id;
		
		$("#exportBtn").attr('href',url);
		
		
}
</script> 
@endsection
