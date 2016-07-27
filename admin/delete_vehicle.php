<?php

session_start();
require_once dirname(__FILE__).'/../api/class.user.php';
require_once dirname(__FILE__).'/../api/class.vehicle.php';
$user_login = new USER();
$user_vehicle = new Vehicle();

include('header.php'); 

if($_GET['vehicleID']) {
	$vehicleID = $_GET['vehicleID'];
	$sql    = "DELETE FROM tbl_vehicles  WHERE vehicleID = :vehicle_id";	
	$stmt   = $user_vehicle->runQuery($sql);
	$result = $stmt->execute(array(":vehicle_id" => $vehicleID));
} 
header('Location: vehicles.php' );
    

 ?>