<?php
if (isset($_GET["regId"]) && isset($_GET["message"]) && isset($_GET["userId"])) {
    $regId = $_GET["regId"];
    $message = $_GET["message"];
    $userId = $_GET["userId"];

	require_once dirname(__FILE__).'/../api/class.user.php';
	require_once dirname(__FILE__).'/../api/class.vehicle.php';
    include_once dirname(__FILE__).'/../api/gcm_sendmsg.php';
     
    
	$user_login = new USER();
	$user_vehicle = new Vehicle();
    $gcm = new GCM();
 
    $registration_ids = array($regId);
    // $message = array("message" => $message);
 
    $result = $gcm->sendMultiple($registration_ids, $message, "WCarPs");
 	
    if($result) {
    	$stmt = $user_login->runQuery("INSERT INTO tbl_notifications (user_id,message) VALUES ( :user_id, :message)");
			$stmt->bindparam(":user_id",$userId, PDO::PARAM_INT);
			$stmt->bindparam(":message",$message);
			$stmt->execute();



			$stmt = $user_login->runQuery('SELECT MAX(id) AS max FROM tbl_notifications');
			$stmt->execute();
			$notification_id =  $stmt->fetch(PDO::FETCH_OBJ)->max;



			$stmt = $user_login->runQuery("SELECT userID FROM tbl_users");
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
			    $stmt = $user_login->runQuery($sql);
			    $stmt->execute($insertData);
			}
			echo true;
		} else {
			echo false;
		}
} else {
	echo false;
}
?>