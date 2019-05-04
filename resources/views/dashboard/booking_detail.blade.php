@extends('dashboard.dashboard_layouts.app')

@section('dashboard_content')
	<!-- /.col-gl-3 col-md-3 col-sm-12 -->
	<div class="col-gl-9 col-md-9 col-sm-12">
		<h3 class="mb-4"><?php echo $data['title'];?><small><?php //echo $data['sub_title'];?></small></h3>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="widget">
					<div class="header">
						<div class="title hide">
						</div>
						<!-- /.title -->
					</div>
					<!-- /.header -->
				<?php if($results){?>							
					<div class="body">
						<div class="col-12">
						<?php foreach($results as $row){?>
							<div class="hotel-list-card">
								<div class="row">
									<div class="col-lg-3 col-md-12 col-sm-12">
										<div class="hotle-cover-img-box">
											<img src="<?php echo $row['thumbnail'];?>" alt="img alt" class="img-height-fix hotel-cover-img">

										</div>
										<!-- /.hotle-cover-img-box -->
									</div>
									<!-- /.col-lg-3 col-md-12 col-sm-12 -->
									<div class="col-lg-9 col-md-12 col-sm-12">
										<div class="p-3">
											<div class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 ">
													<div class="h5 hotel-name"><?php echo $row['item_name_heading'];?></div>
													<div class="hotel-description">
														<p><span>Room Basis : <?php echo $row['room_basis_name'];?></span></p>
														
														<p><span>Check-in/Check-out Date : <?php echo $row['book_date'];?></span></p>
														<p><span class="badge badge-secondary">Rooms - <?php echo $row['rooms'];?></span>
														 <span class="badge badge-secondary">Adults - <?php echo $row['adults'];?></span>
														 <span class="badge badge-secondary">Children - <?php echo $row['children'];?></span>
														</p>
													</div>
												</div>
											</div>
										</div>
									</div>											
								</div>
								<?php if($row['is_booked'] == '1'){?>
								<div class="row mt-4 text-center">
									<div class="col-lg-12 col-md-12 col-sm-12">
										<div class="p-3">
											<div class="row">
												<div class="col-lg-4 col-md-4 col-sm-12 ">
												<div class="h5 booking_code"><span class="text-secondary">Booking Code</span>
												<span class="badge-info badge"><?php echo $row['go_booking_code'];?></span></div>
												</div>
												<div class="col-lg-4 col-md-4 col-sm-12 ">
												
													<div class="h5 booking_status">
										
										<span class="text-secondary">Booking Status</span>
										<?php if($row['booking_status'] == 'C'){?>
											<span class="badge-success badge">Confirmed</span>
										<?php }elseif($row['booking_status'] == 'VCH'){?>
										<span class="badge-info badge">Voucher Requested</span>					
										<?php }elseif($row['booking_status'] == 'RJ'){?>
											<span class="badge-danger badge">Rejected</span>
										<?php }elseif($row['booking_status'] == 'X'){?>
											<span class="badge-danger badge">Cancelled</span>
										<?php }elseif($row['booking_status'] == 'RX'){?>
											<span class="badge-warning badge">Cancel Pending</span>
										<?php }elseif($row['booking_status'] == 'RQ'){?>
											<span class="badge-warning badge">Confirm Pending</span>
										<?php }else{?>
											<span class="badge-default badge">None</span>
										<?php } ?>
										
									</div>
												</div>
												<div class="col-lg-4 col-md-4 col-sm-12 ">
												<div class="h5">
												<button onclick="get_booking_status(this,<?php echo $row['id'];?>,'<?php echo $row['go_booking_code'];?>')" class="mt-3 btn-secondary btn btn-sm"><i class="fa fa-refresh mr-2"></i> Check Status</button>
												</div></div>																	
											</div>
										</div>
									</div>											
								</div>
							<?php if($row['booking_status'] == 'C'){?>
								<hr>
								<div class="row mb-2 text-center">
									<div class="col-lg-12 col-md-12 col-sm-12">
										<div class="p-3">
											<div class="row">
												<div class="col-lg-6 col-md-6 col-sm-12 ">
												<button type="button" onclick="cancel_booking(this,<?php echo $row['id'];?>,'<?php echo $row['go_booking_code'];?>')" class="btn btn-danger theme-btn ">Cancel Booking</button>
												</div>
												<div class="col-lg-6 col-md-6 col-sm-12 ">
												
													<button type="button" onclick="voucher_detail(this,<?php echo $row['id'];?>,'<?php echo $row['go_booking_code'];?>')"  class="btn btn-info theme-btn ">Voucher Detail</button>
												</div>
											
											</div>
										</div>
									</div>											
								</div>
						<?php } ?>
						<?php }else{?>
						<div class="row mt-4 text-center">
							<div class="col-lg-12 col-md-12 col-sm-12">
								<h5 class="text-danger">
									* Booking for this offer is not done please contact admin.
								</h5>
							</div>
						</div>
						<?php } ?>
							</div>
						<?php } ?>
						</div>
					</div>
				<?php }else{ ?>
					<div class="body">
						<div class="row text-center">
							<div class="col-lg-12 col-md-12 col-sm-12">
								<h3 class="text-danger"> No Booking Found !	<br>
								<br><i class="fa fa-warning fa-3x"></i></h3>
								<br>
								<a href="<?php echo env('APP_URL').'home'?>" class="btn btn-primary mt-4">Go To Home</a><br>
							</div>
						</div>
					</div>
				<?php } ?>
				</div>
			</div>
		</div>
	</div>
				

		<!-- Price Break Down Window-->
		<div class="modal fade" id="voucher_detail" tabindex="-1" role="dialog" aria-labelledby="voucher_detailLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content" id="voucher_detailLabel">
					<div class="modal-body">
												
						<!-- Tab panels -->
						<div class="tab-content">
						
							<!-- Employer Panel 1-->
							<div class="tab-pane fade in show active" id="myvoucher" role="tabpanel">
								
							</div>
							<!--/.Panel 1-->
							
						</div>
						<!-- Tab panels -->
					</div>
				</div>
			</div>
		</div>
		<!-- End Price Break Down Window -->	
		
