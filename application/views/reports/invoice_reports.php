<script type="text/javascript">
 
	$(document).ready( function () { 

/* 		$('#reportrange').daterangepicker({
				ranges: {
					'Today': [moment(), moment()],
					'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
					'Last 7 Days': [moment().subtract('days', 6), moment()],
					'Last 30 Days': [moment().subtract('days', 29), moment()],
					'This Month': [moment().startOf('month'), moment().endOf('month')],
					'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
				},
				startDate: moment(),
				//startDate: moment(),
				endDate: moment()
			},
			function(start, end) {
				$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
				$(".filterribbon input[name='startdate']").val(start.format('YYYY-MM-DD'));
				$(".filterribbon input[name='enddate']").val(end.format('YYYY-MM-DD'));
				$(".filterribbon button[type=submit]").click();	        

				console.log(start.format('YYYY-MM-DD')+' - '+start.format('YYYY-MM-DD'))
			}
		);

		$(".daterangepicker li.active").each(function(){
			$(this).removeClass('active'); 
		});	 */	 
		
		$("#startdate").datepicker({ 'autoclose': true, 'format': 'yyyy-mm-dd' })
		.on('changeDate', function(ev){
			$(this).datepicker('hide');
		});
		
		
		$("#enddate").datepicker({ 'autoclose': true, 'format': 'yyyy-mm-dd' })
		.on('changeDate', function(ev){
			$(this).datepicker('hide');
		});		

	});

</script>
 
	<div class="row" style="background-color: #fff; padding: 5px 3px">
		<!--<div class="pull-right filterribbon" style=" width: 680px; background-color: #333; box-shadow: 0 1px 3px #888888; color: #fff; height: 45x; text-shadow: 0 0 0 #000000; padding: 6px 14px 6px 15px; " >-->
		
		<div class="">
			<h4>Report <span class="glyphicon glyphicon-chevron-right" style="color:#333"></span> 
				<a href="reports/invoice"><?php echo $title ?></a> 
				<?php echo (isset($_GET['ref']) AND $_GET['ref'] != '')?'<span class="glyphicon glyphicon-chevron-right" style="color:#333"></span>'.$_GET['ref']:''; ?>
			</h4>  
	 	</div>
		
		<div class="filterribbon" style="" >
			<form name="searchForm" id="searchForminvoice" method="get" action="reports/invoice/" >
				<input type="hidden" name="ref" value="<?php echo @$_GET['ref'] ?>" />
 				<div class="pull-right" >	 
					&nbsp;		  
					<button type="submit" class="btn btn-primary btn-sm">Generate Invoice</button>
					<button type="button" class="btn btn-warning btn-sm" onclick="generatereports.pdfinvoice()">Generete PDF Invoice</button>
				</div>
	
				<div class="pull-right" style="padding-left: 20px"> 
					<label>From: </label><input id="startdate" class="datepicker input-small " style="width:100px; padding: 6px 12px;" type="text" value="<?php echo  (isset($_GET['startdate']) AND $_GET['startdate']!='')?date("Y-m-d", strtotime($_GET['startdate'])):date("Y-m-d"); ?>" name="startdate">
					<label>To:</label> <input id="enddate" class="datepicker input-small" style="width:100px; padding: 6px 12px;"  type="text" value="<?php echo (isset($_GET['enddate']) AND $_GET['enddate']!='')?date("Y-m-d", strtotime($_GET['enddate'])):date("Y-m-d"); ?>" name="enddate"> 						
				</div>  
				
				<div class="pull-right" style="padding-top: 5px">
					&nbsp;<label>No Date: </label>&nbsp;<input type="checkbox" <?php echo  (isset($_GET['bypass']))?'checked':''; ?> value="1" name="bypass" /> 
				</div>
				
			    <div class="col-sm-3 pull-right" style="margin:0px; padding:0 3px">
					<select name="report_type" class="form-control" style="color: #333333; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25), 0 -1px 0 rgba(0, 0, 0, 0.1) inset;" >
						<option value="0" <?php echo (isset($_GET['report_type']) && $_GET['report_type'] == 0)?'selected':'' ?>>All Payments</option>
						<option value="1" <?php echo (isset($_GET['report_type']) && $_GET['report_type'] == 1)?'selected':'' ?>>Success Payments</option>
						<option value="2" <?php echo (isset($_GET['report_type']) && $_GET['report_type'] == 2)?'selected':'' ?>>Failed Payments</option> 
					</select>
					
			    </div>						
				
				<div class="pull-right" style="font-size: 12px"><span class="glyphicon glyphicon-list" style="padding-top: 8px"></span> Filters: &nbsp;	</div>
			     	
			</form>
		</div>
	</div> 
	 
	<div class="row">
	   
		<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="transaction_list" style="font-size: 90%">
			<thead>
				<tr> 
					<td><strong>Name</strong></td>  
					<td><strong>Ref No.</strong></td>  
					<td><strong>Date</strong></td>     
					<td align="center"><strong>Failed (Amt)</strong></td>  
					<td align="center"><strong>Success (Amt)</strong></td>  
				</tr>
			</thead>
			<tbody>
			<?php 
				$amount_sucess = 0;
				$amount_failed = 0;
				foreach( $records as $row): 
					
					if( $row->status=="Accepted" ) $amount_sucess += $row->success; 
					else $amount_failed += $row->failed; 
			?>
				<tr>  
					<td><?php echo $row->ai_fname.' '.$row->ai_lname; ?></td> 	
					<td><a href="reports/invoice/?bypass=1&ref=<?php echo $row->Merchant_Ref; ?>" ><?php echo $row->Merchant_Ref; ?></a></td> 	
					<td><?php echo $row->Order_Date; ?></td> 	
					<td style="text-align:right"><?php echo $row->failed; ?></td>  
					<td style="text-align:right"><?php echo $row->success; ?></td> 	
				</tr>
			<?php endforeach; ?>
				<tr>  
					<td>&nbsp;</td> 	
					<td>&nbsp;</td> 	
					<td style="color:red; font-weight: bold">Total Failed Payment</td> 	
					<td style="color:red; font-weight: bold; text-align:right"><?php echo number_format($amount_failed, 2, '.', ','); ?></td> 	
					<td>&nbsp;</td> 	
				</tr>
				<tr>  
					<td>&nbsp;</td> 	
					<td>&nbsp;</td> 	
					<td style="color:green; font-weight: bold">Total Success Payment</td> 	
					<td>&nbsp;</td> 	
					<td style="color:green; font-weight: bold; text-align:right"><?php echo number_format($amount_sucess, 2, '.', ','); ?></td> 	
				</tr>			
			</tbody>	
			
		</table> 

	</div> 
