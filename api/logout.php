<?php
session_start();
require_once dirname(__FILE__).'/class.user.php';
$user = new USER();

header('Content-Type: application/json');
$response = array();

if(!$user->is_logged_in())
{
	$response["success"] = true;
    $response["message"] = "Logged out Sucessfully";
    echo json_encode($response);
}

if($user->is_logged_in()!="")
{
	$user->logout();	
	$response["success"] = true;
    $response["message"] = "Already Logged out Sucessfully";
    echo json_encode($response);
}
?>