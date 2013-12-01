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
					<label for="inputPrice" class="col-lg-3 control-label">Name</label>
					<div class="col-lg-5">
						<input type="number" class="form-control" name="fullname" id="fullname" value="<?php echo @$row->fullname; ?>" placeholder="">
					</div>
				</div>	 
				
				<div class="form-group">
					<label for="inputPrice" class="col-lg-3 control-label">Username</label>
					<div class="col-lg-4">
						<?php if($type == 'new'): ?>
						<input type="number" class="form-control" name="user_name" id="user_name" value="<?php echo @$row->user_name; ?>" placeholder="">
						<?php else: echo '<p style="font-size: 17px; font-weight: bold; margin-top: 2px;">'.@$row->user_name.'</p>'; ?>
						<?php endif; ?>
					</div>
				</div>	
				
				<div class="form-group">
					<label for="inputPrice" class="col-lg-3 control-label">Password</label>
					<div class="col-lg-4">
						<input type="number" class="form-control" name="user_password" id="user_password" value="" placeholder="">  					
					</div>
					<br style="clear:both"/>
					<i style="margin-left: 160px; color:orange">Leave password blank if not updated</i>	
				</div>	
				
				<div class="form-group">
					<label for="inputPrice" class="col-lg-3 control-label">Email</label>
					<div class="col-lg-6">
						<input type="number" class="form-control" name="email" id="email" value="<?php echo @$row->email; ?>" placeholder="">
					</div>
				</div>				 
				
				<div class="form-group">
					<label for="status_flag" class="col-lg-3 control-label">Status</label>
					<div class="col-lg-4">  
						<select name="status_flag" class="form-control">
							<option value="1">Active</option> 
							<option value="0">Disabled</option> 
						</select> 
					</div>
				</div> 				 
				
				<div class="form-group">
					<label for="access_type" class="col-lg-3 control-label">Access</label>
					<div class="col-lg-4">  
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
 