<script type="text/javascript">

	var companyplan = {
	
		form: function(ref, formtype){
			var content = '';
			var title = (formtype=='update')?'Edit Company Plan':'New Company Plan'; 
			var tpl = $('<div class="modal fade"></div>').load('settings/ajax_companyplan_form/?_t='+(new Date).getTime(), {ref:ref, formtype:formtype, title:title});	
							
			$(tpl).modal().on('hidden.bs.modal', function () {
					//if( redirect != '' ) window.location = redirect;
			});			
		}, 
		
		save: function(form){ 
			if( confirm("Do you want to save?") ){
				$.ajax({
					type: 'post',
					url: 'settings/ajax_companyplan_form',
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
		 
		delete: function(ref, title){
			if( confirm('Do you want to delete '+title+'?') ){
					
				$.ajax({
					type:"post",
					url: 'settings/ajax_delete_companyplan', 
					data:{ref:ref},
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
	 
		
		
	});

</script>


	<div class="row">
	 	<h4>Settings > Company Packages</h4> <hr />
		<button type="button" class="btn btn-primary" onclick="companyplan.form('-1', 'new')" >New Company Plan</button>
		<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="transaction_list">
			<thead> 
			<tr>
				<td>#</td>
				<td><strong>Title</strong></td>
				<td><strong>Company</strong></td>
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
					<td><?php echo $row->co_name;?></td>
					<td><?php echo $row->month;?> months</td>
					<td>S$<?php echo $row->price;?></td>
					<td>
						<a href="javascript:void(0)" onclick="companyplan.form('<?php echo $this->common_model->enccrypData($row->mem_type_id); ?>', 'update')" >Edit</a> |
						<a href="javascript:void(0)" onclick="companyplan.delete('<?php echo $this->common_model->enccrypData($row->mem_type_id); ?>', '<?php echo $row->title; ?>' )" >Delete</a>
					</td>
				</tr>
				<?php $i++; endforeach; ?>
			</tbody>
		</table>	
		 
	</div> 
