<?php

session_start();
require_once dirname(__FILE__).'/../api/class.user.php';
require_once dirname(__FILE__).'/../api/class.vehicle.php';
$user_login = new USER();
$user_vehicle = new Vehicle();

//include('header.php'); 

if($_GET['vehicleID']) {
	$vehicleID = $_GET['vehicleID'];

	$stmt = $user_vehicle->runQuery('SELECT * FROM tbl_vehicles WHERE user_id = :user_id');
	$stmt->execute(array(":user_id"=>$currentUser->userID));
	$all_vehicles =  $stmt->fetchAll(PDO::FETCH_ASSOC);
	if(count($all_vehicles) > 1 ) {
		$sql    = "DELETE FROM tbl_vehicles  WHERE vehicleID = :vehicle_id";	
		$stmt   = $user_vehicle->runQuery($sql);
		$result = $stmt->execute(array(":vehicle_id" => $vehicleID));
		header('Location: vehicles.php');
	} else {
		header('Location: vehicles.php?error' );
	}
	
} 

    

 ?>