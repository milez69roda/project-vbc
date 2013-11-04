<script type="text/javascript">
	var processing = false;
	var memberhipdetails = {
		
		mailUser: function(refno, type ){
			
			if( !processing ){
				processing = true;
				$.ajax({
					type: 'post',
					url: 'membership/ajax_membership_mail',
					data: {refno:refno, type:type},
					success: function(xhr){
						processing = false;	
					}
				});
			}else{
				alert('Please wait, there is still transaction being process.');
			}
			
		},
		
		update: function() {	
		
			var full_payment;
			var payment_mode;
			var ref = document.getElementById('ref').value;
			var tran_id = document.getElementById('tran_id').value;
			var pay_amt = document.getElementById('pay_amt').value;
			
			var active_date = document.getElementById('active_date').value;
			var due_date = document.getElementById('due_date').value;
			var exp_date = document.getElementById('exp_date').value;
			var full_payment0 = document.getElementById('full_payment0').checked;
			var full_payment1 = document.getElementById('full_payment1').checked;
			if(full_payment0==true){
				full_payment = document.getElementById('full_payment0').value;
			}else{
				full_payment = document.getElementById('full_payment1').value;
			}
			var payment_mode0 = document.getElementById('payment_mode0').checked;
			var payment_mode1 = document.getElementById('payment_mode1').checked;
			var payment_mode2 = document.getElementById('payment_mode2').checked;

			if(payment_mode0==true){
				payment_mode = document.getElementById('payment_mode0').value;
			}else if(payment_mode1==true){
				payment_mode = document.getElementById('payment_mode1').value;
			}else if(payment_mode2==true){
				payment_mode = document.getElementById('payment_mode2').value;
			}
			
			if(!processing) {
				processing = true;
				$.ajax({
					url: 'membership/ajax_membership_update',
					type: 'post',
					data: {ref:ref,tran_id:tran_id,pay_amt:pay_amt,active_date:active_date,due_date:due_date,exp_date:exp_date,full_payment:full_payment,payment_mode:payment_mode},
					success: function(xhr){
						processing = false;
						alert(xhr);
					}
				});
			}else{
				alert('Please wait, there is still transaction being process.');
			}
			
		},
		
		expire: function(stat){
	
			var ref = document.getElementById('ref').value;
			var tran_id = document.getElementById('tran_id').value;		
			if(!processing) {
				processing = true;
				$.post('membership/ajax_membership_expire',{ref:ref,tran_id:tran_id,stat:stat},function(xhr){
					processing = false;
					alert(xhr);
				});
			}else{
				alert('Please wait, there is still transaction being process.');
			}
		} 
	
	}
	
	$(document).ready( function () {
		 
	});

