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
				startDate: moment().subtract('days', 29),
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
			<form name="searchForm" method="get" action="reports/freebies/" >
				<input id="startdate" class="datepicker input-small" type="hidden" value="<?php echo  (isset($_GET['startdate']) AND $_GET['startdate']!='')?date("Y-m-d", strtotime($_GET['startdate'])):date("F j, Y", strtotime('-30 day')); ?>" name="startdate">
				<input id="enddate" class="datepicker input-small" type="hidden" value="<?php echo (isset($_GET['enddate']) AND $_GET['enddate']!='')?date("Y-m-d", strtotime($_GET['enddate'])):date("Y-m-d"); ?>" name="enddate"> 				
				
				<div class="pull-right"  >	
					&nbsp;		  
					<button type="submit" class="btn btn-primary btn-sm">Generate Report</button>
				</div>

				<div id="reportrange" class="pull-right">
				    <i class="glyphicon glyphicon-calendar"></i>
				    <!--<span><?php echo date("F j, Y", strtotime('-30 day')); ?> - <?php echo date("F j, Y"); ?></span> <b class="caret"></b>-->
				    <span><?php echo  (isset($_GET['startdate']) AND $_GET['startdate']!='')?date("F j, Y", strtotime($_GET['startdate'])):date("F j, Y", strtotime('-30 day')); ?> - <?php echo (isset($_GET['enddate']) AND $_GET['enddate']!='')?date("F j, Y", strtotime($_GET['enddate'])):date("F j, Y"); ?></span> <b class="caret"></b>
				</div> 
				<div class="pull-right" style="font-size: 12px"><span class="glyphicon glyphicon-list" style="padding-top: 8px"></span> Filters: &nbsp;	</div>
			     	
			</form>
		</div>
	</div> 
	 
	<div class="row">
	  
		<h1 style="color:red">Under Construction!!!!</h1>

	</div> 
