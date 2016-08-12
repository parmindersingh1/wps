<?php

session_start();
require_once dirname(__FILE__).'/api/class.user.php';
require_once dirname(__FILE__).'/api/class.vehicle.php';
$user_login = new USER();
$user_vehicle = new Vehicle();

if($user_login->is_logged_in() !="")
{  
    $userId = $_SESSION['userSession'];
    $stmt = $user_login->runQuery("SELECT * FROM tbl_users WHERE userID = :user_id");
    $stmt->execute(array(":user_id"=>$userId));
    $currentUser = $stmt->fetch(PDO::FETCH_OBJ);  
}

if(isset($_POST['btn-login']))
{
	$login = trim($_POST['login']);
	$upass = trim($_POST['upass']);
	
	if($user_login->login($login,$upass))
	{
		$user_login->redirect('user/index.php');
	}
}
?>

<!DOCTYPE html>

<html lang="en">
<head>

<!-- Html Page Specific -->
<meta charset="utf-8">
<title>WCarPs</title>
<meta name="description" content="WCarPs">
<meta name="author" content="WCarPs | WCarPs.com">

<!-- Mobile Specific -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">

<!--[if lt IE 9]>
    <script type="text/javascript" src="scripts/html5shiv.js"></script>
<![endif]-->

<!-- CSS -->
<link rel="stylesheet" href="css/bootstrap.min.css"/>
<link rel="stylesheet" href="css/animate.css"/>
<link rel="stylesheet" href="css/simple-line-icons.css"/>
<link rel="stylesheet" href="css/icomoon-soc-icons.css"/>
<link rel="stylesheet" href="css/magnific-popup.css"/>
<link rel="stylesheet" href="css/style.css"/>

<!-- Favicons -->
<link rel="icon" href="images/favicon.png">
<link rel="apple-touch-icon" href="images/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
</head>

<body data-spy="scroll" data-target=".navMenuCollapse">

<!-- PRELOADER -->
<div id="preloader">
	<div class="battery inner">
		<div class="load-line"></div>
	</div>
</div>

<div id="wrap"> 

	<!-- NAVIGATION BEGIN -->
	<nav class="navbar navbar-fixed-top navbar-slide">
			<div class="container_fluid"> 
				<a class="navbar-brand goto" href="index.php"> <img src="./images/logo_nav.png" alt="WCarPs" height="40" width="45" /> </a>
				<a class="contact-btn icon-user" data-toggle="modal" data-target="#modalLogin"></a>
				<a class="contact-btn icon-envelope" data-toggle="modal" data-target="#modalContact"></a>
				<button class="navbar-toggle menu-collapse-btn collapsed" data-toggle="collapse" data-target=".navMenuCollapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
				<div class="collapse navbar-collapse navMenuCollapse">
					<ul class="nav">
					    <li><a href="index.php">Home</a> </li>
						<li><a href="#features">Features</a> </li>
						<li><a href="#benefits1">Benefits</a></li>
						<li><a href="#screenshots">Screenshots</a></li>
						<li><a href="#pricing-table">Price</a></li>
						<li><a href="#social">Stay Tuned</a></li>
						<li><a href="aboutus.php">About Us</a></li>
						<li><a href="contactus.php">Contact Us</a></li>
						<!-- <li><a href="http://brand.wcarps.com">Brand Center</a></li> -->
						<!-- <li><a href="termsofservice.php">Terms Of Service</a></li>
						<li><a href="privacypolicy.php">Privacy Policy</a></li> -->
						<li><a href="faq.php">FAQ</a></li>
					</ul>
				</div>
			</div>
	</nav>
	<!-- NAVIGAION END -->