<script type="text/javascript">
	var processing = false;
	var scheduledpayments = {
		
		 
		
	}

$(document).ready( function () {
 
	 
});

</script>

	<div class="row">
		<h4>Report > Signups</h4> <hr />   
 	</div>
	
	<div class="row">
	
	<form class="form-horizontal" role="form">
	
	
		<div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label">Type</label>
			<div class="col-sm-3">
				<select class="form-control input-sm">
					<option>Sign-ups</option>
					<option>Terminated</option>
					<option>Suspended</option>
					<option>Current</option>
					<option>Cash Payment</option>
					<option>Credit Card</option>
				</select>
			</div>
		</div>
	
		<div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label">&nbsp;</label>
			<div class="col-sm-3">
				<select class="form-control input-sm">
					<option>Daily</option>
					<option>Weekly</option>
					<option>Monthly</option>
					<option>Semi-Annual</option>
					<option>Annual</option> 
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label">&nbsp;</label>
			<div class="col-sm-4">
				<select class="form-control input-sm">
					<option>2010</option>
					<option>2011</option>
					<option>2012</option>
					<option>2013</option>
				</select>		
				
				<select class="form-control input-sm">
					<option>1st (Jan - Jun)</option>
					<option>2nd (Jul - Dec)</option> 
				</select>
				
				<select class="form-control input-sm">
					<option>1st Quarter</option> 
					<option>2nd Quarter</option> 
					<option>3rd Quarter</option> 
					<option>4th Quarter</option> 
				</select>

				
				<select class="form-control input-sm">
					<option value="1">January</option> 
					<option value="2">February</option> 
					<option value="3">March</option> 
					<option value="4">April</option> 
					<option value="5">May</option> 
					<option value="6">June</option> 
					<option value="7">July</option> 
					<option value="8">August</option> 
					<option value="9">September</option> 
					<option value="10">October</option> 
					<option value="11">November</option> 
					<option value="12">December</option> 
				</select>	

				<select class="form-control input-sm">
				<?php
				$getAllWeekRange_byYear = $this->common_model->getAllWeekRange_byYear('2013');
				 
				foreach($getAllWeekRange_byYear as $key => $daterange){ 
					echo '<option value="'.$daterange[0].'|'.$daterange[1].'">'.date('M d Y',strtotime($daterange[0])).' - '.date('M d Y',strtotime($daterange[1])).'</option>';
				}
				?>
				
				</select>
 
 
<br /> 
				
			</div> 			
		</div>
		
		<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
		  <button type="submit" class="btn btn-default">Generate Report</button>
		</div>
		</div>
	</form>
	
	 
		<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="transaction_list">
			<thead>
			<tr>
				<td>#</td>
				<!--<td><strong>Date Updated</strong></td>-->
				<td><strong>Ref</strong></td>
				<td width="200px"><strong>Name</strong></td>
				<td width="100px"><strong>Membership</strong></td>
				<td><strong>Amount</strong></td>
				<td><strong>Phone</strong></td>
				<td><strong>Email</strong></td>
				<td><strong>Signup</strong></td> 
			</tr>
			
		</table>
		 
	</div> 
