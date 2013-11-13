<script type="text/javascript">
	var processing = false;
	var uploadscheduledpayments = {
		 
		
	}

$(document).ready( function () {
  
});

</script>

	<div class="row">
		<h4>Reports - Upload Scheduled Payments</h4> <hr />   
 	</div>
	<div class="alert alert-danger">Please click the Check button first before saving.</div>	
	<div class="row">  
		<?php if(isset($results)): ?>
		<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="transaction_list" style="font-size: 90%">
			<tr>
				<th>Master Sch Id.</th>
				<th>Detail Sch Id.</th>
				<th>Merchant Ref.</th>
				<th>Order Date</th>
				<th>Tran Date</th>
				<th>Amount</th>
				<th>Payment Ref.</th>
				<th>Status</th>
				
			</tr>
			<?php foreach($results as $row): ?>
			<tr>
				<td><?php echo @$row[0]; ?></td>
				<td><?php echo @$row[1]; ?></td>
				<td><?php echo @$row[2]; ?></td>
				<td><?php echo @$row[3]; ?></td>
				<td><?php echo @$row[4]; ?></td>  
				<td><?php echo @$row[5].' '.@$row[6]; ?></td>
				<td><?php echo @$row[7]; ?></td> 
				<td><?php echo @$row[8]; ?></td> 
			</tr>
			<?php endforeach; ?>
		</table>
		<?php endif; ?>
		
		<form role="form" name="form1" method="post" action=""> 
			<textarea class="form-control" rows="15" style="width: 800px" name="txt_payments"><?php echo $uploaded_data; ?></textarea>  
			<br />
			<button type="submit" class="btn btn-warning" value="check">Check</button> 
			<button type="submit" class="btn btn-primary" name ="Save" value="Save">Save</button> 
			<!--<input type="submit" class="btn btn-primary" name="Save" value="Save" />-->
		</form>
	 
 
	</div> 
