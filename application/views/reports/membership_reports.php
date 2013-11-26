<script type="text/javascript">
	
	var reports = {
		
		 
		
	}

$(document).ready( function () {
  
	var startDate = $('#startDate').datepicker({
		onRender: function(date) {
			//return date.valueOf() < now.valueOf() ? 'disabled' : '';
		}
	}).on('changeDate', function(ev) {
		if (ev.date.valueOf() > startDate.date.valueOf()) {
			var newDate = new Date(ev.date)
			newDate.setDate(newDate.getDate() + 1);
			startDate.setValue(newDate);
		}
		startDate.hide();
		$('#endDate')[0].focus();
		 
	}).data('datepicker');


	var endDate = $('#endDate').datepicker({
			onRender: function(date) {
				return date.valueOf() <= startDate.date.valueOf() ? 'disabled' : '';
			}
		}).on('changeDate', function(ev) {
			endDate.hide();
		}).data('datepicker');		

})
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
	
		<!--<div class="form-group">
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
		</div>-->
		
		<div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label">Date Range</label>
			<div class="col-sm-2">
				<input type="text" name="startDate" id="startDate" value="" placeholder="" class="form-control"/>
			</div> 			
			<div class="col-sm-2">
				<input type="text" name="endDate" id="endDate" value="" placeholder="" class="form-control"/>
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
