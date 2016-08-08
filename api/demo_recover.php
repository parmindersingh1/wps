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
if(isset($_POST['alertId']) && isset($_POST['userId'])) {
	$alertId = $_POST['alertId'];
	$userId = $_POST['userId'];

	// $stmt = $user->runQuery("SELECT gcm_regid FROM tbl_users WHERE userId <> :user_id)");
	$stmt = $user->runQuery("SELECT gcm_regid FROM tbl_users WHERE userId = :user_id");
	$stmt->bindparam(":user_id",$userId, PDO::PARAM_INT);
	$stmt->execute();
	$regIDs = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
	
	$message = "Demo Vehicle - XX XXXXX is Recovered!!";	

	// $message = array("message" => $message);
	$res = $gcm->sendMultiple(array_unique($regIDs), $message, "WCarPs Demo Vehicle Recovery Alert");

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
	    $response["message"] = "Invalid Request...";
	    echo json_encode($response);
}
?>
