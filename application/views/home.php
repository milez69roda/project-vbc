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
		  
		</div>
	</div>
	<div class="row">
		 		
	</div>      
