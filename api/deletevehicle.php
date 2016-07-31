<?php
require_once dirname(__FILE__).'/class.user.php';
require_once dirname(__FILE__).'/class.vehicle.php';

$reg_user = new USER();
$vehicle = new VEHICLE();

$reg_user->logToFile($_POST['vehicleID']);

header('Content-Type: application/json');
$response = array();


    if(isset($_POST['vehicleID'])) {    	  		
		$vehicleID = trim($_POST['vehicleID']) ;
		
		if($vehicle->delete($vehicleID))
		{			
			$response["success"] = true;
			$response["message"] = "Success! Vehicle Deleted Successfully.";
			echo json_encode($response);			
		}
		else
		{
			$response["success"] = false;
			$response["message"] = "sorry , Some Problem...";
			echo json_encode($response);
		}		
    } else {	
		$response["success"] = false;
		$response["message"] = "Wrong Json ...";
		echo json_encode($response);
	}
	

?>
