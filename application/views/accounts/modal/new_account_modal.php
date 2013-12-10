<!-- Modal -->

<div class="modal-dialog">
	<div class="modal-content">
		<form class="form-horizontal" role="form" name="form1" method="post" onsubmit="return account.save(this);">
			<input type="hidden" name="type" value="<?php echo $type; ?>" /> 
			<input type="hidden" name="idx" value="<?php echo @$row->admin_id; ?>" /> 
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			  <h4 class="modal-title"><?php echo $title; ?></h4> 
			</div>
			<div class="modal-body">
				
				<div class="form-group">
					<label for="inputPrice" class="col-sm-3 control-label">Name</label>
					<div class="col-sm-5">
						<input type="text" class="form-control" required name="fullname" id="fullname" value="<?php echo @$row->fullname; ?>" placeholder="">
					</div>
				</div>	 
				
				<div class="form-group">
					<label for="inputPrice" class="col-sm-3 control-label">Username</label>
					<div class="col-sm-4">
						<?php if($type == 'new'): ?>
						<input type="text" class="form-control" required name="user_name" id="user_name" value="<?php echo @$row->user_name; ?>" placeholder="">
						<?php else: echo '<p style="font-size: 17px; font-weight: bold; margin-top: 2px;">'.@$row->user_name.'</p>'; ?>
						<?php endif; ?>
					</div>
				</div>	
				
				<div class="form-group">
					<label for="inputPrice" class="col-sm-3 control-label">Password</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" <?php echo ($type == 'new')?'required':''; ?> name="user_password" id="user_password" value="" placeholder="">  					
					</div>
					<br style="clear:both"/>
					<?php if($type == 'update'): ?><i style="margin-left: 160px; color:orange">Leave password blank if not updated</i><?php endif; ?>	
				</div>	
				
				<div class="form-group">
					<label for="inputPrice" class="col-sm-3 control-label">Email</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="email" id="email" value="<?php echo @$row->email; ?>" placeholder="">
					</div>
				</div>				 
				
				<div class="form-group">
					<label for="status_flag" class="col-sm-3 control-label">Status</label>
					<div class="col-sm-4">  
						<select name="status_flag" class="form-control">
							<option value="1">Active</option> 
							<option value="0">Disabled</option> 
						</select> 
					</div>
				</div> 				 
				
				<div class="form-group">
					<label for="access_type" class="col-sm-3 control-label">Access</label>
					<div class="col-sm-4">  
						<select name="access_type" class="form-control">
							<option value="0">Regular</option> 
							<option value="1">Admin</option> 
						</select> 
					</div>
				</div>   
				
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			  <button type="submit" class="btn btn-primary"><?php echo ($type=='new')?'Create Account':'Save'; ?></button>
			</div>
		</form>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
 