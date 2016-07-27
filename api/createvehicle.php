<?php
session_start();
require_once dirname(__FILE__).'/class.user.php';
require_once dirname(__FILE__).'/class.vehicle.php';

$reg_user = new USER();
$vehicle = new VEHICLE();

header('Content-Type: application/json');
$response = array();

if(isset($_POST['userID'])){

	$userID = $_POST['userID'];
	
  
	if(isset($_POST['name']) && isset($_POST['type']) && isset($_POST['model']) && isset($_POST['chassis'])) {
		$name = isset($_POST['name']) ? trim($_POST['name']) : '';
		$type = isset($_POST['type']) ? trim($_POST['type']) : '';
		$model = isset($_POST['model']) ? trim($_POST['model']) : '';
		$chassis = isset($_POST['chassis']) ? trim($_POST['chassis']) : '';	
		$photo = isset($_POST['photo']) ? trim($_POST['photo']) : '';
		$colour = isset($_POST['colour']) ? trim($_POST['colour']) : ''; 
		if($vehicle->isValidVehicleNumber($model)) {

			$stmt = $reg_user->runQuery("SELECT * FROM tbl_vehicles WHERE LOWER(REPLACE(model_no, ' ', '')) = LOWER(REPLACE(:model_no, ' ', ''))  OR  LOWER(REPLACE(chassis_no, ' ', '')) = LOWER(REPLACE(:chassis_no, ' ', ''))");
			$stmt->bindparam(":model_no",$model);
			$stmt->bindparam(":chassis_no",$chassis);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			

			if($stmt->rowCount() > 0) {
				$response["success"] = false;
		        $response["message"] = "Sorry ! Vehicle already exists , Please Try another one";
		        echo json_encode($response);
			} else if($vehicle->save($name,$type,$model,$chassis,$photo,$colour,$userID)) {			
				$stmt = $reg_user->runQuery("SELECT v1.*, IF((SELECT COUNT(*) FROM tbl_vehicles as v2 WHERE v2.vehicleID = v1.vehicleID AND (imei_no IS NOT NULL AND v2.imei_no <> '') AND DATE(v2.subscriptiondate) BETWEEN DATE_SUB(CURDATE(),INTERVAL 1 YEAR) AND CURDATE() ),'true','false') as is_subscribed FROM tbl_vehicles as v1 WHERE v1.vehicleID=:vehicle_id");
				$id = $vehicle->lastID();
				$stmt->execute(array(":vehicle_id"=>$id));
				$newVehicle = $stmt->fetch(PDO::FETCH_ASSOC);

				$response["success"] = true;
				$response["message"] = "Success! Vehicle Created Successfully.";
				$response["newVehicle"] = $newVehicle;
				echo json_encode($response);			
			}
			else
			{
				$response["success"] = false;
				$response["message"] = "sorry , Vehicle Already Exists...";
				echo json_encode($response);
			}	
		} else {	
			$response["success"] = false;
			$response["message"] = "Enter Valid Vehicle Number ...";
			echo json_encode($response);
		}
    } else {	
		$response["success"] = false;
		$response["message"] = "Wrong Json ...";
		echo json_encode($response);
	}

	
} else {	
	$response["success"] = false;
	$response["message"] = "Wrong Json ...";
	echo json_encode($response);
}
?>
