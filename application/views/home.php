	<script>
		
		var home = {
			
			_init: function(){
				
				$("#txtcarid").focus();
				
			},
			
			scan: function(){
				var txtcarid = $("#txtcarid");
				
				console.log('scan id');
			}
		
		}
		
		$(document).ready(function(){
			home._init();
		});
		
	</script>
	
	<?php if( $check_payments_today == 0): ?>
	<div class="row"> 
		<div class="alert alert-danger" style="color:red">ALERT: NO SCHEDULED PAYMENTS UPLOADED TODAY!!!</div>
 	</div>
	<?php endif; ?>
	
	<div class="row">
		<div class="panel panel-primary col-sm-5" style="padding-left: 0px; padding-right: 0px; margin-right: 5px">
			<div class="panel-heading">Expire in 35 days <em>(Total:<?php echo count($expired_35_days); ?>)</em></div>
			<div class="panel-body">
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="transaction_list" style="font-size: 90%">
					<thead>
						<tr> 
							<td><strong>Name</strong></td> 
							<td><strong>Ref No</strong></td> 
							<td><strong>Expiry Date</strong></td>
						</tr>
					</thead>	
					<tbody>
						<?php foreach($expired_35_days as $row):  ?>
						<tr>
							<td><?php echo $row->full_name; ?></td>
							<td><a href="javascript:void(0)" onclick="membershiptransaction.details('<?php echo $row->mem_id; ?>')" ><?php echo $row->pay_ref; ?></a></td>
							<td><?php echo date('d/m/Y', strtotime($row->exp_date)); ?></td> 
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>	
			</div>
		</div>	
 
		<div class="panel panel-primary col-sm-5" style="padding-left: 0px; padding-right: 0px"> 
			<div class="panel-heading">Failed Transactions <em>(Total:<?php echo count($failed_transaction); ?>)</em></div>
			<div class="panel-body">
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="transaction_list" style="font-size: 90%">
					<thead>
						<tr> 
							<td><strong>Name</strong></td> 
							<td><strong>Ref No</strong></td> 
							<td><strong>Date</strong></td> 
							<td><strong>Status</strong></td>
						</tr>
					</thead>	
					<tbody>
						<?php foreach($failed_transaction as $row):  ?>
						<tr>
							<td><?php echo $row->full_name; ?></td>
							<td><a href="javascript:void(0)" onclick="membershiptransaction.details('<?php echo $row->mem_id; ?>')" ><?php echo $row->pay_ref; ?></a></td>
							<td><?php echo date('d/m/Y', strtotime($row->Tran_Date)); ?></td> 
							<td><?php echo $row->status ?></td> 
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>	
		</div> 
		
	</div>
	<div class="row">
		<p>What to be display</p> 
		<p>Payment Transaction
			<ul>
				<li>Failed to upload previous Schedule Payment</li>
				<!--<li>Schedule payment with status [Suspend, Rejected]</li>
					<ol> 
						<li>Plan: Manual adding of payment on the schedule payment table to clear the failed payment. Need some clarification with willi</li>
					</ol>
				<li>In case of schedule payment failed.<li>	
					<ol>
						<li>Need to verify with willi if he would like to automatic update membership terms or status if the schedule payment is failed[rejected,suspend].
							if payment is rejected or suspend maybe it automatically update the status to inactive with terms of suspend[reason suspend or rejected payment via schedule payment].
						</li>
					</ol>-->
			</ul>
		</p>
		<p>Member with 35 days before expiry</p>
		<p>Note: There are lot of members with an expiry already been past more than a month(s)(more than 35 days), this need to be updated manually.</p>
	 
	</div>
	<div class="row">
		 		
	</div>      
