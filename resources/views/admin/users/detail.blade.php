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
        <li><a href="<?php echo env('APP_URL').$data['link'];?>" ><?php echo $data['title'];?></a></li>
        <li class="active"><?php echo $data['sub_title'];?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	<div class="box">
		<div class="box-body">
      <!-- Small boxes (Stat box) -->
    <form action="searchajaxorders" method="post" id="ordersfrm">
      {{csrf_field()}}
	<div class="row margin">
	   <div class="col-lg-3 col-xs-6">
            <input id="name" name="name" value="" placeholder="Name" data-column="6" class="form-control"/>
        </div>       
        <div class="col-lg-3 col-xs-6">
		<button type="button" id="filter_submit" name="filter_submit" class="btn btn-primary btn-block">Filter</button>
        </div>
    </div>
    </form>	  
      <div class="row">
        <div class="col-lg-2 col-lg-offset-9 col-xs-6 text-center">
		<span class="badge label label-primary" id="selected_count" style="display:none;"></span>		
		</div>
        <div class="col-lg-1 col-xs-6 text-center">
		<a id="top_order_delete_btn" class="btn btn-danger btn-sm"  onclick="delete_row('orderTable','top-orders-delete')" ><i class="fa fa-trash"></i> Delete</a>			
		</div>		
	  </div>
	  <div class="row">
        <div class="col-lg-12">
        <div class="dt-responsive table-responsive">
            <input type="text" value="" id="checked_ids" style="display:none">
                <table id="orderTable" class="table table-striped table-bordered display nowrap" >
                    <thead>
                        <tr>
                            <th style="width:50px"><input name="select_all" value="1" id="example-select-all" type="checkbox" /></th>
							<th>TXN ID</th>						
							<th>Client Name</th>
							<th>Payment Date</th>
							<th>Price</th>
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
 
@endsection
