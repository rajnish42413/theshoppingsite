@extends('dashboard.dashboard_layouts.app')

@section('dashboard_content')
	<!-- /.col-gl-3 col-md-3 col-sm-12 -->
	<div class="col-gl-9 col-md-9 col-sm-12">
		<h3 class="mb-4"><?php echo $data['title'];?></h3>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="widget">
					<div class="header">
						<div class="changepass_errors mt-2 alert alert-danger" style="display:none;">
							<ul class="nav"></ul>
						</div>										
					</div>
					<div class="body">
						<form action="searchajaxbooking" method="post" id="bookingfrm" style="display:none">
						  {{csrf_field()}}
						<div class="row margin">
						   <div class="col-lg-3 col-xs-6">
								<select name="filter1" class="form-control" id="filter1">
									<option value="0">All Booking</option>
									<option value="1">Upcoming Booking</option>
									<option value="2">Recent Booking</option>
								</select>
							</div>       
							<div class="col-lg-3 col-xs-6">
							<button type="button" id="filter_submit" name="filter_submit" class="btn btn-primary btn-block">Filter</button>
							</div>
						</div>
						</form>	 
						<input type="hidden" id="booking-status" value="<?php echo $data['booking_status'];?>">
		
						<div class="table-responsive">
						<input type="text" value="" id="checked_ids" style="display:none">
							<table id="bookingTable" class="table table-striped table-hover">
								<thead>
									<tr>
										<th style="width:40px">
											 <span class="custom-checkbox">
											 <input name="select_all" value="1" id="example-select-all" type="checkbox" class="form-control"/>
											 <label for="select-all"></label>
											 </span>
										 </th>											 
										<th style="width:450px;">Order Details</th>
										<th>Payment Date</th>
										<th>Price</th>
										<th>Order Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								</tbody>									
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
