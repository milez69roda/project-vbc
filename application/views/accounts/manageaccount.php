<script type="text/javascript">
	 
 
	var account = {
		accountform: function(id, formtype){
			var content = '';
			var title = (formtype=='update')?'Edit Account':'New Account'; 
			var tpl = $('<div class="modal fade"></div>').load('accounts/ajax_account_form/?_t='+(new Date).getTime(), {id:id, formtype:formtype, title:title});	
							
			$(tpl).modal().on('hidden.bs.modal', function () {
					//if( redirect != '' ) window.location = redirect;
			});			
		}, 
		
		save: function(form){ 
			if( confirm("Do you want to save?") ){
				$.ajax({
					type: 'post',
					url: 'accounts/ajax_account_form',
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
		} 	
	} 

</script>
 
	<div class="row" style="background-color: #fff; padding: 5px 3px">
		<!--<div class="pull-right filterribbon" style=" width: 680px; background-color: #333; box-shadow: 0 1px 3px #888888; color: #fff; height: 45x; text-shadow: 0 0 0 #000000; padding: 6px 14px 6px 15px; " >-->
		
		<div class="pull-left">
			<h4>Settings <span class="glyphicon glyphicon-chevron-right" style="color:#333"></span> <a href="accounts/manageaccount">Manage Account</a></h4>  
	 	</div>
	</div>	
	 <button type="button" class="btn btn-primary" onclick="account.accountform('','new')" >New Account</button>
	<div class="row"> 
		<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="transaction_list" style="font-size: 95%">
			<thead>
			<tr>
				<td>#</td> 
				<td><strong>Username</strong></td>
				<td><strong>Name</strong></td>
				<td><strong>Email</strong></td> 
				<td><strong>Access</strong></td> 
				<td><strong>Status</strong></td> 
				<td><strong>Action</strong></td>
			</tr>
			</thead>
			<tbody>
				<?php $i=1;foreach( $results as $row): ?>
				<tr>
					<td><?php echo $i++; ?></td> 
					<td><?php echo $row->user_name; ?></td>
					<td><?php echo $row->fullname; ?></td>
					<td><?php echo $row->email; ?></td>
					<td><?php echo ($row->access_type)?'Admin':'Regular'; ?></td>
					<td><?php echo ($row->status_flag == '1')?'Active':'Disabled'; ?></td>
					<td><a href="javascript:void(0)" onclick="account.accountform(<?php echo $row->admin_id; ?>, 'update')">Edit</a></td> 
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>	
	</div>  
	