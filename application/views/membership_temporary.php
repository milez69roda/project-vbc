<script type="text/javascript">
	var oTable;
	var processing = false;
	
	var temporary = {
	
		activate: function(ref){
		
			if( !processing ){ 
				if( confirm('Confirm activation!') ){ 
					processing = true;
					$.ajax({
						type:"post",
						url: 'membership/ajax_membership_temporary_activate', 
						data:{ref:ref},
						success: function(jqhr){
							processing = false;
							alert(jqhr);
							oTable.fnDraw();
						}
					}); 
				}
			}else{
				alert('Please wait, there is still transaction being process.');
			}	
		},

		delete: function(delid){
			if( !processing ){ 
				if( confirm('Do you want to delete?') ){
					processing = true;
					$.post('membership/ajax_membership_temporary_delete',{delid:delid}, function(json){
						processing = false;
						if(json.status){							
							alert(json.msg);
							window.location = json.url;
						}else{
							alert(json.msg);
						}
					}, 'json');
				}
			}else{
				alert('Please wait, there is still transaction being process.');
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
	
	 	<h4>Temporary Member</h4> <hr />
		<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="transaction_list">
			<thead>
			<tr>
			<td>#</td>
			<td width="40"><strong>Mode</strong></td>
			<td><strong>Ref</strong></td>
			<td><strong>Name</strong></td>
			<td><strong>Email</strong></td>
			<td><strong>Membership</strong></td>
			<td><strong>Phone</strong></td>
			<td><strong>Amount</strong></td>
			<td><strong>Signup</strong></td> 
			<td><strong>ACTION</strong></td>
			</tr> 
		</table>	

	</div> 
	<div id="go_up" style=""><span class="glyphicon glyphicon-arrow-up"></span></div>