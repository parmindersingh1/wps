<?php
session_start();
require_once dirname(__FILE__).'/class.user.php';
require_once dirname(__FILE__).'/class.vehicle.php';
require_once dirname(__FILE__).'/gcm_sendmsg.php';
$user = new USER();
$reg_vehicle = new VEHICLE();
$gcm = new GCM();

header('Content-Type: application/json');
$response = array();
if(isset($_POST['vehicleID']) && isset($_POST['location']) && isset($_POST['dol'])) {
	$vehicleID = $_POST['vehicleID'];
	$location = $_POST['location'];
	$dlost = date_create($_POST['dol']);

	// $mil =  $dlost;
	// $seconds = $mil / 1000;
	// $dol =  date("Y-m-d H:i:s", $seconds);
	
	$dol = date_format($dlost,"Y-m-d H:i:s");

	$stmt = $reg_vehicle->runQuery("SELECT * FROM tbl_vehicles  WHERE vehicleID = :vehicle_id");
	$stmt->bindparam(":vehicle_id",$vehicleID, PDO::PARAM_INT);
	$stmt->execute();
	$vehicleDetails=$stmt->fetch(PDO::FETCH_ASSOC);
	
	if($vehicleDetails) {
		// $stmt = $user->runQuery("SELECT gcm_regid FROM tbl_users WHERE userId <> :user_id)");
		$stmt = $user->runQuery("SELECT gcm_regid FROM tbl_users WHERE userId = :user_id");
		$stmt->bindparam(":user_id",$vehicleDetails['user_id'], PDO::PARAM_INT);
		$stmt->execute();
		$regIDs = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
		
		$message = $vehicleDetails['name']." - ".$vehicleDetails['model_no']." is Stolen!!";

		$message .= '<ul>';
		$message .= "<li><strong>Vehicle Name:</strong> " .$vehicleDetails['name']. "</li>";
		$message .= "<li><strong>Vehicle No.:</strong> " . $vehicleDetails['model_no'] . "</li>";
		$message .= "<li><strong>Chassis No.:</strong> " . $vehicleDetails['chassis_no']. "</li>";
		$message .= "<li><strong>Status:</strong> Lost</li>";
		$message .= "<li><strong>Location:</strong> " . $location . "</li>";
		$message .= "<li><strong>Date/Time:</strong> " .date_format($dlost,'d/m/Y H:i A') . "</li>";

		$message .= "</ul>";
		
		// $message = array("message" => $message);
		$res = $gcm->sendMultiple(array_unique($regIDs), $message, "WCarPs Demo Vehicle Stolen Alert");

		if($res) {	 			
			$response["success"] = true;
		    $response["message"] = "Notification Sent Successfully";
		    echo json_encode($response);
		} else {
			$response["success"] = false;
		    $response["message"] = "Some Problem Pls Try Again ...";
		    echo json_encode($response);
		}
	} else {
		$response["success"] = false;
	    $response["message"] = "No Vehicle Found...";
	    echo json_encode($response);
	}
	
} else {
	    $response["success"] = false;
	    $response["message"] = "Invalid Request...";
	    echo json_encode($response);
}
?>
		