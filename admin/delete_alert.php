<?php

session_start();
require_once dirname(__FILE__).'/../api/class.user.php';
require_once dirname(__FILE__).'/../api/class.vehicle.php';
$user_login = new USER();
$user_vehicle = new Vehicle();

include('header.php'); 

if($_GET['alertID']) {
	$alertID = $_GET['alertID'];
	$sql    = "DELETE FROM tbl_lost_vehicles  WHERE id = :alert_id";	
	$stmt   = $user_vehicle->runQuery($sql);
	$result = $stmt->execute(array(":alert_id" => $alertID));
} 
header('Location: alerts.php' );
    

 ?>