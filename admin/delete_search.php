<?php

session_start();
require_once dirname(__FILE__).'/../api/class.user.php';
require_once dirname(__FILE__).'/../api/class.vehicle.php';
$user_login = new USER();
$user_vehicle = new Vehicle();

include('header.php'); 

if($_GET['searchID']) {
	$searchID = $_GET['searchID'];
	$sql    = "DELETE FROM tbl_users_searches  WHERE id = :search_id";	
	$stmt   = $user_vehicle->runQuery($sql);
	$result = $stmt->execute(array(":search_id" => $searchID));
} 
header('Location: searches.php' );
    

 ?>