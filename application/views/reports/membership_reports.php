<script type="text/javascript">
	
	var generatereports = {
		
			membership: function( form ){

		  }
	} 

	$(document).ready( function () { 

		$('#reportrange').daterangepicker({
				ranges: {
					'Today': [moment(), moment()],
					'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
					'Last 7 Days': [moment().subtract('days', 6), moment()],
					'Last 30 Days': [moment().subtract('days', 29), moment()],
					'This Month': [moment().startOf('month'), moment().endOf('month')],
					'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
				},
				startDate: moment().subtract('days', 29),
				endDate: moment()
			},
			function(start, end) {
				$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
				$(".filterribbon input[name='startdate']").val(start.format('YYYY-MM-DD'));
				$(".filterribbon input[name='enddate']").val(end.format('YYYY-MM-DD'));
				//$(".filterribbon button[type=submit]").click();	        

				console.log(start.format('YYYY-MM-DD')+' - '+start.format('YYYY-MM-DD'))
			}
		);

	});

</script>
 
	<div class="row" style="background-color: #fff; padding: 5px 3px">
		<!--<div class="pull-right filterribbon" style=" width: 680px; background-color: #333; box-shadow: 0 1px 3px #888888; color: #fff; height: 45x; text-shadow: 0 0 0 #000000; padding: 6px 14px 6px 15px; " >-->
		
		<div class="pull-left">
			<h4>Report <span class="glyphicon glyphicon-chevron-right" style="color:#333"></span> Membership</h4>  
	 	</div>
		<div class="pull-right filterribbon" style=" width: 680px;" >
			<form name="searchForm" method="post" action="" >
				<input id="startdate" class="datepicker input-small" type="hidden" value="2013-10-29" name="startdate">
				<input id="enddate" class="datepicker input-small" type="hidden" value="2013-11-27" name="enddate">
				<input id="week" class="input-mini" type="hidden" value="0" name="week">
				<input id="year" type="hidden" value="0" name="year">	
				
				
				<div class="pull-right"  >	
					&nbsp;		  
					<button type="submit" class="btn btn-primary btn-sm">Generate Report</button>
				</div>

				<div id="reportrange" class="pull-right">
				    <i class="glyphicon glyphicon-calendar"></i>
				    <span><?php echo date("F j, Y", strtotime('-30 day')); ?> - <?php echo date("F j, Y"); ?></span> <b class="caret"></b>
				</div>

			    
			    <div class="col-lg-3 pull-right" style="margin:0px; padding:0 3px">
					<select class="form-control" style="color: #333333; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25), 0 -1px 0 rgba(0, 0, 0, 0.1) inset;" >
						<option value="0">Sign-ups</option>
						<option value="1">Terminated</option>
						<option value="2">Suspended</option>
						<option value="3">Current</option>
						<option value="4">Cash Payment</option>
						<option value="5">Credit Card</option>
					</select>
			    </div>		 

				<div class="pull-right" style="font-size: 12px"><span class="glyphicon glyphicon-list" style="padding-top: 8px"></span> Filters: &nbsp;	</div>
			     	
			</form>
		</div>
	</div> 
	<div class="row">
	  
		<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="transaction_list">
			<thead>
				<tr>
					<td>#</td> 
					<td><strong>Ref</strong></td>
					<td width="200px"><strong>Name</strong></td>
					<td width="100px"><strong>Membership</strong></td>
					<td><strong>Amount</strong></td>
					<td><strong>Phone</strong></td>
					<td><strong>Email</strong></td>
					<td><strong>Signup</strong></td> 
				</tr>
			</thead>
			<tbody>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>	
			</tbody>	
			
		</table>
		 
	</div> 