</script> 

	<div class="row">
		<h4><a href="membership">Complete Membership List</a> > Details</h4> <hr /> 
		<?php if( count($row) > 0): ?>
		
		<div class="pull-right">
		<a href="javascript:void(0)" onclick="memberhipdetails.mailUser('<?php echo base64_encode($row->pay_ref);?>','admin')">E-Admin</a> | 
		<a href="javascript:void(0)" onclick="memberhipdetails.mailUser('<?php echo base64_encode($row->pay_ref);?>','email')">E-Member</a> | 
		<a href="javascript:void(0)" onclick="memberhipdetails.mailUser('<?php echo base64_encode($row->pay_ref);?>','vanda')">E-Vanda</a> | 
		<a href="javascript:void(0)" onclick="memberhipdetails.mailUser('<?php echo base64_encode($row->pay_ref);?>','confirmation')">Activate</a>
		</div>
		
		
		<form class="form-horizontal" role="form" method="post" action=""> 
			<input type="hidden" name="token" value="<?php echo $id; ?>" />
			<input type="hidden" name="tran_id" id="tran_id" value="<?php echo $row->tran_id;?>">
			<table class="table table-striped table-bordered custom_table_details"> 
				<tbody>
					<tr>
						<th class="th_fixed_width_300px">Reference Number: </th>
						<td><input type="text" name="ref" id="ref" value="<?php echo $row->pay_ref;?>"></td>
					</tr>
					<tr>
						<th class="th_fixed_width_300px">Amount: </th>
						<td>$<input type="text" name="pay_amt" id="pay_amt" value="<?php echo $row->pay_amt; ?>"></td>
					</tr>
					<tr>
						<th class="th_fixed_width_300px">Membership: </th>
						<td><?php echo $row->mem_name ?></td>
					</tr>
					<tr>
						<th class="th_fixed_width_300px">Joined: </th>
						<td><input type="text" name="active_date"  id="active_date" value="<?php echo $row->active_date; ?>"></td>
					</tr>
					<tr>
						<th class="th_fixed_width_300px">Next Billing: </th>
						<td><input type="text" name="due_date" id="due_date" value="<?php echo $row->due_date; ?>"></td>
					</tr>
					<tr>
						<th class="th_fixed_width_300px">Expiry Date: </th>
						<td><input type="text" name="exp_date" id="exp_date" value="<?php echo $row->exp_date; ?>"></td>
					</tr> 
					<tr>
						<th class="th_fixed_width_300px">Name: </th>
						<td><?php echo $row->ai_fname." ".$row->ai_lname; ?></td>
					</tr> 
					<tr>
						<th class="th_fixed_width_300px">E-mail: </th>
						<td><?php echo $row->ai_email ?></td>
					</tr> 
					<tr>
						<th class="th_fixed_width_300px">Address: Unit/Blk #: </th>
						<td>#01-1984</td>
					</tr> 
					<tr>
						<th class="th_fixed_width_300px">Street: </th>
						<td><?php echo $row->street1 ?></td>
					</tr> 
					<tr>
						<th class="th_fixed_width_300px">Country: </th>
						<td><?php echo $country[$row->country]; ?></td>
					</tr> 
					<tr>
						<th class="th_fixed_width_300px">Postal Code: </th>
						<td><?php echo $row->postalcode ?></td>
					</tr>  
					<tr>
						<th class="th_fixed_width_300px">Phone: </th>
						<td><?php echo $row->ai_hp ?></td>
					</tr> 
					<tr>
						<th class="th_fixed_width_300px">Select Membership Payment Preference *: </th>
						<td>
							<div id="mpay">
							<input  name="full_payment" id="full_payment0" value="0" type="radio" <?php if($row->full_payment==0){?> checked <?php } ?>>
							<span class="texthead">Monthly Payment</span><br />
							</div>
							<input  name="full_payment" id="full_payment1" value="1" type="radio" <?php if($row->full_payment==1){?> checked <?php } ?>>
							<span class="texthead">Full Payment</span>
							<br />					
						</td>
					</tr> 
					<tr>
						<th class="th_fixed_width_300px">Select Membership Payment Mode *: </th>
						<td> 
							<input  name="payment_mode" id="payment_mode0" value="0" type="radio" <?php if($row->payment_mode==0){?> checked <?php } ?> onClick="payMode();">
							<span class="texthead">Pay Now via Credit Card <span class="mandatory"> *</span></span> <br />
							<input  name="payment_mode" id="payment_mode1" value="1" type="radio" <?php if($row->payment_mode==1){?> checked <?php } ?> onClick="payMode();">
							<span class="texthead">Direct Debit Standing order organised through your bank</span>
							<br /><br />
							<span class="texthead">Other Payment Mode</span><br />
							<input  name="payment_mode" id="payment_mode2" value="2" type="radio" <?php if($row->payment_mode==2){?> checked <?php } ?> onClick="payMode();">
							<span class="texthead">Cash Payment at the Club for the entire membership amount.</span> (Not available for monthly payments)
						
						</td>
					</tr>   
					<tr>
						<td></td>
						<td>
							<button type="button" class="btn btn-primary" onclick="memberhipdetails.update()">Update</button>
							<button type="button" class="btn btn-primary" onclick="memberhipdetails.expire(0)">Expire</button>
							<button type="button" class="btn btn-primary" onclick="memberhipdetails.expire(1)">Unexpire</button>
						</td>
					</tr>
				</tbody>
			
			</table>
		</form> 
		<?php else: ?>
		<div>
			<p>Not a valid member!</p>
		</div>
		<?php endif; ?>	
		
	</div> 
