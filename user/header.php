<?php
date_default_timezone_set("Asia/Kolkata");
if($user_login->is_logged_in() !="")
{  
    $userId = $_SESSION['userSession'];
    $stmt = $user_login->runQuery("SELECT * FROM tbl_users WHERE userID = :user_id");
    $stmt->execute(array(":user_id"=>$userId));
    $currentUser = $stmt->fetch(PDO::FETCH_OBJ);
} else {
	header("Location: ../login.php"); //
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Wcarps - Dashboard</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/dataTables.bootstrap.css">
<link href="css/styles.css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">

<!--Icons-->
<script src="js/lumino.glyphs.js"></script>


<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>
	<div class='preloader' style="display: none;">  
	<img src='../img/loader.gif' alt='Loading...'/> 
	   Loading ...
	</div>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php"><span>WCarPs</span></a>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> <?= $currentUser->first_name.' '.$currentUser->last_name?> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">

				              <?php             
				              if($user_login->roles[0] == $currentUser->role) {
				                echo "<li><a tabindex='2' href='../admin/'>Admin Panel</a></li>";
				              } 
				            ?>							
							<li><a href="../logout.php"><svg class="glyph stroked cancel"><use xlink:href="logout.php"></use></svg> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
							
		</div><!-- /.container-fluid -->
	</nav>
		
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<!-- <form role="search">
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Search">
			</div>
		</form> -->
	
	<ul class="nav menu">
	    <li ><a  href="index.php"><i class="icon icon-home"></i>Home</a></li>
		<li ><a  href="vehicles.php"><i class="icon icon-vehicle"></i>Vehicle Information</a></li>
		<li ><a  href="demo_theft_alert.php"><i class="icon icon-demo"></i>Demo Theft Alert </a></li>	
		<li ><a  href="demo_recovery_alert.php"><i class="icon icon-demo"></i>Demo My Alerts </a></li>	
		<li ><a  href="theft_alert.php"><i class="icon icon-theft"></i>Theft Alert </a></li>	
		<li ><a  href="alerts.php"><i class="icon icon-alert"></i>My Alerts</a></li>
		<li ><a  href="user_notifications.php"><i class="icon icon-notify"></i>Notifications</a></li>
		<li ><a  href="lost_vehicles.php"><i class="icon icon-lost"></i>Lost Vehicles</a></li>
		<li ><a  href="vehicles.php?livetracking"><i class="icon icon-track"></i>Live Tracking</a></li>	
		<li ><a  href="searches.php"><i class="icon icon-search"></i>Who Searched Your Vehicle</a></li>
		<li ><a  href="settings.php"><i class="icon icon-settings"></i>Account Settings</a></li>
			
		<li ><a  href="../logout.php"><i class="icon icon-logout"></i>Logout</a></li>		
	</ul>
	</div><!--/.sidebar-->

<!-- Modal -->
  <div class="modal fade" id="confirmRecovery" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Confirmation</h4>
        </div>
        <div class="modal-body">
          <p> Are you sure to Send Notification?</p>
        </div>
         <div class="modal-footer">
		    <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Ok</button>
		    <button type="button" data-dismiss="modal" class="btn">Cancel</button>
		  </div>
      </div>
      
    </div>
  </div>

   <div class="modal fade" id="confirmDemoAlert" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Confirmation</h4>
        </div>
        <div class="modal-body">
          <p> Are you sure to Send Demo Notification?</p>
        </div>
         <div class="modal-footer">
		    <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Ok</button>
		    <button type="button" data-dismiss="modal" class="btn">Cancel</button>
		  </div>
      </div>
      
    </div>
  </div>
  
</div>
