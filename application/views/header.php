<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!--<link rel="shortcut icon" href="../../assets/ico/favicon.png"> -->
	<base href="<?php echo base_url(); ?>" />
    <title><?php echo WEBSITE_TITLE; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="assets/css/DT_bootstrap.css"> 
	
    <!--<link rel="stylesheet" type="text/css" href="assets/css/daterangepicker/daterangepicker-bs3.css" />-->
    <link rel="stylesheet" type="text/css" href="assets/css/datepicker.css" />
    
	<!-- Custom styles for this template -->
    <link href="assets/css/custom.css" rel="stylesheet">
	
	
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
      <script src="assets/js/respond.min.js"></script>
    <![endif]-->
	
	 <script src="assets/js/jquery-2.0.3.min.js"></script>
	 
	 <script> var oTable; </script>
	
	<style>
	
		#upload_images{
			 width:92px;
		}
		
		@-moz-document url-prefix() { 
		  #upload_images {
			 width:85px;
		  }
		}
	</style>	
	 
  </head>

  <body>
	<?php 
		$segment1 = $this->uri->segment(1);
		$segment2 = $this->uri->segment(2); 
	?>
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo base_url(); ?>"><?php echo WEBSITE_HEADER; ?></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
			
			
			<li class="<?php echo ($segment1 == '')?'active':''; ?>"><a href="<?php echo base_url(); ?>">Home</a></li>
            
			<!--<li class="<?php echo ($segment1 == 'membership' AND ($segment2 == '' OR $segment2 == 'details'))?'active':''; ?>"><a href="membership">Complete Membership List</a></li>
            <li class="<?php echo ($segment1 == 'membership' AND $segment2 == 'temporary')?'active':''; ?>"><a href="membership/temporary">Temporary Member</a></li>
            <li class="<?php echo ($segment1 == 'membership' AND ($segment2 == 'company' OR $segment2 == 'companydetails'))?'active':''; ?>"><a href="membership/company">Company Member</a></li>-->

			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Membership <b class="caret"></b></a>
				<ul class="dropdown-menu">
	
					<li class="<?php echo ($segment1 == 'membership' AND ($segment2 == '' OR $segment2 == 'details'))?'active':''; ?>"><a href="membership">Complete Membership List</a></li>
					<li class="<?php echo ($segment1 == 'membership' AND $segment2 == 'temporary')?'active':''; ?>"><a href="membership/temporary">Temporary Member</a></li>
					<!--<li class="<?php echo ($segment1 == 'membership' AND ($segment2 == 'company' OR $segment2 == 'companydetails'))?'active':''; ?>"><a href="membership/company">Company Member</a></li>-->

					<li class="divider"></li>
					<!--<li class="dropdown-header">Nav header</li>
					<li><a href="#">Separated link</a></li>
					<li><a href="#">One more separated link</a></li> -->
				</ul>
            </li>  			
			
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li class="dropdown-header">Schedule Payments</li>
					<li class="<?php echo ($segment1 == 'reports' AND $segment2 == 'schedulepayments' )?'active':''; ?>"><a href="reports/schedulepayments">Schedule Payments</a></li>
					<li class="<?php echo ($segment1 == 'reports' AND $segment2 == 'uploadschedulepayments' )?'active':''; ?>"><a href="reports/uploadschedulepayments">Upload</a></li>
					<li class="divider"></li>
					<li><a href="reports/membership">Membership</a></li> 					
					<li class="divider"></li>
					<li><a href="reports/terms">Terms</a></li>  
					<li><a href="reports/freebies">Freebies</a></li>  
					<li class="divider"></li>
					<li><a href="reports/invoice">Invoice</a></li>   
				</ul>
            </li>            
			
            <li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings <b class="caret"></b></a>
				<ul class="dropdown-menu">
				<?php  if($this->uaccess): ?>
					<li class="dropdown-header">Packages</li>
					<li class="<?php echo ($segment1 == 'settings' AND $segment2 == 'membershipplan' )?'active':''; ?>"><a href="settings/membershipplan">Membership Plan</a></li>
					<!--<li class="<?php echo ($segment1 == 'settings' AND $segment2 == 'companyplan' )?'active':''; ?>"><a href="settings/companyplan">Company Plan</a></li> -->
					<li class="divider"></li>
					<li class="<?php echo ($segment1 == 'settings' AND $segment2 == 'promocodes' )?'active':''; ?>"><a href="settings/promocodes">Promo Codes</a></li>
					<li class="divider"></li>
					
					<li class="dropdown-header">Accounts</li>					
					<li class="<?php echo ($segment1 == 'accounts' AND $segment2 == 'account' )?'active':''; ?>"><a href="accounts/manageaccount">Manage Account</a></li>
					<!--<li class="<?php echo ($segment1 == 'accounts' AND $segment2 == 'account' )?'active':''; ?>"><a href="accounts/newaccount">New Account</a></li>-->
				<?php endif; ?>
					<li class="<?php echo ($segment1 == 'accounts' AND $segment2 == 'changepassword' )?'active':''; ?>"><a href="accounts/changepassword">Change Password</a></li>
					<!--<li class="dropdown-header">Nav header</li>
					<li><a href="#">Separated link</a></li>
					<li><a href="#">One more separated link</a></li> -->
				</ul>
            </li>
			
			 
          </ul>
          
		<ul class="nav navbar-nav navbar-right">
			<li><a href="logout"><?php echo $this->session->userdata('vbc_username');?> (Logout)</a></li>
		</ul>
          <!--<form class="navbar-form navbar-right">
            <div class="form-group">
              <input type="text" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Sign in</button>
          </form>-->
        </div><!--/.navbar-collapse -->
      </div>
    </div>

	<div class="container">
