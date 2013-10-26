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
			 
			  <div class="form-group">
				<label for="txtcardid" class="col-lg-2 control-label" style="width: 94px !important">CARD ID: </label>
				<div class="col-lg-6">
				  <input type="text" class="form-control" id="txtcardid" name="txtcardid" placeholder="SCAN ID">
				</div>
				<button type="button" class="btn btn-default" onclick="home.scan()">Search</button>
			  </div>
			</form> 
		</div>
 	</div>
	<div class="row">
		<div class="col-lg-4">
		<h3>Name: <strong>Vennus Vito</strong></h3>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-2">
			<h3>Profile</h3>
			<img class="img-circle" src="data:image/png;base64," data-src="holder.js/140x140" alt="Generic placeholder image">			
			 
		</div>
		<div class="col-lg-4">
			<h3>Details</h3>
			<p><strong>Name:</strong>  	Vennus Vito</p>
			<p><strong>Reference Number:</strong> M002944</p> 
			<p><strong>Membership:</strong> Adults - 6 months - S$267.50 per month</p> 
			<p><strong>Joined:</strong> 2013-09-25</p>  
			<p><strong>Next Billing:</strong> 2013-10-25</p>  
			<p><strong>Expiry Date:</strong> 2013-09-25</p>  
		</div> 
		<div class="col-lg-6">
			<h3>Transaction</h3>
			<p>Donec id elit non mi porta gravida at eget metus.</p>
			<p>Donec id elit non mi porta gravida at eget metus.</p>  
			<p>Donec id elit non mi porta gravida at eget metus.</p>  
			<p>Donec id elit non mi porta gravida at eget metus.</p>  
			<p>Donec id elit non mi porta gravida at eget metus.</p>  
			<p>Donec id elit non mi porta gravida at eget metus.</p>    
		</div> 		
	</div>      
