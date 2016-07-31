<?php
session_start();
require_once dirname(__FILE__).'/class.user.php';
$user = new USER();

header('Content-Type: application/json');
$response = array();
if(isset($_POST['userID'])) {
	$userID = $_POST['userID'];

	if($user->deactivate($userID))
	{					
			$response["success"] = true;
		    $response["message"] = "Deactivated Sucessfully";
		    echo json_encode($response);
		
	} else {
		$response["success"] = false;
	    $response["message"] = "Some Problem Occurred...";
	    echo json_encode($response);
	}
	
} else {
	    $response["success"] = false;
	    $response["message"] = "Invalid Request...";
	    echo json_encode($response);
}
?>