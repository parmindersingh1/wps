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
		$stmt = $user->runQuery("SELECT gcm_regid FROM tbl_users");
		// $stmt->bindparam(":vehicle_id",$vehicleDetails['user_id'], PDO::PARAM_INT);
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
		$res = $gcm->sendMultiple(array_unique($regIDs), $message, "WCarPs Vehicle Stolen Alert");

		if($res) {	    

			$stmt = $user->runQuery("SELECT userID,userEmail,first_name,last_name,phone  FROM tbl_users WHERE userId=:user_id");
			$stmt->bindparam(":user_id",$vehicleDetails['user_id'], PDO::PARAM_INT);
			$stmt->execute();
			$vehUser = $stmt->fetch(PDO::FETCH_ASSOC);
			

			$stmt = $user->runQuery("INSERT INTO tbl_lost_vehicles (address,vehicle_id,date_of_lost) VALUES (:location, :vehicle_id, :dol)");
			$stmt->bindparam(":vehicle_id",$vehicleID, PDO::PARAM_INT);
			$stmt->bindparam(":location",$location);
			$stmt->bindparam(":dol",$dol, PDO::PARAM_STR);
			$stmt->execute();

			$stmt = $user->runQuery("INSERT INTO tbl_notifications (user_id,message) VALUES ( :user_id, :message)");
			$stmt->bindparam(":user_id",$vehicleDetails['user_id'], PDO::PARAM_INT);
			$stmt->bindparam(":message",$message);
			$stmt->execute();



			$stmt = $user->runQuery('SELECT MAX(id) AS max FROM tbl_notifications');
			$stmt->execute();
			$notification_id =  $stmt->fetch(PDO::FETCH_OBJ)->max;


			// file_put_contents( 'debug' . time() . '.log', var_export( $res, true));

			// $user->add_notifications($notification_id);

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
