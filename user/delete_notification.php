<?php

session_start();
require_once dirname(__FILE__).'/../api/class.user.php';
require_once dirname(__FILE__).'/../api/class.vehicle.php';
$user_login = new USER();
$user_vehicle = new Vehicle();

//include('header.php'); 

if($_GET['notID']) {
	$notificationID = $_GET['notID'];
	
	$sql    = "DELETE FROM tbl_users_notifications  WHERE id = :notification_id";	
	$stmt   = $user_vehicle->runQuery($sql);
	$result = $stmt->execute(array(":notification_id" => $notificationID));
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit();
} else {
	header('Location: user_notifications.php?error' );
	exit();
}

    

 ?>