<script>
	function get_booking_status(e,cid,bcode){
		var ihtml = '';
		$('.wait_loader').show();
		$.ajax({
			type: "POST",
			url: '<?php echo route("check-booking-status");?>',
			data:  {'booking_code':bcode,'cart_item_id':cid},	
			success: function(response)
			{ 
				$('.wait_loader').hide();
				if(response == 'error'){
					alert('Some Error Occured.');
				}else{
						ihtml = '<span class="font-bold">Booking Status</span>';
					if(response == 'C'){
						ihtml += '<span class="badge-success badge">Confirm</span>';
					}else if(response == 'VCH'){
						ihtml += '<span class="badge-info badge">Voucher Requested</span>';
					}
					else if(response == 'RJ'){
						ihtml += '<span class="badge-danger badge">Rejected</span>';
					}else if(response == 'X'){
						ihtml += '<span class="badge-danger badge">Cancelled</span>';
					}else if(response == 'RX'){
						ihtml += '<span class="badge-warning badge">Cancel Pending</span>';
					}else if(response == 'RQ'){
						ihtml += '<span class="badge-warning badge">Confirm Pending</span>';
					}else{
						ihtml += '<span class="badge-default badge">None</span>';
					}
					$(e).parent().find('.booking_status').html(ihtml);					
				}
				
			}
		});
	}
	
	function cancel_booking(e,cid,bcode){
		if(confirm('Are you sure to cancel this booking?')){
			$('.wait_loader').show();
			$.ajax({
				type: "POST",
				url: '<?php echo route("cancel-booking");?>',
				data:  {'booking_code':bcode,'cart_item_id':cid},	
				success: function(response)
				{ 
					$('.wait_loader').hide();
					if(response == 'error'){
						$.notify({
						  message: 'This Booking Not Cancelled' 
						 },{ element: 'body', type: "danger", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000
						 });
						 return false;
					}else if(response == 'RX'){
						var ihtml = '<span class="font-bold">Booking Status</span>';
						ihtml += '<span class="badge-warning badge">Cancel Pending</span>';
						$(e).parent().parent().parent().find('.booking_status').html(ihtml);	
					
						$.notify({
						  message: 'Booking Cancel Requested Successfully' 
						 },{ element: 'body', type: "success", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000
						 });
						window.setTimeout(function() { location.reload(); }, 1000);							 
						}else if(response == 'X'){
							var ihtml = '<span class="font-bold">Booking Status</span>';
							ihtml += '<span class="badge-danger badge">Cancelled</span>';
							$(e).parent().parent().parent().find('.booking_status').html(ihtml);	
					
							$.notify({
							  message: 'Booking Cancelled Successfully' 
							 },{ element: 'body', type: "success", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000
							 });
							window.setTimeout(function() { location.reload(); }, 1000);
						}
					}
				});
		}else{
			return false;
		}
	}

	function voucher_detail(e,cid,bcode){
		$('.wait_loader').show();
		$.ajax({
			type: "POST",
			url: '<?php echo route("voucher-detail");?>',
			data:  {'booking_code':bcode,'cart_item_id':cid},	
			success: function(response)
			{ 
				$('.wait_loader').hide();
				if(response == 'error'){
					$.notify({
					  message: 'Voucher request allowed only if booking status is confirmed' 
					 },{ element: 'body', type: "danger", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
					 });
					 return false;
				}else{
					$("#voucher_detail #myvoucher").html(response);
					$("#voucher_detail").modal('show');
				}
				
			}
		});
	}	


</script>

@endsection
