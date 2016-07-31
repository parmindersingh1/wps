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
if(isset($_POST['alertId'])) {
	$alertId = $_POST['alertId'];

	$stmt = $reg_vehicle->runQuery("SELECT v.* FROM tbl_vehicles as v JOIN tbl_lost_vehicles as lv on lv.vehicle_id = v.vehicleID WHERE lv.id = :alert_id");
	$stmt->bindparam(":alert_id",$alertId, PDO::PARAM_INT);
	$stmt->execute();
	$vehicleDetails=$stmt->fetch(PDO::FETCH_ASSOC);
	if($vehicleDetails) {
		// $stmt = $user->runQuery("SELECT gcm_regid FROM tbl_users WHERE userId <> :user_id)");
		$stmt = $user->runQuery("SELECT gcm_regid FROM tbl_users");
		// $stmt->bindparam(":vehicle_id",$vehicleDetails['user_id'], PDO::PARAM_INT);
		$stmt->execute();
		$regIDs = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
		
		$message = $vehicleDetails['name']." - ".$vehicleDetails['model_no']." is Recovered!!";
		// $message = array("message" => $message);
		$res = $gcm->sendMultiple(array_unique($regIDs), $message, "WCarPs Vehicle Recovery Alert");

		if($res) {	 
			$stmt = $user->runQuery("UPDATE tbl_lost_vehicles SET is_lost = 0 WHERE id = :alert_id");
			$stmt->bindparam(":alert_id",$alertId, PDO::PARAM_INT);			
			$stmt->execute();

			$stmt = $user->runQuery("INSERT INTO tbl_notifications (user_id,message) VALUES ( :user_id, :message)");
			$stmt->bindparam(":user_id",$vehicleDetails['user_id'], PDO::PARAM_INT);
			$stmt->bindparam(":message",$message);
			$stmt->execute();

			$stmt = $user->runQuery('SELECT MAX(id) AS max FROM tbl_notifications');
			$stmt->execute();
			$notification_id =  $stmt->fetch(PDO::FETCH_OBJ)->max;



			$stmt = $user->runQuery("SELECT userID FROM tbl_users");
			$stmt->execute();
			$data = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
			$sql = "INSERT INTO tbl_users_notifications (user_id, notification_id) VALUES ";
			$insertQuery = array();
			$insertData = array();
			foreach ($data as $user_id) {
			    $insertQuery[] = '(?, ?)';
			    $insertData[] = $user_id;
			    $insertData[] = $notification_id;
			}
			

			if (!empty($insertQuery)) {
			    $sql .= implode(', ', $insertQuery);
			    $stmt = $user->runQuery($sql);
			    $stmt->execute($insertData);
			}

			
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
