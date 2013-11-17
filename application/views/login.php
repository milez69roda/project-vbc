<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!--<link rel="shortcut icon" href="assets/ico/favicon.png">-->
	<base href="<?php echo base_url(); ?>" />
	
    <title>Vanda Boxing Club</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/signin.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
		<script src="assets/js/html5shiv.js"></script>
		<script src="assets/js/respond.min.js"></script>
    <![endif]-->
	
	<script src="assets/js/jquery-2.0.3.min.js"></script>
	 
	<script>
		$(document).ready(function(){
			$("#InputUsername1").focus();	
		});
	</script>
	
  </head>

  <body>

    <div class="container">

	
		 
		
			<form class="form-horizontal form-signin" role="form" method="post" action="">
			 
			<h2 class="form-signin-heading">Please sign in</h2>
		  
			<?php
				echo $msg;
			?>	
			
			<div class="form-group">
				<label for="inputEmail1" class="col-lg-2 control-label">Username</label>
				<div class="col-lg-10">
				  <input type="text" class="form-control"  id="InputUsername1" name="InputUsername1"  placeholder="Email" setfocus> 
				</div>
			</div>
			<div class="form-group">
				<label for="inputPassword1" class="col-lg-2 control-label">Password</label>
				<div class="col-lg-10">
				  <input type="password" class="form-control" id="InputPassword1" name="InputPassword1" placeholder="Password">
				</div>
			</div>		
	 
			<div class="form-group">
				<div class="col-lg-offset-2 col-lg-10">
				  <button type="submit" class="btn btn-default">Sign in</button>
				</div>
			</div>
			 
			 
		</div> 
		
	</div>
	
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
   <script src="assets/js/bootstrap.min.js"></script>
   
  </html>
