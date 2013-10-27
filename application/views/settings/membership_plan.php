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
	 
		
		
	});

</script>


	<div class="row">
	 	<h4>Settings > Membership Package</h4> <hr />
		<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="transaction_list">
			<thead> 
			<tr>
				<td>#</td>
				<td><strong>Title</strong></td>
				<td><strong>Month(s)</strong></td>
				<td><strong>Price/Month</strong></td>
				<td><strong>ACTION</strong></td> 
			</tr> 
			</thead>
			<tbody>
				<?php $i=1; foreach($results as $row):  ?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $row->title;?></td>
					<td><?php echo $row->month;?> months</td>
					<td><?php echo $row->price;?></td>
					<td>
						<a href="" >Edit</a>|
						<a href="" >Disable</a>
					</td>
				</tr>
				<?php $i++; endforeach; ?>
			</tbody>
		</table>	
		 
	</div> 
