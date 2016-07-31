<?php

session_start();
require_once dirname(__FILE__).'/../api/class.user.php';
require_once dirname(__FILE__).'/../api/class.vehicle.php';
$user_login = new USER();
$user_vehicle = new Vehicle();

include('header.php'); 

if($_GET['blockID']) {
	$userID = $_GET['blockID'];
	 $sql    = "UPDATE tbl_users SET is_blocked = true WHERE userID = :user_id";	
	 $stmt   = $user_login->runQuery($sql);
	$result = $stmt->execute(array(":user_id" => $userID));
} else if($_GET['unblockID']) {
	$userID = $_GET['unblockID'];
	 $sql    = "UPDATE tbl_users SET is_blocked = false WHERE userID = :user_id";	
	 $stmt   = $user_login->runQuery($sql);
	$result = $stmt->execute(array(":user_id" => $userID));
}
header('Location: ' . $_SERVER['HTTP_REFERER']);
    

 ?>