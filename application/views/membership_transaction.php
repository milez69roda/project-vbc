<script type="text/javascript">

$(document).ready( function () {
 
	var oTable = $('#transaction_list').dataTable({ 
			"sDom": "<'row'<'pull-right'f><'pull-left'l>r<'clearfix'>>t<'row'<'pull-left'i><'pull-right'p><'clearfix'>>",
			"sPaginationType": "bootstrap", 
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "membership/ajax_membership_transaction",
			"bPaginate": true,		 
			"oLanguage": {
				"sLengthMenu": "Show _MENU_ Rows",
				"sSearch": "Search: "
			},						
			"iDisplayLength": 25,
			"aaSorting": [[ 1, 'desc' ]],
			"aoColumnDefs":[
				{ 'bSortable': false, 'aTargets': [ 0, 9 ]}
			],
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
		<h4>Complete Membership List</h4> <hr />
		<form name="ext_search_form" id="ext_search_form">
			<select class="form-control" name="sel_sort_view" id="sel_sort_view">
				<option value="-1">View All</option> 
				<option value="0">by Card</option>
				<option value="1">by DD</option>
				<option value="2">by Cash</option>
				<option value="3">by Expired</option> 
				<option value="5">by Current Members</option>
			</select>

		</form>		
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
			<td><strong>Expiry</strong></td>
			<td><strong>ACT</strong></td>
			</tr>
			
		</table>	
		 
	</div> 
