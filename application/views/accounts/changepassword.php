<script type="text/javascript">
	 
	$(document).ready( function () { 
		
		var accounts = {
			changepassword: function(){
				
				
				
			}			
		}
 
	});

</script>
 
	<div class="row" style="background-color: #fff; padding: 5px 3px">
		<!--<div class="pull-right filterribbon" style=" width: 680px; background-color: #333; box-shadow: 0 1px 3px #888888; color: #fff; height: 45x; text-shadow: 0 0 0 #000000; padding: 6px 14px 6px 15px; " >-->
		
		<div class="pull-left">
			<h4>Settings <span class="glyphicon glyphicon-chevron-right" style="color:#333"></span> <a href="accounts/changepassword">Change Password</a></h4>  
	 	</div>
	</div>	
	 
	<div class="row"> 
		<?php echo $this->session->flashdata('flash_message'); ?>
		<?php $errors = validation_errors();  
			if( $errors != '' ){
				echo '<div class="alert alert-danger" style="color:red">'.$errors.'</div>';
			}
		?> 
		<form class="form-horizontal" role="form" name="form1" method="post">
			<div class="form-group">
				<label for="inputMonth" class="col-lg-3 control-label">Current Password *</label>
				<div class="col-lg-4">   
					<input type="number" class="form-control" name="currentPass" id="currentPass" value="" placeholder="Current Password">
				</div>
			</div>
			<div class="form-group">
				<label for="inputMonth" class="col-lg-3 control-label">New Password *</label>
				<div class="col-lg-4">   
					<input type="number" class="form-control" name="newPass" id="newPass" value="" placeholder="New Password">
				</div>
			</div>
			<div class="form-group">
				<label for="inputMonth" class="col-lg-3 control-label">Password Confirmation *</label>
				<div class="col-lg-4">   
					<input type="number" class="form-control" name="repeatPass" id="repeatPass" value="" placeholder="Password Confirmation">
				</div>
			</div> 	
			
			<div class="form-group">
				<label for="inputMonth" class="col-lg-3 control-label">&nbsp;</label>
				<div class="col-lg-4">   
					<button type="submit" class="btn btn-primary">Change Password</button>
				</div>
			</div> 	
			
			
		</form>
	</div>  
	