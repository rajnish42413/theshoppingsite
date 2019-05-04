<?php if($row){?>
	<div class="row">												
		<div class="col-md-12 col-sm-12">
			<div class="user_dashboard_listed">
			<strong>Hotel Name:</strong>  <?php echo $row['HotelName'];?> 
			</div>	

			<div class="user_dashboard_listed">
			<strong>Address:</strong> <?php echo $row['Address'];?> 
			</div>		
			<div class="user_dashboard_listed">
			<strong>Phone:  </strong> <?php echo $row['Phone'];?>
			</div> 	
			<div class="user_dashboard_listed">
			<strong>Fax:  </strong> <?php echo $row['Fax'];?>
			</div> 	
			<div class="user_dashboard_listed">
			<strong>Check-in Date:  </strong> <?php echo $row['CheckInDate'];?>
			</div> 	
			<div class="user_dashboard_listed">
			<strong>Nights:  </strong> <?php echo $row['Nights'];?>
			</div> 			
			<div class="user_dashboard_listed">
			<strong>Rooms:  </strong> <?php echo $row['Rooms'];?>
			</div> 	
			<div class="user_dashboard_listed">
			<strong>Remarks:  </strong> <?php echo $row['Remarks'];?>
			</div>
			<div class="user_dashboard_listed">
			<strong>Booked & Payable By:  </strong> <?php echo $row['BookedAndPayableBy'];?>
			</div>
			<div class="user_dashboard_listed">
			<strong>Supplier Ref. No. :  </strong> <?php echo $row['SupplierReferenceNumber'];?>
			</div>			
			<div class="user_dashboard_listed">
			<strong>Emergency Phone:  </strong> <?php echo $row['EmergencyPhone'];?>
			</div>			
			
		</div>												
	</div>
<?php  }else{
	?>
	<h3>No Data Found!</h3>
	<?php 
} ?>