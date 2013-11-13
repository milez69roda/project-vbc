<script type="text/javascript">
	var oTable;
	
	var promocodes = {
	
		form: function(formtype){
			var content = '';
			var title = (formtype=='update')?'':'New Promo Codes'; 
			var tpl = $('<div class="modal fade"></div>').load('settings/ajax_promocodes_form/?_t='+(new Date).getTime(), {formtype:formtype, title:title});	
							
			$(tpl).modal().on('hidden.bs.modal', function () {
					//if( redirect != '' ) window.location = redirect;
			});			
		}, 
		
		save: function(form){ 
			if( confirm("Do you want to save?") ){
				$.ajax({
					type: 'post',
					url: 'settings/ajax_promocodes_form',
					data: $(form).serialize(),
					dataType: 'json',
					success: function(jqhr){
						if(jqhr.status){
							alert(jqhr.msg);
							window.location = jqhr.redirect;
						}else{
							alert(jqhr.msg);
						}
					}
				});
			}
			return false;
		},
		 
		delete: function(id, code){
			 if( confirm('Do you want to delete '+code+'?') ){
					
				$.ajax({
					type:"post",
					url: 'settings/ajax_delete_promocode', 
					data:{id:id, pcode:code},
					dataType: 'json',
					success: function(jqhr){
						if(jqhr.status){
							alert(jqhr.msg);
							window.location = jqhr.redirect;
						}else{
							alert(jqhr.msg);
						}						
					}
				});
			} 			
		} 
	}


	$(document).ready( function () {
		
		oTable = $('#transaction_list').dataTable({
						"iDisplayLength": 25,
					});
		 
	});

</script>


	<div class="row">
	 	<h4>Settings > Promo Codes</h4> <hr />
		<button type="button" class="btn btn-primary" onclick="promocodes.form('new')" >New Promo Codes</button>
		<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="transaction_list">
			<thead> 
			<tr> 
				<td>#</td>
				<td><strong>Promo Code</strong></td>
				<td><strong>Description</strong></td>
				<td><strong>Type</strong></td>
				<td><strong>Total/Available</strong></td>
				<td><strong>Value</strong></td>  
				<td><strong>Company</strong></td>  
				<td><strong>Date Created</strong></td>  
				<td><strong>Action</strong></td>   
			</tr> 
			</thead>
			<tbody>
				<?php $i=1; foreach($results as $row):  ?>
				<tr>
					<td><?php echo $i; ?></td> 
					<td><?php echo $row->promo_code; ?></td> 
					<td><?php echo $row->promo_name; ?></td> 
					<td><?php echo $row->operator; ?></td> 
					<td><?php echo $row->total_unit." ( ".$row->avail_unit." )"; ?></td> 
					<td><?php echo $row->promo_val; ?></td> 
					<td><?php echo $row->company_name; ?></td> 
					<td><?php echo $row->date_created; ?></td>  
					<td>  
						<a href="javascript:void(0)" onclick="promocodes.delete(<?php echo $row->id; ?>, '<?php echo $row->promo_code; ?>')" >Delete</a>
					</td>
				</tr>
				<?php $i++; endforeach; ?>
			</tbody>
		</table>	
		 
	</div> 
