<script type="text/javascript">
	var processing = false;
	var scheduledpayments = {
		
		 delete: function(id){
		 	if(confirm('Confirm delete?')){
		 		$.post('reports/ajax_deleteschedulepayment',{id:id}, function(response){
		 			alert(response);
		 			oTable.fnDraw();
		 		});
		 	}
		 }
		
	}

$(document).ready( function () {
 
	oTable = $('#transaction_list').dataTable({ 
			"sDom": "<'row'<'pull-right'f><'pull-left'l>r<'clearfix'>>t<'row'<'pull-left'i><'pull-right'p><'clearfix'>>",
			"sPaginationType": "bootstrap", 
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "reports/ajax_schedule_payments",
			"bPaginate": true,		 
			"oLanguage": {
				"sLengthMenu": "Show _MENU_ Rows",
				"sSearch": "Search: "
			},						
			"iDisplayLength": 25,
			"aaSorting": [[ 9, 'desc' ]],
			/* "aoColumnDefs":[
				{ 'bSortable': false, 'aTargets': [ 0, 9 ]}
			], */
			"fnServerParams": function( aoData ){
				aoData.push( { "name": "sel_sort_view", "value": $("#sel_sort_view").val() } );   
			}						
	}); 

	$("#sel_sort_view").change(function(){ 
		oTable.fnDraw();
	});	 
	
});

</script>

	<div class="row">
		<h4>Reports <span class="glyphicon glyphicon-chevron-right" style="color:#333"></span> Scheduled Payments  [<a href="reports/uploadschedulepayments">Upload</a>]</h4> <hr />   
 	</div>
	
	<div class="row">
	 
		<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="transaction_list" style="font-size: 90%">
			<thead>
			<tr>
			<td>#</td>
			<td><strong>Master Sch Id</strong></td>
			<td><strong>Detail Sch Id.</strong></td>
			<td><strong>Merchant Ref.</strong></td>
			<td><strong>Order Date</strong></td>
			<td><strong>Tran Date</strong></td>
			<td><strong>Amount</strong></td>
			<td><strong>Payment Ref.</strong></td>
			<td><strong>Status</strong></td> 
			<td><strong>Date Uploaded</strong></td> 
			</tr>
			
		</table>	
		 
	</div> 
