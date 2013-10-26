<script type="text/javascript">
	var oTable;

	var temporary = {
	
		activate: function(ref){
			if( confirm('Confirm activation!') ){
				
				$.ajax({
					type:"post",
					url: 'membership/ajax_membership_temporary_activate', 
					data:{ref:ref},
					success: function(jqhr){
						alert(jqhr);
						oTable.fnDraw();
					}
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
				"sAjaxSource": "membership/ajax_membership_temporary",
				"bPaginate": true,		 
				"oLanguage": {
					"sLengthMenu": "Show _MENU_ Rows",
					"sSearch": "Search: "
				},						
				"iDisplayLength": 25,
				"aaSorting": [[ 0, 'desc' ]],
				"aoColumnDefs":[
					//{ 'bSortable': false, 'aTargets': [ 0, 9 ]}
				],
				"fnServerParams": function( aoData ){
					aoData.push( { "name": "sel_sort_view", "value": $("#sel_sort_view").val() } );   
				}						
			}); 

			$("#sel_sort_view").change(function(){
				
				oTable.fnDraw();
			})	
		
	});

</script>


	<div class="row">
	 	<h4>Temporary</h4> <hr />
		<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="transaction_list">
			<thead>
			<tr>
			<td>#</td>
			<td width="40"><strong>Mode</strong></td>
			<td><strong>Name</strong></td>
			<td><strong>Email</strong></td>
			<td><strong>Membership</strong></td>
			<td><strong>Phone</strong></td>
			<td><strong>$</strong></td>
			<td><strong>Signup</strong></td> 
			<td><strong>ACTION</strong></td>
			</tr>
			
		</table>	
		 
	</div> 
