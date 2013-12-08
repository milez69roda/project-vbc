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
		
		/* $('#transaction_list').dataTable({ 
				"sDom": "<'row'<'pull-right'f><'pull-left'l>r<'clearfix'>>t<'row'<'pull-left'i><'pull-right'p><'clearfix'>>",
				"sPaginationType": "bootstrap", 
				"bProcessing": true, 
				"bPaginate": true,		 
				"oLanguage": {
					"sLengthMenu": "Show _MENU_ Rows",
					"sSearch": "Search: "
				},						
				"iDisplayLength": 25,
				"aaSorting": [[ 8, 'desc' ]],
				"aoColumnDefs":[
					//{ 'bSortable': false, 'aTargets': [ 0, 11 ]}					 
				] 						
		});  */		

	});

</script>
 
	<div class="row" style="background-color: #fff; padding: 5px 3px">
		<!--<div class="pull-right filterribbon" style=" width: 680px; background-color: #333; box-shadow: 0 1px 3px #888888; color: #fff; height: 45x; text-shadow: 0 0 0 #000000; padding: 6px 14px 6px 15px; " >-->
		
		<div class="pull-left">
			<h4>Report <span class="glyphicon glyphicon-chevron-right" style="color:#333"> <a href="reports/terms"></span> <?php echo $title ?></a> </h4>  
	 	</div>
		
		<div class="pull-right filterribbon" style=" width: 680px;" >
			<form id="searchForm" name="searchForm" method="get" action="reports/terms/" >
				<input type="hidden" name="report_page" value="terms" />
				<input id="startdate" class="datepicker input-small" type="hidden" value="<?php echo  (isset($_GET['startdate']) AND $_GET['startdate']!='')?date("Y-m-d", strtotime($_GET['startdate'])):date("Y-m-d", strtotime('-30 day')); ?>" name="startdate">
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

			    
			    <div class="col-lg-3 pull-right" style="margin:0px; padding:0 3px">
					<select name="report_type" class="form-control" style="color: #333333; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25), 0 -1px 0 rgba(0, 0, 0, 0.1) inset;" >
						<option value="" >--All--</option>
						<option value="<?php echo TERM_ACTIVE; ?>" <?php echo (isset($_GET['report_type']) && $_GET['report_type'] == TERM_ACTIVE)?'selected':'' ?>>Activated/Reactivate</option>
						<option value="<?php echo TERM_EXPIRED; ?>" <?php echo (isset($_GET['report_type']) && $_GET['report_type'] == TERM_EXPIRED)?'selected':'' ?>>Expired</option>
						<option value="<?php echo TERM_SUSPENSION; ?>" <?php echo (isset($_GET['report_type']) && $_GET['report_type'] == TERM_SUSPENSION)?'selected':'' ?>>Suspended</option>
						<option value="<?php echo TERM_TERMINATION; ?>" <?php echo (isset($_GET['report_type']) && $_GET['report_type'] == TERM_TERMINATION)?'selected':'' ?>>Terminated</option>
						<option value="<?php echo TERM_ROLLING_MONTLY; ?>" <?php echo (isset($_GET['report_type']) && $_GET['report_type'] == TERM_ROLLING_MONTLY)?'selected':'' ?>>Rolling Monthtly</option>
						<option value="<?php echo TERM_EXTEND_6; ?>" <?php echo (isset($_GET['report_type']) && $_GET['report_type'] == TERM_EXTEND_6)?'selected':'' ?>>Extend 6 Months</option>
						<option value="<?php echo TERM_EXTEND_12; ?>" <?php echo (isset($_GET['report_type']) && $_GET['report_type'] == TERM_EXTEND_12)?'selected':'' ?>>Extend 12 Months</option>
						<option value="<?php echo TERM_DELETED; ?>" <?php echo (isset($_GET['report_type']) && $_GET['report_type'] == TERM_DELETED)?'selected':'' ?>>Deleted</option>
					</select>
			    </div>		 

				<div class="pull-right" style="font-size: 12px"><span class="glyphicon glyphicon-list" style="padding-top: 8px"></span> Filters: &nbsp;	</div>
			     	
			</form>
		</div>
	</div> 
	 
	<a href="javascript:void(0)" onclick="generatereports.export()"><span class="glyphicon glyphicon-save" style="color:#333; font-size:15px"></span>Export</a> 
	<div class="row">
		<?php if( isset($records['results']) ): ?>
		<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="transaction_list" style="font-size: 90%">
			<thead>
				<tr>
					<td>#</td>
					<?php foreach($records['header'] as $key=>$head): ?>	
					<td><strong><?php echo $head; ?></strong></td> 
					<?php endforeach; ?>
				</tr>
			</thead>
			<tbody>
			<?php $i = 1;foreach( $records['results'] as $row): ?>
				<tr>
				<td><?php echo $i; ?></td> 	
				<?php foreach( $records['header'] as $key=>$val ): ?>
					<td><?php echo $row->$key; ?></td> 	
				<?php endforeach; ?>
				</tr>
			<?php $i++; endforeach; ?>
			</tbody>	
			
		</table>
		<?php endif; ?> 
	</div> 
	<!--<div id="go_up" style=""><span class="glyphicon glyphicon-arrow-up"></span></div>-->