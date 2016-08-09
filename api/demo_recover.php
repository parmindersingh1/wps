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

	$message .= '<ul>';
	$message .= "<li><strong>Vehicle Name:</strong> Demo Vehicle</li>";
	$message .= "<li><strong>Vehicle No.:</strong> XX XXXXXX</li>";
	$message .= "<li><strong>Chassis No.:</strong> XX/XXXXXXXX</li>";
	$message .= "<li><strong>Status:</strong>  Recovered</li>";
	$message .= "<li><strong>Location:</strong> Demo Address</td></tr>";
	$message .= "<li><strong>Date/Time:</strong> ". date('d/m/Y h:i a')."</td></tr>";
	$message .= "</ul>";

	// $message = array("message" => $message);
	$res = $gcm->sendMultiple(array_unique($regIDs), $message, "WCarPs Demo Vehicle Recovery Alert", 0);

	if($res) {			
		$stmt = $user->runQuery("INSERT INTO tbl_notifications (user_id,message) VALUES ( :user_id, :message)");
		$stmt->bindparam(":user_id",$userId, PDO::PARAM_INT);
		$stmt->bindparam(":message",$message);
		$stmt->execute();

		$stmt = $user->runQuery('SELECT MAX(id) AS max FROM tbl_notifications');
		$stmt->execute();
		$notification_id =  $stmt->fetch(PDO::FETCH_OBJ)->max;


		$sql = "INSERT INTO tbl_users_notifications (user_id, notification_id) VALUES (:user_id, :notification_id)";			
	    $stmt = $user->runQuery($sql);
	    $stmt->bindparam(":user_id",$userId, PDO::PARAM_INT);
	    $stmt->bindparam(":notification_id",$notification_id, PDO::PARAM_INT);
	    $stmt->execute();

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
