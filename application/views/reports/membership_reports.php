<script type="text/javascript">
	 
	$(document).ready( function () {  
	
		$("#startdate").datepicker({ 'autoclose': true, 'format': 'yyyy-mm-dd' })
		.on('changeDate', function(ev){
			$(this).datepicker('hide');
		});
		
		
		$("#enddate").datepicker({ 'autoclose': true, 'format': 'yyyy-mm-dd' })
		.on('changeDate', function(ev){
			$(this).datepicker('hide');
		});
		 
		
		/* $("#report_type").change(function(){
			var v = this.value;
			if(v == 0){
				$("#div_member_type").fadeIn();
			}else{
				$("#div_member_type").fadeOut();
			}
		}); */
		$("#option2").change(function(){
			var v = this.value;
			if(v == 0){
				$("#daterange").fadeOut();
			}else{
				$("#daterange").fadeIn();
			}
		});

	});

</script>
 
	<div class="row" style="background-color: #fff; padding: 5px 3px">
		<!--<div class="pull-right filterribbon" style=" width: 680px; background-color: #333; box-shadow: 0 1px 3px #888888; color: #fff; height: 45x; text-shadow: 0 0 0 #000000; padding: 6px 14px 6px 15px; " >-->
		
		<div>
			<h4>Report <span class="glyphicon glyphicon-chevron-right" style="color:#333"></span> <a href="reports/membership">Membership</a> </h4>  
	 	</div>
		
		<div class="filterribbon" style="" >
			<form id="searchForm" name="searchForm" method="get" action="reports/membership/" >
				<input type="hidden" name="report_page" value="membership" />
				 
				<div class="pull-right"  >	
					&nbsp;		  
					<button type="submit" class="btn btn-primary btn-sm">Generate Report</button>
					<button type="button" class="btn btn-warning btn-sm" onclick="generatereports.export()"><span class="glyphicon glyphicon-save" style="font-size:15px"></span>Export</button>
				</div>

				<div id="daterange" class="pull-right" style="padding-left: 20px; <?php echo (!isset($_GET['option2']) OR $_GET['option2'] == 0)?'display:none':'' ?>"> 
					<label>From: </label><input id="startdate" class="datepicker input-small " style="width:100px; padding: 6px 12px;" type="text" value="<?php echo  (isset($_GET['startdate']) AND $_GET['startdate']!='')?date("Y-m-d", strtotime($_GET['startdate'])):date("Y-m-d"); ?>" name="startdate">
					<label>To:</label> <input id="enddate" class="datepicker input-small" style="width:100px; padding: 6px 12px;"  type="text" value="<?php echo (isset($_GET['enddate']) AND $_GET['enddate']!='')?date("Y-m-d", strtotime($_GET['enddate'])):date("Y-m-d"); ?>" name="enddate"> 						
				</div>
				
				<!--<div id="div_member_type" class="pull-right" style="<?php echo (!isset($_GET['report_type']) OR $_GET['report_type'] == 0)?'':'display:none' ?>"> 
					<select name="member_type" class="form-control" style="color: #333333; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25), 0 -1px 0 rgba(0, 0, 0, 0.1) inset;">
						<option value="-1">All</option>
						<?php foreach($membership_type as $row): ?>
						<option value="<?php echo $row->mem_type_id; ?>" <?php echo (isset($_GET['member_type']) AND $_GET['member_type'] == $row->mem_type_id )?'selected':'' ?>><?php echo $row->title; ?></option> 
						<?php endforeach; ?>	
					</select>
					
				</div>
				 
			    <div class="col-sm-3 pull-right" style="margin:0px; padding:0 3px">
					<select name="report_type" id="report_type" class="form-control" style="color: #333333; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25), 0 -1px 0 rgba(0, 0, 0, 0.1) inset;" >
						<option value="0" <?php echo (isset($_GET['report_type']) && $_GET['report_type'] == 0)?'selected':'' ?>>Sign-ups</option>
						<option value="1" <?php echo (isset($_GET['report_type']) && $_GET['report_type'] == 1)?'selected':'' ?>>Terminated</option>
						<option value="2" <?php echo (isset($_GET['report_type']) && $_GET['report_type'] == 2)?'selected':'' ?>>Suspended</option>
						<option value="3" <?php echo (isset($_GET['report_type']) && $_GET['report_type'] == 3)?'selected':'' ?>>Current</option>
						<option value="4" <?php echo (isset($_GET['report_type']) && $_GET['report_type'] == 4)?'selected':'' ?>>Cash Payment</option>
						<option value="5" <?php echo (isset($_GET['report_type']) && $_GET['report_type'] == 5)?'selected':'' ?>>Credit Card</option>
					</select>
					
			    </div>-->		 

				<div class="pull-right" > 
					<select name="option2" id="option2" class="form-control" style="color: #333333; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25), 0 -1px 0 rgba(0, 0, 0, 0.1) inset;">
						<option value="0" <?php echo (isset($_GET['option2']) && $_GET['option2'] == 0)?'selected':'' ?>>Current and Active</option>	
						<option value="1" <?php echo (isset($_GET['option2']) && $_GET['option2'] == 1)?'selected':'' ?>>Terminated</option>	
						<option value="2" <?php echo (isset($_GET['option2']) && $_GET['option2'] == 2)?'selected':'' ?>>Suspended</option>	
					</select> 
				</div>			 

				<div class="pull-right"> 
					<select name="option1" class="form-control" style="color: #333333; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25), 0 -1px 0 rgba(0, 0, 0, 0.1) inset;">
						<option value="0" <?php echo (isset($_GET['option1']) && $_GET['option1'] == 0)?'selected':'' ?>>Full Payment</option>	
						<option value="1" <?php echo (isset($_GET['option1']) && $_GET['option1'] == 1)?'selected':'' ?>>Cash Payment</option>	
						<option value="2" <?php echo (isset($_GET['option1']) && $_GET['option1'] == 2)?'selected':'' ?>>Credit Card</option>	
					</select> 
				</div>				
				
				<div class="pull-right" style="font-size: 12px"><span class="glyphicon glyphicon-list" style="padding-top: 8px"></span> Filters: &nbsp;	</div>
		     	
			</form>
		</div>
	</div> 
	
	<!--<div class="row" style="color:red">For <strong>Current, Cash Payment and Credit Card</strong> no date range filter, just hit the generate report and it will display all the current members that are active.</div>
	<div class="row" style="color:red">To be discuss with willi</div>-->
	
	<!--<a href="javascript:void(0)" onclick="generatereports.export()"><span class="glyphicon glyphicon-save" style="color:#333; font-size:15px"></span>Export</a>-->
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