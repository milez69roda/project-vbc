	<script>
		
		var home = {
			
			_init: function(){
				
				$("#txtcarid").focus();
				
			},
			
			scan: function(){
				var txtcarid = $("#txtcarid");
				
				console.log('scan id');
			}
		
		}
		
		$(document).ready(function(){
			home._init();
		});
		
	</script>
	
	
	<div class="row">
	
		<div class="col-lg-8"> 
			<form class="form-horizontal" role="form">
			 
			  <!--<div class="form-group">
				<label for="txtcardid" class="col-lg-2 control-label" style="width: 94px !important">CARD ID: </label>
				<div class="col-lg-6">
				  <input type="text" class="form-control" id="txtcardid" name="txtcardid" placeholder="SCAN ID">
				</div>
				<button type="button" class="btn btn-default" onclick="home.scan()">Search</button>
			  </div>
			</form>-->   
		</div>
 	</div>
	<div class="row">
		<p>What to be display</p> 
		<p>Payment Transaction
			<ul>
				<li>Failed to upload previous Schedule Payment</li>
				<!--<li>Schedule payment with status [Suspend, Rejected]</li>
					<ol> 
						<li>Plan: Manual adding of payment on the schedule payment table to clear the failed payment. Need some clarification with willi</li>
					</ol>
				<li>In case of schedule payment failed.<li>	
					<ol>
						<li>Need to verify with willi if he would like to automatic update membership terms or status if the schedule payment is failed[rejected,suspend].
							if payment is rejected or suspend maybe it automatically update the status to inactive with terms of suspend[reason suspend or rejected payment via schedule payment].
						</li>
					</ol>-->
			</ul>
		</p>
		<p>Member with 35 days before expiry</p>
		<p>Note: There are lot of members with an expiry already been past more than a month(s)(more than 35 days), this need to be updated manually.</p>
	 
	</div>
	<div class="row">
		 		
	</div>      
