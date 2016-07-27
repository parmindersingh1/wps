<?php
date_default_timezone_set("Asia/Kolkata");
if($user_login->is_logged_in() !="")
{  
    $userId = $_SESSION['userSession'];
    $stmt = $user_login->runQuery("SELECT * FROM tbl_users WHERE userID = :user_id");
    $stmt->execute(array(":user_id"=>$userId));
    $currentUser = $stmt->fetch(PDO::FETCH_OBJ);

   if($user_login->roles[0] == $currentUser->role) {
   
   } else {
   	header("Location: ../index.php");
   }
} else {
	header("Location: ../index.php"); //
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
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="../"><span>Wcarps</span>Admin</a>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> <?= $currentUser->first_name.' '.$currentUser->last_name?> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">	
						<li><a href="../user">User Panel</a></li>						
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
		<li ><a href="index.php"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Users</a></li>
		<li ><a href="vehicles.php"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Vehicles</a></li>
		<li ><a href="searches.php"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Searches</a></li>
		<li ><a href="alerts.php"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Alerts</a></li>
		<li ><a  href="users.php?livetracking"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg>Live Tracking</a></li>	
		<li ><a href="archived_users.php"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Archived Users</a></li>
		<li ><a href="archived_vehicles.php"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Archived Vehicles</a></li>
		<li ><a href="notifications.php"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Send Notifications</a></li>
	</ul>
	</div><!--/.sidebar-->
