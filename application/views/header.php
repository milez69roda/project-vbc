<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!--<link rel="shortcut icon" href="../../assets/ico/favicon.png"> -->
	<base href="<?php echo base_url(); ?>" />
    <title>Project VBC Admin</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="assets/css/DT_bootstrap.css"> 
	
    <!-- Custom styles for this template -->
    <link href="assets/css/custom.css" rel="stylesheet">
	
	
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
      <script src="assets/js/respond.min.js"></script>
    <![endif]-->
	
	 <script src="assets/js/jquery-2.0.3.min.js"></script>
	 
	 <script> var oTable; </script>
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
          <a class="navbar-brand" href="<?php echo base_url(); ?>">Project VBC</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="<?php echo ($segment1 == '')?'active':''; ?>"><a href="<?php echo base_url(); ?>">Home</a></li>
            <li class="<?php echo ($segment1 == 'membership' AND $segment2 == '')?'active':''; ?>"><a href="membership">Complete Membership List</a></li>
            <li class="<?php echo ($segment1 == 'membership' AND $segment2 == 'temporary')?'active':''; ?>"><a href="membership/temporary">Temporary Member</a></li>
            <li class="<?php echo ($segment1 == 'membership' AND $segment2 == 'company')?'active':''; ?>"><a href="membership/company">Company Member</a></li>
            
			
            <li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li class="dropdown-header">Packages</li>
					<li><a href="settings/membershipplan">Membership Plan</a></li>
					<li><a href="settings/companyplan">Company Plan</a></li> 
					<li class="divider"></li>
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
