<script type="text/javascript">
 
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
		});		 

	});

</script>
 
	<div class="row" style="background-color: #fff; padding: 5px 3px">
		<!--<div class="pull-right filterribbon" style=" width: 680px; background-color: #333; box-shadow: 0 1px 3px #888888; color: #fff; height: 45x; text-shadow: 0 0 0 #000000; padding: 6px 14px 6px 15px; " >-->
		
		<div class="pull-left">
			<h4>Report <span class="glyphicon glyphicon-chevron-right" style="color:#333"></span> <a href="reports/invoice"><?php echo $title ?></a> </h4>  
	 	</div>
		
		<div class="pull-right filterribbon" style=" width: 680px;" >
			<form name="searchForm" method="get" action="reports/invoice/" >
				<input id="startdate" class="datepicker input-small" type="hidden" value="<?php echo  (isset($_GET['startdate']) AND $_GET['startdate']!='')?date("Y-m-d", strtotime($_GET['startdate'])):date("Y-m-d"); ?>" name="startdate">
				<input id="enddate" class="datepicker input-small" type="hidden" value="<?php echo (isset($_GET['enddate']) AND $_GET['enddate']!='')?date("Y-m-d", strtotime($_GET['enddate'])):date("Y-m-d"); ?>" name="enddate"> 				
				
				<div class="pull-right"  >	
					&nbsp;		  
					<button type="submit" class="btn btn-primary btn-sm">Generate Invoice</button>
					<button type="button" class="btn btn-warning btn-sm" onclick="generatereports.pdfinvoice()">Generete PDF Invoice</button>
				</div>

				<div id="reportrange" class="pull-right">
				    <i class="glyphicon glyphicon-calendar"></i> 
				    <!--<span><?php echo  (isset($_GET['startdate']) AND $_GET['startdate']!='')?date("F j, Y", strtotime($_GET['startdate'])):date("F j, Y", strtotime('-30 day')); ?> - <?php echo (isset($_GET['enddate']) AND $_GET['enddate']!='')?date("F j, Y", strtotime($_GET['enddate'])):date("F j, Y"); ?></span> <b class="caret"></b>-->
				    <span><?php echo  (isset($_GET['startdate']) AND $_GET['startdate']!='')?date("F j, Y", strtotime($_GET['startdate'])):date("F j, Y"); ?> - <?php echo (isset($_GET['enddate']) AND $_GET['enddate']!='')?date("F j, Y", strtotime($_GET['enddate'])):date("F j, Y"); ?></span> <b class="caret"></b>
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
					<td><strong>Amount</strong></td>  
				</tr>
			</thead>
			<tbody>
			<?php $amount = 0;foreach( $records as $row): $amount += $row->Amount; ?>
				<tr>  
					<td><?php echo $row->ai_fname.' '.$row->ai_lname; ?></td> 	
					<td><?php echo $row->Merchant_Ref; ?></td> 	
					<td><?php echo $row->Order_Date; ?></td> 	
					<td style="text-align:right"><?php echo $row->Amount; ?></td> 	
				</tr>
			<?php endforeach; ?>
				<tr>  
					<td>&nbsp;</td> 	
					<td>&nbsp;</td> 	
					<td style="color:red; font-weight: bold">Total</td> 	
					<td style="color:red; font-weight: bold; text-align:right"><?php echo number_format($amount, 2, '.', ','); ?></td> 	
				</tr>			
			</tbody>	
			
		</table> 

	</div> 
