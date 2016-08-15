<?php

session_start();
require_once dirname(__FILE__).'/../api/class.user.php';
require_once dirname(__FILE__).'/../api/class.vehicle.php';
$user_login = new USER();
$user_vehicle = new Vehicle();

include('header.php'); 

if(isset($_GET['userID'])) {
	$userID = $_GET['userID'];

	if($user_login->reactivate($userID))
	{					
		header('Location: ' . $_SERVER['HTTP_REFERER']). '?success';
		
	} else {
		header('Location: ' . $_SERVER['HTTP_REFERER']). '?oops';
	}

} else {
	header('Location: ' . $_SERVER['HTTP_REFERER']). '?Invalid Request';
}
    

 ?>
