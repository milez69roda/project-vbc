<script type="text/javascript">

$(document).ready( function () {
	$('#example').dataTable( {
		"sDom": "<'row-fluid'<'span6'T><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
		 
	} );
	
	oTable = $('#mail_table_list').dataTable({ 
			"sDom": "<'row'<'pull-right'f><'pull-left'l>r<'clearfix'>>t<'row'<'pull-left'i><'pull-right'p><'clearfix'>>",
			"sPaginationType": "bootstrap", 
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "inbox/category_ajax_list",
			"bPaginate": true,		 
			"oLanguage": {
				"sLengthMenu": "Show _MENU_ Rows",
				"sSearch": "Search: "
			},						
			"iDisplayLength": 10,
			/* "aaSorting": [[ 4, 'desc' ]],
			"aoColumnDefs":[
				{ 'bSortable': false, 'aTargets': [ 0 ]}
			], */
			"fnServerParams": function( aoData ){
				/* aoData.push( { "name": "gidx", "value": x } ); 
				aoData.push( { "name": "gidy", "value": y } );  */
			}						
		}); 	
	
});

</script>


	<div class="row">
		 
		<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
			<tr align="center" valign="middle">
			<td>#</td>
				<td><strong>Ref</strong></td>
				<td><strong>Name</strong></td>
				<td><strong>Membership</strong></td>
				<td><strong>Amount</strong></td>
				<td><strong>Phone</strong></td>
				<td><strong>Email</strong></td>
				<td><strong>Signup</strong></td>
				<td><strong>Expiry</strong></td>
				<td><strong>ACT</strong></td>
			</tr>
		</table>	
		 
	</div> 